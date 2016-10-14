<?php

namespace App\Admin\Http\Controllers;

use DB;
use Hash;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'username' => 'required',
                'password' => 'required',
            ]);

            if($validator->passes())
            {
                $credential = [
                    'username' => $input['username'],
                    'password' => $input['password'],
                    'status' => Util::STATUS_ACTIVE_VALUE,
                ];

                if(Auth::attempt($credential, true))
                {
                    if(!empty($input['redirectUrl']))
                        return redirect($input['redirectUrl']);
                    else
                        return redirect('admin');
                }
            }
        }

        return view('admin.users.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function home()
    {
        return view('admin.users.home');
    }

    public function phpinfo()
    {
        phpinfo();
    }

    public function listUser(Request $request)
    {
        $input = $request->all();

        $builder = User::select('ff_user.*')->with(['userRoles.role' => function($query) {
            $query->select('id', 'name');
        }]);

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['username']))
                $builder->where('ff_user.username', 'like', '%' . $input['filter']['username'] . '%');

            if(!empty($input['filter']['role']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_user_role` on') === false)
                    $builder->join('ff_user_role', 'ff_user.id', '=', 'ff_user_role.user_id');
                $builder->where('ff_user_role.id', $input['filter']['role']);
            }

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('ff_user.status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('ff_user.id', 'DESC');

        $users = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.users.list_user', [
            'users' => $users,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createUser(Request $request)
    {
        $user = new User();
        $user->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveUser($request, $user, 'admin.users.create_user');
    }

    public function editUser(Request $request, $id)
    {
        $user = User::with(['userRoles.role' => function($query) {
            $query->select('id', 'name');
        }])->find($id);

        return $this->saveUser($request, $user, 'admin.users.edit_user');
    }

    protected function saveUser($request, $user, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('user');

            $user->username = isset($input['username']) ? trim($input['username']) : '';
            $user->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $inputRoles = array();
            $newRoles = array();
            $deleteRoles = array();

            if(isset($input['role']) && is_array($input['role']))
                $inputRoles = Role::select('id', 'name')->whereIn('id', $input['role'])->get();

            foreach($user->userRoles as $keyUserRole => $userRole)
            {
                $haveRole = false;

                foreach($inputRoles as $keyInputRole => $inputRole)
                {
                    if($inputRole->id == $userRole->role_id)
                    {
                        unset($inputRoles[$keyInputRole]);
                        $haveRole = true;
                        break;
                    }
                }

                if($haveRole == false)
                {
                    unset($user->userRoles[$keyUserRole]);
                    $deleteRoles[] = $userRole;
                }
            }

            foreach($inputRoles as $inputRole)
            {
                $newUserRole = new UserRole();
                $newUserRole->role_id = $inputRole->id;

                $newRoles[] = $newUserRole;
                $user->userRoles[] = $newUserRole;
            }

            if(empty($user->id))
                $user->password = isset($input['password']) ? trim($input['password']) : '';

            $errors = $user->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    unset($user->userRoles);

                    if(empty($user->id))
                        $user->password = Hash::make($user->password);

                    $user->save();

                    foreach($newRoles as $newRole)
                    {
                        $newRole->user_id = $user->id;
                        $newRole->save();
                    }

                    foreach($deleteRoles as $deleteRole)
                        $deleteRole->delete();

                    Db::commit();

                    return redirect('admin/user');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['user' => $user, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['user' => $user, 'errors' => $errors]);
        }

        return view($view, ['user' => $user]);
    }

    public function changeUserPassword(Request $request, $id)
    {
        $authUser = auth()->user();

        $isAdmin = false;

        foreach($authUser->userRoles as $userRole)
        {
            if($userRole->role->name == Util::ROLE_ADMINISTRATOR)
            {
                $isAdmin = true;
                break;
            }
        }

        if($isAdmin == false && $authUser->id != $id)
            return view('admin.errors.403');

        $user = User::find($id);

        if($request->isMethod('post'))
        {
            $input = $request->input('user');

            $validator = Validator::make($input, [
                'password' => 'required|min:6|regex:/^[a-zA-Z0-9]+$/',
            ]);

            $errors = array();

            if($validator->fails())
                $errors = $validator->errors()->all();

            if(count($errors) == 0)
            {
                $user->password = Hash::make($input['password']);
                $user->save();
                return redirect('admin/user/changePassword/' . $user->id)->with('successMessage', 'Change password successfully');
            }

            return view('admin.users.change_password', ['user' => $user, 'errors' => $errors]);
        }

        return view('admin.users.change_password', ['user' => $user]);
    }

    public function listRole(Request $request)
    {
        $input = $request->all();

        $builder = Role::select('id', 'name');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $roles = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.users.list_role', [
            'roles' => $roles,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createRole(Request $request)
    {
        $role = new Role();

        return $this->saveRole($request, $role, 'admin.users.create_role');
    }

    public function editRole(Request $request, $id)
    {
        $role = Role::find($id);

        return $this->saveRole($request, $role, 'admin.users.edit_role');
    }

    protected function saveRole($request, $role, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('role');

            $role->name = isset($input['name']) ? trim($input['name']) : '';

            if(isset($input['permission']) && is_array($input['permission']))
                $role->permission = json_encode($input['permission']);

            $errors = $role->validate();

            if(count($errors) == 0)
            {
                $role->save();
                return redirect('admin/role');
            }

            return view($view, ['role' => $role, 'errors' => $errors]);
        }

        return view($view, ['role' => $role]);
    }
}
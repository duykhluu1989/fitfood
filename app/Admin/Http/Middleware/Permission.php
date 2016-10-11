<?php

namespace App\Admin\Http\Middleware;

use Closure;
use App\Libraries\Util;

class Permission
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        $route = $request->route();

        $isAdmin = false;
        $permissions = array();

        foreach($user->userRoles as $userRole)
        {
            if($userRole->role->name == Util::ROLE_ADMINISTRATOR)
            {
                $isAdmin = true;
                break;
            }

            if(!empty($userRole->role->permission))
                $permissions = array_merge(json_decode($userRole->role->permission, true));
        }

        if($isAdmin == false && in_array('permission', $route->middleware()))
        {
            if(count($permissions) == 0)
                return response()->view('admin.errors.403');

            if(!in_array($route->getMethods()[0] . ' - ' . $route->getPath(), $permissions))
                return response()->view('admin.errors.403');
        }

        return $next($request);
    }
}

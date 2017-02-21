<?php

namespace App\Admin\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\Setting;

class SettingController extends Controller
{
    public function listSetting(Request $request)
    {
        $input = $request->all();

        $builder = Setting::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(isset($input['filter']['type']) && $input['filter']['type'] !== '')
                $builder->where('type', $input['filter']['type']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $settings = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.settings.list_setting', [
            'settings' => $settings,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createSetting(Request $request)
    {
        $setting = new Setting();

        return $this->saveSetting($request, $setting, 'admin.settings.create_setting', 'create');
    }

    public function editSetting(Request $request, $id)
    {
        $setting = Setting::find($id);

        return $this->saveSetting($request, $setting, 'admin.settings.edit_setting', 'edit');
    }

    protected function saveSetting($request, $setting, $view, $action)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('setting');

            if($action == 'create')
            {
                $setting->name = isset($input['name']) ? trim($input['name']) : '';
                $setting->type = isset($input['type']) ? trim($input['type']) : '';
            }

            $errors = $setting->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $setting->save();

                    if($action == 'edit')
                    {
                        switch($setting->type)
                        {
                            case Util::TYPE_SETTING_JSON_VALUE:

                                if(isset($input['value']) && is_array($input['value']))
                                    $setting->value = json_encode($input['value']);

                                break;

                            case Util::TYPE_SETTING_INT_VALUE:

                                $setting->value = $input['value'];

                                break;
                        }

                        $setting->save();
                    }

                    Db::commit();

                    return redirect('admin/setting');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['setting' => $setting, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['setting' => $setting, 'errors' => $errors]);
        }

        return view($view, ['setting' => $setting]);
    }
}
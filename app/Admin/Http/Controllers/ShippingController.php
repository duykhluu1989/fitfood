<?php

namespace App\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipper;
use App\Models\Area;
use App\Libraries\Util;

class ShippingController extends Controller
{
    public function listShipper(Request $request)
    {
        $input = $request->all();

        $builder = Shipper::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['phone']))
                $builder->where('phone', 'like', '%' . $input['filter']['phone'] . '%');

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $shippers = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.shippings.list_shipper', [
            'shippers' => $shippers,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createShipper(Request $request)
    {
        $shipper = new Shipper();
        $shipper->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveShipper($request, $shipper, 'admin.shippings.create_shipper');
    }

    public function editShipper(Request $request, $id)
    {
        $shipper = Shipper::find($id);

        return $this->saveShipper($request, $shipper, 'admin.shippings.edit_shipper');
    }

    protected function saveShipper($request, $shipper, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('shipper');

            $shipper->name = isset($input['name']) ? trim($input['name']) : '';
            $shipper->phone = isset($input['phone']) ? trim($input['phone']) : '';
            $shipper->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $shipper->validate();

            if(count($errors) == 0)
            {
                $shipper->save();
                return redirect('admin/shipper');
            }

            return view($view, ['shipper' => $shipper, 'errors' => $errors]);
        }

        return view($view, ['shipper' => $shipper]);
    }

    public function listArea(Request $request)
    {
        $input = $request->all();

        $builder = Area::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $areas = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.shippings.list_area', [
            'areas' => $areas,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createArea(Request $request)
    {
        $area = new Area();
        $area->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveArea($request, $area, 'admin.shippings.create_area');
    }

    public function editArea(Request $request, $id)
    {
        $area = Area::find($id);

        return $this->saveArea($request, $area, 'admin.shippings.edit_area');
    }

    protected function saveArea($request, $area, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('area');

            $area->name = isset($input['name']) ? trim($input['name']) : '';
            $area->shipping_price = !empty($input['shipping_price']) ? trim(str_replace('.', '', $input['shipping_price'])) : 0;
            $area->shipping_time = isset($input['shipping_time']) ? json_encode($input['shipping_time']) : '';
            $area->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $area->note = isset($input['note']) ? trim($input['note']) : '';
            $area->note_en = isset($input['note_en']) ? trim($input['note_en']) : '';

            $errors = $area->validate();

            if(count($errors) == 0)
            {
                $area->save();
                return redirect('admin/area');
            }

            return view($view, ['area' => $area, 'errors' => $errors]);
        }

        return view($view, ['area' => $area]);
    }
}
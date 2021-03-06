<?php

namespace App\Admin\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Discount;
use App\Libraries\Util;
use App\Models\Customer;

class DiscountController extends Controller
{
    public function listDiscount(Request $request)
    {
        $input = $request->all();

        $builder = Discount::select('*')->with('customer');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['code']))
                $builder->where('code', 'like', '%' . $input['filter']['code'] . '%');

            if(!empty($input['filter']['type']))
                $builder->where('type', $input['filter']['type']);

            if(isset($input['filter']['used']) && $input['filter']['used'] !== '')
            {
                if($input['filter']['used'] == '0')
                    $builder->where('times_used', '>', 0);
                else
                    $builder->where('times_used', 0);
            }

            if(!empty($input['filter']['campaign']))
                $builder->where('campaign', $input['filter']['campaign']);

            if(!empty($input['filter']['description']))
                $builder->where('description', 'like', '%' . $input['filter']['description'] . '%');

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

        $discounts = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.discounts.list_discount', [
            'discounts' => $discounts,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createDiscount(Request $request)
    {
        $discount = new Discount();
        $discount->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveDiscount($request, $discount, 'admin.discounts.create_discount', 'create');
    }

    public function editDiscount(Request $request, $id)
    {
        $shipper = Discount::find($id);

        return $this->saveDiscount($request, $shipper, 'admin.discounts.edit_discount', 'edit');
    }

    protected function saveDiscount($request, $discount, $view, $action)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('discount');

            if($action == 'create')
            {
                $discount->code = isset($input['code']) ? trim($input['code']) : '';
                $discount->type = isset($input['type']) ? trim($input['type']) : '';

                if($discount->type == Util::DISCOUNT_TYPE_FREE_MEAL_VALUED)
                    $discount->value = 1;
                else
                    $discount->value = isset($input['value']) ? trim(str_replace('.', '', $input['value'])) : '';

                $discount->times_used = 0;
                $discount->created_at = date('Y-m-d H:i:s');
                $discount->customer_id_str = !empty($input['customer_id_str']) ? trim($input['customer_id_str']) : null;
            }

            $discount->description = isset($input['description']) ? trim($input['description']) : '';
            $discount->times_limit = !empty($input['times_limit']) ? trim($input['times_limit']) : 0;
            $discount->start_time = !empty($input['start_time']) ? trim($input['start_time']) : null;
            $discount->end_time = !empty($input['end_time']) ? trim($input['end_time']) : null;
            $discount->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $discount->usage_unique = isset($input['usage_unique']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $discount->validate();

            if(count($errors) == 0)
            {
                if($action == 'create')
                    unset($discount->customer_id_str);

                $discount->save();
                return redirect('admin/discount');
            }

            return view($view, ['discount' => $discount, 'errors' => $errors]);
        }

        return view($view, ['discount' => $discount]);
    }

    public function generateCode(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $number = (int)trim($input['number']);

                $code = Discount::generateRandomUniqueCodeByNumberCharacter($number);

                echo $code;
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function getAutoCompleteCustomerData(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $term = trim($input['term']);

                $customers = Customer::where('customer_id', 'like', '%' . $term . '%')->limit(10)->get();

                $data = array();

                foreach($customers as $customer)
                {
                    $data[] = [
                        'name' => $customer->name,
                        'customer_id' => $customer->customer_id,
                        'phone' => $customer->phone,
                    ];
                }

                echo json_encode($data);
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function createManyDiscount(Request $request)
    {
        $discount = new Discount();
        $discount->status = Util::STATUS_ACTIVE_VALUE;

        if($request->isMethod('post'))
        {
            $input = $request->input('discount');

            $discount->character = isset($input['character']) ? trim($input['character']) : '';
            $discount->quantity = isset($input['quantity']) ? trim($input['quantity']) : '';
            $discount->type = isset($input['type']) ? trim($input['type']) : '';

            if($discount->type == Util::DISCOUNT_TYPE_FREE_MEAL_VALUED)
                $discount->value = 1;
            else
                $discount->value = isset($input['value']) ? trim(str_replace('.', '', $input['value'])) : '';

            $discount->times_used = 0;
            $discount->created_at = date('Y-m-d H:i:s');
            $discount->times_limit = !empty($input['times_limit']) ? trim($input['times_limit']) : 0;
            $discount->start_time = !empty($input['start_time']) ? trim($input['start_time']) : null;
            $discount->end_time = !empty($input['end_time']) ? trim($input['end_time']) : null;
            $discount->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $discount->usage_unique = isset($input['usage_unique']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $discount->description = isset($input['description']) ? trim($input['description']) : '';
            $discount->campaign = isset($input['campaign']) ? trim($input['campaign']) : '';

            $errors = $discount->validateMany();

            if(count($errors) == 0)
            {
                for($i = 1;$i <= $discount->quantity;$i ++)
                {
                    $newDiscount = new Discount();
                    $newDiscount->code = Discount::generateRandomUniqueCodeByNumberCharacter($discount->character);
                    $newDiscount->type = $discount->type;
                    $newDiscount->value = $discount->value;
                    $newDiscount->times_used = $discount->times_used;
                    $newDiscount->created_at = $discount->created_at;
                    $newDiscount->times_limit = $discount->times_limit;
                    $newDiscount->start_time = $discount->start_time;
                    $newDiscount->end_time = $discount->end_time;
                    $newDiscount->status = $discount->status;
                    $newDiscount->usage_unique = $discount->usage_unique;
                    $newDiscount->description = $discount->description;
                    $newDiscount->campaign = $discount->campaign;
                    $newDiscount->save();
                }

                return redirect('admin/discount');
            }

            return view('admin.discounts.create_many_discount', ['discount' => $discount, 'errors' => $errors]);
        }

        return view('admin.discounts.create_many_discount', ['discount' => $discount]);
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::where('times_used', 0)->find($id);
        $discount->delete();

        return redirect('admin/discount');
    }

    public function controlDiscount(Request $request)
    {
        $input = $request->all();

        switch($input['control'])
        {
            case 'export':

                $discounts = Discount::whereIn('id', $input['id'])->pluck('code')->all();

                $exportData[] = [
                    'Code',
                ];

                foreach($discounts as $discount)
                {
                    $exportData[] = [
                        $discount,
                    ];
                }

                if(count($exportData) > 1)
                {
                    Excel::create('export-discount-' . date('Y-m-d'), function($excel) use($exportData) {

                        $excel->sheet('sheet1', function($sheet) use($exportData) {

                            $sheet->fromArray($exportData, null, 'A1', true, false);

                        });

                    })->export('xls');
                }

                break;

            case 'delete':

                $discounts = Discount::where('times_used', 0)->whereIn('id', $input['id'])->get();

                foreach($discounts as $discount)
                    $discount->delete();

                break;
        }

        $referer = $request->server('HTTP_REFERER');
        if(!empty($referer))
            return redirect($referer);

        return redirect('admin/discount');
    }
}
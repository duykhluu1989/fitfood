<?php

namespace App\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Libraries\Util;
use App\Models\Customer;

class DiscountController extends Controller
{
    public function listDiscount()
    {
        $builder = Discount::select('*');

        $builder->orderBy('id', 'DESC');

        $discounts = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.discounts.list_discount', ['discounts' => $discounts]);
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
                return redirect('discount');
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

                $customers = Customer::where('customer_id', 'like', '%' . $term . '%')->get();

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
            $discount->value = isset($input['value']) ? trim(str_replace('.', '', $input['value'])) : '';
            $discount->times_used = 0;
            $discount->created_at = date('Y-m-d H:i:s');
            $discount->times_limit = !empty($input['times_limit']) ? trim($input['times_limit']) : 0;
            $discount->start_time = !empty($input['start_time']) ? trim($input['start_time']) : null;
            $discount->end_time = !empty($input['end_time']) ? trim($input['end_time']) : null;
            $discount->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $discount->usage_unique = isset($input['usage_unique']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $discount->description = isset($input['description']) ? trim($input['description']) : '';

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
                    $newDiscount->save();
                }

                return redirect('discount');
            }

            return view('admin.discounts.create_many_discount', ['discount' => $discount, 'errors' => $errors]);
        }

        return view('admin.discounts.create_many_discount', ['discount' => $discount]);
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::where('times_used', 0)->find($id);
        $discount->delete();

        return redirect('discount');
    }
}
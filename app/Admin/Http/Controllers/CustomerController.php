<?php

namespace App\Admin\Http\Controllers;

use Excel;
use Validator;
use DB;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\Customer;
use App\Models\Area;

class CustomerController extends Controller
{
    public function listCustomer(Request $request)
    {
        list($customers, $filter, $queryString) = $this->getListCustomer($request, 'list');

        return view('admin.customers.list_customer', [
            'customers' => $customers,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function exportCustomer(Request $request)
    {
        list($customers, $filter, $queryString) = $this->getListCustomer($request, 'export');

        $exportData[] = [
            'Customer ID',
            'Phone',
            'Name',
            'Email',
            'Gender',
            'Address',
            'District',
            'Address Google',
            'Latitude',
            'Longitude',
            'Orders',
            'Spent',
        ];

        foreach($customers as $customer)
        {
            $phone = Util::formatPhone($customer->phone);

            $exportData[] = [
                $customer->customer_id,
                $phone,
                $customer->name,
                $customer->email,
                Util::getGender($customer->gender),
                $customer->address,
                $customer->district,
                $customer->address_google,
                $customer->latitude,
                $customer->longitude,
                $customer->orders_count,
                Util::formatMoney($customer->total_spent),
            ];
        }

        Excel::create('export-customer-' . date('Y-m-d'), function($excel) use($exportData) {

            $excel->sheet('sheet1', function($sheet) use($exportData) {

                $sheet->fromArray($exportData, null, 'A1', true, false);

            });

        })->export('xls');
    }

    protected function getListCustomer($request, $action)
    {
        $input = $request->all();

        $builder = Customer::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['customer_id']))
                $builder->where('customer_id', 'like', '%' . $input['filter']['customer_id']);

            if(!empty($input['filter']['phone']))
                $builder->where('phone', 'like', '%' . $input['filter']['phone'] . '%');

            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['email']))
                $builder->where('email', 'like', '%' . $input['filter']['email'] . '%');

            if(!empty($input['filter']['address']))
                $builder->where('address', 'like', '%' . $input['filter']['address'] . '%');

            if(!empty($input['filter']['gender']))
                $builder->where('gender', $input['filter']['gender']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        if($action == 'list')
            $customers = $builder->paginate(Util::GRID_PER_PAGE);
        else
            $customers = $builder->get();

        return [$customers, $filter, $queryString];
    }

    public function detailCustomer($id)
    {
        $customer = Customer::with(['firstOrder', 'lastOrder', 'orders' => function($query) {
            $query->select('id', 'customer_id')->orderBy('id', 'DESC');
        }])->find($id);

        return view('admin.customers.detail_customer', ['customer' => $customer]);
    }

    public function editCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);
        $areas = Area::getModelActiveArea();

        if($request->isMethod('post'))
        {
            $input = $request->input('customer');

            $customer->name = isset($input['name']) ? trim($input['name']) : '';
            $customer->phone = isset($input['phone']) ? trim($input['phone']) : '';
            $customer->email = isset($input['email']) ? trim($input['email']) : '';
            $customer->address = isset($input['address']) ? trim($input['address']) : '';
            $customer->district = isset($input['district']) ? trim($input['district']) : '';
            $customer->latitude = isset($input['latitude']) ? trim($input['latitude']) : '';
            $customer->longitude = isset($input['longitude']) ? trim($input['longitude']) : '';
            $customer->address_google = isset($input['address_google']) ? trim($input['address_google']) : '';
            $customer->gender = isset($input['gender']) ? trim($input['gender']) : '';

            $code = isset($input['code']) ? trim($input['code']) : '';

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'address' => 'required|string',
                'district' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'address_google' => 'required|string',
                'gender' => 'required|in:' . Util::GENDER_MALE_VALUE . ',' . Util::GENDER_FEMALE_VALUE,
                'code' => 'required|in:' . Util::CUSTOMER_CODE_VN . ',' . Util::CUSTOMER_CODE_FR,
            ]);

            if($validator->fails())
                $errors = $validator->errors()->all();
            else
                $errors = array();

            if(Util::validatePhone($input['phone']) == false)
                $errors[] = 'Phone is not valid';

            if(count($errors) == 0)
            {
                if($customer->gender == Util::GENDER_MALE_VALUE)
                    $code .= 'M';
                else
                    $code .= 'F';
                $code .= ($customer->id + Util::CUSTOMER_ID_PREFIX);
                $customer->customer_id = $code;

                try
                {
                    DB::beginTransaction();

                    $customer->save();

                    DB::commit();

                    return redirect('admin/customer/detail/' . $customer->id);
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    $errors[] = $e->getMessage();
                }
            }

            return view('admin.customers.edit_customer', ['customer' => $customer, 'areas' => $areas, 'errors' => $errors]);
        }

        return view('admin.customers.edit_customer', ['customer' => $customer, 'areas' => $areas]);
    }
}
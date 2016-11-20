<?php

namespace App\Admin\Http\Controllers;

use Excel;
use Validator;
use DB;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\Customer;
use App\Models\Area;
use App\Models\Banner;

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

    public function listBanner(Request $request)
    {
        $input = $request->all();

        $builder = Banner::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['page']))
                $builder->where('page', $input['filter']['page']);

            if(!empty($input['filter']['customer_type']))
                $builder->where('customer_type', $input['filter']['customer_type']);

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

        $banners = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.customers.list_banner', [
            'banners' => $banners,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createBanner(Request $request)
    {
        $banner = new Banner();

        return $this->saveBanner($request, $banner, 'admin.customers.create_banner');
    }

    public function editBanner(Request $request, $id)
    {
        $banner = Banner::find($id);

        return $this->saveBanner($request, $banner, 'admin.customers.edit_banner');
    }

    protected function saveBanner($request, $banner, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('banner');

            $file = $request->file('image');

            $banner->name = isset($input['name']) ? trim($input['name']) : '';
            $banner->start_time = !empty($input['start_time']) ? trim($input['start_time']) : null;
            $banner->end_time = !empty($input['end_time']) ? trim($input['end_time']) : null;
            $banner->page = isset($input['page']) ? trim($input['page']) : '';
            $banner->customer_type = isset($input['customer_type']) ? trim($input['customer_type']) : '';
            $banner->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $banner->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    if(!empty($file))
                    {
                        if(in_array($file->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/banner';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'banner_' . str_replace('.', '', microtime(true)) . '.' . strtolower($file->getClientOriginalExtension());

                            $file->move($path, $fileName);

                            if(!empty($banner->image_src))
                            {
                                $imageSrcParts = explode('/', $banner->image_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $banner->image_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/banner/' . $fileName;
                        }
                    }

                    $banner->save();

                    Db::commit();

                    return redirect('admin/banner');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['banner' => $banner, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['banner' => $banner, 'errors' => $errors]);
        }

        return view($view, ['banner' => $banner]);
    }
}
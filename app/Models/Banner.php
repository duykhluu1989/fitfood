<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Banner extends Model
{
    protected $table = 'ff_banner';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'start_time' => 'date',
            'end_time' => 'date',
            'url' => 'string',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if(!empty($this->start_time) && !empty($this->end_time) && strtotime($this->start_time) >= strtotime($this->end_time))
            $errors[] = 'Start Time must be less than End Time';

        return $errors;
    }

    public static function getCustomerBanner($request, $customerType)
    {
        $time = date('Y-m-d H:i:s');
        $page = $request->getPathInfo();

        if($page == '/')
            $page = Util::BANNER_HOME_PAGE;
        else
        {
            $start = strpos($page, '/');
            $end = strpos($page, '/', $start + 1);

            $page = substr($page, $start + 1, ($end !== false ? $end - $start - 1 : null));
        }

        $banners = Banner::where(function($query) use($customerType) {
            $query->where('customer_type', $customerType)->orWhere('customer_type', '')->orWhereNull('customer_type');
        })->where(function($query) use($time) {
            $query->where('start_time', '<=', $time)->orWhere('start_time', '')->orWhereNull('start_time');
        })->where(function($query) use($time) {
            $query->where('end_time', '>=', $time)->orWhere('end_time', '')->orWhereNull('end_time');
        })->where(function($query) use($page) {
            $query->where('page', $page)->orWhere('page', '')->orWhereNull('page');
        })->where('status', Util::STATUS_ACTIVE_VALUE)->get()->toArray();

        if(count($banners) > 0)
        {
            $keyBanner = array_rand($banners);
            return $banners[$keyBanner];
        }

        return null;
    }
}
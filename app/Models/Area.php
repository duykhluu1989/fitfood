<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Area extends Model
{
    protected $table = 'ff_area';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'shipping_price' => 'integer|min:0',
            'shipping_time' => 'required|string',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }

    public static function getModelActiveArea()
    {
        $areas = Area::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        return $areas;
    }

    public static function getShippingTimeByDistrict($district)
    {
        $area = Area::where('name', $district)->where('status', Util::STATUS_ACTIVE_VALUE)->first();

        return json_decode($area->shipping_time, true);
    }

    public static function getArrayActiveArea()
    {
        $areasArr = array();

        $areas = Area::all();

        foreach($areas as $area)
            $areasArr[$area->name] = $area;

        return $areasArr;
    }
}
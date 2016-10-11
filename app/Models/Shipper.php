<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Shipper extends Model
{
    protected $table = 'ff_shipper';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'phone' => 'required|numeric',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();
        
        if(Util::validatePhone($this->phone) == false)
            $errors[] = 'Phone is not valid';

        return $errors;
    }

    public static function getDropDownActiveShipper()
    {
        $dropDown = array();

        $shippers = Shipper::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        foreach($shippers as $shipper)
            $dropDown[$shipper->id] = $shipper->name;

        return $dropDown;
    }
}
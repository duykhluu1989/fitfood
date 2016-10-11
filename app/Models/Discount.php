<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Discount extends Model
{
    protected $table = 'ff_discount';

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'code' => 'required|alpha_num|min:6|max:255',
            'value' => 'required|integer|min:1',
            'start_time' => 'date',
            'end_time' => 'date',
            'times_limit' => 'integer|min:0',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if($this->type == Util::DISCOUNT_TYPE_PERCENTAGE_VALUED && $this->value > 100)
            $errors[] = 'Value percentage can not be greater than 100';

        if(!empty($this->start_time) && !empty($this->end_time) && strtotime($this->start_time) >= strtotime($this->end_time))
            $errors[] = 'Start Time must be less than End Time';

        if(empty($this->id) && !empty($this->customer_id_str))
        {
            $customer = Customer::where('customer_id', $this->customer_id_str)->first();

            if(!empty($customer))
                $this->customer_id = $customer->id;
            else
                $errors[] = 'Customer ID is not valid';
        }

        return $errors;
    }

    public function validateMany()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'character' => 'required|integer|min:6|max:255',
            'quantity' => 'required|integer|min:2|max:300',
            'value' => 'required|integer|min:1',
            'start_time' => 'date',
            'end_time' => 'date',
            'times_limit' => 'integer|min:0',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if($this->type == Util::DISCOUNT_TYPE_PERCENTAGE_VALUED && $this->value > 100)
            $errors[] = 'Value percentage can not be greater than 100';

        if(!empty($this->start_time) && !empty($this->end_time) && strtotime($this->start_time) >= strtotime($this->end_time))
            $errors[] = 'Start Time must be less than End Time';

        return $errors;
    }

    public static function generateRandomUniqueCodeByNumberCharacter($number)
    {
        $times = 0;
        $maxTimes = 20;

        do
        {
            $randomString = Util::generateRandomCodeByNumberCharacter($number);

            $discount = Discount::where('code', $randomString)->first();

            $times ++;
        }
        while(!empty($discount) && $times < $maxTimes);

        if(empty($discount))
            return $randomString;

        return null;
    }
}
<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Customer extends Model
{
    protected $table = 'ff_customer';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::created(function(Customer $customer) {

            if(empty($customer->customer_id))
            {
                if(App::getLocale() == 'vi')
                    $customer->customer_id = Util::CUSTOMER_CODE_VN;
                else
                    $customer->customer_id = Util::CUSTOMER_CODE_FR;

                if($customer->gender == Util::GENDER_MALE_VALUE)
                    $customer->customer_id .= 'M';
                else
                    $customer->customer_id .= 'F';

                $customer->customer_id .= ($customer->id + Util::CUSTOMER_ID_PREFIX);
                $customer->save();
            }

        });
    }

    public function firstOrder()
    {
        return $this->belongsTo('App\Models\Order', 'first_order');
    }

    public function lastOrder()
    {
        return $this->belongsTo('App\Models\Order', 'last_order');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }
}
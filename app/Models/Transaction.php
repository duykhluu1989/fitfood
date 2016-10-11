<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Transaction extends Model
{
    protected $table = 'ff_transaction';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::created(function(Transaction $transaction) {

            if($transaction->type == Util::TRANSACTION_TYPE_PAY_VALUE)
            {
                if(!empty($transaction->customer))
                {
                    $transaction->customer->total_spent += $transaction->amount;
                    $transaction->customer->save();
                }
            }

        });
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Models\Shipper', 'shipper_id');
    }
}
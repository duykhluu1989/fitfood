<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $table = 'ff_order_discount';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\Discount', 'code', 'code');
    }
}
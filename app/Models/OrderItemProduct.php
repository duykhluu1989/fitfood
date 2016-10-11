<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemProduct extends Model
{
    protected $table = 'ff_order_item_product';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem', 'order_item_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Models\Shipper', 'shipper_id');
    }
}
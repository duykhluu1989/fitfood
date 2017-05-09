<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'ff_order_item';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function orderItemMeals()
    {
        return $this->hasMany('App\Models\OrderItemMeal', 'order_item_id');
    }

    public function orderItemProduct()
    {
        return $this->hasOne('App\Models\OrderItemProduct', 'order_item_id');
    }

    public function orderExtras()
    {
        return $this->hasMany('App\Models\OrderExtra', 'order_item_id');
    }
}
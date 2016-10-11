<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemMealDetail extends Model
{
    protected $table = 'ff_order_item_meal_detail';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItemMeal', 'order_item_meal_id');
    }
}
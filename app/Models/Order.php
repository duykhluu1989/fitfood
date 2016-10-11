<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Order extends Model
{
    protected $table = 'ff_order';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::created(function(Order $order) {

            if(empty($order->order_id))
            {
                $order->order_id = $order->id + Util::ORDER_ID_PREFIX;
                $order->save();
            }

        });
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function orderAddress()
    {
        return $this->hasOne('App\Models\OrderAddress', 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function orderItemMeals()
    {
        return $this->hasMany('App\Models\OrderItemMeal', 'order_id');
    }

    public function orderExtras()
    {
        return $this->hasMany('App\Models\OrderExtra', 'order_id');
    }

    public function orderDiscount()
    {
        return $this->hasOne('App\Models\OrderDiscount', 'order_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'order_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Models\Shipper', 'shipper_id');
    }

    public function fromOrder()
    {
        return $this->belongsTo('App\Models\Order', 're_order');
    }

    public function reCalculateTotalDiscount()
    {
        if(!empty($this->orderDiscount))
        {
            $mealPackNames = array();
            $orderItemPrices = array();

            foreach($this->orderItems as $orderItem)
            {
                if($orderItem->price > 0)
                {
                    if(!in_array($orderItem->meal_pack, $mealPackNames))
                        $mealPackNames[] = $orderItem->meal_pack;

                    if(!isset($orderItemPrices[$orderItem->meal_pack]))
                        $orderItemPrices[$orderItem->meal_pack] = $orderItem->price;
                    else
                        $orderItemPrices[$orderItem->meal_pack] += $orderItem->price;
                }
            }

            $mealPacks = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->whereIn('name', $mealPackNames)->get();

            $totalMainPackPrice = 0;

            foreach($mealPacks as $mealPack)
            {
                if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                    $totalMainPackPrice += $orderItemPrices[$mealPack->name];
            }

            if($this->orderDiscount->type == Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED)
            {
                if($this->orderDiscount->value < $totalMainPackPrice)
                    $discountAmount = $this->orderDiscount->value;
                else
                    $discountAmount = $totalMainPackPrice;
            }
            else
                $discountAmount = round($totalMainPackPrice * $this->orderDiscount->value / 100);

            $totalPrice = $this->total_line_items_price + $this->total_extra_price + $this->shipping_price;

            $this->orderDiscount->amount = $discountAmount;
            $this->orderDiscount->save();

            $this->total_discounts = $discountAmount;
            $this->total_price = $totalPrice - $discountAmount;
        }
    }
}
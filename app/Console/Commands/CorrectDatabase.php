<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Util;
use App\Models\OrderItem;

class CorrectDatabase extends Command
{
    protected $signature = 'CorrectDatabase';

    protected $description = 'Correct data for new table attribute';

    public function handle()
    {
        $page = 1;
        do
        {
            $orderItems = OrderItem::with('orderItemMeals.orderItemMealDetails')->paginate(100, ['*'], 'page', $page);

            $countOrderItems = count($orderItems);

            if($countOrderItems > 0)
            {
                foreach($orderItems as $orderItem)
                {
                    $shippingDayOfWeek = array();

                    $countShippingDayOfWeek = count($orderItem->orderItemMeals);

                    foreach($orderItem->orderItemMeals as $orderItemsMeal)
                    {
                        $shippingDayOfWeek[] = $orderItemsMeal->day_of_week;

                        $orderItemsMeal->price = $orderItem->price / $countShippingDayOfWeek;
                        $orderItemsMeal->save();
                    }

                    asort($shippingDayOfWeek);

                    $orderItem->shipping_day_of_week = implode(';', $shippingDayOfWeek);

                    $mealPack = strtoupper($orderItem->meal_pack);

                    if($mealPack == 'MEAT LOVER' || $mealPack == 'VEGETARIAN' || $mealPack == 'FULL'
                        || $mealPack == 'FIT 1' || $mealPack == 'FIT 2' || $mealPack == 'FIT 3')
                        $orderItem->main_dish = Util::STATUS_ACTIVE_VALUE;

                    if($countShippingDayOfWeek == 0 && $mealPack == 'MIXED NUTS')
                        $orderItem->shipping_day_of_week = 1;

                    $orderItem->save();
                }
            }

            $page ++;
        }
        while($countOrderItems > 0);
    }
}

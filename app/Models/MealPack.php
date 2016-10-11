<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class MealPack extends Model
{
    protected $table = 'ff_meal_pack';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'price' => 'required|integer|min:1',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if($this->type == Util::MEAL_PACK_TYPE_PACK_VALUE)
        {
            if(empty($this->breakfast) && empty($this->lunch) && empty($this->lunch) && empty($this->fruit) && empty($this->veggies) && empty($this->juice))
                $errors[] = 'Breakfast, Lunch, Dinner, Fruit, Veggies and Juice can not be all empty';
        }

        return $errors;
    }

    public static function getModelActiveMealPack()
    {
        $mealPacks = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        return $mealPacks;
    }
}
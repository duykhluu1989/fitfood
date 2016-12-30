<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'ff_resource';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::updated(function(Resource $resource) {

            if($resource->getOriginal('price') != $resource->getAttribute('price') || $resource->getOriginal('quantity') != $resource->getAttribute('quantity')
                || $resource->getOriginal('calories') != $resource->getAttribute('calories') || $resource->getOriginal('carb') != $resource->getAttribute('carb')
                || $resource->getOriginal('fat') != $resource->getAttribute('fat') || $resource->getOriginal('protein') != $resource->getAttribute('protein'))
            {
                foreach($resource->recipeResources as $recipeResource)
                {
                    $oldRecipeResource = $recipeResource;

                    $recipeResource->price = round($resource->price * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->calories = round($resource->calories * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->carb = round($resource->carb * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->fat = round($resource->fat * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->protein = round($resource->protein * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->save();

                    $recipeResource->recipe->price = $recipeResource->recipe->price - $oldRecipeResource->price + $recipeResource->price;
                    $recipeResource->recipe->calories = $recipeResource->recipe->calories - $oldRecipeResource->calories + $recipeResource->calories;
                    $recipeResource->recipe->carb = $recipeResource->recipe->carb - $oldRecipeResource->carb + $recipeResource->carb;
                    $recipeResource->recipe->fat = $recipeResource->recipe->fat - $oldRecipeResource->fat + $recipeResource->fat;
                    $recipeResource->recipe->protein = $recipeResource->recipe->protein - $oldRecipeResource->protein + $recipeResource->protein;
                    $recipeResource->recipe->save();
                }
            }

        });
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }

    public function recipeResources()
    {
        return $this->hasMany('App\Models\RecipeResource', 'resource_id');
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'code' => 'required|string',
            'category_id' => 'required|integer|min:1',
            'unit_id' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|numeric|min:0',
            'calories' => 'required|numeric|min:0',
            'carb' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }

    public function validateDelete()
    {
        $recipeResource = RecipeResource::where('resource_id', $this->id)->first();

        if(empty($recipeResource))
            return true;

        return false;
    }
}
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

            if($resource->getOriginal('price') != $resource->getAttribute('price') || $resource->getOriginal('quantity') != $resource->getAttribute('quantity'))
            {
                foreach($resource->recipeResources as $recipeResource)
                {
                    $oldRecipeResource = $recipeResource->price;
                    $recipeResource->price = round($resource->price * $recipeResource->quantity / $resource->quantity);
                    $recipeResource->save();

                    $recipeResource->recipe->price = $recipeResource->recipe->price - $oldRecipeResource + $recipeResource->price;
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
            'quantity' => 'required|integer|min:1',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }
}
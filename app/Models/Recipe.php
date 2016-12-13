<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'ff_recipe';

    public $timestamps = false;

    public function recipeResources()
    {
        return $this->hasMany('App\Models\RecipeResource', 'recipe_id');
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'price' => 'required|integer|min:1',
            'calories' => 'required|integer|min:1',
            'carb' => 'required|integer|min:1',
            'fat' => 'required|integer|min:1',
            'protein' => 'required|integer|min:1',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if(count($this->recipeResources) == 0)
            $errors[] = 'Recipe must have at least 1 Resource';

        return $errors;
    }

    public function validateDelete()
    {
        $menuRecipe = MenuRecipe::where('breakfast_id', $this->id)->orWhere('lunch_id', $this->id)->orWhere('dinner_id', $this->id)->first();

        if(empty($menuRecipe))
            return true;

        return false;
    }
}
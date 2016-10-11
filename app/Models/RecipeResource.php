<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeResource extends Model
{
    protected $table = 'ff_recipe_resource';

    public $timestamps = false;

    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe', 'recipe_id');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource', 'resource_id');
    }
}
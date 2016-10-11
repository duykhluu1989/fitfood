<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRecipe extends Model
{
    protected $table = 'ff_menu_recipe';

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    public function breakfastRecipe()
    {
        return $this->belongsTo('App\Models\Recipe', 'breakfast_id');
    }

    public function lunchRecipe()
    {
        return $this->belongsTo('App\Models\Recipe', 'lunch_id');
    }

    public function dinnerRecipe()
    {
        return $this->belongsTo('App\Models\Recipe', 'dinner_id');
    }
}
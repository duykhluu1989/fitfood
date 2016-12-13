<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Menu extends Model
{
    protected $table = 'ff_menu';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::saved(function(Menu $menu) {

            if($menu->status == Util::STATUS_MENU_NEXT_WEEK_VALUE)
            {
                $oldNextWeekMenu = Menu::where('status', Util::STATUS_MENU_NEXT_WEEK_VALUE)->where('id', '<>', $menu->id)->where('type', $menu->type)->first();

                if(!empty($oldNextWeekMenu))
                {
                    $oldNextWeekMenu->status = Util::STATUS_MENU_CURRENT_VALUE;
                    $oldNextWeekMenu->week = null;
                    $oldNextWeekMenu->save();
                }
            }
            else if($menu->status == Util::STATUS_MENU_CURRENT_VALUE)
            {
                $oldCurrentMenu = Menu::where('status', Util::STATUS_MENU_CURRENT_VALUE)->where('id', '<>', $menu->id)->where('type', $menu->type)->first();

                if(!empty($oldCurrentMenu))
                {
                    $oldCurrentMenu->status = Util::STATUS_MENU_LAST_WEEK_VALUE;
                    $oldCurrentMenu->save();
                }
            }
            else if($menu->status == Util::STATUS_MENU_LAST_WEEK_VALUE)
            {
                $oldLastWeekMenu = Menu::where('status', Util::STATUS_MENU_LAST_WEEK_VALUE)->where('id', '<>', $menu->id)->where('type', $menu->type)->first();

                if(!empty($oldLastWeekMenu))
                {
                    $oldLastWeekMenu->status = Util::STATUS_MENU_HIDE_VALUE;
                    $oldLastWeekMenu->save();
                }
            }

        });

    }

    public function menuRecipes()
    {
        return $this->hasMany('App\Models\MenuRecipe', 'menu_id');
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'week' => 'date',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        if(count($this->menuRecipes) == 0)
            $errors[] = 'Menu must have at least 1 Recipe';

        $valid = false;

        foreach($this->menuRecipes as $menuRecipe)
        {
            if($menuRecipe->status == true)
                $valid = true;
        }

        if($valid == false)
            $errors[] = 'Menu must active at least 1 Day';

        if(!empty($this->id))
        {
            if($this->getOriginal('status') != $this->status)
            {
                if($this->getOriginal('status') == Util::STATUS_MENU_CURRENT_VALUE)
                    $errors[] = 'Menu with status Current can not change status';
            }
        }

        return $errors;
    }

    public function validateDelete()
    {
        if($this->status == Util::STATUS_MENU_HIDE_VALUE)
            return true;

        return false;
    }
}
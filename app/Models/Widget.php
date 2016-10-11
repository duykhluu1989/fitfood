<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Widget extends Model
{
    protected $table = 'ff_widget';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }

    public static function getModelActiveWidget()
    {
        $widgets = Widget::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        $activeWidgets = array();

        foreach($widgets as $widget)
            $activeWidgets[$widget->name] = $widget;

        return $activeWidgets;
    }
}
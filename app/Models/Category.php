<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Category extends Model
{
    protected $table = 'ff_category';

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

    public static function getModelActiveCategory()
    {
        $categories = Category::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        return $categories;
    }
}
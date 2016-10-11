<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class BlogCategory extends Model
{
    protected $table = 'ff_blog_category';

    public $timestamps = false;

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'slug' => 'unique:' . $this->table . ',slug,' . $this->id,
            'slug_en' => 'unique:' . $this->table . ',slug_en,' . $this->id,
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }

    public static function getModelActiveCategory()
    {
        $categories = BlogCategory::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        return $categories;
    }
}
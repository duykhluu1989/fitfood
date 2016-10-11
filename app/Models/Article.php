<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'ff_blog_article';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Models\BlogCategory', 'category_id');
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string',
            'slug' => 'unique:' . $this->table . ',slug,' . $this->id,
            'slug_en' => 'unique:' . $this->table . ',slug_en,' . $this->id,
            'published_at' => 'date',
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }
}
<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'ff_blog_tag';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::updated(function(Tag $tag) {

            if($tag->getOriginal('name') != $tag->name && $tag->article > 0)
            {
                $articles = Article::where('tags', 'like', '%' . $tag->getOriginal('name') . '%')->get();

                foreach($articles as $article)
                {
                    $changed = false;
                    $articleTags = explode(';', $article->tags);

                    foreach($articleTags as $key => $articleTag)
                    {
                        if($articleTag == $tag->getOriginal('name'))
                        {
                            $articleTags[$key] = $tag->name;
                            $changed = true;
                        }
                    }

                    if($changed)
                    {
                        $article->tags = implode(';', $articleTags);
                        $article->save();
                    }
                }
            }

        });
    }

    public function validate()
    {
        $errors = array();

        $validator = Validator::make($this->getAttributes(), [
            'name' => 'required|string|unique:' . $this->table . ',name,' . $this->id,
        ]);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }
}
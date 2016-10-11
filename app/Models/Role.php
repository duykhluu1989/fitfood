<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'ff_role';

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
}
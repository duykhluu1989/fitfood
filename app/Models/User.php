<?php

namespace App\Models;

use Validator;
use Illuminate\Foundation\Auth\User as Authenticate;

class User extends Authenticate
{
    protected $table = 'ff_user';

    public $timestamps = false;

    public function userRoles()
    {
        return $this->hasMany('App\Models\UserRole', 'user_id');
    }

    public function validate()
    {
        $errors = array();

        $rules = [
            'username' => 'required|min:3|regex:/^[a-zA-Z0-9]+$/',
        ];

        if(empty($this->id))
            $rules['password'] = 'required|min:6|regex:/^[a-zA-Z0-9]+$/';

        $validator = Validator::make($this->getAttributes(), $rules);

        if($validator->fails())
            $errors = $validator->errors()->all();

        return $errors;
    }
}

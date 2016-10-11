<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Unit extends Model
{
    protected $table = 'ff_unit';

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

    public static function getModelActiveUnit()
    {
        $units = Unit::where('status', Util::STATUS_ACTIVE_VALUE)->get();

        return $units;
    }
}
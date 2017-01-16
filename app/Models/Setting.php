<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Util;

class Setting extends Model
{
    protected $table = 'ff_setting';

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

    public function getSettingValueDetail()
    {
        $valueHtml = '';

        if(!empty($this->value))
        {
            switch($this->type)
            {
                case Util::TYPE_SETTING_JSON_VALUE:

                    $values = json_decode($this->value, true);

                    foreach($values as $key => $value)
                        $valueHtml .= '<b>' . strtoupper($key) . ':</b> ' . $value . '<br />';

                    break;
            }
        }

        return $valueHtml;
    }
}
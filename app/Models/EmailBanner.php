<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBanner extends Model
{
    protected $table = 'ff_email_banner';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
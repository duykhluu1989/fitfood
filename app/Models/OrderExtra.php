<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderExtra extends Model
{
    protected $table = 'ff_order_extra';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
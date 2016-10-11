<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = 'ff_order_address';

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
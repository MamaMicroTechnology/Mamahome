<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposit';
    function order(){
    	return $this->belongsTo('App\Order','orderId','id');
    }
}


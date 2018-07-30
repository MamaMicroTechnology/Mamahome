<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $table = 'check_details';
    function orders(){
    	return $this->belongsTo(Order::class,'orderId','id');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    function payment(){
    	return $this->hasOne('App\Payment','order_id');
    }
    function deposit(){
    	return $this->hasOne('App\Deposit','orderId','id');
    }
    function check(){
    	return $this->hasOne(Check::class,'id','orderId');
    }
    
}

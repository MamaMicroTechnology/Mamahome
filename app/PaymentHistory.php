<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
     protected $table = 'payment_history';
     public function order()
    {
        return $this->belongsTo(Order::class);
    }
      public function user(){
        return $this->belongsTo('App\User','cash_holder','id');
    }
}

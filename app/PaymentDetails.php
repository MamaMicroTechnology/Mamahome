<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $table = 'payment_details';
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
     public function user(){
        return $this->belongsTo('App\User','cash_holder','id');
    }
}

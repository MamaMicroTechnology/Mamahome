<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payment";
    function order(){
    	return $this->belongsToOne('App\Deposit');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tlwards extends Model
{
    protected $table = 'tlwards';

    function ward(){
    	return $this->belongsTo(Ward::class,'id','ward_id');
    }
    function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
     public function department()
    {
        return $this->belongsTo('App\Department');
    }
}

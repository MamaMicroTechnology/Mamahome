<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tlwards extends Model
{
    protected $table = 'tlwards';

    function ward(){
    	return $this->belongsTo(Ward::class,'id','ward_id');
    }
}

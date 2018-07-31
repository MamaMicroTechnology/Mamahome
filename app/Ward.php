<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';
    public function subward()
    {
    	return $this->hasMany('App\SubWard');
    }
     function tlward(){
    	return $this->hasOne(Tlwards::class,'id','ward_id');
    }
}

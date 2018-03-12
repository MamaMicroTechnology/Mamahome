<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    public function country()
    {
    	return $this->belongsTo('App\Country');
    }
    public function state()
    {
    	return $this->hasMany('App\State');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public function territory()
    {
    	return $this->hasMany('App\Territory');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WardAssignment extends Model
{
    protected $table = 'ward_assignments';
    public function subward()
    {
    	return $this->belongsTo('App\SubWard');
    }
}

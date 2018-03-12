<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $table = 'requirements';
    public function user(){
        return $this->belongsTo('App\User');
    }
}

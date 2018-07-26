<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $table = 'requirements';
    public function user(){
        return $this->belongsTo('App\User','generated_by','id');
    }
    public function project(){
        return $this->belongsTo('App\ProjectDetails','project_id','project_id');
    }
}

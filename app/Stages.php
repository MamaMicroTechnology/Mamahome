<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    protected  $fillable =[
    	'list','status'
      ];
      protected $primarykey ='id';
}

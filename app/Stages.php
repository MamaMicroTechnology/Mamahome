<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Stages extends Model
{
      protected $primarykey ='id';
      use LogsActivity;
      protected  $fillable =[
    	'status','created_at','updated_at',
      ];
   
 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

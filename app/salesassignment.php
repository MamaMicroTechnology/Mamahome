<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class salesassignment extends Model
{
    protected $table = 'salesassignments';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','user_id','assigned_date','prev_assign','status',
	];

 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}
 
 
 
 
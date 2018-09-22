<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RoomType extends Model
{
    protected $table = 'room_types';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','project_id','room_type','floor_no','no_of_rooms',
	];
	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

 
 
 
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class UserLocation extends Model
{
    use LogsActivity;
    protected  $fillable =[
        'user_id',
 'latitude',
 'longitude',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class TrackLocation extends Model
{
    protected $table = 'tracking_location';
    use LogsActivity;
    protected  $fillable =[
        'user_id','lat_long','time','date','kms',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

 
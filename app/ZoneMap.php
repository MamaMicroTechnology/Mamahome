<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ZoneMap extends Model
{
    use LogsActivity;
    protected  $fillable =[
       'zone_id',
'color',
'lat',
      ];
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

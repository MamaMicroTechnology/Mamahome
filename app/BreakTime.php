<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BreakTime extends Model
{
     protected $table = 'breaktime';
     use LogsActivity;



protected $fillable = ['user_id',
'start_time',
'stop_time',
'date ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

}

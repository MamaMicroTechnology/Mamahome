<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class training extends Model
{
    protected $table = 'trainings';
    use LogsActivity;
    protected  $fillable =[
        'dept','designation','upload','remark','viewed_by',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class attendance extends Model
{
    protected $table = 'empattendance';


   use LogsActivity;



protected $fillable = ['empId',
'date',
'inTIme',
'outTime',
'place',
'grade',
'remarks',
'am_remarks ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;






}

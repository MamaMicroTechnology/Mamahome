<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificate extends Model
{
    protected $table = 'certificates';
    use LogsActivity;



protected $fillable = ['employeeId',
'type',
'location ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

}

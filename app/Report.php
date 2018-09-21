<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Report extends Model
{
    protected $table = 'reports';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','empId','report','start','end',
	];
	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}
	

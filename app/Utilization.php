<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Utilization extends Model
{
    use LogsActivity;
    protected  $fillable =[
        
'planning',
'digging',
'foundation',
'pillars',
'walls',
'roofing',
'electrical',
'plumbing',
'plastering',
'flooring',
'carpentry',
'painting',
'fixture',
'completion',
'closed',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}
	

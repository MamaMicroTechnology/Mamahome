<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Assignenquiry extends Model
{
       use LogsActivity;
    protected $table = 'assignenquiry';



protected $fillable = ['user_id','ward','subward','cat','brand','sub','dateenq',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
}

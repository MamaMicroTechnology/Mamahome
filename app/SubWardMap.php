<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class SubWardMap extends Model
{
    protected $table = 'sub_ward_maps';

    use LogsActivity;
    protected  $fillable =[
        'sub_ward_id','lat','color',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

 
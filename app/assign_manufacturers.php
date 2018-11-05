<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class assign_manufacturers extends Model
{
     use LogsActivity;



protected $fillable = ['user_id','ward','subward','totalarea','capacity','present_utilization','capacityt','totalareat','persentto','cementto','sandt','agrrigatet','cement_requiernment','sand_requiernment','manufacture_type','data','aggregates_required',
];


 protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
}
	
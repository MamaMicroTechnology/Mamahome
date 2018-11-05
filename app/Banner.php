<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Banner extends Model
{
    protected $table = 'banners';

     use LogsActivity;



protected $fillable = ['title',
'info',
'image ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
}

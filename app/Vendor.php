<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Vendor extends Model
{
    protected $table = 'vendor';
    use LogsActivity;
    protected  $fillable =[
        'vendor_type',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

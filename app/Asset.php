<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends Model
{
    use LogsActivity;
    protected $table = 'assets';
     use LogsActivity;



protected $fillable = ['type','created_at','updated_at'];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
}

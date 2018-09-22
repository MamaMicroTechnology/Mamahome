<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class numbers extends Model
{
      use LogsActivity;
      protected $table = 'numbers';
      protected $fillable = [
            'number'
      ];
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
      protected static $logOnlyDirty = true;
}

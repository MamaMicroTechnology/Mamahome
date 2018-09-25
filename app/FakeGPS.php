<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FakeGPS extends Model
{
    use LogsActivity;
     protected $table = "fakegps";
     protected $fillable = [	
        'user_id',
        'date',
        'fakegps',
        'time'
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

}

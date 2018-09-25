<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Planning extends Model
{
    use LogsActivity;
    protected $fillable = [ 	
        'incremental_percentage',
        'type',
        'totalTarget',
        'totalTP',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}
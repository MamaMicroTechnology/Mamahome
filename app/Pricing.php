<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Pricing extends Model
{
    use LogsActivity;
    protected $table = 'pricing';
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Projection extends Model
{
    use LogsActivity;
    protected $fillable = [ 	
        'category',
        'price',
        'business_cycle',
        'target',
        'transactional_profit',
        'incremental_percentage',
        'from_date',
        'to_date',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

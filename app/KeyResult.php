<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KeyResult extends Model
{
    use LogsActivity;
    protected $table = 'key_results';
    protected $fillable = [	
        'id',
        'department_id',
        'group_id',
        'role',
        'goal',
        'key_result_area',
        'key_performance_area'
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

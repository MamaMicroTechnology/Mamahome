<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class History extends Model
{
    use LogsActivity;
    protected $table = 'history';
    protected $fillable = [ 	
        'user_id',
        'project_id',
        'called_Time',
        'username',
        'question',
        'remarks',
        'manu_id',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class numbercount extends Model{
    use LogsActivity;
    protected $table = 'numbercount';
    protected $fillable = [
        'user_id',
        'num'
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

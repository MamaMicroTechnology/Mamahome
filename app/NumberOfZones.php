<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NumberOfZones extends Model
{
    use LogsActivity;
    protected $fillable = [
                'month',
                'grade_a',
                'grade_b',
                'grade_c',
                'grade_d',
                'grade_e',
            ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

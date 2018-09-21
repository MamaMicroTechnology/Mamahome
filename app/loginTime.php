<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class loginTime extends Model
{
    use LogsActivity;
    protected $table='login_times';
    protected $fillable = [
            'user_id',
            'logindate',
            'loginTime',
            'login_time_in_ward',
            'firstListingTime',
            'firstUpdateTime',
            'allocatedWard',
            'morningRemarks',
            'morningMeter',
            'morningData',
            'gtracing',
            'kmfromhtw',
            'afternoonMeter',
            'afternoonData',
            'ward_tracing_image',
            'km_from_software',
            'noOfProjectsListedInMorning',
            'noOfProjectsUpdatedInMorning',
            'afternoonRemarks',
            'eveningMeter',
            'eveningData',
            'evening_ward_tracing_image',
            'evening_km_from_tracking',
            'tracing_image_w_to_h',
            'km_from_w_to_h',
            'TotalProjectsListed',
            'totalProjectsUpdated',
            'lastListingTime',
            'lastUpdateTime',
            'logoutTime',
            'total_kilometers',
            'eveningRemarks',
            'AmGrade',
            'AmRemarks',
            'tracktime'
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

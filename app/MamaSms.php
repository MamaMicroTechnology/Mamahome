<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MamaSms extends Model
{
    use LogsActivity;
    protected $table = 'mama_sms';
    protected $fillable = [        	
            'sim_number',
            'totalnumber',
            'user_id',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

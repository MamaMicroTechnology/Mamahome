<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MamahomeAsset extends Model
{
    use LogsActivity;
    protected $table = 'mamahome_assets';
    protected $fillable = [  	
        'asset_id',
        'name',
        'sl_no',
        'asset_image',
        'description',
        'company',
        'date',
        'bill',
        'remark',
        'sim_remark',
        'sim_number',
        'provider',
        'status'
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

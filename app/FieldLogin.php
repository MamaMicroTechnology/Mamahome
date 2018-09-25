<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FieldLogin extends Model
{
    use LogsActivity;
    protected $table = 'field_login';
    protected $fillable = [  	
                        'user_id',
                        'logindate',
                        'logintime',
                        'latitude',
                        'longitude',
                        'address',
                        'remark',
                        'tlapproval',
                        'adminapproval',
                        'logout',
                        'logout_lat',
                        'logout_long',
                        'logout_address',
                        'status',
                        'hrapproval'
                    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

}

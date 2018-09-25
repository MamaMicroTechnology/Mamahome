<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
    use LogsActivity;
    protected $table = "payment";
    function order(){
    	return $this->belongsToOne('App\Deposit');
    }
    protected $fillable = [ 	
        'project_id',
        'c_name',
        'p_method',
        'amount',
        'advance_amount',
        'log_name',
        'order_id',
        'signature',
        'signature1',
        'payment_status',
        'rtgs',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

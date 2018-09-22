<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Deposit extends Model
{
    protected $table = 'deposit';

protected $fillable = ['orderId',
'bankname',
'Amount',
'bdate',
'image',
'created_at',
'updated_at',
'location',
'user_id',
'zone_id ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;



    function order(){
    	return $this->belongsTo('App\Order','orderId','id');
    }
}


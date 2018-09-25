<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Check extends Model
{
    protected $table = 'check_details';

  use LogsActivity;



protected $fillable = ['project_id',
'orderId',
'checkno',
'amount',
'date',
'image',
'created_at',
'updated_at',
'remark',
'bank ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;



    function orders(){
    	return $this->belongsTo(Order::class,'orderId','id');
    }
}

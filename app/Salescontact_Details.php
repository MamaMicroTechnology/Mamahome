<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Salescontact_Details extends Model
{
	 protected $table='salescontact_details';
	 use LogsActivity;
    protected $fillable = ['created_at','updated_at','manu_id','name','email','contact','contact1',
	];

 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

     public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
}
 
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class State extends Model
{
	protected $table = 'states';
	use LogsActivity;
    protected  $fillable =[
    	'status','created_at','updated_at','zone_id','state_name',
      ];
   
 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
	public function zone()
	{
		return $this->belongsTo('App\Zone');
	}
}


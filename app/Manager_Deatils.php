<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Manager_Deatils extends Model
{
	use LogsActivity;
	protected $table='manager_details';
	protected $fillable = [	
				'manu_id',
				'name',
				'email',
				'contact',
				'contact1',
			];
	  public function manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
	}
	protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SiteAddress extends Model
{
    protected $table = 'site_addresses';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','project_id','latitude','longitude','address',
	];

 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

 
 
 

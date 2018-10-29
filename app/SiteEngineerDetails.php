<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteEngineerDetails extends Model
{
    protected $table = 'site_engineer_details';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','project_id','site_engineer_name','site_engineer_contact_no','site_engineer_email',
	];
        use SoftDeletes;

 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

 
 
 
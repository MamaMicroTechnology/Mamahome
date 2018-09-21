<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class OwnerDetails extends Model
{
    use LogsActivity;
    protected $table = 'owner_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
    protected $fillable = [ 	
        'project_id',
        'owner_name',
        'owner_contact_no',
        'owner_email',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

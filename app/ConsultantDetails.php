<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ConsultantDetails extends Model
{
    protected $table = 'consultant_details';

    use LogsActivity;



protected $fillable = ['project_id',
'consultant_name',
'consultant_contact_no',
'consultant_email ',
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

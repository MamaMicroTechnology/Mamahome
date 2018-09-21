<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ContractorDetails extends Model
{
    protected $table = 'contractor_details';

   use LogsActivity;



protected $fillable = ['project_id',
'contractor_name',
'contractor_contact_no',
'contractor_emai',
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

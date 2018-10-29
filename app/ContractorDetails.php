<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractorDetails extends Model
{
    protected $table = 'contractor_details';

   use LogsActivity;
        use SoftDeletes;



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

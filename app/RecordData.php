<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class RecordData extends Model
{
    protected $table = 'record_data';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','rec_project','rec_date','rec_name','rec_contact','rec_email','rec_product','rec_location','rec_quantity','rec_remarks',
	];

 	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;


}











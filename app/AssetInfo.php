<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetInfo extends Model
{
    protected $table = 'asset_infos';
    protected $primaryKey = 'mh_id';

     use LogsActivity;



protected $fillable = ['employeeId','asset_type','id','name','serial_no','emp_signature','image','assign_date','remark','description','manager_signature','provider','sim_number','sim_remark',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
}

	 	
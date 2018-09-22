<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class WardAssignment extends Model
{
    protected $table = 'ward_assignments';
         use LogsActivity;

protected $fillable = ['user_id','subward_id','prev_subward_id','status','created_at','updated_at',
];


 	protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
    public function subward()
    {
    	return $this->belongsTo('App\SubWard');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    protected $table = 'departments';


use LogsActivity;



protected $fillable = ['dept_name',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;



    public function user()
    {
    	return $this->hasOne('App\User');
    }
     public function department()
    {
        return $this->belongsTo('App\User','id','department_id');
    }
}

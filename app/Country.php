<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    protected $table = 'countries';

     use LogsActivity;



protected $fillable = ['country_code',
'country_name',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;


    public function territory()
    {
    	return $this->hasMany('App\Territory');
    }
}
 
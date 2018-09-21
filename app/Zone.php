<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Zone extends Model
{
    protected $table = 'zones';
    use LogsActivity;
    protected  $fillable =[
       'country_id',
'zone_name',
'zone_number',
'zone_image',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
    public function country()
    {
    	return $this->belongsTo('App\Country');
    }
    public function state()
    {
    	return $this->hasMany('App\State');
    }
}

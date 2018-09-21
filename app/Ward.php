<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Ward extends Model
{
    protected $table = 'wards';
    use LogsActivity;
    protected  $fillable =[
        'country_id',
 'zone_id',
 'state_id',
 'ward_name',
 'ward_image',
' ward_image_2',
' ward_image_3',
' ward_image_4',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
    public function subward()
    {
    	return $this->hasMany('App\SubWard');
    }
     function tlward(){
    	return $this->hasMany(Tlwards::class,'id','ward_id');
    }
}

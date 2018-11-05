<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class SubWard extends Model
{
    protected $table = 'sub_wards';

    use LogsActivity;
    protected  $fillable =[
        'ward_id','sub_ward_name','sub_ward_image',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

    public function ward()
    {
    	return $this->belongsTo('App\Ward');
    }
    public function wardassignment(){
    	return $this->hasMany('App\WardAssignment');
    }
   public function activity()
    {
    	return $this->hasMany(Activity::class,'sub_ward_id','id');
    } 
     public function req(){
        return $this->belongsTo('App\Requirement');
    }
}
 
 
 
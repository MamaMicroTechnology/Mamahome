<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Tlwards extends Model
{
    protected $table = 'tlwards';
    use LogsActivity;
    protected  $fillable =[
        'user_id','group_id','ward_id','users',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;
    function ward(){
    	return $this->belongsTo(Ward::class,'id','ward_id');
    }
    function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
     public function department()
    {
        return $this->belongsTo('App\Department');
    }
}

 

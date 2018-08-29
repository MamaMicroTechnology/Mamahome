<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    public function subward()
    {
    	return $this->belongsTo('App\SubWard','sub_ward_id','id');
    } 
     public function user()
    {
    	return $this->belongsTo('App\User','updater','id');
    } 
    public function user1()
    {
    	return $this->belongsTo('App\User','enquiry','id');
    } 
}

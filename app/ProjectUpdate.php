<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    
    protected $table = 'project_updates';
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
   public function subwardids()
    {
      return $this->hasOne('App\SubWard','id','sub_ward_id');
    
    } 
    public function siteaddress()
    {
    	return $this->hasOne("App\SiteAddress",'project_id','project_id');
    }
}

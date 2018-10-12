<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;

class ProjectDetails extends Model
{
        use SoftDeletes;
         use LogsActivity;
    protected $table = 'project_details';
    protected $primaryKey = 'project_id';

    protected $fillable = [

       'sub_ward_id','project_name','construction_type','interested_in_rmc','interested_in_loan','interested_in_doorsandwindows',' road_width','road_name','municipality_approval','other_approvals','project_status','quality','contract','basement','ground',  'project_type' ,'project_size' ,   'budget' , 'image' ,  'remarks' ,    'note'   , 'reqDate',     'listing_engineer_id' ,    'created_at' , 'updated_at', 'with_cont', 'followup', 'follow_up_by','confirmed','call_attended_by ','updated_by',' deleted','budgetType','follow_up_date','length ', 'breadth' ,'plotsize', 'user_id', 'automation', 'interested_in_premium', 'brilaultra','detailed_mcal','deleted_at','res',
                         ];
protected static $logFillable = true;
     protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
    public function siteaddress()
    {
    	return $this->hasOne("App\SiteAddress",'project_id','project_id');
    }
    public function ownerdetails()
    {
    	return $this->hasOne('App\OwnerDetails','project_id','project_id');
    }
    public function consultantdetails()
    {
    	return $this->hasOne('App\ConsultantDetails','project_id','project_id');
    }
    public function contractordetails()
    {
    	return $this->hasOne('App\ContractorDetails','project_id','project_id');
    }
    public function siteengineerdetails()
    {
    	return $this->hasOne('App\SiteEngineerDetails','project_id','project_id');
    }
    public function procurementdetails()
    {
    	return $this->hasOne('App\ProcurementDetails','project_id','project_id');
    }
     public function builders()
    {
        return $this->hasOne('App\Builder','project_id','project_id');
    }
    public function requirement()
    {
    	return $this->hasOne('App\Requirement','project_id','project_id');
    }
     public function subward()
    {
      return $this->hasOne('App\SubWard','sub_ward_id','id');
    
    } 
    public function user(){
        return $this->belongsTo('App\User','listing_engineer_id','id');
    }
}

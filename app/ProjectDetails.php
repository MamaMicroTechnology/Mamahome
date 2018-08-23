<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    protected $table = 'project_details';
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
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
   use SoftDeletes;
    protected $table = 'requirements';
    use LogsActivity;
    protected $fillable = ['created_at','updated_at','project_id','main_category','brand','sub_category','material_spec','referral_image1','referral_image2','requirement_date','measurement_unit','unit_price','quantity','total','notes','follow_up','follow_up_by','status','Truck','payment_status','delivery_status','dispatch_status','generated_by','converted_by','A_contact','billadress','ship','updated_by','total_quantity','enquiry_quantity','manu_id','product','sub_ward_id',
	];
	  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

    public function user(){
        return $this->belongsTo('App\User','generated_by','id');
    }
     public function conuser(){
        return $this->belongsTo('App\User','converted_by','id');
    }
    public function project(){
        return $this->belongsTo('App\ProjectDetails','project_id','project_id');
    }
    public function procurementdetails()
    {
      return $this->hasOne('App\ProcurementDetails','project_id','project_id');
    
    }
     public function subward()
    {
      return $this->hasOne('App\SubWard','id','sub_ward_id');
    
    }
    public function manu()
    {
      return $this->hasOne('App\Manufacturer','id','manu_id');
    
    }
     public function proc()
    {
      return $this->hasOne('App\Mprocurement_Details','manu_id','manu_id');
    }
    public function siteaddress(){
        return $this->belongsTo('App\SiteAddress','project_id','project_id');
    }
    public function quot(){
        return $this->belongsTo('App\Quotation','id','req_id');
    }
    
}
	














<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public function manufacturerProduct(){
        return $this->hasMany('App\ManufacturerProduce');
    }
     public function Manager()
    {
    	return $this->hasOne('App\Manager_Deatils','manu_id','id');
    }
    public function sales()
    {
    	return $this->hasOne('App\Salescontact_Details','manu_id','id');
    }
    public function proc()
    {
    	return $this->hasOne('App\Mprocurement_Details','manu_id','id');
    }
    public function owner()
    {
    	return $this->hasOne('App\Mowner_Deatils','manu_id','id');
    }
}




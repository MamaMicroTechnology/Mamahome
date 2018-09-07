<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mowner_Deatils extends Model
{
	 protected $table='mowner_details';

	  public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
   
}

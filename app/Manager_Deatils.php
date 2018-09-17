<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager_Deatils extends Model
{

	 protected $table='manager_details';
	  public function manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
}

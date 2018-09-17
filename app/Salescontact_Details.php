<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salescontact_Details extends Model
{
	 protected $table='salescontact_details';
     public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
}

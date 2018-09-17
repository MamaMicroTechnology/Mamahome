<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mprocurement_Details extends Model
{
    //
	 protected $table='mprocurement_details';
 public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
}

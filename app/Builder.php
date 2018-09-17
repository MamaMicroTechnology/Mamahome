<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
   protected $table = 'builders';
   public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

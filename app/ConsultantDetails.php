<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantDetails extends Model
{
    protected $table = 'consultant_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

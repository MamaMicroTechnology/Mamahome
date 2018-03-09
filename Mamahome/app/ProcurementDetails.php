<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcurementDetails extends Model
{
    protected $table = 'procurement_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

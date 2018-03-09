<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorDetails extends Model
{
    protected $table = 'contractor_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

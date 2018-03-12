<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteEngineerDetails extends Model
{
    protected $table = 'site_engineer_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

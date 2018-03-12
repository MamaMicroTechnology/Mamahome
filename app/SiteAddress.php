<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteAddress extends Model
{
    protected $table = 'site_addresses';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

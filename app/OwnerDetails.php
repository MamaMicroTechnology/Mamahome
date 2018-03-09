<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerDetails extends Model
{
    protected $table = 'owner_details';
    public function projectdetails()
    {
    	return $this->belongsTo("App\ProjectDetails");
    }
}

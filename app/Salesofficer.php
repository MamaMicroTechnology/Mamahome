<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesofficer extends Model
{
      protected $table = 'salesofficers';
       public function user()
    {
    	return $this->hasOne("App\User",'id','user_id');
    }
}

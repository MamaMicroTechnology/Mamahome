<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProjectAssign extends Model
{
<<<<<<< HEAD
    //
=======
      public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
>>>>>>> master
}

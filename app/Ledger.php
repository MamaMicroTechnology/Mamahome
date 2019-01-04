<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
     protected $table='ledgers';

      public function acc(){
        return $this->belongsTo('App\AccountHead','accounthead','id');
    }
     public function sub(){
        return $this->belongsTo('App\Subaccountheads','subhead','id');
    }


}

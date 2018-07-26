<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufacturerProduce extends Model
{
    public function manufacturer(){
        return $this->belongsTo('App\Manufacturer');
    }
}

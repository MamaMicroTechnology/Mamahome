<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public function manufacturerProduct(){
        return $this->hasMany('App\ManufacturerProduce');
    }
}

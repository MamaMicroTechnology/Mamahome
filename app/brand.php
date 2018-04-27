<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    protected $table = "brands";

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function SubCategory()
    {
        return $this->hasMany('App\SubCategory');
    }
}

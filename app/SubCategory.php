<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\CategoryPrice;

class SubCategory extends Model
{
    protected $table = 'category_sub';
    public function category(){
        return $this->belongsTo("App\Category");
    }
    public function categoryprice(){
        return $this->hasMany("App\CategoryPrice");
    }
    public function brand(){
    	return $this->belongsTo("App\brand");
    }
}

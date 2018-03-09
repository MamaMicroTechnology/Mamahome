<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SubCategory;

class CategoryPrice extends Model
{
    protected $table = 'category_price';
    public function subcategory(){
        return $this->belongsTo("App\SubCategory",'category_sub_id','id');
    }
}

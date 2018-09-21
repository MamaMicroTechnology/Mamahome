<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\CategoryPrice;
use Spatie\Activitylog\Traits\LogsActivity;

class SubCategory extends Model
{
    protected $table = 'category_sub';
    use LogsActivity;
    protected  $fillable =[
        'created_at','updated_at','category_id','brand_id','Quantity','sub_cat_name',
      ];
   
      protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";
      protected static $logFillable = true;

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

 
 
 
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SubCategory;
use Spatie\Activitylog\Traits\LogsActivity;

class CategoryPrice extends Model
{
    protected $table = 'category_price';

 use LogsActivity;



protected $fillable = ['category_id',
'category_sub_id',
'price',
'gst',
'transportation_cost',
'royalty ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;


    public function subcategory(){
        return $this->belongsTo("App\SubCategory",'category_sub_id','id');
    }
}

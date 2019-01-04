<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class brand extends Model
{
    protected $table = "brands";


     use LogsActivity;



protected $fillable = ['category_id',
'brand',
'created_at',
'updated_at 1',
'brandimage ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function SubCategory()
    {
        return $this->hasMany('App\SubCategory');
    }
    
}

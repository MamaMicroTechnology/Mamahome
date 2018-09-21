<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    protected $table = 'category';


     use LogsActivity;



protected $fillable = ['category_name',
'measurement_unit',
'created_at ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
    public function brand(){
        return $this->hasMany("App\brand");
    }


}

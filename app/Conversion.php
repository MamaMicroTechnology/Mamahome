<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Conversion extends Model
{
    protected $table = 'conversion';


   use LogsActivity;



protected $fillable = ['category',
'minimum_requirement',
'price_per_unit',
'conversion',
'unit',
'business_cycle',
'created_at',
'updated_at',
'per',
'full_form',
'average_price',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

}

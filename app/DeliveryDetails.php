<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DeliveryDetails extends Model
{ 
 use LogsActivity;



protected $fillable = ['order_id',
'vehicle_no',
'location_picture',
'quality_of_material',
'delivery_video',
'delivery_date ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;
}

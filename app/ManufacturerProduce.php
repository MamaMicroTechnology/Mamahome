<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ManufacturerProduce extends Model
{
    use LogsActivity;
    public function manufacturer(){
        return $this->belongsTo('App\Manufacturer');
    }
    protected $fillable = [
            'manufacturer_id',
            'block_type',
            'block_size',
            'price',
        ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

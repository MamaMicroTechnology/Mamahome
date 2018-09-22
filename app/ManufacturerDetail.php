<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ManufacturerDetail extends Model
{
    use LogsActivity;
    protected $table = 'manufacturer_details';
    protected $primaryKey = 'manufacturer_id';
    protected $fillable = [
            'manufacturer_id',
            'vendortype',
            'company_name',
            'category',
            'cin',
            'gst',
            'registered_office',
            'pan',
            'production_capacity',
            'factory_location',
            'ware_house_location',
            'md',
            'ceo',
            'sales_contact',
            'finance_contact',
            'quality_department',
        ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MhInvoice extends Model
{
    use LogsActivity;
    protected $table = 'mh_invoice';
    protected $fillable = [
            'invoice_id',
            'project_id',
            'requirement_id',
            'customer_name',
            'deliver_location',
            'delivery_date',
            'item',
            'quantity',
            'price',
            'invoice_pic',
            'signature',
            'weighment_slip',
            'amount_to_manufacturer',
            'mama_invoice_amount',
            'transactional_profit',
            'manufacturer_number',
            'date_of_invoice',
            'total_amount',
            'manufacturer_invoice',
        ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

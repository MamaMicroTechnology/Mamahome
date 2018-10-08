<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use LogsActivity;
    protected $table = 'orders';
    function payment(){
    	return $this->hasOne('App\Payment','order_id');
    }
    function deposit(){
    	return $this->hasOne('App\Deposit','orderId','id');
    }
    function check(){
    	return $this->hasOne(Check::class,'id','orderId');
    }
    protected $fillable = [
            'project_id',
            'req_id',
            'main_category',
            'brand',
            'sub_category',
            'material_spec',
            'referral_image1',
            'referral_image2',
            'requirement_date',
            'measurement_unit',
            'unit_price',
            'quantity',
            'total',
            'notes',
            'status',
            'Truck',
            'payment_status',
            'delivery_status',
            'dispatch_status',
            'generated_by',
            'signature',
            'delivery_boy',
            'delivered_on',
            'payment_mode',
        ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

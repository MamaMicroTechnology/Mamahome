<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Supplierdetails extends Model
{
	use LogsActivity;
    protected $table = 'supplierdetails';
    protected $primaryKey = 'id';

      protected $fillable = [
'manu_id',
'supplier_name',
'gst',
'description',
'quantity',
'unit',
'unit_price',
'amount',
'amount_words',
'order_id',
'created_at' ,
'updated_at',
'totalamount',
'tamount_words',
'lpo',
'unitwithoutgst',
'address',
'cgstpercent',
'sgstpercent',
'gstpercent',
        ];
     protected static $logFillable = true;
     protected static $logOnlyDirty = true; 
     protected static $causerId = 3;
      public function brand(){
        return $this->belongsTo('App\brand','brand','supplier_name');
    }
    //  public function cat(){
    //     return $this->belongsTo('App\Category','id','category');
    // }
    public function st(){
        return $this->belongsTo('App\State','state','id');
    }
}


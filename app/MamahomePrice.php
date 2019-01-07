<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MamahomePrice extends Model
{
	 use SoftDeletes;
         use LogsActivity;
     protected $table = 'mamahome_invoices';
     protected $primaryKey = 'id';

      protected $fillable = [

       'quantity','mamahome_price','unitwithoutgst','totalamount','cgst','sgst',' totaltax','amountwithgst','order_id','unit','amount_word','tax_word','gstamount_word','manu_id','description',  'billaddress' ,'shipaddress' ,   'edited' , 'cgstpercent' ,  'sgstpercent' ,    'gstpercent'   , 'updated_by',     'invoiceno' ,    'created_at' , 'updated_at', 
                         ];
                         protected static $logFillable = true;
     protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
}
















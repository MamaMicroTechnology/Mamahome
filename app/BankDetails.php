<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BankDetails extends Model
{
    protected $table = 'bank_details';

 use LogsActivity;



protected $fillable = ['employeeId',
'accountHolderName',
'bank_name',
'accountNo',
'ifsc',
'passbook',
'pan_card_no',
'pan_card_image',
'branchName ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

} 

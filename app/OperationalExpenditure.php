<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class OperationalExpenditure extends Model
{
    use LogsActivity;
    protected $fillable = [
                    'salary',
                    'office_rent',
                    'petrol',
                    'travelling',
                    'telephone_charges',
                    'miscellineous',
                    'mmt_user_fee',
                ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

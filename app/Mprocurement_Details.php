<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Mprocurement_Details extends Model
{
    use LogsActivity;
	protected $table='mprocurement_details';
    public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer",'manu_id','id');
    }
    protected $fillable = [	
            'manu_id',
            'name',
            'email',
            'contact',
            'contact1',
        ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

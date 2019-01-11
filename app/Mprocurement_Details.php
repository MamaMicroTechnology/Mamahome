<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Mprocurement_Details extends Model
{
      use SoftDeletes;
    use LogsActivity;
	protected $table='mprocurement_details';
    public function Manufacturer()
    {
    	return $this->belongsTo("App\Manufacturer");
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

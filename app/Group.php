<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use LogsActivity;
    protected $table='groups';
    protected $fillable = [
        'group_name'
    ];
    public function user(){
    	return $this->hasMany('App\User');
    }
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

}

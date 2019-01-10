<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class CustomerProjectAssign extends Model
{
     

    use LogsActivity;
 protected $fillable = [
            'project_id',
            'user_id',
        ];


    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;




      public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}

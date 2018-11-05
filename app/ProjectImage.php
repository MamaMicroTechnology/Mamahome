<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectImage extends Model
{
    use LogsActivity;
     protected $table = 'project_image';
     protected $fillable = [ 	
        'project_id',
        'project_status',
        'image',
    ];
    protected static $causerId = 3;
    protected static $logName = "";
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
}

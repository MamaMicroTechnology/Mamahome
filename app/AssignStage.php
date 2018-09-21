<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class AssignStage extends Model

{


use LogsActivity;

protected $fillable = ['user_id',
'sub_id',
'ward',
'id',
'subward',
'stage',
'assigndate',
'project_type',
'project_size',
'budget',
'contract_type',
'constraction_type',
'rmc',
'budget_type',
'prv_ward',
'prv_subward',
'prv_date',
'prv_stage',
'state',
'quality',
'created_at',
'updated_at',
'Floor',
'basement',
'base',
'Floor2',
'total',
'projectsize',
'budgetto',
'Count',
'project_ids',
'time',
'instruction',
'remark',
'group_id',
'auto',
'Premium',
'bank',
'door',
'undate ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

     protected $table = 'assignstage';
}

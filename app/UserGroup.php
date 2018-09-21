<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class UserGroup extends Model
{
    protected $table = 'user_groups';
}

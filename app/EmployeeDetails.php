<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeDetails extends Model
{
    protected $table = 'employee_details';


    use LogsActivity;



protected $fillable = ['employee_id',
'date_of_joining',
'adhar_no',
'aadhar_image',
'dob',
'blood_group',
'fathers_name',
'mothers_name',
'spouse_name',
'alt_phone',
'office_phone',
'official_email',
'mh_email',
'personal_email',
'permanent_address',
'permanent_address_proof',
'temporary_address',
'temporary_address_proof',
'emergency_contact_name',
'emergency_contact_no',
'emergency_contact2_name',
'emergency_contact2_no',
'curriculum_vite',
'confirmation_call',
'confirmation_call2',
'verification_status ',
];


  protected static $logOnlyDirty = true; 
      protected static $causerId = 3;
      protected static $logName = "";

      protected static $logFillable = true;

}

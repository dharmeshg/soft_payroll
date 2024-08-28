<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'workinstitutionname',
     'workstartdate',
     'workenddate',
     'workduration',
     'workdepartment',
     'workdesignation',
     'workpostheld',
     'workgradelevel',
     'workstep',
     'workcadre',
     'employee_id',
     'user_id'
    ];
     public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
  }
}

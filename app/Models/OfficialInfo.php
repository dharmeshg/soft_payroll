<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficialInfo extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory,SoftDeletes;

    protected $dates = ['dateofemployment'];
    protected $fillable = [
      'staff_id',
      'directorate',
      'department',
      'designation',
      'cadre',
      'highestqualification',
      'gradelevel',
      'step',
      'areaofstudy',
      'dateofemployment',
      'typeofemployment',
      'user_id',
      'employee_id',
      'officialinfoother',
      'role',
      'expectedretirementdate',
      'unit'
    ];

  public function employee_detail()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
   public function departments()
    {
        return $this->hasOne(Department::class);
    }

    public function departments_dt()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function faculty_dt()
    {
        return $this->belongsTo(FacultyDirectorate::class, 'directorate');
    }
    public function unit_dt()
    {
        return $this->belongsTo(Unit::class,'unit');
    }

    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }
    

    
}

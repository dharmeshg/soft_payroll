<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'transferclass',
    'transfertype',
    'transfercategory',
    'transferreason',
    'nameofstaff',
    'staffid',
    'faculty',
    'department',
    'unit',
    'previous_role',
    'hou_status',
    'hod_status',
    'hof_status',
    'insti_status',
    'institutionname',
    'transferfaculty',
    'transferdepartment',
    'transferunit',
    'user_id',
    'status',
    'other',
    'initiate',
    'process_by',
    'authorize_by_hou',
    'authorize_by_hod',
    'authorize_by_hof',
    'approve_by',
    'approve_by_insti',
    'process_datetime',
    'hou_datetime',
    'hod_datetime',
    'hof_datetime',
    'insti_datetime',
    'previous_designation',
    'designation',
    'final_insti_datetime'
    ];

    public function employee_trf_detail()
    {
        return $this->belongsTo(Employee::class, 'nameofstaff');
    }
    public function insti_trf_detail()
    {
        return $this->belongsTo(User::class, 'institutionname');
    }

    public function departments_trf_dt()
    {
        return $this->belongsTo(Department::class, 'department');
    }
    public function faculty_trf_dt()
    {
        return $this->belongsTo(FacultyDirectorate::class, 'faculty');
    }
    public function unit_trf_dt()
    {
        return $this->belongsTo(Unit::class,'unit');
    }
}



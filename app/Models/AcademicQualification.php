<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicQualification extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'institutionname',
     'institutioncategory',
     'courseofstudy',
     'certificateobtained',
     'programmeduration',
     'programmedurationenddate',
     'employee_id',
     'user_id',
     'postheldandprojecthandled',
     'academicother',
     'acaduration',
     'academic_upload',
     'academic_upload_name'
    ];

    public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
  }
  
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryDetails extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
      'bankname',
      'accountname',
      'uploadidcard',
      'accountnumber',
      'bvn',
      'tin',
      'employee_id',
      'user_id'
    ];
     public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
  }
}

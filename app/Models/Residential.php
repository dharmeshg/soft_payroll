<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residential extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'houseno',
     'streetname',
     'residentialcountry',
     'state',
     'localgoverment',
     'citytown',
     'phone_no_1',
     'phone_no_2',
     'email',
     'user_id',
     'residentialnationality',
     'residentialstate'
    ];

    public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
}
}

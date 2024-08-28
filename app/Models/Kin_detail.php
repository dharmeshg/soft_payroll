<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kin_detail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'name',
     'relationship',
     'phone_no',
     'kinemail',
     'address',
     'image',
     'user_id',
     'kindetailssex'
    ];

    public function employee_detail()
    { 
      return $this->belongsTo(Employee::class, 'employee_id');
    }
}

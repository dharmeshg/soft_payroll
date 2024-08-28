<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{ 
    use HasFactory, SoftDeletes;   
      protected $fillable = [        
        'name'
    ];
     public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
  }
}

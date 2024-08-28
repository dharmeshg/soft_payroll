<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultyDirectorate extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;   
      protected $fillable = [        
        'facultyname',
        'faculty_description',
        'institue_id',
        'used_id'        
    ];
}

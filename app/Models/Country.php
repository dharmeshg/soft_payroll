<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;   
      protected $fillable = [        
        'name'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class,'country');
    }
}

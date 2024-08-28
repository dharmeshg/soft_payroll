<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'name',
     'description',
     'user_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institute extends Model
{
    use HasFactory, SoftDeletes;

      protected $fillable = [        
        'institutionname',
        'contact_person',
        'contact_no',
        'mobile',
        'email',
        'password',
        'confirm_password',
        'address',
        'pin_code',
        'state',
        'city',
        'dbname',
        'dbuser',
        'dbpassword',
        'instiimage',
        'institutionmotto',
    ];
}

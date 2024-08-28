<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
     'birthcerticate',
     'professionalcertificate',
     'marriagecertificate',
     'awardandhonorarycertificate',
     'othercertificate',
     'deathcertificate',
     'user_id',
     'employee_id',
     'certificatename'
    ];
}

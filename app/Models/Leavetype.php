<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    use HasFactory;
    public $timestamps = false;
        protected $fillable = [        
        'name',
        'days',
        'description',
        'accrual_method',
        'max_allow_days',
        'carry_over_policy',
        'all_remaning_leaves',
        'max_leave_carry_forword',
        'rules'
    ];
    
}

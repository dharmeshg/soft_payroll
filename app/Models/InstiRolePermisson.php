<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstiRolePermisson extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [        
        'institute_id',
        'role_id',
        'permission_id',
    ];
    public function InstiPermission()
    {
        return $this->belongsTo(InstitutePermission::class);
    }
}

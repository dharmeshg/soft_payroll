<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{ 
    use HasFactory, SoftDeletes;   
      protected $fillable = [        
        'departmentname',
        'departmentdescription',
        'image',
    ];

    public function official_infos()
    {
        return $this->belongsTo(OfficialInfo::class);
    }
    public function official_info()
    {
        return $this->hasMany(OfficialInfo::class,'department');
    }
    public function employee_detail()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

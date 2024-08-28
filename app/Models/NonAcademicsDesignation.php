<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonAcademicsDesignation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
     'title',
     'description',
     'image',
    ];

    // public function official_info()
    // {
    //     return $this->hasMany(OfficialInfo::class,'designation');
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefereeInfo extends Model
{
    // protected $connection = 'mysql2';
    use HasFactory, SoftDeletes;
    protected $fillable = [
      'referee_info_fullname',
      'referee_info_occupation',
      'referee_info_postheld',
      'referee_info_address',
      'referee_info_phoneno',
      'referee_info_email',
      'refereeconsentletter',
      'employee_id',
      'user_id'
    ];
     public function employee_detail()
  {
      return $this->belongsTo(Employee::class, 'employee_id');
  }

  // public static function boot() {
  
  //       parent::boot();
  
  //       static::created(function ($item) {
                
  //           //$adminEmail = "your_admin_email@gmail.com";
  //           Mail::to('prachi@karmasource.net')->send(new ContactMail($item));
  //       });
  //   }
}

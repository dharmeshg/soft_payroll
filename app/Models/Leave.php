<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [        
        'employee_id',
        'leavetype_id',
        'leave_days',
        'start_date',
        'end_date',
        'reason',
    ];
    public function employee() {
        return $this->belongsTo(Employee::class);
      }
      public function leavetype() {
        return $this->belongsTo(Leavetype::class);
      }
      
      public function getDurationAttribute()
      {
          return (new Carbon($this->end_date))->diffInDays(new Carbon($this->start_date))+1;
      }
}

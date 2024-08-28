<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'message',
        'role',
        'is_read',
        'visible_users'
    ];

    // public function user()
    // {
    //     return $this->hasMany(User::class,'user_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

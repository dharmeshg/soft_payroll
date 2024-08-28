<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Notification;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'mobile',
        'contact_no',
        'address',
        'image',
        'is_school',
        'institutionname',
        'contact_person',
        'pin_code',
        'state',
        'city',
        'confirm_password',        
        'dbname',
        'dbuser',
        'dbpassword',
        'instiimage',
        'institutionmotto',
        'datecreated',
        'subscriptiondate',
        'registrationdate',
        'institutiontype',
        'ownershiptype',
        'institutionlocationcountry',
        'schoolname',
        'role',
        'websiteaddress'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    // public function employee()
    // {
    //     return $this->belongsTo(Employee::class);
    // }

    // public function Notifications()
    // {
    //     return $this->belongsTo(Notification::class,'visible_users');
    //  }
    public function Notifications()
    {
        return $this->hasMany(Notification::class,'visible_users');
    }

    public function emp()
    {
        return $this->belongsTo(Employee::class);
    }

    
    public function institution()
    {
        // return $this->hasOneThrough(
        //     Employee::class,
        //     User::class,
        //      // Foreign key on the cars table...
        //     'id', // Foreign key on the owners table...
        //     'institution_id',
        // );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['dateofbirth'];
    protected $fillable = [
      'fname',
      'mname',
      'lname',
      'sex',
      'dateofbirth',
      'maritalstatus',
      'noofchildren',
      'nationality',
      'bloodgroup',
      'spousename',
      'phoneno',
      'religion',
      'denomination',
      'tribe',
      'genotype',
      'localgovernmentoforigin',
      'hometown',
      'user_id',
      'country',
      'stateoforigin',
      'city',
      'academicother',
      'state',
      'profile_image',
      'employeeemail',
      'title',
      'maidenname',
      'formername',
      'disability',
      'disabilitytype',
      'dateofdeath',
      'causeofdeath',
      'employeestatus'
    ];

    public function official_information()
    {
        return $this->hasOne(OfficialInfo::class);
    }
    public function unit()
    {
        return $this->hasOne(OfficialInfo::class);
    }
    public function kin_details()
    {
        return $this->hasOne(Kin_detail::class);
    }
    public function residentails()
    {
        return $this->hasOne(Residential::class);
    }
    public function work_experiences()
    {
        return $this->hasMany(WorkExperience::class);
    }
    public function salary_details()
    {
        return $this->hasOne(SalaryDetails::class);
    }
    public function Referee_infos()
    {
        return $this->hasMany(RefereeInfo::class);
    }
    public function AcademicQualification()
    {
        return $this->hasMany(AcademicQualification::class);
    }
    public function departments()
    {
        return $this->hasOne(Department::class);
    }
     public function nationality()
    {
        return $this->hasOne(Nationality::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userfind()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function institute()
    {
        return $this->belongsTo(User::class,'institution_id');
    }
    public function countrys()
    {
        return $this->belongsTo(Country::class, 'country');
    }
    public function states()
    {
        return $this->belongsTo(State::class, 'state');
    }
    public function cities()
    {
        return $this->belongsTo(City::class, 'city');
    }
    public function academic_qualification()
    {
        return $this->hasMany(AcademicQualification::class);
    }
    public function certi_details()
    {
        return $this->hasOne(Certificate::class);
    }
    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
    }
    
}

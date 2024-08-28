<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\FacultyDirectorate;
use App\Models\Department;
use App\Models\TransferClass;
use App\Models\TransferType;
use App\Models\TransferCategory;
use App\Models\Unit;
use App\Models\OfficialInfo;
use App\Models\User;
use App\Models\AcademicQualification;
use App\Models\TransferReason;
use App\Models\Employee;
use App\Models\Notification;


class TansferOtherController extends Controller
{
    public function add()
    {
      $facultydirectorates = FacultyDirectorate::get();
      $departments = Department::get();
      $transferclass = TransferClass::where('classname','Transfer Out')->first();
      $transferclassIn = TransferClass::where('classname','Transfer In')->first();
      $transertype = TransferType::get();
      $transfercategory = TransferCategory::get();
      $units = Unit::get();
      $officialinfos = OfficialInfo::get();
      $academicqualification = AcademicQualification::get();
      $transferreason = TransferReason::get();
      $employee=[];
      if(Auth::user()->role == "HOU"){
        $new_off = OfficialInfo::where('user_id',Auth::user()->employee->institution_id)
        ->where('directorate',Auth::user()->employee->official_information->directorate)
        ->where('department',Auth::user()->employee->official_information->department)
        ->where('unit',Auth::user()->employee->official_information->unit)
        ->where('role','Employee')
        ->get();
        foreach($new_off as $new_offs){
            $employee[] = Employee::where('id','=',$new_offs->employee_id)->get();
        }
      }elseif(Auth::user()->role == "HOD"){
        $new_off = OfficialInfo::where('user_id',Auth::user()->employee->institution_id)
        ->where('directorate',Auth::user()->employee->official_information->directorate)
        ->where('department',Auth::user()->employee->official_information->department)
        ->where('unit',Auth::user()->employee->official_information->unit)
        ->whereIn('role',['Employee','HOU'])
        ->get();
        foreach($new_off as $new_offs){
            $employee[] = Employee::where('id','=',$new_offs->employee_id)->get();
        }
      }elseif(Auth::user()->role == "HOF"){
        $new_off = OfficialInfo::where('user_id',Auth::user()->employee->institution_id)
        ->where('directorate',Auth::user()->employee->official_information->directorate)
        ->where('department',Auth::user()->employee->official_information->department)
        ->where('unit',Auth::user()->employee->official_information->unit)
        ->whereIn('role',['Employee','HOU','HOD'])
        ->get();
        foreach($new_off as $new_offs){
            $employee[] = Employee::where('id','=',$new_offs->employee_id)->get();
        }
      }
      
     // $employee = Employee::get();
      
    //   $employees = null;
    
      $initiatedata = '';
      $emp = [];
      $users = User::where('institutionname','!=',null)->get();

      return view('Transfer/trfotherform',compact('transferclassIn','emp','facultydirectorates','departments','transferclass','transertype','transfercategory','units','officialinfos','academicqualification','transferreason','employee','users','initiatedata'));
    }
    public function store(Request $request)  
    {
            $transfer = new Transfer;
            $transfer->transferclass = $request->transferclass;
            $transfer->transfertype = $request->transfertype;
            $transfer->transfercategory = $request->transfercategory;
            $transfer->transferreason = $request->transferreason;
            $transfer->institutionname = $request->institutionname;
            $transfer->transferfaculty = $request->transferfaculty;
            $transfer->transferdepartment = $request->transferdepartment;
            $transfer->transferunit = $request->transferunit;
            $transfer->	initiate = $request->initiate;
            $transfer->	other = $request->other;
            $hel=Employee::where('id',$request->nameofstaff)->first();
            $help=User::where('id',$hel->user_id)->first();
            $transfer->user_id = $help->id;
            // dd($transfer);
            $transfer->institution_id = isset(Auth::user()->employee) ? Auth::user()->employee->institution_id : Auth::user()->id;
            $transfer->nameofstaff = $request->nameofstaff;
            $transfer->staffid = $request->staffid;
            $transfer->	transferclassIn = $request->transferclassIn;
            $transfer->faculty = $request->faculty;
            $transfer->department = $request->department;
            $transfer->unit = $request->unit;
            $transfer->previous_role = $request->previous_role;
            $transfer->role = $request->role;
            $transfer->status = 1;
        
        $employee = Employee::all()->pluck('institution_id');
        // dd($transfer);
        $transfer->save();

            $name = Employee::where('id','=',$transfer->nameofstaff)->first();
            $created = Employee::where('user_id','=',$transfer->user_id)->first();
            $visible_users = User::where('id',$transfer->user_id)->pluck('id')->toArray();
            $notifications = new Notification();
            foreach ($visible_users as  $key => $value){
                $notifications->create( [ 'notifiable_id' => $transfer->id, 'notifiable_type' => 'initiate_transfer', 'user_id' => Auth::user()->id, 'message' => 'New Transfer Initiate for '.$name->fname.' '.$name->lname.' Created By ('.Auth::user()->employee->fname.')', 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
            }
        if($transfer)
            return redirect()->route('transfer.list')->with('success',"Transfer Added Successfully.");
        else
            return redirect()->route('transfer.list')->with('error',"Error In Adding Transfer.");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Employee;
use App\Models\OfficialInfo;
use App\Models\Department;
use App\Models\LocalGovernment;
use App\Models\State;
use App\Models\AcademicQualification;
use App\Models\FacultyDirectorate;
use App\Models\TransferType;
use App\Models\TransferClass;
use App\Models\Unit;
use App\Models\User;
use App\Models\TransferCategory;
use App\Models\Designation;
use App\Models\TransferReason;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use App\Models\Notification;

class DestinationApproveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
           $data = Transfer::where('status', '=', 3)->where('insti_status', '=', 1)->where('institutionname','=',Auth::user()->id)->get();
        return view('DestiApprove/list',['data'=> $data]);

    }

    public function edit($id)
    {   
        $employee = Employee::get();
        $officialinfos = OfficialInfo::get();
        $departments = Department::get();
        $localgoverments = LocalGovernment::get();
        $transferreason = TransferReason::get();
        $states = State::get();
        $approvetransfer = Transfer::findOrFail($id);
        $academicqualification = AcademicQualification::get();
        $facultydirectorates = FacultyDirectorate::get();
        $units = Unit::get();
        $designations = Designation::get();
        $transferclass = TransferClass::get();
        $transertype = TransferType::get();
        $transfercategory = TransferCategory::get();
        $users = User::get();
        return view('/DestiApprove/add', compact('approvetransfer' , 'id','employee','officialinfos','departments','localgoverments','transferreason','states','academicqualification','facultydirectorates','units','designations','transferclass','transertype','transfercategory','users'));
    }

    public function update(Request $request, $code)
    { 

        $approvetransfer = Transfer::findOrFail($code);
        $data = $request->input();
        $data['status'] = 3;

        if($approvetransfer){
            if($approvetransfer->update($data)){
                return redirect()->route('destination.list')->with('success',"Process Transfer Edited Successfully.");
            }else{
                return redirect()->route('destination.list')->with('error',"Process Transfer in Updating Unit.");
            }
        }else{
            return redirect()->route('destination.list')->with('error',"Process Transfer Not Found.");
        }
    }


    public function finalapproveform($id)
    { 

        $approvetransfer = Transfer::findOrFail($id);
        
        $user = User::where('id',$approvetransfer->user_id)->first();
        
        $data['status'] = 4;
        $data['final_insti_datetime']=date('Y-m-d h:i A');
        $data['approve_by_insti'] = Auth::user()->institutionname;
        // dd($data);
        $insti = User::where('id',$approvetransfer->institutionname)->first();
        
        if($approvetransfer){
            if($approvetransfer->update($data)){
               
                if($insti){
                    
                    $user->role=$approvetransfer->role;
                    
                    $employee = $user->employee;
                    
                    $office = $employee->official_information;
                    
                    $office->directorate = $approvetransfer->transferfaculty;
                    $office->department = $approvetransfer->transferdepartment;
                    $office->unit = $approvetransfer->transferunit;
                    $office->designation = $approvetransfer->designation;
                    $office->role = $approvetransfer->role;
                    $office->user_id = $insti->id;
                    $employee->institution_id = $insti->id;
                    $ik = $office->update();
                    $ij =$employee->update();
                    $i =$user->update();
                    $name = Employee::where('id','=',$approvetransfer->nameofstaff)->first();
                    $created = Employee::where('user_id','=',$approvetransfer->user_id)->first();
                    $visible_users = User::where('id',$approvetransfer->user_id)->pluck('id')->toArray();
                    $notifications = new Notification();
                    foreach ($visible_users as  $key => $value){
                        $notifications->create( [ 'notifiable_id' => $approvetransfer->id, 'notifiable_type' => 'SuccessFully Transfer', 'user_id' => Auth::user()->id, 'message' => $name->fname.' '.$name->lname.' has been Transferred to 
 '.Auth::user()->institutionname, 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
                    }
                }
                return redirect()->route('destination.list')->with('success',"Transfer Approved Successfully.");
            }else
                return redirect()->route('destination.list')->with('error',"Error In updating Transfer.");
        }else{
            return redirect()->route('destination.list')->with('error',"Error In updating Transfer.");
        }
    }

    public function delete($code)
    {
        $approvetransfer = Transfer::where('id', '=', $code)->first();   
        $approvetransfer->delete();

        return redirect()->route('destination.list')->with('success',"Process Transfer Deleted Successfully.");
    }

    public function approveform($id){

        $data = transfer::where('id','=',$id)->first();
        
        //dd(Auth::user()->id);
        //$employee = Employee::where('id',$id)->first();
        //dd($data['user_id']);
        $dep = Department::where('id',$data['transferdepartment'])->first();
        $u = Unit::where('id',$data['transferunit'])->first();
        $fac = FacultyDirectorate::where('id',$data['transferfaculty'])->first();

        $employee = Employee::where('user_id','=',$data['user_id'])->first();
        // dd($employee);
        $officialinfo = OfficialInfo::where('user_id','=',$data['user_id'])->get();
        $users = User::where('id','=',$data['institution_id'])->first();
        
        $instiname = isset($users->institutionname) ? $users->institutionname : '';
        //dd($instiname);
        $transfer = $data;
        //dd($officialinfo);
        $date = Employee::where('user_id','=',$data['user_id'])->first();
        //dd($date);
        // $age = Carbon::createFromFormat('d/m/Y', $date->dateofbirth)->diff(Carbon::now())->y;
        $age = Carbon::parse($date->dateofbirth)->diff(Carbon::now())->y;
        //dd($age);

        $service = OfficialInfo::where('user_id','=',$data['user_id'])->first();
        
        if($service){
            $year = Carbon::parse($service->dateofemployment)->diff(Carbon::now())->y;
        }else{
            $year = 0;
        }
        
        $created = $transfer->created_at->format('d/m/Y');

        $initiateby = $transfer->initiate;

        
        //$users = User::get();
        return view('/DestiApprove/approveform', compact('dep','u','fac','employee','officialinfo','transfer','users','instiname','age','year','created','initiateby'));
    }
    
}

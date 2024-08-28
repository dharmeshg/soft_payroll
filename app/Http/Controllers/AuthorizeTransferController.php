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
use App\Models\Notification;

class AuthorizeTransferController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    { 
        $employee = Employee::get();
        $officialinfos = OfficialInfo::get();
        $departments = Department::get();
        $localgoverments = LocalGovernment::get();
        $transferreason = TransferReason::get();
        $academicqualification = AcademicQualification::get();
        $states = State::get();
        $facultydirectorates = FacultyDirectorate::get();
        $units = Unit::get();
        $designations = Designation::get();
        $transferclass = TransferClass::get();
        $transertype = TransferType::get();
        $transfercategory = TransferCategory::get();
        $users = User::get();
        return view('AuthorizeTransferRequestList/add', compact('employee','officialinfos','departments','transferreason','localgoverments','states','academicqualification','facultydirectorates','units','designations','transferclass','transertype','transfercategory','users'));
    }

    public function store(Request $request,)  
    {  
        $data = $request->all();
        $authorizetransfer = new Transfer;
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 3;
        $ins = $authorizetransfer->create($data);       
        if($ins)
            return redirect()->route('authorizetransfer.list')->with('success',"Process Transfer Added Successfully.");
        else
            return redirect()->route('authorizetransfer.list')->with('error',"Error In Adding Process Transfer.");
    }

    public function index()
    {
        if(Auth::user()->role == 'HOU'){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
            // dd($emp);
            if($emp->official_information->directorate != null && $emp->official_information->department != null && $emp->official_information->unit != null){
                $data=Transfer::where('faculty',$emp->official_information->directorate)
                ->where('department',$emp->official_information->department)
                ->where('unit',$emp->official_information->unit)
                ->where('institution_id',$emp->institution_id)
                ->where('previous_role','Employee')
                ->where('status',2)
                ->where('hou_status',null)->get();
            }elseif($emp->official_information->directorate != null && $emp->official_information->department != null && $emp->official_information->unit == null){
                $data=Transfer::where('faculty',$emp->official_information->directorate)
                ->where('department',$emp->official_information->department)
                ->where('unit',null)
                ->where('institution_id',$emp->institution_id)
                ->where('previous_role','Employee')
                ->where('status',2)
                ->where('hou_status',null)->get();
                // dd($data);
            }
            
        }
        elseif(Auth::user()->role == 'HOD'){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
            if($emp->official_information->unit !=null && $emp->official_information->department !=null && $emp->official_information->directorate !=null){
                $data=Transfer::where('faculty',$emp->official_information->directorate)
                ->where('department',$emp->official_information->department)
                ->where('unit',$emp->official_information->unit)
                ->where('institution_id',$emp->institution_id)
                ->whereIn('previous_role',['Employee','HOU'])
                ->where('status',2)
                ->where('hou_status',1)
                ->where('hod_status',null)->get();
            }elseif($emp->official_information->department !=null && $emp->official_information->directorate !=null && $emp->official_information->unit ==null){
                $data=Transfer::where('faculty',$emp->official_information->directorate)
                ->where('department',$emp->official_information->department)
                ->where('unit',null)
                ->where('institution_id',$emp->institution_id)
                ->whereIn('previous_role',['Employee','HOU'])
                ->where('status',2)
                ->where('hod_status',null)->get();
            }
        }
        elseif(Auth::user()->role == 'HOF'){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
            if($emp->official_information->unit !=null && $emp->official_information->department !=null && $emp->official_information->directorate !=null){

                $data=Transfer::where('faculty',$emp->official_information->directorate)
                ->where('department',$emp->official_information->department)
                ->where('unit',$emp->official_information->unit)
                ->where('institution_id',$emp->institution_id)
                ->whereIn('previous_role',['Employee','HOU','HOD'])
                ->where('status',2)
                ->where('hod_status',1)
                ->where('hof_status',null)->get();
                    
                }elseif($emp->official_information->department !=null && $emp->official_information->directorate !=null && $emp->official_information->unit ==null){
                    $data=Transfer::where('faculty',$emp->official_information->directorate)
                    ->where('department',$emp->official_information->department)
                    ->where('unit',null)
                    ->where('institution_id',$emp->institution_id)
                    ->whereIn('previous_role',['Employee','HOU','HOD'])
                    ->where('status',2)
                    ->where('hod_status',1)
                    ->where('hof_status',null)->get();
                }
        }
        else{
           $data = Transfer::where('institution_id','=',Auth::user()->id)->get();
      }
        return view('AuthorizeTransferRequestList/list',['data'=> $data]);

    }

    public function edit($id)
    {   
        $employee = Employee::get();
        $officialinfos = OfficialInfo::get();
        $departments = Department::get();
        $localgoverments = LocalGovernment::get();
        $transferreason = TransferReason::get();
        $states = State::get();
        $authorizetransfer = Transfer::findOrFail($id);
        if(!$authorizetransfer){
            return redirect()->route('authorizetransfer.list');
            }
        $academicqualification = AcademicQualification::get();
        $facultydirectorates = FacultyDirectorate::get();
        $units = Unit::get();
        $Previousunit = Unit::get();
        $designations = Designation::get();
        $transferclass = TransferClass::get();
        $transertype = TransferType::get();
        $transfercategory = TransferCategory::get();
        $users = User::get();
// dd($departments);
        if(Auth::user()->is_school == 3){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
          
            if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' ){
              $employee = Employee::where('institution_id','=',Auth::user()->employee->institution_id)->get();
            }
             $initiate = Employee::where('user_id','=',Auth::user()->id)->first();
             $initiatedata = $initiate->fname;
             //dd($initiate);
            
        }
        return view('/AuthorizeTransferRequestList/add', compact('Previousunit','emp','authorizetransfer' , 'id','employee','officialinfos','departments','localgoverments','transferreason','states','academicqualification','facultydirectorates','units','designations','transferclass','transertype','transfercategory','users'));
    }

    public function update(Request $request, $code)
    { 
        $authorizetransfer = Transfer::findOrFail($code);
        if(Auth::user()->role == "HOU"){
            if($authorizetransfer->unit ==  null){
                $find_fdu = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('department',$authorizetransfer->department)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if (in_array("HOD", $find_user)) {
                    $data = $request->input();
                    $data['hou_status'] = 1;
                    $data['status'] = 2;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }elseif(in_array("HOF", $find_user)){
                    $data = $request->input();
                    $data['status'] = 2;
                    $data['hou_status'] = 1;
                    $data['hod_status'] = 1;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }else{
                    $data = $request->input();
                    $data['status'] = 3;
                    $data['hou_status'] = 1;
                    $data['hod_status'] = 1;
                    $data['hof_status'] = 1;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }
            }else{
                $find_fdu = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('department',$authorizetransfer->department)->where('unit',$authorizetransfer->unit)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if(in_array("HOD", $find_user)) {
                    $data = $request->input();
                    $data['hou_status'] = 1;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                    $data['status'] = 2;
                }elseif(in_array("HOF", $find_user)){
                    $data = $request->input();
                    $data['status'] = 2;
                    $data['hou_status'] = 1;
                    $data['hod_status'] = 1;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }else{
                    $data = $request->input();
                    $data['status'] = 3;
                    $data['hou_status'] = 1;
                    $data['hod_status'] = 1;
                    $data['hof_status'] = 1;
                    $data['hou_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hou'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }
            }
            
        }elseif(Auth::user()->role == "HOD"){
            $find_fdu = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('department',$authorizetransfer->department)->pluck('employee_id')->toArray();
            $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
            $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
            if(in_array("HOF", $find_user)) {
                if($authorizetransfer->hou_status == 1 && $authorizetransfer->unit != null ){
                    $data = $request->input();
                    $data['hod_status'] = 1;
                    $data['hod_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hod'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }
                elseif($authorizetransfer->unit == null){
                    $data = $request->input();
                    $data['hou_status'] = 0;
                    $data['hod_status'] = 1;
                    $data['hod_datetime']=date('Y-m-d h:i A');
                    $data['authorize_by_hod'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }else{
                    return redirect()->route('authorizetransfer.list')->with('error',"Head of Unit Action is Pending");
                }  
            }else{
                $data['status'] = 3;
                $data['hod_status'] = 1;
                $data['hof_status'] = 1;
                $data['hod_datetime']=date('Y-m-d h:i A');
                $data['authorize_by_hod'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }  
        }
        elseif(Auth::user()->role == "HOF"){
            $authorizetransfer = Transfer::findOrFail($code);
            // dd($authorizetransfer);
            if($authorizetransfer->hou_status == 1 && $authorizetransfer->unit != null && $authorizetransfer->hod_status == 1){
            $data = $request->input();
            $data['hof_status'] = 1;
            $data['status'] = 3;
            $data['hof_datetime']=date('Y-m-d h:i A');
            $data['authorize_by_hof'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }elseif($authorizetransfer->previous_role == "HOU" && $authorizetransfer->unit != null && $authorizetransfer->hod_status == 1){
                $data = $request->input();
                $data['hof_status'] = 1;
                $data['status'] = 3;
                $data['hof_datetime']=date('Y-m-d h:i A');
                $data['authorize_by_hof'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }
            elseif($authorizetransfer->unit == null && $authorizetransfer->hod_status == 1){
                $data = $request->input();
                $data['hof_status'] = 1;
                $data['status'] = 3;
                $data['hof_datetime']=date('Y-m-d h:i A');
                $data['authorize_by_hof'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }
            else{
                return redirect()->route('authorizetransfer.list')->with('error',"Head of Department Action is Pending");
            }
        }
        // $data['status'] = 3;

        // if($authorizetransfer){
        //     if($authorizetransfer->update($data))
        //         return redirect()->route('authorizetransfer.list')->with('success',"Process Transfer Edited Successfully.");
        //     else
        //         return redirect()->route('authorizetransfer.list')->with('error',"Process Transfer in Updating Unit.");
        // }else{
        //     return redirect()->route('authorizetransfer.list')->with('error',"Process Transfer Not Found.");
        // }
        // dd($data);
        $ins = $authorizetransfer->update($data);
        $authorizedby = Employee::where('user_id','=',Auth::user()->id)->first();
        $name = Employee::where('id','=',$authorizetransfer->nameofstaff)->first();
        if(Auth::user()->role == "HOU"){
            if($authorizetransfer->unit ==  null){}
            $visible_user = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('department',$authorizetransfer->department)->where('role','HOD')->pluck('employee_id')->toArray();
            $visible_user_hof = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('department',$authorizetransfer->department)->where('role','HOF')->pluck('employee_id')->toArray();
            $find_emp_d = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
            $find_emp_f = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
            if(!empty($find_emp_d)){
                $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }elseif(!empty($find_emp_f)){
                $vs_user = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }else{
                $visible_users = User::where('id',$authorizetransfer->institution_id)->pluck('id')->toArray();
            }
        }elseif(Auth::user()->role == "HOD"){
            $visible_user = OfficialInfo::where('user_id',$authorizetransfer->institution_id)->where('directorate',$authorizetransfer->faculty)->where('role','HOF')->pluck('employee_id')->toArray();
            $find_emp_f = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
            if(!empty($find_emp_f)){
                $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }else{
                $visible_users = User::where('id',$authorizetransfer->institution_id)->pluck('id')->toArray();
            }
        }elseif(Auth::user()->role == "HOF"){
            $visible_users = User::where('id',$authorizetransfer->institution_id)->pluck('id')->toArray();
        }   
        $notifications = new Notification();
        foreach ($visible_users as  $key => $value){
            $notifications->create( [ 'notifiable_id' => $authorizetransfer->id, 'notifiable_type' => 'authorized_transfer', 'user_id' => Auth::user()->id, 'message' => 'New Authorized Transfer for '.$name->fname.' '.$name->lname.' Authorized By ('.$authorizedby->fname.' '.$authorizedby->lname.')', 'role' => Auth::user()->role, 'is_read' => '0', 'visible_users' => $value ] );
            }

        if($ins)
            return redirect()->route('authorizetransfer.list')->with('success',"Authorized Transfer Edited Successfully.");
        else
            return redirect()->route('authorizetransfer.list')->with('error',"Authorized Transfer in Updating.");
    }

    public function delete($code)
    {
        $authorizetransfer = Transfer::where('id', '=', $code)->first();   
        $authorizetransfer->delete();

        return redirect()->route('authorizetransfer.list')->with('success',"Process Transfer Deleted Successfully.");
    }
    
}

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

class ProcessTransferController extends Controller
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
        return view('ProcessTransferList/add', compact('employee','officialinfos','departments','transferreason','localgoverments','states','academicqualification','facultydirectorates','units','designations','transferclass','transertype','transfercategory','users'));
    }

    public function store(Request $request,)  
    {  
        $data = $request->all();
        $processtransfer = new Transfer;
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 2;
        $ins = $processtransfer->create($data);       
        if($ins)
            return redirect()->route('processtransfer.list')->with('success',"Process Transfer Added Successfully.");
        else
            return redirect()->route('processtransfer.list')->with('error',"Error In Adding Process Transfer.");
    }

    public function index()
    {
        if(Auth::user()->role == 'Dean'){
           $emp = Employee::where('employeeemail',Auth::user()->email)->first();
           $departments = $emp->official_information->department;
           $data = Transfer::where('status', '=', 2 )->where('department', '=', $departments)->get();
        }else{

           $data = Transfer::where('status', '=', 2)->where('user_id','=',Auth::user()->id)->get();
      }
        return view('ProcessTransferList/list',['data'=> $data]);

    }

    public function edit($id)
    {   
        $employee = Employee::get();
        $officialinfos = OfficialInfo::get();
        $departments = Department::get();
        $localgoverments = LocalGovernment::get();
        $transferreason = TransferReason::get();
        $states = State::get();
        $processtransfer = Transfer::findOrFail($id);
        $academicqualification = AcademicQualification::get();
        $facultydirectorates = FacultyDirectorate::get();
        $units = Unit::get();
        $designations = Designation::get();
        $transferclass = TransferClass::get();
        $transertype = TransferType::get();
        $transfercategory = TransferCategory::get();
        $users = User::get();
        $emp=[];
        if(Auth::user()->is_school == 3){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
          
            if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' ){
              $employee = Employee::where('institution_id','=',Auth::user()->employee->institution_id)->get();
            }
             $initiate = Employee::where('user_id','=',Auth::user()->id)->first();
             $initiatedata = $initiate->fname;
             //dd($initiate);
            
        }
        return view('/ProcessTransferList/add', compact('processtransfer' ,'emp', 'id','employee','officialinfos','departments','localgoverments','transferreason','states','academicqualification','facultydirectorates','units','designations','transferclass','transertype','transfercategory','users'));
    }

    public function update(Request $request, $code)
    { 
        $processtransfer = Transfer::findOrFail($code);
        // dd($processtransfer);
        if(Auth::user()->role == "Employee"){
            if($processtransfer->unit ==  null){
                $find_fdu = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if(in_array("HOU", $find_user)){
                    $data = $request->input();
                    $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                    $data['status'] = 2;
                }elseif(in_array("HOD", $find_user)) {
                        $data = $request->input();
                        $data['hou_status'] = 1;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        $data['status'] = 2;
                }elseif(in_array("HOF", $find_user)){
                        $data = $request->input();
                        $data['status'] = 2;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        // $data['hod_datetime']=date('Y-m-d H:i:s');
                }else{
                        $data = $request->input();
                        $data['status'] = 3;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['hof_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                        $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        // $data['hod_datetime']=date('Y-m-d H:i:s');
                        // $data['hof_datetime']=date('Y-m-d H:i:s');
                }
            }else{
                $find_fdu = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',$processtransfer->unit)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if(in_array("HOU", $find_user)){
                    $data = $request->input();
                    $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                    $data['status'] = 2;
                    // dd($data);
                }elseif(in_array("HOD", $find_user)) {
                    $data = $request->input();
                    $data['hou_status'] = 1;
                    // $data['hou_datetime']=date('Y-m-d H:i:s');
                    $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                    $data['status'] = 2;
                }elseif(in_array("HOF", $find_user)){
                        $data = $request->input();
                        $data['status'] = 2;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        // $data['hod_datetime']=date('Y-m-d H:i:s');
                }else{
                        $data = $request->input();
                        $data['status'] = 3;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['hof_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                        $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        // $data['hod_datetime']=date('Y-m-d H:i:s');
                        // $data['hof_datetime']=date('Y-m-d H:i:s');
                }
            }
        }elseif(Auth::user()->role == "HOU"){
            if($processtransfer->unit ==  null){
                $find_fdu = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if (in_array("HOD", $find_user)) {
                        $data = $request->input();
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        $data['process_datetime']=date('Y-m-d h:i A');
                        $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        $data['hou_status'] = 1;
                        $data['status'] = 2;
                }elseif(in_array("HOF", $find_user)){
                        $data = $request->input();
                        $data['status'] = 2;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                        $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        // $data['hou_datetime']=date('Y-m-d H:i:s');
                        // $data['hod_datetime']=date('Y-m-d H:i:s');
                }else{
                        $data = $request->input();
                        $data['status'] = 3;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['hof_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }
            }else{
                $find_fdu = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',$processtransfer->unit)->pluck('employee_id')->toArray();
                $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
                $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
                if(in_array("HOD", $find_user)) {
                    $data = $request->input();
                    $data['hou_status'] = 1;
                    $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                    $data['status'] = 2;
                }elseif(in_array("HOF", $find_user)){
                        $data = $request->input();
                        $data['status'] = 2;
                        $data['hou_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                        $data['hod_status'] = 1;
                }else{
                        $data = $request->input();
                        $data['status'] = 3;
                        $data['hou_status'] = 1;
                        $data['hod_status'] = 1;
                        $data['hof_status'] = 1;
                        $data['process_datetime']=date('Y-m-d h:i A');
                        $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
                }
            }
        }elseif(Auth::user()->role == "HOD"){
            $find_fdu = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->pluck('employee_id')->toArray();
            $find_emp_fdu = Employee::whereIn('id',$find_fdu)->pluck('user_id')->toArray();
            $find_user = User::whereIn('id',$find_emp_fdu)->pluck('role')->toArray();
            if(in_array("HOF", $find_user)){
                $data = $request->input();
                $data['status'] = 2;
                $data['hou_status'] = 1;
                $data['hod_status'] = 1;
                $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }else{
                    $data = $request->input();
                    $data['status'] = 3;
                    $data['hou_status'] = 1;
                    $data['hod_status'] = 1;
                    $data['hof_status'] = 1;
                    $data['process_datetime']=date('Y-m-d h:i A');
                    $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;
            }
        }elseif(Auth::user()->role == "HOF"){
            $data = $request->input();
            $data['status'] = 3;
            $data['hof_status'] = 1;
            $data['process_datetime']=date('Y-m-d h:i A');
            $data['process_by'] = Auth::user()->employee->fname . ' ' . Auth::user()->employee->mname . ' ' . Auth::user()->employee->lname;

        }
// dd($data);
        $ins = $processtransfer->update($data);
        $processedby = Employee::where('user_id','=',Auth::user()->id)->first();
        $name = Employee::where('id','=',$processtransfer->nameofstaff)->first();
        if(Auth::user()->role == "Employee"){
            if($processtransfer->unit ==  null){
                $visible_user_u = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',null)->where('role','HOU')->pluck('employee_id')->toArray();
                $find_emp_u = Employee::whereIn('id',$visible_user_u)->pluck('user_id')->toArray();
                $visible_user = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',null)->where('role','HOD')->pluck('employee_id')->toArray();
                $find_emp_d = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_user_hof = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',null)->where('role','HOF')->pluck('employee_id')->toArray();
                $find_emp_f = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                if(!empty($find_emp_u)){
                    $vs_user = Employee::whereIn('id',$visible_user_u)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
                }
                elseif(!empty($find_emp_d)){
                    $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
                }elseif(!empty($find_emp_f)){
                    $vs_user = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
                }else{
                    $visible_users = User::where('id',$processtransfer->institution_id)->pluck('id')->toArray();
                }
            }else{
                $visible_user = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',$processtransfer->unit)->where('role','HOU')->pluck('employee_id')->toArray();
                $find_emp_u = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_user_hod = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',$processtransfer->unit)->where('role','HOD')->pluck('employee_id')->toArray();
                $find_emp_d = Employee::whereIn('id',$visible_user_hod)->pluck('user_id')->toArray();
                $visible_user_hof = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('unit',$processtransfer->unit)->where('role','HOF')->pluck('employee_id')->toArray();
                $find_emp_f = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                if(!empty($find_emp_u)){
                    $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray(); 
                }elseif(!empty($find_emp_d)){
                    $vs_user = Employee::whereIn('id',$visible_user_hod)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray(); 
                }elseif(!empty($find_emp_f)){
                    $vs_user = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                    $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray(); 
                }else{
                    $visible_users = User::where('id',$processtransfer->institution_id)->pluck('id')->toArray();
                }
            }
        }elseif(Auth::user()->role == "HOU"){
            $visible_user = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('role','HOD')->pluck('employee_id')->toArray();
            $visible_user_hof = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('department',$processtransfer->department)->where('role','HOF')->pluck('employee_id')->toArray();
            $find_emp_d = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
            $find_emp_f = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
            if(!empty($find_emp_d)){
                $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }elseif(!empty($find_emp_f)){
                $vs_user = Employee::whereIn('id',$visible_user_hof)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }else{
                $visible_users = User::where('id',$processtransfer->institution_id)->pluck('id')->toArray();
            }
        }elseif(Auth::user()->role == "HOD"){
            $visible_user = OfficialInfo::where('user_id',$processtransfer->institution_id)->where('directorate',$processtransfer->faculty)->where('role','HOF')->pluck('employee_id')->toArray();
            $find_emp_f = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
            if(!empty($find_emp_f)){
                $vs_user = Employee::whereIn('id',$visible_user)->pluck('user_id')->toArray();
                $visible_users = User::whereIn('id',$vs_user)->pluck('id')->toArray();
            }else{
                $visible_users = User::where('id',$processtransfer->institution_id)->pluck('id')->toArray();
            }
        }elseif(Auth::user()->role == "HOF"){
            $visible_users = User::where('id',$processtransfer->institution_id)->pluck('id')->toArray();
        }
        $notifications = new Notification();
        foreach ($visible_users as  $key => $value){
            $notifications->create( [ 'notifiable_id' => $processtransfer->id, 'notifiable_type' => 'process_transfer', 'user_id' => Auth::user()->id, 'message' => 'New Process Transfer for '.$name->fname.' '.$name->lname.' processed By ('.$processedby->fname.' '.$processedby->lname.')', 'role' => Auth::user()->role, 'is_read' => '0', 'visible_users' => $value ] );
            }
        if($ins)
            return redirect()->route('transfer.list')->with('success',"Process Transfer Edited Successfully.");
        else
            return redirect()->route('transfer.list')->with('error',"Process Transfer in Updating.");

    }

    public function delete($code)
    {
        $processtransfer = Transfer::where('id', '=', $code)->first();   
        $processtransfer->delete();

        return redirect()->route('processtransfer.list')->with('success',"Process Transfer Deleted Successfully.");
    }
    
}

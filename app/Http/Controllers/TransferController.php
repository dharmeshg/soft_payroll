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
use App\Models\Designation;
use App\Models\Notification;


class TransferController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
      $facultydirectorates = FacultyDirectorate::get();
      $departments = Department::get();
      $transferclass = TransferClass::where('classname','Transfer Out')->first();
      $transferclassIn = TransferClass::where('classname','Transfer In')->first();
    //   dd($transferclass);
      $transertype = TransferType::get();
      $transfercategory = TransferCategory::get();
      $units = Unit::get();
      $officialinfos = OfficialInfo::get();
      $academicqualification = AcademicQualification::get();
      $transferreason = TransferReason::get();
      $desig = Designation::get();
      //dd(Auth::user()->employee()->id);
      $employee = Employee::where('institution_id','=',Auth::user()->id)->get();
     // $employee = Employee::get();
      $staff_id = null;
      $employees = null;
      $transferdepartments = null;
      $transferfacultydirectorates = null;
      $transferunit = null;
      $offrole = null;
      $initiatedata = '';
      $emp = [];
      if(Auth::user()->is_school == 3){
          $emp = Employee::where('employeeemail',Auth::user()->email)->first();
        
          $employees = $emp->id;
        
          if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' ){
            $employee = Employee::where('institution_id','=',Auth::user()->employee->institution_id)->get();
          }
           $initiate = Employee::where('user_id','=',Auth::user()->id)->first();
           $initiatedata = $initiate->fname;
           //dd($initiate);
          
      }
      $users = User::where('institutionname','!=',null)->get();

      return view('Transfer/transferinitiationform',compact('desig','transferclassIn','emp','offrole','facultydirectorates','departments','transferclass','transertype','transfercategory','units','officialinfos','academicqualification','transferreason','employee','users','employees','transferdepartments','initiatedata','transferunit'));
    }

    public function store(Request $request)  
    {
      
        $emp = Employee::where('employeeemail',Auth::user()->email)->first();
        if(isset($emp)){
        $employees = $emp->id;
        $staff_id = $emp->official_information->staff_id;
        $transferfacultydirectorates = $emp->official_information->directorate;
        $transferdepartments = $emp->official_information->department;
        $transferunits = $emp->official_information->unit;
        $officialRole = $emp->official_information->role;
        }
       
        $transfer = new Transfer;
        if(Auth::user()->role=='Employee' || Auth::user()->role=='HOU' || Auth::user()->role=='HOF' || Auth::user()->role=='HOD'){
            // dd($request->all());
            $transfer->transferclass = $request->transferclass;
            $transfer->transfertype = $request->transfertype;
            $transfer->transfercategory = $request->transfercategory;
            $transfer->transferreason = $request->transferreason;
            $transfer->institutionname = $request->institutionname;
            $transfer->transferfaculty = $request->transferfaculty;
            $transfer->transferdepartment = $request->transferdepartment;
            $transfer->transferunit = $request->transferunit;
            $transfer->previous_designation = $request->previous_designation;
            $transfer->designation = $request->designation;
            $transfer->	initiate = $request->initiate;
            $transfer->	other = $request->other;
            $transfer->user_id = Auth::user()->id;
            // dd($transfer);
            $transfer->institution_id = isset(Auth::user()->employee) ? Auth::user()->employee->institution_id : Auth::user()->id;
            //  dd($transfer);
            $transfer->nameofstaff = $employees;
            $transfer->staffid = $staff_id;
            $transfer->	transferclassIn = $request->transferclassIn;
            $transfer->faculty = $transferfacultydirectorates;
            $transfer->department = $transferdepartments;
            $transfer->unit = $transferunits;
            $transfer->previous_role = $officialRole;
            $transfer->role = $request->role;
            $transfer->status = 1;
            // dd($transfer);
        }else{
            // dd($data);
            $transfer->transferclass = $request->transferclass;
            $transfer->transfertype = $request->transfertype;
            $transfer->transfercategory = $request->transfercategory;
            $transfer->transferreason = $request->transferreason;
            $transfer->institutionname = $request->institutionname;
            $transfer->transferfaculty = $request->transferfaculty;
            $transfer->transferdepartment = $request->transferdepartment;
            $transfer->transferunit = $request->transferunit;
            $transfer->	initiate = $request->initiate;
            $transfer->previous_designation = $request->previous_designation;
            $transfer->designation = $request->designation;
            $transfer->	other = $request->other;
            $transfer->	transferclassIn = $request->transferclassIn;
            $hel=Employee::where('id',$request->nameofstaff)->first();
            $help=User::where('id',$hel->user_id)->first();
            $transfer->user_id = $help->id;
            // dd($transfer);
            $transfer->institution_id = isset(Auth::user()->employee) ? Auth::user()->employee->institution_id : Auth::user()->id;
            $transfer->nameofstaff = $request->nameofstaff;
            $transfer->staffid = $request->staffid;
            $transfer->faculty = $request->faculty;
            $transfer->department = $request->department;
            $transfer->unit = $request->unit;
            $transfer->previous_role = $request->previous_role;
            $transfer->role = $request->role;
            $transfer->status = 1;
        }

        $employee = Employee::all()->pluck('institution_id');
        // dd(Auth::user()->institutionname);
        $transfer->save();

        if(Auth::user()->role==null){
            $name = Employee::where('id','=',$transfer->nameofstaff)->first();
            $created = Employee::where('user_id','=',$transfer->user_id)->first();
            $visible_users = User::where('id',$transfer->user_id)->pluck('id')->toArray();
        
            $notifications = new Notification();
            foreach ($visible_users as  $key => $value){
                //$notifications->create( [ 'notifiable_id' => $transfer->id, 'notifiable_type' => 'initiate_transfer', 'user_id' => Auth::user()->id, 'message' => 'New Transfer Initiate for '.$name->fname.' '.$name->lname.' Created By ('.Auth::user()->institutionname.')', 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
                if($transfer->department == $transfer->transferdepartment){
                    $notifications->create( [ 'notifiable_id' => $transfer->id, 'notifiable_type' => 'initiate_transfer', 'user_id' => Auth::user()->id, 'message' => $name->fname.' '.$name->lname.' has been Redeployed Request by '.$name->official_information->departments_dt->departmentname, 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
                }else{
                    $notifications->create( [ 'notifiable_id' => $transfer->id, 'notifiable_type' => 'initiate_transfer', 'user_id' => Auth::user()->id, 'message' => $name->fname.' '.$name->lname.' has been Transferred Request by '.Auth::user()->institutionname, 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
                }
                
            }
        }
        if($transfer)
            return redirect()->route('transfer.list')->with('success',"Transfer Added Successfully.");
        else
            return redirect()->route('transfer.list')->with('error',"Error In Adding Transfer.");
    }

    public function index()
    { 
        if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOF'){
           $emp = Employee::where('employeeemail',Auth::user()->email)->first();
           $data = Transfer::where('status', '=', 1)->where('nameofstaff', '=', $emp->id)->get();
        }
        else{
           $data = Transfer::where('institution_id','=',Auth::user()->id)->get();
        }
        return view('Transfer/list',['data'=> $data]);
    }
    public function audit()
    { 
        return view('Transfer/audit',);
    }
    public function audit_details(Request $request){
        $transfer_out = null;
        $transfer_in = null;
        $trfClass = $request->trfClass;
        if (isset($request->trfClass) ) {
            if (in_array("incoming", $request->trfClass))
            {
                $transfer_in = Transfer::where('institutionname','=',Auth::user()->id)->get()->toArray();
            }
            if (in_array("outgoing", $request->trfClass))
            {
                $transfer_out = Transfer::where('institution_id','=',Auth::user()->id)->get()->toArray();
            }
            if (in_array("", $request->trfClass))
            {
                $transfer_out = Transfer::where('institution_id','=',Auth::user()->id)->get();
                $transfer_in = Transfer::where('institutionname','=',Auth::user()->id)->get();
            }
        }else{
            $transfer_out = Transfer::where('institution_id','=',Auth::user()->id)->get();
            $transfer_in = Transfer::where('institutionname','=',Auth::user()->id)->get();
        }
        return view('Transfer/audit',compact('transfer_out','transfer_in','trfClass'));
    }

    public function alltransfer()
    { 
        $transfer_out = Transfer::where('institution_id','=',Auth::user()->id)->where('status',4)->get();
        $transfer_in = Transfer::where('institutionname','=',Auth::user()->id)->where('status',4)->get();
        // dd($data);
        return view('Transfer/transferList',compact('transfer_out','transfer_in'));
    }

    public function fetchFaculty(Request $request)
    {
        $data['fac'] = FacultyDirectorate::where('user_id', $request->insti_id)
                                ->get();
  
        return response()->json($data);
    }

    public function fetchDepart(Request $request)
    {
        $data['depart'] = Department::where('faculty_id', $request->faculty_id)
                                ->get();
  
        return response()->json($data);
    }
    public function fetchUnit(Request $request)
    {
        $data['FetchUnits'] = Unit::where('department_id', $request->depart_id)
                                ->get();
        $data['FetchDesig'] = Designation::where('department_id', $request->depart_id)
                                ->get();
  
        return response()->json($data);
    }
    public function fetchInsti(Request $request)
    {
        $data['insti_intra'] = User::where('id', $request->user_id)
                                ->first();
        $gt = $data['insti_intra']->id;

        $data['fac_intra'] = FacultyDirectorate::where('user_id', $gt)
                                ->get();

        $data['Insti_user'] = User::where('institutionname','!=',null)->get();
        return response()->json($data);
    }

    public function fetchOfficialInfo(Request $request)
    {
        $data['Employee_OfficialInfo'] = OfficialInfo::where('employee_id', $request->employee_id)
                                    ->first()->load('departments_dt')->load('faculty_dt')->load('unit_dt')->load('designations');
        // $data['depart_dt'] = School::get()->load('user');
        return response()->json($data);
    }


    public function edit($id)
    {
      $facultydirectorates = FacultyDirectorate::get();
      $departments = Department::get();
      $transferclass = TransferClass::where('classname','Transfer Out')->first();
      $transferclassIn = TransferClass::where('classname','Transfer In')->first();
      $transertype = TransferType::get();
      $desig = Designation::get();
      $transfercategory = TransferCategory::get();
      $units = Unit::get();
      $officialinfos = OfficialInfo::get();
      $academicqualification = AcademicQualification::get();
      $transferreason = TransferReason::get();
      $employee = Employee::get();
      $users = User::get();
        $transfer = Transfer::findOrFail($id);



        $emp_fetc = Employee::where('institution_id','=',Auth::user()->id)->get();
        
     // $employee = Employee::get();
      $staff_id = null;
      $employees = null;
      $transferdepartments = null;
      $transferfacultydirectorates = null;
      $transferunit = null;
      $offrole = null;
      $initiatedata = '';
      $emp = [];
      if(Auth::user()->is_school == 3){
          $emp = Employee::where('employeeemail',Auth::user()->email)->first();
          $staff_id = isset($emp->official_information) ? $emp->official_information->staff_id : '';
          $employees = $emp->id;
          $transferfacultydirectorates = isset($emp->official_information) ? $emp->official_information->directorate : '';
          $transferdepartments = isset($emp->official_information) ? $emp->official_information->department : ''; 
          $transferunit =  isset($emp->official_information) ? $emp->official_information->unit : '';  
          $offrole = isset($emp->official_information) ? $emp->official_information->role : '';  
        //   dd($offrole);
          if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' ){
            $employee = Employee::where('institution_id','=',Auth::user()->employee->institution_id)->get();
          }
           $initiate = Employee::where('user_id','=',Auth::user()->id)->first();
           $initiatedata = $initiate->fname;
           //dd($initiate);
          
      }

       
        return view('/Transfer/transferinitiationform', compact('desig','transferclassIn','staff_id','employees','transferdepartments','transferfacultydirectorates','transferunit','offrole','emp','transfer' , 'id','facultydirectorates','departments','transferclass','transertype','transfercategory','units','officialinfos','academicqualification','transferreason','employee','users'));
    }

    public function update(Request $request, $code)
    { 

        $transfer = Transfer::findOrFail($code);
        $data = $request->input();
        $data['status'] = 2;

        if($transfer){
            if($transfer->update($data))
                return redirect()->route('transfer.list')->with('success',"Transfer Edited Successfully.");
            else
                return redirect()->route('transfer.list')->with('error',"Transfer in Updating Unit.");
        }else{
            return redirect()->route('transfer.list')->with('error',"Transfer Not Found.");
        }
    }

    public function delete($code)
    {
        $transfer = Transfer::where('id', '=', $code)->first();   
        $transfer->delete();
        
        return redirect()->route('transfer.list')->with('success',"Transfer Deleted Successfully.");
    }
    public function export_pdf()
    {
        if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOF'){
            $emp = Employee::where('employeeemail',Auth::user()->email)->first();
         //    $data['offInfo']= OfficialInfo::where('employee_id',$emp->id)->first();
            $data = Transfer::where('status', '=', 1)->where('nameofstaff', '=', $emp->id)->get();
         }
         else{
            $data = Transfer::where('institution_id','=',Auth::user()->id)->get();
         }
         $html = '';
         $html = '<div class="content">
        <div class="col-12">
        <div class="card">
                <div class="card-body">
            <center><h3 style="padding-bottom: 20px;">Transfer List</h3></center>
            <table style="border-collapse: collapse; width: 100%;">
                <thead style="padding-top:30px;">
                    <tr>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Sr.No</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Staff ID No</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Staff Name</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Department</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Application Type</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Transfer Class</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($data as $key => $val) {
                    $html .= '<tr>
                <td style="padding-right: 10px;text-align: center;">' . ($key + 1) . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->staffid . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->employee_trf_detail->fname . ' ' . $val->employee_trf_detail->mname . ' ' . $val->employee_trf_detail->lname . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->departments_trf_dt->departmentname . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->transfertype . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->transferclass . '</td>';
            }
                echo $html;
    }

    
}

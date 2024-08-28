<?php

namespace App\Http\Controllers;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\Employee;
use App\Models\FacultyDirectorate;
use App\Models\Department;
use App\Models\User;
use App\Models\OfficialInfo;
use App\Models\Unit;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\ApplicationRejectedNotification;
use App\Notifications\NewApplicationNotification;
use App\Http\Requests\NewLeaveApplicationRequest;

class HOULeaveController extends Controller
{
    public function index()
    {        
        $data = Employee::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->first();

        $condition=OfficialInfo::where('employee_id', '=', $data->id)->first();


        $director = FacultyDirectorate::where('faculty_directorates.user_id',$data->institution_id)
        ->join('departments','departments.faculty_id','=','faculty_directorates.id')
        ->join('units','units.department_id','=','departments.id')
        
        ->get(['faculty_directorates.id','faculty_directorates.user_id','departments.id as depart_id','departments.faculty_id','units.id as unit_id','units.faculty_id as fac_id','units.department_id as departs_id']);
        // dd($director);
       
        foreach($director as $directors){
        $offcial[]=OfficialInfo::where('directorate',$directors->fac_id)
        ->where('department',$directors->departs_id)
        ->where('unit',$directors->unit_id)
        ->where('official_infos.user_id',$directors->user_id)
        ->where('official_infos.unit',$condition->unit)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->where('official_infos.role','Employee')
        ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
        }
        // dd($offcial);
        if (count($offcial) > 0) {
            $collection = collect($offcial[0]);

            foreach ($offcial as $key => $value) {
                if ($key != 0) {
                    $merge = $collection->merge($value);
                    $collection = collect($merge);
                }
            }
        }
        $col=[];
        if($collection->isNotEmpty()){
        foreach($collection as $offcials){
                $leave[] = Leave::where('employee_id',$offcials->emp_id)
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')
                ->get();
        }
        // dd($collection);
        if (count($leave) > 0) {
            $col = collect($leave[0]);

            foreach ($leave as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
    }
}
        return view('employeeLeave.hou_index',compact('col'));
}
    public function HODindex()
    {
        $data = Employee::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->first();

        $condition=OfficialInfo::where('employee_id', '=', $data->id)->first();
        $col=[];
// dd($condition);
        if($condition->unit !=null && $condition->department !=null && $condition->directorate !=null){
        $director = FacultyDirectorate::where('faculty_directorates.user_id',$data->institution_id)
        ->join('departments','departments.faculty_id','=','faculty_directorates.id')
        ->join('units','units.department_id','=','departments.id')
        
        ->get(['faculty_directorates.id','faculty_directorates.user_id','departments.id as depart_id','departments.faculty_id','units.id as unit_id','units.faculty_id as fac_id','units.department_id as departs_id']);

       
        foreach($director as $directors){
        $offcial[]=OfficialInfo::where('directorate',$directors->fac_id)
        ->where('department',$directors->departs_id)
        ->where('unit',$directors->unit_id)
        ->where('official_infos.user_id',$directors->user_id)
        ->where('official_infos.department',$condition->department)
        ->where('official_infos.unit',$condition->unit)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->whereIn('official_infos.role',['Employee','HOU'])
        ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
        }
        
        if (count($offcial) > 0) {

            $collection = collect($offcial[0]);

            foreach ($offcial as $key => $value) {
                if ($key != 0) {
                    $merge = $collection->merge($value);
                    $collection = collect($merge);
                }
            }
        }
        $col=[];
        if($collection->isNotEmpty()){
        foreach($collection as $offcials){
                $leave[] = Leave::where('employee_id',$offcials->emp_id)
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')
                ->get();
        }
        if (count($leave) > 0) {
            $col = collect($leave[0]);

            foreach ($leave as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
        }
        
    }
}


//  unit is not null department is not null director null



// elseif($condition->unit !=null && $condition->department !=null){
//     $director = Department::where('departments.user_id',$data->institution_id)
//         ->join('units','units.department_id','=','departments.id')
        
//         ->get(['departments.user_id','departments.id as depart_id','units.id as unit_id','units.department_id as departs_id']);

       
//         foreach($director as $directors){
//         $offcial[]=OfficialInfo::where('department',$directors->departs_id)
//         ->where('unit',$directors->unit_id)
//         ->where('official_infos.user_id',$directors->user_id)
//         ->where('official_infos.directorate',null)
//         ->where('official_infos.department',$condition->department)
//         ->where('official_infos.unit',$condition->unit)
//         ->join('employees','employees.id','=','official_infos.employee_id')
//         ->whereIn('official_infos.role',['Employee','HOU'])
//         ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
//         }
        
//         if (count($offcial) > 0) {

//             $collection = collect($offcial[0]);

//             foreach ($offcial as $key => $value) {
//                 if ($key != 0) {
//                     $merge = $collection->merge($value);
//                     $collection = collect($merge);
//                 }
//             }
//         }
//         $col=[];
//         if($collection->isNotEmpty()){
//         foreach($collection as $offcials){
//                 $leave[] = Leave::where('employee_id',$offcials->emp_id)
//                 ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
//                 ->select('leaves.*','leavetypes.name')
//                 ->get();
//         }
//         if (count($leave) > 0) {
//             $col = collect($leave[0]);

//             foreach ($leave as $key => $value) {
//                 if ($key != 0) {
//                     $merge = $col->merge($value);
//                     $col = collect($merge);
//                 }
//             }
//         }
        
//     }
// }



elseif($condition->department !=null && $condition->directorate !=null && $condition->unit ==null){
    // dd($condition);
    $director = FacultyDirectorate::where('faculty_directorates.user_id',$data->institution_id)
        ->join('departments','departments.faculty_id','=','faculty_directorates.id')
        
        ->get(['faculty_directorates.id','faculty_directorates.user_id','departments.id as depart_id','departments.faculty_id']);

       
        foreach($director as $directors){
        $offcial[]=OfficialInfo::where('directorate',$directors->faculty_id)
        ->where('department',$directors->depart_id)
        ->where('official_infos.user_id',$directors->user_id)
        ->where('official_infos.unit',null)
        ->where('official_infos.department',$condition->department)
        ->where('official_infos.directorate',$condition->directorate)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->whereIn('official_infos.role',['Employee','HOU'])
        ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
        }
        
        if (count($offcial) > 0) {

            $collection = collect($offcial[0]);

            foreach ($offcial as $key => $value) {
                if ($key != 0) {
                    $merge = $collection->merge($value);
                    $collection = collect($merge);
                }
            }
        }
        $col=[];
        if($collection->isNotEmpty()){
        foreach($collection as $offcials){
                $leave[] = Leave::where('employee_id',$offcials->emp_id)
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')
                ->get();
        }
        if (count($leave) > 0) {
            $col = collect($leave[0]);

            foreach ($leave as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
        }
        
    }
}


// Faculty is null , department , unit is null code 


// elseif($condition->unit ==null && $condition->department !=null && $condition->directorate ==null){
//     $director = Department::where('departments.user_id',$data->institution_id)
        
//         ->get(['departments.user_id','departments.id as depart_id','departments.faculty_id']);

       
//         foreach($director as $directors){
//         $offcial[]=OfficialInfo::where('department',$directors->depart_id)
//         ->where('official_infos.user_id',$directors->user_id)
//         ->where('official_infos.directorate',null)
//         ->where('official_infos.unit',null)
//         ->where('official_infos.department',$condition->department)
//         ->join('employees','employees.id','=','official_infos.employee_id')
//         ->whereIn('official_infos.role',['Employee','HOU','HOF'])
//         ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
//         }
        
//         if (count($offcial) > 0) {

//             $collection = collect($offcial[0]);

//             foreach ($offcial as $key => $value) {
//                 if ($key != 0) {
//                     $merge = $collection->merge($value);
//                     $collection = collect($merge);
//                 }
//             }
//         }
//         $col=[];
//         if($collection->isNotEmpty()){
//         foreach($collection as $offcials){
//                 $leave[] = Leave::where('employee_id',$offcials->emp_id)
//                 ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
//                 ->select('leaves.*','leavetypes.name')
//                 ->get();
//         }
//         if (count($leave) > 0) {
//             $col = collect($leave[0]);

//             foreach ($leave as $key => $value) {
//                 if ($key != 0) {
//                     $merge = $col->merge($value);
//                     $col = collect($merge);
//                 }
//             }
//         }
        
//     }
// }
    return view('employeeLeave.hod_index',compact('col'));
}

    public function HOFindex()
    {
        $data = Employee::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->first();

        $condition=OfficialInfo::where('employee_id', '=', $data->id)->first();
        $col=[];
        // dd($condition);
        if($condition->unit !=null && $condition->department !=null && $condition->directorate !=null){
        $director = FacultyDirectorate::where('faculty_directorates.user_id',$data->institution_id)
        ->join('departments','departments.faculty_id','=','faculty_directorates.id')
        ->join('units','units.department_id','=','departments.id')
        
        ->get(['faculty_directorates.id','faculty_directorates.user_id','departments.id as depart_id','departments.faculty_id','units.id as unit_id','units.faculty_id as fac_id','units.department_id as departs_id']);
        // dd($director);
       
        foreach($director as $directors){
        $offcial[]=OfficialInfo::where('directorate',$directors->fac_id)
        ->where('department',$directors->departs_id)
        ->where('unit',$directors->unit_id)
        ->where('official_infos.user_id',$directors->user_id)
        ->where('official_infos.directorate',$condition->directorate)
        ->where('official_infos.department',$condition->department)
        ->where('official_infos.unit',$condition->unit)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->whereIn('official_infos.role',['Employee','HOU','HOD'])
        ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
        }
        // dd($offcial);
        if (count($offcial) > 0) {
            $collection = collect($offcial[0]);

            foreach ($offcial as $key => $value) {
                if ($key != 0) {
                    $merge = $collection->merge($value);
                    $collection = collect($merge);
                }
            }
        }
        // dd($collection);
        $col=[];
        if($collection->isNotEmpty()){
        foreach($collection as $offcials){
                $leave[] = Leave::where('employee_id',$offcials->emp_id)
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')
                ->get();
        }
        // dd($collection);
        if (count($leave) > 0) {
            $col = collect($leave[0]);

            foreach ($leave as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
        }
    }
}
elseif($condition->department !=null && $condition->directorate !=null && $condition->unit == null ){
    // dd($condition);
    $director = FacultyDirectorate::where('faculty_directorates.user_id',$data->institution_id)
        ->join('departments','departments.faculty_id','=','faculty_directorates.id')
        // ->join('units','units.department_id','=','departments.id')
        
        ->get(['faculty_directorates.id','faculty_directorates.user_id','departments.id as depart_id','departments.faculty_id']);
        // dd($director);
       
        foreach($director as $directors){
        $offcial[]=OfficialInfo::where('directorate',$directors->faculty_id)
        ->where('department',$directors->depart_id)
        ->where('official_infos.user_id',$directors->user_id)
        ->where('official_infos.directorate',$condition->directorate)
        ->where('official_infos.department',$condition->department)
        // ->where('official_infos.unit',null)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->whereIn('official_infos.role',['Employee','HOU','HOD'])
        ->get(['employees.fname','employees.lname','employees.mname','employees.id as emp_id','official_infos.*']);
        }
        // dd($offcial);
        if (count($offcial) > 0) {
            $collection = collect($offcial[0]);

            foreach ($offcial as $key => $value) {
                if ($key != 0) {
                    $merge = $collection->merge($value);
                    $collection = collect($merge);
                }
            }
        }
        // dd($collection);
        $col=[];
        if($collection->isNotEmpty()){
        foreach($collection as $offcials){
                $leave[] = Leave::where('employee_id',$offcials->emp_id)
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')
                ->get();
        }
        // dd($collection);
        if (count($leave) > 0) {
            $col = collect($leave[0]);

            foreach ($leave as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
        }
    }
}
        return view('employeeLeave.hof_index',compact('col'));
}


    public function LeaveView()
    {
        // dd(permission_employee());

        $employeeData=Employee::where('user_id', '=', Auth::user()->id)->first();
        $check=$employeeData->leavetype_id;
        $leaveId = explode(',', $check);
        
        foreach ($leaveId as $leaveIds) {
            $leaveType = DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
         }

        //  dd($leaveType);
        return view('employeeLeave.leaveRequest',compact('employeeData','leaveType'));
    }

    public function EmployeeLeaveAssign(Request $request)
    {
    //    dd($request->all());
        $validatedData = $request->validate([
            'leavetype_id' => 'required',
            'leave_days' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);
        $employeeData=Employee::where('user_id', '=', Auth::user()->id)->first();
        $leave = new Leave();
        $leave->employee_id = $employeeData->id;
        $leave->leavetype_id = $request['leavetype_id'];
        $leave->leave_days = $request['leave_days'];
        if($leave->leave_days == "half"){
            $leave->half_leave = $request['half_leave'];
        }elseif($leave->leave_days == "hourly"){
            $leave->hourly_hours = $request['hourly_hours'];
        }
        else{
            $leave['leave_days'] = $request['leave_days'];
            $leave['half_leave'] = null;
            $leave->hourly_hours = null;
        }
        $leave->start_date =date($request['start_date']);
        $leave->end_date = date($request['end_date']);
        $leave->reason = $request->reason; 
        if($leave->reason == "Other"){
            $leave->other_reason = $request['other_reason'];
        }else{
            $leave['other_reason'] = null;
        }
        $leave->status = "Pending";
        $leave->hod_status = "Pending";
        $leave->hou_status = "Pending";
        $leave->hof_status = "Pending";
        // dd($leave);
        $leave->save();


//         $users=DB::table('users')
//         ->select(['users.*'])
//         ->where('users.id', $employeeData->institution_id)
//         ->first();
//         $check=$users->id;
        
//         // Notification::send($check, new NewApplicationNotification($leave));
//        $c=Notification::route('Employeeleave.store', $check)->notify(new NewApplicationNotification($leave));
// dd($c);
        if($leave)
            return redirect()->route('LeaveBalanceview')->with('success',"Leave Request Submit Successfully.");
        else
            return redirect()->route('LeaveBalanceview')->with('error',"Error In Adding Leave Request.");
    }

    public function edit($id)
    {
        $leavetypes = Leavetype::get();
        $leave = Leave::find($id);
        $leaveID=$leave->leavetype_id;
        $empID=$leave->employee_id;
        $data= Employee::where('id',$empID)->first();
        
        
        $type=DB::table('leavetypes')
        ->select(['leavetypes.*'])
        ->where('leavetypes.id',$leaveID)
        ->first();
        
        return view('employeeLeave.edit',compact('leave','leavetypes','data','type'));
    }
    public function update(Request $request,$id)
    {

        $leave = Leave::find($id);
        if($request->has('Approve')){
            $leave->status = 'Approved';
        }else{
            $leave->status = 'Rejected';
        }
        // dd($leave);
        $leave->update();
        return redirect()->route('LeaveBalanceview')
                        ->with('success','Leave Request updated successfully');
    }
}

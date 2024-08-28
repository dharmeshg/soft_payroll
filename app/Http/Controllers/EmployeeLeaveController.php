<?php

namespace App\Http\Controllers;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\Employee;
use App\Models\User;
use App\Models\OfficialInfo;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\ApplicationRejectedNotification;
use App\Notifications\NewApplicationNotification;
use App\Http\Requests\NewLeaveApplicationRequest;

class EmployeeLeaveController extends Controller
{
    public function index()
    {
     
        // dd(permission_employee());
        
        $leaves = DB::table('leaves')
        ->join('employees', 'leaves.employee_id', '=', 'employees.id')
        ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
        // ->where('employees.institution_id', '=', Auth::user()->id)
        ->select('leaves.*', 'employees.fname','employees.mname','employees.lname','leavetypes.name')
        ->get();
// dd($leaves);
        return view('employeeLeave.index',compact('leaves'));
    }

    public function LeaveView()
    {

        $names=Leavetype::all();
        $data['name'] = $names;
        
        $employeeData=Employee::where('user_id', '=', Auth::user()->id)->first();
        $check=$employeeData->leavetype_id;
        $leaveId = explode(',', $check);
        
        $results = DB::table('users')
            ->where('users.id','=',Auth::user()->id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->first();

        $date = Carbon::now()->format('Y');
        
        foreach ($leaveId as $leaveIds) {
            $leaveType = DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
         }

         if($results->year == $date){
            $leaveUseDays=DB::table('leaves')
            ->select(['leaves.*'])
            ->where('leaves.employee_id', $employeeData->id)
            ->whereIn('leaves.status',array('Pending','Approved'))
            ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
            ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
            ->get()
            ->each(function($query){
                $query->start_date = explode(",", $query->start_date);
                $query->end_date = explode(",", $query->end_date);
            });
            // dd($leaveUseDays);
        foreach ($names as $name) {
            $data['leaveCount'][$name->name] = 0;
        }

        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
            $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
            // dd($check_date);
            if($check_date == $date && $check_enddate == $date){
                // dd("hi");
                if($apps->leave_days == "half"){
                    $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                    $data['leaveCount'][$apps->name] += $diffren;
                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                    $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                    $data['leaveCount'][$apps->name] += $diffre;
                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                    $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                    $data['leaveCount'][$apps->name] += $diffr;
                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                    $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                    $data['leaveCount'][$apps->name] += $diff;
                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                    $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                    $data['leaveCount'][$apps->name] += $dif;
                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                    $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                    $data['leaveCount'][$apps->name] += $di;
                }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                    $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                    $data['leaveCount'][$apps->name] += $diffrent;
                }elseif($apps->leave_days == "intermittent"){
                    // $dateex = explode(',',$apps->start_date);
                    $diffrent=count($apps->start_date);
                    $data['leaveCount'][$apps->name] += $diffrent;
                }
            }
            }elseif($apps -> leave_cycle == "Other"){
                $from_date = Carbon::createFromFormat('d-m-Y',  $apps -> from_date)->format('Y/m/d');
                            $to_date = Carbon::createFromFormat('d-m-Y',  $apps -> to_date)->format('Y/m/d');
                            $Try_from_date =Carbon::parse($from_date);
                            $Try_to_date =Carbon::parse($to_date);

                            $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                            $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');
        
                            $Try_check_date =Carbon::parse($check_date);
                            $Try_check_enddate =Carbon::parse($check_enddate);

                            if($Try_check_date->between($Try_from_date, $Try_to_date) && $Try_check_enddate -> between($Try_from_date, $Try_to_date)){
                                if($apps->leave_days == "half"){
                                    $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                                    $data['leaveCount'][$apps->name] += $diffren;
                                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                                    $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                                    $data['leaveCount'][$apps->name] += $diffre;
                                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                                    $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                                    $data['leaveCount'][$apps->name] += $diffr;
                                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                                    $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                                    $data['leaveCount'][$apps->name] += $diff;
                                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                                    $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                                    $data['leaveCount'][$apps->name] += $dif;
                                }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                                    $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                                    $data['leaveCount'][$apps->name] += $di;
                                }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                                    $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                                    $data['leaveCount'][$apps->name] += $diffrent;
                                }elseif($apps->leave_days == "intermittent"){
                                    // $dateex = explode(',',$apps->start_date);
                                    $diffrent=count($apps->start_date);
                                    $data['leaveCount'][$apps->name] += $diffrent;
                                }
                            }
            }elseif($apps -> leave_cycle == "Fiscal Year"){
                $period = CarbonPeriod::create(
                    now()->month(4)->startOfMonth()->format('Y-m-d'),
                    '1 month',
                    now()->month(3)->addMonths(12)->format('Y-m-d')
                );
                $finYear = [];
                foreach ($period as $p) {
                    $finYear[] = $p->format('Y/m/d');
                }
                
                $st=$finYear[0];
                $en=$finYear[11];
                $try_en=Carbon::parse($en)->endOfMonth()->toDateString();
                $try_st=Carbon::parse($st)->startOfMonth()->toDateString();
            
                $try_st_new = Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                $try_en_new = Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');
              

                $Try_New =Carbon::parse($try_st_new);
                $Try_New_end =Carbon::parse($try_en_new);


                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');

                $Try_check_date =Carbon::parse($check_date);
                $Try_check_enddate =Carbon::parse($check_enddate);


                if($Try_check_date -> between($Try_New, $Try_New_end) && $Try_check_enddate -> between($Try_New, $Try_New_end)){
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['leaveCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['leaveCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['leaveCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['leaveCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['leaveCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['leaveCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['leaveCount'][$apps->name] += $diffrent;
                    }elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $diffrent=count($apps->start_date);
                        $data['leaveCount'][$apps->name] += $diffrent;
                    }
                }
            }
            
         }
         }else{
            $leaveUseDays=DB::table('leaves')
                ->select(['leaves.*'])
                ->where('leaves.employee_id', $employeeData->id)
                ->whereIn('leaves.status',array('Pending','Approved'))
                ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
                ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
                ->get()
                ->each(function($query){
                    $query->start_date = explode(",", $query->start_date);
                    $query->end_date = explode(",", $query->end_date);
                });
// dd($leaveUseDays);
            foreach ($names as $name) {
                $data['leaveCount'][$name->name] = 0;
            }
            foreach ($leaveUseDays as $apps) {
                if($apps -> leave_cycle == "Anniversary Year"){
                    $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                // dd($check_date);
                if($check_date == $date && $check_enddate == $date){
                    // dd("hi");
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['leaveCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['leaveCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['leaveCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['leaveCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['leaveCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['leaveCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['leaveCount'][$apps->name] += $diffrent;
                    }elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $diffrent=count($apps->start_date);
                        $data['leaveCount'][$apps->name] += $diffrent;
                    }
                }
                }elseif($apps -> leave_cycle == "Other"){
                    $from_date = Carbon::createFromFormat('d-m-Y',  $apps -> from_date)->format('Y/m/d');
                                $to_date = Carbon::createFromFormat('d-m-Y',  $apps -> to_date)->format('Y/m/d');
                                $Try_from_date =Carbon::parse($from_date);
                                $Try_to_date =Carbon::parse($to_date);
    
                                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');
            
                                $Try_check_date =Carbon::parse($check_date);
                                $Try_check_enddate =Carbon::parse($check_enddate);
    
                                if($Try_check_date->between($Try_from_date, $Try_to_date) && $Try_check_enddate -> between($Try_from_date, $Try_to_date)){
                                    if($apps->leave_days == "half"){
                                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                                        $data['leaveCount'][$apps->name] += $diffren;
                                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                                        $data['leaveCount'][$apps->name] += $diffre;
                                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                                        $data['leaveCount'][$apps->name] += $diffr;
                                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                                        $data['leaveCount'][$apps->name] += $diff;
                                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                                        $data['leaveCount'][$apps->name] += $dif;
                                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                                        $data['leaveCount'][$apps->name] += $di;
                                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                                        $data['leaveCount'][$apps->name] += $diffrent;
                                    }elseif($apps->leave_days == "intermittent"){
                                        // $dateex = explode(',',$apps->start_date);
                                        $diffrent=count($apps->start_date);
                                        $data['leaveCount'][$apps->name] += $diffrent;
                                    }
                                }
                }elseif($apps -> leave_cycle == "Fiscal Year"){
                    $period = CarbonPeriod::create(
                        now()->month(4)->startOfMonth()->format('Y-m-d'),
                        '1 month',
                        now()->month(3)->addMonths(12)->format('Y-m-d')
                    );
                    $finYear = [];
                    foreach ($period as $p) {
                        $finYear[] = $p->format('Y/m/d');
                    }
                    
                    $st=$finYear[0];
                    $en=$finYear[11];
                    $try_en=Carbon::parse($en)->endOfMonth()->toDateString();
                    $try_st=Carbon::parse($st)->startOfMonth()->toDateString();
                
                    $try_st_new = Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                    $try_en_new = Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');
                  
    
                    $Try_New =Carbon::parse($try_st_new);
                    $Try_New_end =Carbon::parse($try_en_new);
    
    
                    $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                    $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');
    
                    $Try_check_date =Carbon::parse($check_date);
                    $Try_check_enddate =Carbon::parse($check_enddate);
    
    
                    if($Try_check_date -> between($Try_New, $Try_New_end) && $Try_check_enddate -> between($Try_New, $Try_New_end)){
                        if($apps->leave_days == "half"){
                            $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                            $data['leaveCount'][$apps->name] += $diffren;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                            $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                            $data['leaveCount'][$apps->name] += $diffre;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                            $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                            $data['leaveCount'][$apps->name] += $diffr;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                            $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                            $data['leaveCount'][$apps->name] += $diff;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                            $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                            $data['leaveCount'][$apps->name] += $dif;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                            $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                            $data['leaveCount'][$apps->name] += $di;
                        }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                            $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                            $data['leaveCount'][$apps->name] += $diffrent;
                        }elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $diffrent=count($apps->start_date);
                            $data['leaveCount'][$apps->name] += $diffrent;
                        }
                    }
                }
             }
         }
         
        return view('employeeLeave.leaveRequest',$data,compact('leaveUseDays','employeeData','leaveType'));
    }

    public function EmployeeLeaveAssign(Request $request)
    {
    //    dd($request->all());
    
        $validatedData = $request->validate([
            'leavetype_id' => 'required',
            'leave_days' => 'required',
            'reason' => 'required',
        ]);
        
        $employeeData=Employee::where('user_id', '=', Auth::user()->id)->first();
        $leavemaxallowdays=Leavetype::where('id',$request->leavetype_id)->first('max_allow_days');
        $leaveDate=Leave::where('employee_id',$employeeData->id)->whereIn('status',array('Pending','Approved'))->get(['start_date','end_date','leave_days']);
        $InterLeave=Leave::where('employee_id',$employeeData->id)->whereIn('status',array('Pending','Approved'))->where('leave_days',"intermittent")->get(['start_date','end_date']);
        if($InterLeave->isNotEmpty()){
        foreach($InterLeave as $InterLeaves){
            $interex[]=explode(',',$InterLeaves->start_date);
        }
        if (count($interex) > 0) {
            $col = collect($interex[0]);

            foreach ($interex as $key => $value) {
                if ($key != 0) {
                    $merge = $col->merge($value);
                    $col = collect($merge);
                }
            }
            if($col->isNotEmpty()){
                foreach($col as $cols){
                }
            }
        }
    }
    // dd($col);
        $empData=OfficialInfo::where('employee_id', '=', $employeeData->id)->first();
        $remaning=$request->count_data;
        // dd($remaning);
        $dur=$request->duration;
        // dd($dur);
        $storedate=implode(',',$request->get('start_dates'));
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
        if($leaveDate->isNotEmpty()){
            foreach($leaveDate as $leavedates){
                if($leavemaxallowdays->max_allow_days >= $dur){
                    if((date('d-m-Y', strtotime($leavedates->start_date))) != $request->start_date && (date('d-m-Y', strtotime($leavedates->end_date))) != $request->end_date && (date('d-m-Y', strtotime($leavedates->start_date))) != $request->end_date && (date('d-m-Y', strtotime($leavedates->end_date))) != $request->start_date){
                        if($leave->leave_days == "half" || $leave->leave_days == "hourly" || $leave->leave_days == "full"){
                            if(isset($col)){
                                if($col->isNotEmpty()){
                                    foreach($col as $cols){
                                        if($cols != $request->start_date){
                                            if($remaning >= $dur){
                                                $leave->start_date =date($request['start_date']);
                                                $leave->end_date = date($request['start_date']);
                                            }else{
                                                return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }else{
                                            return redirect()->route('LeaveBalanceview')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                        }
                                    }
                                }else{
                                    if($remaning >= $dur){
                                        $leave->start_date =date($request['start_date']);
                                        $leave->end_date = date($request['start_date']);
                                    }else{
                                        return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                    }
                                }
                            }else{
                                if($remaning >= $dur){
                                    $leave->start_date =date($request['start_date']);
                                    $leave->end_date = date($request['start_date']);
                                }else{
                                    return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                }
                            }
                        }elseif($leave->leave_days == "intermittent"){
                            $ex=explode(',',$storedate);
                            // dd($ex);
                            foreach($ex as $exs){
                                if((date('d-m-Y', strtotime($leavedates->start_date))) != $exs && (date('d-m-Y', strtotime($leavedates->end_date))) != $exs && (date('d-m-Y', strtotime($leavedates->start_date))) != $exs && (date('d-m-Y', strtotime($leavedates->end_date))) != $exs){
                                    if(isset($col)){
                                        if($col->isNotEmpty()){
                                            foreach($col as $cols){
                                               if((date('d-m-Y', strtotime($cols))) != $exs){
                                                if($remaning >= $dur){
                                                    $leave->start_date = date($storedate);
                                                    $leave->end_date = date($storedate);
                                                    // dd($storedate);
                                                }else{
                                                    return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                                }
                                               }else{
                                                return redirect()->route('LeaveBalanceview')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                               }
                                            }
                                        }else{
                                            if($remaning >= $dur){
                                                $leave->start_date = date($storedate);
                                                $leave->end_date = date($storedate);
                                            }else{
                                                return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }
                                    }else{
                                        if($remaning >= $dur){
                                            $leave->start_date = date($storedate);
                                            $leave->end_date = date($storedate);
                                        }else{
                                            return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                        }
                                    }
                                }else{
                                    return redirect()->route('LeaveBalanceview')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                }
                            }
                        }else{
                            if(isset($col)){
                                if($col->isNotEmpty()){
                                    foreach($col as $cols){
                                        if($cols != $request->start_date && $cols != $request->end_date){
                                            if($remaning >= $dur){
                                                $leave->start_date =date($request['start_date']);
                                                $leave->end_date = date($request['end_date']);
                                            }else{
                                                return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }else{
                                            return redirect()->route('LeaveBalanceview')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                        }
                                    }
                                }else{
                                    if($remaning >= $dur){
                                    $leave->start_date =date($request['start_date']);
                                    $leave->end_date = date($request['end_date']);
                                }else{
                                    return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                }
                            }
                            }else{
                                if($remaning >= $dur){
                                    $leave->start_date =date($request['start_date']);
                                    $leave->end_date = date($request['end_date']);
                                }else{
                                    return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                }
                            }
                        }
                    }else{
                        return redirect()->route('LeaveBalanceview')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                    }
                }else{
                    return redirect()->route('LeaveBalanceview')->with('error',"You can not apply to leave More than Max allow Days... Your Max Allow Days is $leavemaxallowdays->max_allow_days.");
                }
                
            }
        }else{
            if($leavemaxallowdays->max_allow_days >= $dur){
                    if($leave->leave_days == "half" || $leave->leave_days == "hourly" || $leave->leave_days == "full"){
                        if($remaning >= $dur){
                            $leave->start_date =date($request['start_date']);
                            $leave->end_date = date($request['start_date']);
                        }else{
                            return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                        }
                    }
                    elseif($leave->leave_days == "intermittent"){
                        if($remaning >= $dur){
                                $leave->start_date = date($storedate);
                                $leave->end_date = date($storedate);
                        }else{
                            return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                        }
                    }else{
                        if($remaning >= $dur){
                            $leave->start_date =date($request['start_date']);
                            $leave->end_date = date($request['end_date']);
                        }else{
                            return redirect()->route('LeaveBalanceview')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                        }
                    }
            }else{
                return redirect()->route('LeaveBalanceview')->with('error',"You can not apply to leave More than Max allow Days... Your Max Allow Days is $leavemaxallowdays->max_allow_days.");
            }
        }
        // dd($leave);
        $leave->reason = $request->reason; 
        if($leave->reason == "Other"){
            $leave->other_reason = $request['other_reason'];
        }else{
            $leave['other_reason'] = null;
        }
        if($empData->role == "Employee" && $empData->unit == null){
            $leave->hou_status = 0;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }elseif($empData->role == "Employee" && $empData->unit != null){
            $leave->hou_status = "Pending";
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOU" && $empData->unit == null){
            $leave->hou_status = 0;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOU" && $empData->unit != null){
            $leave->hou_status = null;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOD" && $empData->unit == null){
            $leave->hou_status = 0;
            $leave->hod_status = null;
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOD" && $empData->unit != null){
            $leave->hou_status = null;
            $leave->hod_status = null;
            $leave->hof_status = "Pending";
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOF" && $empData->unit == null){
            $leave->hou_status = 0;
            $leave->hod_status = null;
            $leave->hof_status = null;
            $leave->status = "Pending";
        }
        elseif(Auth::user()->role == "HOF" && $empData->unit != null){
            $leave->hou_status = null;
            $leave->hod_status = null;
            $leave->hof_status = null;
            $leave->status = "Pending";
        }
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
        // dd(Auth::user()->role);
        $leavetypes = Leavetype::get();
        $leave = Leave::find($id);
        $leaveID=$leave->leavetype_id;
        $empID=$leave->employee_id;
        $data= Employee::where('id',$empID)->first();
        // dd($data);
        
        $type=DB::table('leavetypes')
        ->select(['leavetypes.*'])
        ->where('leavetypes.id',$leaveID)
        ->first();
        
        return view('employeeLeave.edit',compact('leave','leavetypes','data','type'));
    }
    public function update(Request $request,$id)
    {
        $leave = Leave::find($id);
        if(Auth::user()->role == "HOU"){
            if($request->has('Approve')){
                $leave->hou_status = 'Approved';
            }else{
                $leave->hou_status = 'Rejected';
            }
        }elseif(Auth::user()->role == "HOD"){
            if($leave->hou_status == "Approved"){
                if($request->has('Approve')){
                    $leave->hod_status = 'Approved';
                }else{
                    $leave->hod_status = 'Rejected';
                }
            }
            elseif($leave->hou_status == null){
                if($request->has('Approve')){
                    $leave->hod_status = 'Approved';
                }else{
                    $leave->hod_status = 'Rejected';
                }
            }
            elseif($leave->hou_status == "Rejected"){
                if($request->has('Reject')){
                    $leave->hod_status = 'Rejected';
                }
            }
            elseif($leave->hou_status == "Pending"){
                return redirect()->route('HODLeave.index')->with('error',"You Can not Approve or Reject this Leave Request Because Head of Unit Action is Pending!");
            }
            else{
                return redirect()->route('HODLeave.index')->with('error',"You Can not Approve this Leave Request Because Head of Unit Reject This Leave Request");
            }
            
        }elseif(Auth::user()->role == "HOF"){
            if($leave->hod_status == "Approved"){
                if($request->has('Approve')){
                    $leave->hof_status = 'Approved';
                }else{
                    $leave->hof_status = 'Rejected';
                }
            }
            elseif($leave->hod_status == "Rejected"){
                if($request->has('Reject')){
                    $leave->hof_status = 'Rejected';
                }
            }
            elseif($leave->hod_status == null){
                if($request->has('Approve')){
                    $leave->hof_status = 'Approved';
                }else{
                    $leave->hof_status = 'Rejected';
                }
            }
            elseif($leave->hod_status == "Pending"){
                return redirect()->route('HOFLeave.index')->with('error',"You Can not Approve or Reject this Leave Request Because Head of Department Action is Pending!");
            }
            else{
                return redirect()->route('HOFLeave.index')->with('error',"You Can not Approve this Leave Request Because Head of Department Reject This Leave Request");
            }
        }elseif(Auth::user()->role == "Employee"){
            return redirect()->route('LeaveBalanceview')->with('error',"You Can not Approve this Leave Request Because You Are Employee");
        }else{
            return redirect()->route('LeaveBalanceview')
            ->with('error',"Something Went Wrong");
        }
        // dd($leave);
        // dd(Auth::user());
        $leave->update();
        if(Auth::user()->role == "HOD"){
            return redirect()->route('HODLeave.index')
                        ->with('success','Leave Request updated successfully');
        }
        elseif(Auth::user()->role == "HOF"){
            return redirect()->route('HOFLeave.index')
                        ->with('success','Leave Request updated successfully');
        }
        elseif(Auth::user()->role == "HOU"){
            return redirect()->route('HOULeave.index')
                        ->with('success','Leave Request updated successfully');
        }else{
            return redirect()->route('LeaveBalanceview')
                        ->with('success','Leave Request updated successfully');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\Employee;
use App\Models\Department;
use App\Models\FacultyDirectorate;
use App\Models\Unit;
use App\Models\User;
use App\Models\OfficialInfo;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use DB;
use DateTime;
use App\Models\Notification;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $leaves = DB::table('leaves')
            ->join('employees', 'leaves.employee_id', '=', 'employees.id')
            ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
            ->where('employees.institution_id', '=', Auth::user()->id)
            ->select('leaves.*','employees.fname','employees.mname','employees.lname','leavetypes.name')
            ->get();
        return view('leave.index',compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $departments = Department::where('user_id','=',Auth::user()->id)->get();

        $data['facultydirectorates'] = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();

        $emp_detail = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();

        $leavetypes = Leavetype::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('leave.add',$data,compact('emp_detail','departments','leavetypes'));
    }

    public function fetchDepart(Request $request)
    {
        $data['depart'] = Department::where('faculty_id', $request->faculty_id)
                                ->get();
  
        return response()->json($data);
    }

    public function fetchUnit(Request $request)
    {
        $data['units'] = Unit::where('department_id', $request->department_id)
                                    ->get();
                                      
        return response()->json($data);
    }
    
    public function fetchEmp(Request $request)
    {
        // dd($request);
        $data['emp'] = DB::table('official_infos')
        ->where('official_infos.user_id','=',Auth::user()->id)
        ->where('official_infos.unit',$request->unit_id)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->get(['official_infos.role','employees.id','employees.fname','employees.mname','employees.lname']);
        return response()->json($data);
    }

    public function fetchEmployee(Request $request)
    {
        // dd($request);
        $data['department_employee'] = DB::table('official_infos')
        ->where('official_infos.user_id','=',Auth::user()->id)
        ->where('official_infos.department',$request->department_id)
        ->join('employees','employees.id','=','official_infos.employee_id')
        ->get(['official_infos.role','employees.id','employees.fname','employees.mname','employees.lname']);
        return response()->json($data);
    }

    public function fetchLeaveType(Request $request)
    {
        $names=Leavetype::all();
        $data['Leavetypename'] = $names;
        // dd($request);
        $daem= DB::table('employees')
        ->where('employees.id',$request->employee_id)->first();
        // dd($daem);
        $check=$daem->leavetype_id;
        $leaveId = explode(',', $check);

        $data['result'] = DB::table('users')
            ->where('users.id','=',$daem->user_id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->first();
            $data['date'] = Carbon::now()->format('Y');
            $data['Previous_year'] = Carbon::now()->subYear(1)->format('Y');
            $data['ok'] = Carbon::now()->format('Y/m/d');
            $data['fis_b']=DB::table('users')
            ->where('users.id','=',$daem->user_id)
            ->select('users.created_at')
            ->first();
            
            // $data['date'] = Carbon::now()->addYear()->format('Y');
            // $data['Previous_year'] = Carbon::now()->format('Y');
            

            $period_x = CarbonPeriod::create(
                now()->month(4)->startOfMonth()->format('d-m-Y'),
                '1 month',
                now()->month(3)->addMonths(12)->format('d-m-Y')
            );
            $finYear_x = [];
            foreach ($period_x as $px) {
                $finYear_x[] = $px->format('d-m-Y');
            }
            
            $st_x=$finYear_x[0];
            $en_x=$finYear_x[11];
            $try_en_x=Carbon::parse($en_x)->endOfMonth()->toDateString();
            $try_st_x=Carbon::parse($st_x)->startOfMonth()->toDateString();
            
            $try_st_new_x = Carbon::createFromFormat('Y-m-d', $try_st_x)->format('Y/m/d');
            $try_en_new_x = Carbon::createFromFormat('Y-m-d', $try_en_x)->format('Y/m/d');
            

            $data['Try_New_x'] =Carbon::parse($try_st_new_x);
            $data['Try_New_end_x'] =Carbon::parse($try_en_new_x);
            
        foreach ($leaveId as $leaveIds) {
            $data['leave_type'] = DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
         }

         $leaveUseDays=DB::table('leaves')
         ->select(['leaves.*'])
         ->where('leaves.employee_id', $daem->id)
         ->whereIn('leaves.status',array('Pending','Approved'))
         ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
         ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
         ->get()
         ->each(function($query){
            $query->start_date = explode(",", $query->start_date);
            $query->end_date = explode(",", $query->end_date);
        });

        foreach ($names as $name) {
            $data['PreviousCount'][$name->name] = 0;
        }

        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                if($check_date == $data['Previous_year'] && $check_enddate == $data['Previous_year']){
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['PreviousCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['PreviousCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['PreviousCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['PreviousCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['PreviousCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['PreviousCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['PreviousCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['PreviousCount'][$apps->name] += $IntiDiff;
                    }
                }elseif($apps -> leave_cycle == "Fiscal Year"){
                    $period = CarbonPeriod::create(
                        now()->subMonths(12)->month(4)->startOfMonth()->format('Y-m-d'),
                        '1 month',
                        now()->month(3)->format('Y-m-d')
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
                            $data['PreviousCount'][$apps->name] += $diffren;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                            $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                            $data['PreviousCount'][$apps->name] += $diffre;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                            $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                            $data['PreviousCount'][$apps->name] += $diffr;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                            $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                            $data['PreviousCount'][$apps->name] += $diff;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                            $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                            $data['PreviousCount'][$apps->name] += $dif;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                            $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                            $data['PreviousCount'][$apps->name] += $di;
                        }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                            $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                            $data['PreviousCount'][$apps->name] += $diffrent;
                        }
                        elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $IntiDiff=count($apps->start_date);
                            $data['PreviousCount'][$apps->name] += $IntiDiff;
                        }
                    }
                }
            }
     }

if($data['result']->year == $data['date']){
    $leaveUseDays=DB::table('leaves')
         ->select(['leaves.*'])
         ->where('leaves.employee_id', $daem->id)
         ->whereIn('leaves.status',array('Pending','Approved'))
         ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
         ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
         ->get()
         ->each(function($query){
            $query->start_date = explode(",", $query->start_date);
            $query->end_date = explode(",", $query->end_date);
        });
        
         foreach ($names as $name) {
            $data['LeavetypeNameCount'][$name->name] = 0;
        }
        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                if($check_date == $data['date'] && $check_enddate == $data['date']){
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
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
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
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
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
                    }
                }
            }
         }
    }else{
        $leaveUseDays=DB::table('leaves')
         ->select(['leaves.*'])
         ->where('leaves.employee_id', $daem->id)
         ->whereIn('leaves.status',array('Pending','Approved'))
         ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
         ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
         ->get()
         ->each(function($query){
            $query->start_date = explode(",", $query->start_date);
            $query->end_date = explode(",", $query->end_date);
        });

        foreach ($names as $name) {
            $data['LeavetypeNameCount'][$name->name] = 0;
        }

        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                if($check_date == $data['date'] && $check_enddate == $data['date']){
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
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
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
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
                        $data['LeavetypeNameCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['LeavetypeNameCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['LeavetypeNameCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['LeavetypeNameCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['LeavetypeNameCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['LeavetypeNameCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['LeavetypeNameCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $IntiDiff=count($apps->start_date);
                        $data['LeavetypeNameCount'][$apps->name] += $IntiDiff;
                    }
                }
            }
     }
    }
        return response()->json($data);
    }


    public function fetchCountData(Request $request)
    {  
        $names=Leavetype::all();
        $data['name'] = $names;

        $data['LeCy'] = Leavetype::where('id', '=', $request->leAve_id)->first();

        $daem= DB::table('employees')
        ->where('employees.id',$request->employee_id)->first();
        
        $check=$daem->leavetype_id;
        $leaveId = explode(',', $check);

        $data['CountResult'] = DB::table('users')
            ->where('users.id','=',$daem->user_id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->first();
            // $data['CountDate'] = Carbon::now()->addYear()->format('Y');
            $data['CountDate'] = Carbon::now()->format('Y');
            $data['Count_Previous_year'] = Carbon::now()->subYear(1)->format('Y');
            // $data['Count_Previous_year'] = Carbon::now()->format('Y');
            $data['Countok'] = Carbon::now()->format('Y/m/d');
            $data['Countfis_b']=DB::table('users')
            ->where('users.id','=',$daem->user_id)
            ->select('users.created_at')
            ->first();
            
            // $data['date'] = Carbon::now()->addYear()->format('Y');
            // $data['Previous_year'] = Carbon::now()->format('Y');
            

            $period_x = CarbonPeriod::create(
                now()->month(4)->startOfMonth()->format('Y-m-d'),
                '1 month',
                now()->month(3)->addMonths(12)->format('Y-m-d')
            );
            $finYear_x = [];
            foreach ($period_x as $px) {
                $finYear_x[] = $px->format('Y/m/d');
            }
            
            $st_x=$finYear_x[0];
            $en_x=$finYear_x[11];
            $try_en_x=Carbon::parse($en_x)->endOfMonth()->toDateString();
            $try_st_x=Carbon::parse($st_x)->startOfMonth()->toDateString();
            
            $try_st_new_x = Carbon::createFromFormat('Y-m-d', $try_st_x)->format('Y/m/d');
            $try_en_new_x = Carbon::createFromFormat('Y-m-d', $try_en_x)->format('Y/m/d');
            

            $data['CountTry_New_x'] =Carbon::parse($try_st_new_x);
            $data['CountTry_New_end_x'] =Carbon::parse($try_en_new_x);
        
        foreach ($leaveId as $leaveIds) {
            $data['leaveTypeCount'] = DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
         }
         $leaveUseDays=DB::table('leaves')
         ->select(['leaves.*'])
         ->where('leaves.employee_id', $daem->id)
         ->whereIn('leaves.status',array('Pending','Approved'))
         ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
         ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
         ->get()
         ->each(function($query){
             $query->start_date = explode(",", $query->start_date);
             $query->end_date = explode(",", $query->end_date);
         });
         foreach ($names as $name) {
            $data['PreviousleaveCount'][$name->name] = 0;
        }

        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                    $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                    $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                    if($check_date == $data['Count_Previous_year'] && $check_enddate == $data['Count_Previous_year']){
                    if($apps->leave_days == "half"){
                        $diffren=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                        $data['PreviousleaveCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['PreviousleaveCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['PreviousleaveCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['PreviousleaveCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['PreviousleaveCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['PreviousleaveCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['PreviousleaveCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $InterDiff=count($apps->start_date);
                        $data['PreviousleaveCount'][$apps->name] += $InterDiff;
                    }
                }
            }elseif($apps -> leave_cycle == "Fiscal Year"){
                $period = CarbonPeriod::create(
                    now()->subMonths(12)->month(4)->startOfMonth()->format('Y-m-d'),
                    '1 month',
                    now()->month(3)->format('Y-m-d')
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
                        $data['PreviousleaveCount'][$apps->name] += $diffren;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                        $diffre=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                        $data['PreviousleaveCount'][$apps->name] += $diffre;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                        $diffr=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                        $data['PreviousleaveCount'][$apps->name] += $diffr;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                        $diff=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                        $data['PreviousleaveCount'][$apps->name] += $diff;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                        $dif=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                        $data['PreviousleaveCount'][$apps->name] += $dif;
                    }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                        $di=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                        $data['PreviousleaveCount'][$apps->name] += $di;
                    }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                        $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                        $data['PreviousleaveCount'][$apps->name] += $diffrent;
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $InterDiff=count($apps->start_date);
                        $data['PreviousleaveCount'][$apps->name] += $InterDiff;
                    }
                }
            }
            
        }

         if($data['CountResult']->year == $data['CountDate']){
            $leaveUseDays=DB::table('leaves')
                ->select(['leaves.*'])
                ->where('leaves.employee_id', $daem->id)
                ->whereIn('leaves.status',array('Pending','Approved'))
                ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
                ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
                ->get()
                ->each(function($query){
                    $query->start_date = explode(",", $query->start_date);
                    $query->end_date = explode(",", $query->end_date);
                });
            foreach ($names as $name) {
                $data['leaveCount'][$name->name] = 0;
            }
        foreach ($leaveUseDays as $apps) {
            if($apps -> leave_cycle == "Anniversary Year"){
                $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                if($check_date == $data['CountDate'] && $check_enddate == $data['CountDate']){
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
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $InterDiff=count($apps->start_date);
                        $data['leaveCount'][$apps->name] += $InterDiff;
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
                        }
                        elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $InterDiff=count($apps->start_date);
                            $data['leaveCount'][$apps->name] += $InterDiff;
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
                        }
                        elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $InterDiff=count($apps->start_date);
                            $data['leaveCount'][$apps->name] += $InterDiff;
                        }
                    }
                }
            }
            
         }else{
            $leaveUseDays=DB::table('leaves')
                ->select(['leaves.*'])
                ->where('leaves.employee_id', $daem->id)
                ->whereIn('leaves.status',array('Pending','Approved'))
                ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
                ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
                ->get()
                ->each(function($query){
                    $query->start_date = explode(",", $query->start_date);
                    $query->end_date = explode(",", $query->end_date);
                });
            foreach ($names as $name) {
                $data['leaveCount'][$name->name] = 0;
            }
            foreach ($leaveUseDays as $apps) {
                if($apps -> leave_cycle == "Anniversary Year"){
                    $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                    $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                    if($check_date == $data['CountDate'] && $check_enddate == $data['CountDate']){
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
                    }
                    elseif($apps->leave_days == "intermittent"){
                        // $dateex = explode(',',$apps->start_date);
                        $InterDiff=count($apps->start_date);
                        $data['leaveCount'][$apps->name] += $InterDiff;
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
                        }
                        elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $InterDiff=count($apps->start_date);
                            $data['leaveCount'][$apps->name] += $InterDiff;
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
                        }
                        elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $InterDiff=count($apps->start_date);
                            $data['leaveCount'][$apps->name] += $InterDiff;
                        }
                    }
                }
            }
         }
         
        //  dd($data);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'leavetype_id' => 'required',
            'leave_days' => 'required',
            'reason' => 'required',
        ]);
        $leavemaxallowdays=Leavetype::where('id',$request->leavetype_id)->first('max_allow_days');
        $leaveDate=Leave::where('employee_id',$request->employee_id)->get(['start_date','end_date']);

        $InterLeave=Leave::where('employee_id',$request->employee_id)->whereIn('status',array('Pending','Approved'))->where('leave_days',"intermittent")->get(['start_date','end_date']);
        // dd($InterLeave);
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
    // dd($cols);
        $remaning=$request->count_data;
        $dur=$request->duration;
        $storedate=implode(',',$request->get('start_dates'));
        // dd($request->all());
        $leave = new Leave();
        $leave->employee_id = $request['employee_id'];
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
                                                return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }else{
                                            return redirect()->route('leave.index')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                        }
                                    }
                                }else{
                                    if($remaning >= $dur){
                                        $leave->start_date =date($request['start_date']);
                                        $leave->end_date = date($request['start_date']);
                                    }else{
                                        return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                    }
                                }
                            }else{
                                if($remaning >= $dur){
                                    $leave->start_date =date($request['start_date']);
                                    $leave->end_date = date($request['start_date']);
                                }else{
                                    return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                }
                            }
                        }elseif($leave->leave_days == "intermittent"){
                            $ex=explode(',',$storedate);
                            foreach($ex as $exs){
                                if((date('d-m-Y', strtotime($leavedates->start_date))) != $exs && (date('d-m-Y', strtotime($leavedates->end_date))) != $exs && (date('d-m-Y', strtotime($leavedates->start_date))) != $exs && (date('d-m-Y', strtotime($leavedates->end_date))) != $exs){
                                    if(isset($col)){
                                        if($col->isNotEmpty()){
                                            foreach($col as $cols){
                                               if($cols != $exs){
                                                if($remaning >= $dur){
                                                    $leave->start_date = date($storedate);
                                                    $leave->end_date = date($storedate);
                                                }else{
                                                    return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                                }
                                               }else{
                                                return redirect()->route('leave.index')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                               }
                                            }
                                        }else{
                                            if($remaning >= $dur){
                                                $leave->start_date = date($storedate);
                                                $leave->end_date = date($storedate);
                                            }else{
                                                return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }
                                    }else{
                                        if($remaning >= $dur){
                                            $leave->start_date = date($storedate);
                                            $leave->end_date = date($storedate);
                                        }else{
                                            return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                        }
                                    }
                                }else{
                                    return redirect()->route('leave.index')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                }
                            }
                        }
                        else{
                            if(isset($col)){
                                if($col->isNotEmpty()){
                                    foreach($col as $cols){
                                        if($cols != $request->start_date && $cols != $request->end_date){
                                            if($remaning >= $dur){
                                                $leave->start_date =date($request['start_date']);
                                                $leave->end_date = date($request['end_date']);
                                            }else{
                                                return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                            }
                                        }else{
                                            return redirect()->route('leave.index')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                                        }
                                    }
                                }else{
                                    if($remaning >= $dur){
                                        $leave->start_date =date($request['start_date']);
                                        $leave->end_date = date($request['end_date']);
                                    }else{
                                        return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                    }
                                }     
                            }else{
                                if($remaning >= $dur){
                                    $leave->start_date =date($request['start_date']);
                                    $leave->end_date = date($request['end_date']);
                                }else{
                                    return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                                }
                            }
                        }
                    }else{
                        return redirect()->route('leave.index')->with('error',"You have an Existing Leave Application/Approval on the Selected Days");
                    }
                }else{
                    return redirect()->route('leave.index')->with('error',"You can not apply to leave More than Max allow Days... Your Max Allow Days is $leavemaxallowdays->max_allow_days");
                }
            }
        }else{
            if($leavemaxallowdays->max_allow_days >= $dur){
                    if($leave->leave_days == "half" || $leave->leave_days == "hourly" || $leave->leave_days == "full"){
                        if($remaning >= $dur){
                            $leave->start_date =date($request['start_date']);
                            $leave->end_date = date($request['start_date']);
                        }else{
                            return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
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
                            return redirect()->route('leave.index')->with('error',"You Can Not Apply Leave More Than Remaning Leaves");
                        }
                    }
            }else{
                return redirect()->route('leave.index')->with('error',"You can not apply to leave More than Max allow Days... Your Max Allow Days is $leavemaxallowdays->max_allow_days");
            }
        }
        $leave->reason = $request['reason']; 
        if($leave->reason == "Other"){
            $leave->other_reason = $request['other_reason'];
        }else{
            $leave['other_reason'] = null;
        }
        $employee_id = Employee::where('id', '=', $request->input('employee_id'))->first();
        $employeeId = OfficialInfo::where('employee_id', '=', $employee_id->id)->first();
        
        if($employeeId->role == "Employee" && $employeeId->unit == null){
            $leave->status = "Pending";
            $leave->hou_status = 0;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
        }elseif($employeeId->role == "Employee" && $employeeId->unit != null){
            $leave->status = "Pending";
            $leave->hou_status = "Pending";
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
        }
        elseif($employeeId->role == "HOU" && $employeeId->unit == null){
            $leave->status = "Pending";
            $leave->hou_status = 0;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
        }
        elseif($employeeId->role == "HOU" && $employeeId->unit != null){
            $leave->status = "Pending";
            $leave->hou_status = null;
            $leave->hod_status = "Pending";
            $leave->hof_status = "Pending";
        }
        elseif($employeeId->role == "HOD" && $employeeId->unit == null){
            $leave->status = "Pending";
            $leave->hou_status = 0;
            $leave->hod_status = null;
            $leave->hof_status = "Pending";
        }
        elseif($employeeId->role == "HOD" && $employeeId->unit != null){
            $leave->status = "Pending";
            $leave->hou_status = null;
            $leave->hod_status = null;
            $leave->hof_status = "Pending";
        }
        elseif($employeeId->role == "HOF" && $employeeId->unit == null){
            $leave->status = "Pending";
            $leave->hou_status = 0;
            $leave->hod_status = null;
            $leave->hof_status = null;
        }
        elseif($employeeId->role == "HOF" && $employeeId->unit != null){
            $leave->status = "Pending";
            $leave->hou_status = null;
            $leave->hod_status = null;
            $leave->hof_status = null;
        }
        // dd($leave);
        // dd($leave);
        $leave->save();

        if($leave)
            return redirect()->route('leave.index')->with('success',"Leave Request Submit Successfully.");
        else
            return redirect()->route('leave.index')->with('error',"Error In Adding Leave Request.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd(Auth::user()->role);
        // $data = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->first();
        $leavetypes = Leavetype::get();
        $leave = Leave::find($id);
        $leaveID=$leave->leavetype_id;
        $data = Employee::where('institution_id', '=', Auth::user()->id)->where('id',$leave->employee_id)->first();
        $type=DB::table('leavetypes')
        ->select(['leavetypes.*'])
        ->where('leavetypes.id',$leaveID)
        ->first();
        
        return view('leave.edit',compact('leave','leavetypes','data','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $leave = Leave::find($id);
        if($leave->hof_status == "Approved"){
            if($request->has('Approve')){
                $leave->status = 'Approved';
            }else{
                $leave->status = 'Rejected';
            }
        }
        elseif($leave->hof_status == null){
            if($request->has('Approve')){
                $leave->status = 'Approved';
            }else{
                $leave->status = 'Rejected';
            }
        }
        elseif($leave->hof_status == "Rejected"){
            if($request->has('Reject')){
                $leave->status = 'Rejected';
            }
        }
        elseif($leave->hof_status == "Pending"){
            return redirect()->route('leave.index')->with('error',"You Can not Approve or Reject this Leave Request Because Head of Faculty Action is Pending!");
        }
        else{
            return redirect()->route('leave.index')->with('error',"You Can not Approve this Leave Request Because Head of Faculty Reject This Leave Request");
        }
        
        // if($request->has('Approve')){
        //     $leave->status = 'Approve';
        // }else{
        //     $leave->status = 'Reject';
        // }
        // dd($leave);
        $leave->update();
        $emp = Employee::where('id', $leave->employee_id)->first();
        $visible_users = User::where('id',$emp->user_id)->pluck('id')->first();
        $inst = User::where('id',$emp->user_id)->first();

        $other_users = User::where('institutionname',$emp->institutionname)->pluck('id')->toArray();

        $strt = explode('-',$leave->start_date);
        $end = explode('-',$leave->end_date);

        $notifications = new Notification();

        $leavetype = Leavetype::where('id', $leave->leavetype_id)->first();

        $notifications->create( [ 'notifiable_id' => $id, 'notifiable_type' => 'Leave', 'user_id' => Auth::user()->id, 'message' => $emp->fname.' '.$emp->lname.' your Leave '.$leavetype->name.' Request between Start '.$leave->start_date.' and End '.$leave->start_date.' has been Approved', 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $visible_users ] );

        foreach ($other_users as  $key => $value){
            if($value == $visible_users){
                continue;
            }
            $notifications->create( [ 'notifiable_id' => $id, 'notifiable_type' => 'Leave', 'user_id' => Auth::user()->id, 'message' => $emp->fname.' '.$emp->lname.'`s Leave '.$leavetype->name.' Request between Start '.$leave->start_date.' and End '.$leave->start_date.' has been Approved', 'role' => 'HOD', 'is_read' => '0', 'visible_users' => $value ] );
        }



        return redirect()->route('leave.index')
                        ->with('success','Leave Request updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave=Leave::find($id);
        $leave->delete();
    
        return redirect()->route('leave.index')
                        ->with('success','Leave Request deleted successfully');
    }
    public function export_pdf(Request $request){
        $leaves = DB::table('leaves')
        ->join('employees', 'leaves.employee_id', '=', 'employees.id')
        ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
        ->where('employees.institution_id', '=', Auth::user()->id)
        ->select('leaves.*','employees.fname','employees.mname','employees.lname','leavetypes.name')
        ->get();
        $html = '';
        $html = '<div class="content">
        <div class="col-12">
        <div class="card">
                <div class="card-body">
            <center><h3 style="padding-bottom: 20px;">Employee Leave Details</h3></center>
            <table style="border-collapse: collapse; width: 100%;">
                <thead style="padding-top:30px;">
                    <tr>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Sr.No</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Employee Name</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Leave Type</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Leave Days</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Start Date</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">End Date</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Reason For Leave</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Head of Unit Status</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Head of Department Status</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Head of Faculty Status</th>
                        <th style="background-color: #000; color: white;padding-right: 10px;text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($leaves as $key => $val) {
    $offcial = OfficialInfo::where('employee_id', $val->employee_id)->first();

    $html .= '<tr ' . ($key == 4 ? 'style="padding-top:20px;"' : '') . '>
                <td style="padding-right: 10px;text-align: center;">' . ($key + 1) . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->fname . ' ' . $val->mname . ' ' . $val->lname . '</td>
                <td style="padding-right: 10px;text-align: center;">' . $val->name . '</td>';

    if ($val->leave_days == 'half') {
        $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->leave_days . ' Leave in ' . $val->half_leave . '</td>';
    } elseif ($val->leave_days == 'hourly') {
        $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->leave_days . ' Leave in ' . $val->hourly_hours . '</td>';
    } else {
        $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->leave_days . '</td>';
    }

    $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->start_date . '</td>
               <td style="padding-right: 10px;text-align: center;">' . $val->end_date . '</td>';

    if ($val->reason == 'Other') {
        $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->other_reason . '</td>';
    } else {
        $html .= '<td style="padding-right: 10px;text-align: center;">' . $val->reason . '</td>';
    }

    $status = '';
    if ($val->hou_status !== null && $val->hou_status !== 0) {
        $status = $val->hou_status;
    } elseif ($val->hou_status === null && $offcial->role !== 'HOU') {
        $status = 'I Am Not Authorized to Accept this Leave Request';
    } elseif ($val->hou_status === null && $offcial->role === 'HOU') {
        $status = 'I Can\'t Accept this Leave Request Because It\'s Mine';
    } else {
        $status = 'Head Of Unit Does Not Exist';
    }

    $status1 = '';
    if ($val->hod_status !== null) {
        $status1 = $val->hod_status;
    } elseif ($val->hod_status === null && $offcial->role === 'HOD') {
        $status1 = 'I Can\'t Accept this Leave Request Because It\'s Mine';
    } else {
        $status1 = 'I Am Not Authorized to Accept this Leave Request';
    }

    $status2 = '';
    if ($val->hof_status !== null) {
        $status2 = $val->hof_status;
    } elseif ($val->hof_status === null && $offcial->role === 'HOF') {
        $status2 = 'I Can\'t Accept this Leave Request Because It\'s Mine';
    } else {
        $status2 = 'I Am Not Authorized to Accept this Leave Request';
    }

    $html .= '<td style="padding-right: 10px;text-align: center;">' . $status . '</td>
               <td style="padding-right: 10px;text-align: center;">' . $status1 . '</td>
               <td style="padding-right: 10px;text-align: center;">' . $status2 . '</td>
               <td style="padding-right: 10px;text-align: center;">' . $val->status . '</td>
            </tr>';
}

$html .= '</tbody>
           </table>
        </div></div></div>';
        echo $html; 
    }
}

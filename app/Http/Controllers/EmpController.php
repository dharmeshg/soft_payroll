<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leavetype;
use App\Models\Leave;
use App\Models\User;
use App\Models\InstitutePermission;
use App\Models\Transfer;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use DateTime;


class EmpController extends Controller
{  
    public function index()
    {
        $notifications = Notification::where('visible_users','=',Auth::user()->id)->where('is_read','=',0)->limit(5)->get();
        // dd($notifications);
        // $notificationcounts = Notification::where('visible_users','=',Auth::user()->id)->count();
        return view('emp_dashboard/employeehome');
    }

    public function LeaveBalanceView()
    {
        // $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();

        // $lastDayofPreviousMonth = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        
        // dd(date('Y-m-d H:i:s'));
        $names=Leavetype::all();
        $data['name'] = $names;

        $user_id = Auth::user()->id;
        $leave=DB::table('employees')
        ->select(['employees.*'])
        ->where('employees.user_id', $user_id)
        ->first();
        // dd($user_id);
        $check=$leave->leavetype_id;
        $leaveId = explode(',', $check);

        $results = DB::table('users')
            ->where('users.id','=',$user_id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->first();
            $date = Carbon::now()->format('Y');
        foreach ($leaveId as $leaveIds) {
            $leaveType = DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
         }
                if($results->year == $date){
                    $leaveUseDays=DB::table('leaves')
                        ->select(['leaves.*'])
                        ->where('leaves.employee_id', $leave->id)
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
                        
                        if($check_date == $date && $check_enddate == $date){
                           
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
                                // dd("hi");
                                $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                                $data['leaveCount'][$apps->name] += $diffrent;
                            }elseif($apps->leave_days == "intermittent"){
                                // $dateex = explode(',',$apps->start_date);
                                $din=count($apps->start_date);
                                $data['leaveCount'][$apps->name] += $din;
                            }
                        }
                        }elseif($apps -> leave_cycle == "Other"){
                            $from_date = Carbon::createFromFormat('d-m-Y',  $apps -> from_date)->format('Y/m/d');
                            $to_date = Carbon::createFromFormat('d-m-Y',  $apps -> to_date)->format('Y/m/d');
                            $Try_from_date =Carbon::parse($from_date);
                            $Try_to_date =Carbon::parse($to_date);
                            // dd($Try_from_date);
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
                                    $IntiDiff=count($apps->start_date);
                                    $data['leaveCount'][$apps->name] += $IntiDiff;
                                }
                            }
                        }elseif($apps -> leave_cycle == "Fiscal Year"){
                            $period = CarbonPeriod::create(
                                now()->month(4)->startOfMonth()->format('d-m-Y'),
                                '1 month',
                                now()->month(3)->addMonths(12)->format('d-m-Y')
                            );
                            $finYear = [];
                            foreach ($period as $p) {
                                $finYear[] = $p->format('d-m-Y');
                            }
                            // dd($finYear);
                            $st=$finYear[0];
                            $en=$finYear[11];
                            $try_en=Carbon::parse($en)->endOfMonth()->toDateString();
                            $try_st=Carbon::parse($st)->startOfMonth()->toDateString();
                            // dd($try_st);
                            // dd($try_en);
                            $try_st_new = Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                            $try_en_new = Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');
                            // dd($try_st_new);
                            // dd($try_en_new);

                            $Try_New =Carbon::parse($try_st_new);
                            $Try_New_end =Carbon::parse($try_en_new);

                            // dd($Try_New);
                            // dd($Try_New_end);

                            $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                            $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');

                            $Try_check_date =Carbon::parse($check_date);
                            $Try_check_enddate =Carbon::parse($check_enddate);

                            // dd($Try_check_date);
                            // dd($Try_check_enddate);

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
                                    $IntiDiff=count($apps->start_date);
                                    $data['leaveCount'][$apps->name] += $IntiDiff;
                                }
                            }
                        }
                     }
                 }else{
                    $leaveUseDays=DB::table('leaves')
                        ->select(['leaves.*'])
                        ->where('leaves.employee_id', $leave->id)
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
                        
                        if($check_date == $date && $check_enddate == $date){
                           
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
                                // dd("hi");
                                $diffrent=Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                                $data['leaveCount'][$apps->name] += $diffrent;
                            }elseif($apps->leave_days == "intermittent"){
                                // $dateex = explode(',',$apps->start_date);
                                $din=count($apps->start_date);
                                $data['leaveCount'][$apps->name] += $din;
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
                                    $IntiDiff=count($apps->start_date);
                                    $data['leaveCount'][$apps->name] += $IntiDiff;
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
                            // dd($try_st);
                            // dd($try_en);
                            $try_st_new = Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                            $try_en_new = Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');
                            // dd($try_st_new);
                            // dd($try_en_new);

                            $Try_New =Carbon::parse($try_st_new);
                            $Try_New_end =Carbon::parse($try_en_new);

                            // dd($Try_New);
                            // dd($Try_New_end);

                            $check_date = Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                            $check_enddate = Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');

                            $Try_check_date =Carbon::parse($check_date);
                            $Try_check_enddate =Carbon::parse($check_enddate);

                            // dd($Try_check_date);
                            // dd($Try_check_enddate);

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
                                    $IntiDiff=count($apps->start_date);
                                    $data['leaveCount'][$apps->name] += $IntiDiff;
                                }
                            }
                        }
                     }
                 }
        $history=DB::table('leaves')
        ->select(['leaves.*'])
        ->where('leaves.employee_id', $leave->id)
        ->join('leavetypes', 'leavetypes.id', '=', 'leaves.leavetype_id')
        ->addSelect('leavetypes.name','leavetypes.leave_cycle','leavetypes.from_date','leavetypes.to_date')
        ->get();
        return view('emp_dashboard/leaveBalance',$data,compact('leaveType','leaveUseDays','history'));
    }

    public function readAllNotification( Request $request ) {
        // $data = $request->all();
        // dd($data);
        $data = Notification::all();
        foreach($data as $temp)
        if( !empty( $temp['visible_users'] ) ) :
            $notification = Notification::where('visible_users','=',Auth::user()->id )->update( ['is_read' => '1' ] );
    	    $notification = Notification::where('visible_users','=',Auth::user()->id )->get();
        //  dd($notification);
         return view('emp_dashboard/employeehome', compact('notification'));
        endif;
        // $data = $request->all();
        // if( !empty( $data['isIds'] ) ) :
        //     $notifications = Notifications::where( 'id', $data['isIds'] )->update( ['is_read' => '1' ] );
        // endif;
    }

    public function destroy($id)
    {
        $leave=Leave::find($id);
        $leave->delete();
    
        return redirect()->route('LeaveBalanceview')
                        ->with('success','Leave Request deleted successfully');
    }

    public function employeeprofile(Request $request){
       // $employee = Employee::where('institution_id', '=', Auth::user()->id)->get();
        $user_id = Auth::user()->id;
        $employee=DB::table('employees')
        ->select(['employees.*'])
        ->where('employees.user_id', $user_id)
        ->first();
        return view('emp_dashboard/profile',compact('employee'));
    }

    public function employeeprofileupdate(Request $request){
      
        $id=$request->id;

        $Employee=Employee::find($id);
        $Employee->title = $request['title'];
        $Employee->fname = $request['fname'];
        $Employee->mname = $request['mname'];
        $Employee->lname = $request['lname'];
        $Employee->maidenname = $request['maidenname'];

        $old_email = $Employee->employeeemail;
        $Employee->employeeemail = $request['employeeemail'];
        
        // $Employee->sex   = $request['sex'];
    
        // $Employee->phoneno = $request['phoneno'];
        
        $Employee->formername = $request['formername'];
       
       
       $result=$Employee->save();
       
    
        if ($result)
            return redirect()->route('emp_dashboard.profile')->with('success', "Employee Update Successfully");
        else
            return redirect()->route('emp_dashboard.profile')->with('error', "Error In Updating Employee");
    }

}

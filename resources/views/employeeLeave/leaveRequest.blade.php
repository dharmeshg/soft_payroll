<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')
<style type="text/css">
   .form-check .form-check-label {
    font-size: 15px;
}
.radio_parsley .parsley-required{position: relative; top: 18px; right: 90px; padding-bottom: 14px; padding-top: 3px; white-space: nowrap;}
</style>

<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Leave Request</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                 <!--  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol> -->
                </nav>
              </div>
            </div>
          </div>
        </div>
     
        <div class="container-fluid">
          <div class="card">
            <div class="card-body wizard-content">
              <h4 class="card-title">Add Leave Request</h4>
             
              <form id="example-form" action="{{ route('Employee.leave.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_name">Employee Name*</label>
                      
                      <input
                        id="employee_id"
                        name="employee_id"
                        type="text"
                        class="required form-control"
                        value=""
                        placeholder="{{$employeeData->fname}}{{$employeeData->mname}}{{$employeeData->lname}}"
                        disabled
                      />
                    </div>
                    <?php 
                       $PreName=App\Models\Leavetype::all();
                       $data['PreviousName'] = $PreName;
                           $usEr = \Auth::user()->id;
                           $leave=\DB::table('employees')
                          ->select(['employees.*'])
                          ->where('employees.user_id', $usEr)
                          ->first();

                          $check=$leave->leavetype_id;
                          $leaveId = explode(',', $check);
                              foreach ($leaveId as $leaveIds) {
                                  $LeaveAllType = \DB::table('leavetypes')->select(['leavetypes.*'])->whereIn('id', $leaveId)->get();
                              }
                           $results = \DB::table('users')
                           ->where('users.id','=',$usEr)
                           ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
                           ->first();
                           $date = Carbon\Carbon::now()->format('Y');
                           $ok = Carbon\Carbon::now();
                          //  dd($ok);
                          //  dd(\Auth::user()->created_at);
                          $fis_b=\Auth::user()->created_at;
                          //  dd($fis_b);
                          //  $date = Carbon\Carbon::now()->addYear()->format('Y');
                           $Previous_year = Carbon\Carbon::now()->subYear(1)->format('Y');
                          //  dd($Previous_year);
                          //  $newDateTime = Carbon\Carbon::now()->addYear()->format('Y');
                          //  dd($newDateTime);
                          $period_x = Carbon\CarbonPeriod::create(
                            now()->month(4)->startOfMonth()->format('Y-m-d'),
                            '1 month',
                            now()->month(3)->addMonths(12)->format('Y-m-d')
                        );
                        $finYear_x = [];
                        foreach ($period_x as $px) {
                            $finYear_x[] = $px->format('Y/m/d');
                        }
                        // dd($finYear_x);
                        $st_x=$finYear_x[0];
                        $en_x=$finYear_x[11];
                        $try_en_x=Carbon\Carbon::parse($en_x)->endOfMonth()->toDateString();
                        $try_st_x=Carbon\Carbon::parse($st_x)->startOfMonth()->toDateString();
                        // dd($try_st);
                        // dd($try_en);
                        $try_st_new_x = Carbon\Carbon::createFromFormat('Y-m-d', $try_st_x)->format('Y/m/d');
                        $try_en_new_x = Carbon\Carbon::createFromFormat('Y-m-d', $try_en_x)->format('Y/m/d');
                        // dd($try_st_new);
                        // dd($try_en_new);
  
                        $Try_New_x =Carbon\Carbon::parse($try_st_new_x);
                        $Try_New_end_x =Carbon\Carbon::parse($try_en_new_x);

                          $leaveUseDays=\DB::table('leaves')
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
                          // dd($leaveUseDays);
                      foreach ($PreName as $PreNames) {
                          $data['PreviousleaveCount'][$PreNames->name] = 0;
                      }
                      foreach ($leaveUseDays as $apps) {
                        // dd($apps);
                        if($apps -> leave_cycle == "Anniversary Year"){
                          $check_date = Carbon\Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y');
                          $check_enddate = Carbon\Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y');
                          if($check_date == $Previous_year && $check_enddate == $Previous_year){
                              if($apps->leave_days == "half"){
                                  $diffren=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                                  $data['PreviousleaveCount'][$apps->name] += $diffren;
                              }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                                  $diffre=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                                  $data['PreviousleaveCount'][$apps->name] += $diffre;
                              }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                                  $diffr=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                                  $data['PreviousleaveCount'][$apps->name] += $diffr;
                              }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                                  $diff=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                                  $data['PreviousleaveCount'][$apps->name] += $diff;
                              }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                                  $dif=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                                  $data['PreviousleaveCount'][$apps->name] += $dif;
                              }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                                  $di=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                                  $data['PreviousleaveCount'][$apps->name] += $di;
                              }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                                  $diffrent=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                                  $data['PreviousleaveCount'][$apps->name] += $diffrent;
                              }elseif($apps->leave_days == "intermittent"){
                                  // $dateex = explode(',',$apps->start_date);
                                  $diffrent=count($apps->start_date);
                                  $data['PreviousleaveCount'][$apps->name] += $diffrent;
                              }
                          }
                        }elseif($apps -> leave_cycle == "Fiscal Year"){
                          $period = Carbon\CarbonPeriod::create(
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
                        $try_en=Carbon\Carbon::parse($en)->endOfMonth()->toDateString();
                        $try_st=Carbon\Carbon::parse($st)->startOfMonth()->toDateString();


                        $try_st_new = Carbon\Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                        $try_en_new = Carbon\Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');

                        $Try_New =Carbon\Carbon::parse($try_st_new);
                        $Try_New_end =Carbon\Carbon::parse($try_en_new);

                        $check_date = Carbon\Carbon::createFromFormat('d-m-Y', $apps->start_date[0])->format('Y/m/d');
                        $check_enddate = Carbon\Carbon::createFromFormat('d-m-Y', $apps->end_date[0])->format('Y/m/d');

                        $Try_check_date =Carbon\Carbon::parse($check_date);
                        $Try_check_enddate =Carbon\Carbon::parse($check_enddate);

                        if($Try_check_date -> between($Try_New, $Try_New_end) && $Try_check_enddate -> between($Try_New, $Try_New_end)){
                          if($apps->leave_days == "half"){
                            $diffren=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.5;
                            $data['PreviousleaveCount'][$apps->name] += $diffren;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==1){
                            $diffre=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.125;
                            $data['PreviousleaveCount'][$apps->name] += $diffre;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==2){
                            $diffr=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.250;
                            $data['PreviousleaveCount'][$apps->name] += $diffr;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==3){
                            $diff=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.375;
                            $data['PreviousleaveCount'][$apps->name] += $diff;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==5){
                            $dif=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.625;
                            $data['PreviousleaveCount'][$apps->name] += $dif;
                        }elseif($apps->leave_days == "hourly" && $apps->hourly_hours==6){
                            $di=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+0.750;
                            $data['PreviousleaveCount'][$apps->name] += $di;
                        }elseif($apps->leave_days == "full" || $apps->leave_days == "multiple"){
                            $diffrent=Carbon\Carbon::parse($apps->end_date[0])->diffInDays($apps->start_date[0])+1;
                            $data['PreviousleaveCount'][$apps->name] += $diffrent;
                        }elseif($apps->leave_days == "intermittent"){
                            // $dateex = explode(',',$apps->start_date);
                            $diffrent=count($apps->start_date);
                            $data['PreviousleaveCount'][$apps->name] += $diffrent;
                        }
                        }
                        }
                     }
                  ?>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leavetype_id">Leave Type Select*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Leave Type" name="leavetype_id" id="leavetype_id" onchange="CountFetchData()">
                        <option></option>
                        @foreach($leaveType as $leaveTypes)
                        @if($leaveTypes->leave_cycle == "Anniversary Year")
                        @if($results->year == $date)
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} 
                          ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] }} Remaning days)
                        </option>
                        @else
                        @if($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 1)
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}} Remaning days)</option>
                        @elseif($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 0)
                        @if($leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name] < $leaveTypes->max_leave_carry_forword)
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}} Remaning days)</option>
                        @else
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->max_leave_carry_forword}} Remaning days)</option>
                        @endif
                        @else
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} 
                          ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] }} Remaning days)
                        </option>
                        @endif
                        @endif
                        @elseif($leaveTypes->leave_cycle == "Fiscal Year")
                        @if($fis_b -> between($Try_New_x, $Try_New_end_x))
                        
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} 
                          ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] }} Remaning days)
                        </option>
                        @else
                        @if($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 1)
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}} Remaning days)</option>
                        @elseif($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 0)
                        @if($leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name] < $leaveTypes->max_leave_carry_forword)
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days + $leaveTypes->max_leave_carry_forword - $data['PreviousleaveCount'][$leaveTypes->name]}} Remaning days)</option>
                        @else
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} ({{$leaveTypes->days + $leaveTypes->max_leave_carry_forword - $data['PreviousleaveCount'][$leaveTypes->name]}} Remaning days)</option>
                        @endif
                        @else
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} 
                          ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] }} Remaning days)
                        </option>
                        @endif
                        @endif
                        @elseif($leaveTypes->leave_cycle == "Other")
                        <?php
                        $from_date = Carbon\Carbon::createFromFormat('d-m-Y',  $leaveTypes -> from_date)->format('Y/m/d');
                        $to_date = Carbon\Carbon::createFromFormat('d-m-Y',  $leaveTypes -> to_date)->format('Y/m/d');
                        $Try_from_date =Carbon\Carbon::parse($from_date);
                        $Try_to_date =Carbon\Carbon::parse($to_date);
                         ?>
                         @if($ok -> between($Try_from_date,$Try_to_date))
                        <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->name}} 
                          ({{$leaveTypes->days - $leaveCount[$leaveTypes->name] }} Remaning days)
                        </option>
                        @else
                        <option hidden></option>
                        @endif
                        @endif
                        @endforeach
                      </select>
                    </div>
                    
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <select class="js-directorate" name="count_leavetype_id" id="count_leavetype_id" hidden>
                        <option></option>
                        @foreach($leaveType as $leaveTypes)
                        @if($leaveTypes->leave_cycle == "Anniversary Year")
                        @if($results->year == $date)
                        <option value="{{ $leaveTypes->id }}">
                          {{$leaveTypes->days - $leaveCount[$leaveTypes->name] }}
                        </option>
                        @else
                        @if($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 1)
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}} </option>
                        @elseif($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 0)
                        @if($leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name] < $leaveTypes->max_leave_carry_forword)
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}} </option>
                        @else
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->max_leave_carry_forword}} </option>
                        @endif
                        @else
                        <option value="{{ $leaveTypes->id }}">
                          {{$leaveTypes->days - $leaveCount[$leaveTypes->name] }}
                        </option>
                        @endif
                        @endif
                        @elseif($leaveTypes->leave_cycle == "Fiscal Year")
                        @if($fis_b -> between($Try_New_x, $Try_New_end_x))
                        <option value="{{ $leaveTypes->id }}"> 
                          {{$leaveTypes->days - $leaveCount[$leaveTypes->name] }}
                        </option>
                        @else
                        @if($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 1)
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}}</option>
                        @elseif($leaveTypes->carry_over_policy == 1 && $leaveTypes->all_remaning_leaves == 0)
                        @if($leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name] < $leaveTypes->max_leave_carry_forword)
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->days - $data['PreviousleaveCount'][$leaveTypes->name]}}</option>
                        @else
                        <option value="{{ $leaveTypes->id }}"> {{$leaveTypes->days - $leaveCount[$leaveTypes->name] + $leaveTypes->max_leave_carry_forword }}</option>
                        @endif
                        @else
                        <option value="{{ $leaveTypes->id }}"> 
                          {{$leaveTypes->days - $leaveCount[$leaveTypes->name] }}
                        </option>
                        @endif
                        @endif
                        @elseif($leaveTypes->leave_cycle == "Other")
                        <?php
                        $from_date = Carbon\Carbon::createFromFormat('d-m-Y',  $leaveTypes -> from_date)->format('Y/m/d');
                        $to_date = Carbon\Carbon::createFromFormat('d-m-Y',  $leaveTypes -> to_date)->format('Y/m/d');
                        $Try_from_date =Carbon\Carbon::parse($from_date);
                        $Try_to_date =Carbon\Carbon::parse($to_date);
                         ?>
                         @if($ok -> between($Try_from_date,$Try_to_date))
                        <option value="{{ $leaveTypes->id }}"> 
                          {{$leaveTypes->days - $leaveCount[$leaveTypes->name] }}
                        </option>
                        @else
                        <option hidden></option>
                        @endif
                        @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                       <input
                        id="count_data"
                        name="count_data"
                        type="text"
                        class="form-control"
                        hidden
                      />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_days">Select Leave Days*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Selct Leave Day" name="leave_days" id="leave_days" onchange="CheckLeaveDay(this)">
                        <option></option>
                        <option value="half">Half Day</option>
                        <option value="full">Full Day</option>
                        <option value="multiple">Multiple Days</option>
                        <option value="intermittent">Intermittent Leave</option>
                        <option value="hourly">Hourly Leave</option>
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="hourly_hours" id="hour" style="display: none;">Select Hours*</label>
                      <select class="js-directorate"  data-parsley-required-message="Please Selct Hours" name="hourly_hours" id="hourly_hours" style="display: none;" onchange="diffHours()">
                        <option></option>
                        <option value="1">1 Hour</option>
                        <option value="2">2 Hours</option>
                        <option value="3">3 Hours</option>
                        <option value="4" disabled>4 Hours (If you want 4 Hours leave then Please Select half Leave)</option>
                        <option value="5">5 Hours</option>
                        <option value="6">6 Hours</option>
                      </select>
                      <!-- <label for="hourly_hours">Hours*</label> -->
                      <!-- <input
                        id="hourly_hours"
                        name="hourly_hours"
                        type="text"
                        class="required form-control"
                        style="display: none;"
                        
                        placeholder="Please Enter Hours"
                      /> -->
                    </div>
                    
                    <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group d-flex radio_parsley">
                    <div class="form-check form-check-inline" style="display: none;" id="halfday" >
                      <input class="form-check-input" type="radio" name="half_leave" id="half_leave" value="morning"  data-parsley-required-message="Please Select Half Leave Type" onchange="diffHalf()">
                      <label class="form-check-label">Morning</label>
                    </div>
                    <div class="form-check form-check-inline" style="display: none;" id="halfDay">
                      <input class="form-check-input" type="radio" name="half_leave" id="half_leave" value="afternoon" onchange="diffHalf()" >
                      <label class="form-check-label">Afternoon</label>
                    </div>
                    </div>
                  </div>
                    <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="start_date">Start Date*</label>
                      <input type="text" name="start_date" id="start_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter Start Date" onchange="diffStart()">
                      <input type="text" name="start_dates[]" id="start_dates" class="required form-control datepicker1" required="" data-parsley-required-message="Please Enter Start Date" >
                    </div>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="end_date">End Date*</label>
                      <input type="text" name="end_date" id="end_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter End Date" onchange="diffDays()">
                      <input type="text" name="end_dates[]" id="end_dates" class="required form-control datepicker1" required="" data-parsley-required-message="Please Enter End Date">
                    </div>
                    <!-- <span id="access-code-error" class="rsvp required-fields"> </span> -->
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                       <input
                        id="duration"
                        name="duration"
                        type="text"
                        class="form-control"
                        hidden
                      />
                    </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="reason">Reason For Leave*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Reason" name="reason" id="reason" onchange="CheckReason(this)">
                        <option></option>
                        <option value="Illness">Illness(Illness or medical condition requiring time off for recovery)</option>
                        <option value="Family Care">Family Care(Taking leave to care for a sick family member or attending to family-related responsibilities)</option>
                        <option value="Personal Needs">Personal Needs(Requesting leave for personal matters, such as appointments, personal events, or self-care)</option>
                        <option value="Bereavement">Bereavement(Leave taken due to the death of a family member or close relative)</option>
                        <option value="Vacation">Vacation(Planned time off for leisure, travel, or rest and relaxation)</option>
                        <option value="Jury Duty">Jury Duty(Leave requested when an employee is summoned for jury duty)</option>
                        <option value="Other">  
                          Other
                        </option>
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <textarea class="form-control other" id="otherReason" name="other_reason" rows="3"  data-parsley-required-message="Please Enter Reason" style="display: none;"></textarea>
                    </div>
                    </div>
                  </section>
                  </div>
                  <div class="row">
                    <div class="col-12 change-btn">
                      <button type="submit" class="btn btn-primary">save</button>
                    </div>
                  </div>
                  
                </div>
              </form>
            </div>
          </div>
        
        </div>
      </div>
      <script>
       function getCurrentFinancialYear() {
        var startYear = "";
        var endYear = "";
        var docDate = new Date();
        var aniv = docDate.getFullYear();
        if ((docDate.getMonth() + 1) <= 3) {
          startYear = docDate.getFullYear() - 1;
          endYear = docDate.getFullYear();
        } else {
          startYear = docDate.getFullYear();
          endYear = docDate.getFullYear() + 1;
        }
        return {stDate :  "01/04/" + startYear, enDate: "31/03/" + endYear, stYear : "01/01/" + aniv, enYear: "31/12/" + aniv};
      }
      </script>
        <script>
            jQuery(document).ready( function () {
              var Picker = $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                });

              var MultiPicker = $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                });

                MultiPicker.hide();
                MultiPicker.prop('required',false);
                $('#leave_days').on('change', function () {
                var day = this.value;
                if(day == "intermittent"){
                  Picker.prop('required',false);
                  MultiPicker.prop('required',true);
                  Picker.hide();
                  MultiPicker.show();
                }else{
                  Picker.prop('required',true);
                  MultiPicker.prop('required',false);
                  Picker.show();
                  MultiPicker.hide();
                }
            });

            $('#start_dates').on('change', function () {
                var dates = $('#start_dates').val();
                var Enddates = $('#end_dates').val(dates);
                  Enddates.prop('disabled',true);
                var datesCount = $('#start_dates').val().split(',').length;
                var dateCount = $('#duration').val(datesCount);
            });


            $('#leavetype_id').on('change', function () {
                var idLeave = this.value;
                Picker.val('');
                MultiPicker.val('');
                Picker.datepicker("destroy");
                MultiPicker.datepicker("destroy");
                $.ajax({
                    url: "{{url('LeaveType')}}",
                    type: "POST",
                    data: {
                      leaveType_id: idLeave,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                      // console.log(res.LeCy.leave_cycle);
                      if(res.LeCy.leave_cycle == "Anniversary Year"){
                        // alert("hi");
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stYear,
                        endDate : getCurrentFinancialYear().enYear
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stYear,
                        endDate : getCurrentFinancialYear().enYear
                        });
                      }else if(res.LeCy.leave_cycle == "Other"){
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : res.LeCy.from_date,
                        endDate : res.LeCy.to_date
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : res.LeCy.from_date,
                        endDate : res.LeCy.to_date
                        });
                      }else{
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                        });
                      }
                    }
                });
            });

        });
        </script>
        <script>

          function CountFetchData(){
            var leaveCountId = $('#leavetype_id :selected').val();
            var countid = $("#count_leavetype_id").val(leaveCountId);
            var counttext = $('#count_leavetype_id :selected').text();
            var countData = $("#count_data").val(counttext);
          }

          function diffStart(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const date1 = $("input[name=start_date]").val();
            const $date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.5);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.125 );
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.250);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.375);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.625);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.750);
          }
          else if($("#leave_days").val() == "full"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(1);
          }
          // else if($("#leave_days").val() == "intermittent"){
          //   const date1 = $("#start_dates").val();
          //   const date2 = $("#end_dates").val(date1);
          //   const no = $('#start_dates').multiDatesPicker('getDates').length;
          //   alert(no);
          //   const dura = $('#duration').val();
          // }
          else if($("#leave_days").val() == "multiple"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val();
            const dateParts = date1.split("-");
            const datePart = date2.split("-");
            const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
            const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
            const diffTime = Date.parse(dt) - Date.parse(dt_en);
            const diffDays = diffTime/1000/60/60/24;
            const dura = $("input[name=duration]").val(diffDays + 1 );
          }
          }

        function diffDays(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.5);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.125 );
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.250);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.375);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.625);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.750);
          }
          else if($("#leave_days").val() == "full"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(1);
          }
          // else if($("#leave_days").val() == "intermittent"){
          //   const date1 = $("input[name=start_date]").val();
          //   const date2 = $("input[name=end_date]").val();
          //   const diffTime = Date.parse(date2) - Date.parse(date1);
          //   const diffDays = diffTime/1000/60/60/24;
          //   const dura = $("input[name=duration]").val(diffDays + 1 );
          // }
          else if($("#leave_days").val() == "multiple"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val();
            const dateParts = date1.split("-");
            const datePart = date2.split("-");
            const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
            const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
            const diffTime = Date.parse(dt) - Date.parse(dt_en);
            const diffDays = diffTime/1000/60/60/24;
            const dura = $("input[name=duration]").val(diffDays + 1 );
          }
          
          }

          function diffHours(){
          var countId = $('#count_leavetype_id :selected').text();

          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const dura = $("input[name=duration]").val(0.125);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const dura = $("input[name=duration]").val(0.250);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const dura = $("input[name=duration]").val(0.375);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const dura = $("input[name=duration]").val(0.625);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const dura = $("input[name=duration]").val(0.750);
          }
          }


          function diffHalf(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const dura = $("input[name=duration]").val(0.5);
          }
          }




          function CheckReason(reason) {
            var selectedValue = reason.options[reason.selectedIndex].value;
            var OtherReason = document.getElementById("otherReason");
            OtherReason.required=false;
            // txtOther.style.display.none = selectedValue == "Other" ? false : true;
            if(selectedValue == "Other"){
              OtherReason.style.display='block';
              OtherReason.focus();
              OtherReason.required=true;
            }else {
              OtherReason.style.display='none';
              OtherReason.required=false;
     }
    }
   
      function CheckLeaveDay(leave_days) {
            var selectedValue = leave_days.options[leave_days.selectedIndex].value;
            var txtOther = document.getElementById("halfday");
            var txtRadio = document.getElementById("halfDay");
            var txtCheck = document.getElementById("half_leave");
            var txtHours = document.getElementById("hourly_hours");
            var txtlabel = document.getElementById("hour");
            var EndDate = document.getElementById("end_date");
            txtCheck.required=false;
            txtHours.required=false;
            // txtOther.style.display.none = selectedValue == "Other" ? false : true;
            if(selectedValue == "half"){
              txtOther.style.display='block';
              txtRadio.style.display='block';
              txtCheck.required=true;
              // txtOther.focus();
            }else {
              txtOther.style.display='none';
              txtRadio.style.display='none';
              txtCheck.required=false;
     }
     if(selectedValue=="hourly"){
              txtHours.style.display='block';
              txtlabel.style.display='block';
              txtHours.required=true;
              txtHours.focus();
     }else{
        txtHours.style.display='none';
        txtlabel.style.display='none';
        txtHours.required=false;
     }
     if(selectedValue=="hourly" || selectedValue == "half" || selectedValue == "full"){
      EndDate.disabled=true;
      EndDate.required=false;
     }else{
        EndDate.disabled=false;
        EndDate.required=true;
     }

     if(selectedValue == "full"){
        const date1 = $("input[name=start_date]").val();
        const date2 = $("input[name=end_date]").val(date1); 
        const dura = $("input[name=duration]").val(1);
     }

    //  if(selectedValue == "intermittent"){
    //     const date1 = $("input[name=start_date]").val();
    //     const date2 = $("input[name=end_date]").val();
    //     const diffTime = Date.parse(date2) - Date.parse(date1);
    //     const diffDays = diffTime/1000/60/60/24;
    //     const dura = $("input[name=duration]").val(diffDays + 1 );
    //  }

     if(selectedValue == "multiple"){
        const date1 = $("input[name=start_date]").val();
        const date2 = $("input[name=end_date]").val();
        const dateParts = date1.split("-");
        const datePart = date2.split("-");
        const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
        const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
        const diffTime = Date.parse(dt) - Date.parse(dt_en);
        const diffDays = diffTime/1000/60/60/24;
        const dura = $("input[name=duration]").val(diffDays + 1 );
     }
  }
</script>

<script>
</script>

@endsection
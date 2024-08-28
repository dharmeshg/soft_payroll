@extends('layouts.employee')

@section('content')
<style>
  
  .fa-edit{
    padding: 6px 5px;
    background-color: #2255a4;
    color: #fff;
    font-size: 16px;
    margin-right: 7px;
  }
  .fa-trash{
    padding: 6px 5px;
    color: #fff;
    background-color: #da542e;
    font-size: 16px;
  }
  .nodata{
    font-size: 25px;
  }

</style>



      <div class="page-wrapper">
     
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">View Leave Balance</h4>
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
         
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Leave List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Leave Type</th>
                          <th>Allowance Per Year (days)</th>
                          <th>Used (days)</th>
                          <th>Remaining (days)</th>
                        </tr>
                      </thead>
                      <tbody>
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
                          //  $date = Carbon\Carbon::now()->addYear()->format('Y');
                           $Previous_year = Carbon\Carbon::now()->subYear(1)->format('Y');
                          //  $Previous_year = Carbon\Carbon::now()->subYear()->format('Y');
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

                          @forelse($leaveType as $emp)
                          
                          <tr>
                            @if($emp -> leave_cycle == "Anniversary Year")
                            <td>{{$emp->name}}</td>
                            @if($results->year == $date)
                              <td>{{$emp->days}}</td>
                            @else
                            @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{$emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name]}}</td>
                            @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)
                            @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{$emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name]}}</td>
                            @else
                              <td>{{$emp->days + $emp->max_leave_carry_forword}}</td>
                            @endif
                            @else
                              <td>{{$emp->days}}</td>
                            @endif
                            @endif 
                            @if($results->year == $date)
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @else
                              @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)
                              @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @else
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @endif
                              @else
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @endif
                            @endif 
                            @if($results->year == $date)
                              <td>{{ $emp->days - $leaveCount[$emp->name] }}</td>
                              @else
                              @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{ $emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name] - $leaveCount[$emp->name]}}</td>
                              @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)
                              @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{ $emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name] - $leaveCount[$emp->name]}}</td>
                              @else
                              <td>{{ $emp->days + $emp->max_leave_carry_forword - $leaveCount[$emp->name]}}</td>
                              @endif
                              @else
                                <td>{{ $emp->days - $leaveCount[$emp->name] }}</td>
                              @endif
                            @endif 
                            @elseif($emp -> leave_cycle == "Fiscal Year")
                            <td>{{$emp->name}}</td>
                            @if($fis_b -> between($Try_New_x, $Try_New_end_x))
                              <td>{{$emp->days}}</td>
                            @else
                              @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{$emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name]}}</td>
                              @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)

                              @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{$emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name]}}</td>
                              @else
                              <td>{{$emp->days + $emp->max_leave_carry_forword}}</td>
                              @endif
                              @else
                              <td>{{$emp->days}}</td>
                              @endif
                            @endif 
                            @if($fis_b -> between($Try_New_x, $Try_New_end_x))

                              <td>{{$leaveCount[$emp->name]}}</td>
                            @else
                              @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{$leaveCount[$emp->name]}}</td>
                              @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)
                              @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{$data['PreviousleaveCount'][$emp->name] }}</td>
                              @else
                              <td>{{$data['PreviousleaveCount'][$emp->name]}}</td>
                              @endif
                              @else
                              <td>{{$data['PreviousleaveCount'][$emp->name]}}</td>
                              @endif
                            @endif 
                            @if($fis_b -> between($Try_New_x, $Try_New_end_x))
                              <td>{{ $emp->days - $leaveCount[$emp->name] }}</td>
                            @else
                              @if($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 1)
                              <td>{{ $emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name] - $leaveCount[$emp->name]}}</td>
                              @elseif($emp->carry_over_policy == 1 && $emp->all_remaning_leaves == 0)
                              @if($emp->days - $data['PreviousleaveCount'][$emp->name] < $emp->max_leave_carry_forword)
                              <td>{{ $emp->days + $emp->days - $data['PreviousleaveCount'][$emp->name] - $leaveCount[$emp->name]}}</td>
                              @else
                              <td>{{ $emp->days + $emp->max_leave_carry_forword - $data['PreviousleaveCount'][$emp->name]}}</td>
                              @endif
                              @else
                              <td>{{ $emp->days + $emp->max_leave_carry_forword - $data['PreviousleaveCount'][$emp->name] }}</td>
                              @endif
                            @endif 
                            @elseif($emp -> leave_cycle == "Other")
                            <?php
                              $from_date = Carbon\Carbon::createFromFormat('d-m-Y',  $emp -> from_date)->format('Y/m/d');
                              $to_date = Carbon\Carbon::createFromFormat('d-m-Y',  $emp -> to_date)->format('Y/m/d');
                              $Try_from_date =Carbon\Carbon::parse($from_date);
                              $Try_to_date =Carbon\Carbon::parse($to_date);
                            ?>
                            <td>{{$emp->name}}</td>
                            @if($ok -> between($Try_from_date,$Try_to_date))
                              <td>{{$emp->days}}</td>
                            @else
                              <td>-</td>
                            @endif 
                            @if($ok -> between($Try_from_date,$Try_to_date))
                              <td>{{$leaveCount[$emp->name]}}</td>
                            @else
                              <td>-</td>
                            @endif 
                            @if($ok -> between($Try_from_date,$Try_to_date))
                              <td>{{ $emp->days - $leaveCount[$emp->name] }}</td>
                            @else
                              <td>-</td>
                            @endif 
                            @endif
                          </tr>
                          @empty
                            <tr>
                                <td colspan="4" style="text-align: center" class="nodata"><b>No Data</b></td>
                            </tr>
                          @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Leave Request List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Leave Type</th>
                          <th>Leave Days</th>
                          <th>Leave Duration</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Reason For Leave</th>
                          @if(Auth::user()->role == "Employee")
                            <th>Head of Unit Status</th>
                            <th>Head of Department Status</th>
                            <th>Head of School/Directorate Status</th>
                            <th>Status</th>
                            @elseif(Auth::user()->role == "HOU")
                            <th>Head of Department Status</th>
                            <th>Head of School/Directorate Status</th>
                            <th>Status</th>
                            @elseif(Auth::user()->role == "HOD")
                            <th>Head of School/Directorate Status</th>
                            <th>Status</th>
                            @else
                            <th>Status</th>
                            @endif
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

                        @forelse($history as $past)
                        <?php
                        if($past -> leave_cycle == "Anniversary Year"){
                        $new=explode(',',$past->start_date);
                        $old=explode(',',$past->end_date);
                        $check_date_c = Carbon\Carbon::createFromFormat('d-m-Y', $new[0])->format('Y');
                        $check_enddate_d = Carbon\Carbon::createFromFormat('d-m-Y', $old[0])->format('Y');
                        if($past->leave_days=="half"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.5;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==1){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.125;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==2){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.250;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==3){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.375;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==5){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.625;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==6){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.750;
                        }
                        elseif($past->leave_days=="full" || $past->leave_days=="multiple"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+1;
                        }elseif($past->leave_days=="intermittent"){
                          // $daes = explode(',',$past->start_date);
                          $difdays=count($new);
                        }
                      }elseif($past -> leave_cycle == "Other"){
                        $new=explode(',',$past->start_date);
                        $old=explode(',',$past->end_date);
                        $from_date = Carbon\Carbon::createFromFormat('d-m-Y',  $past -> from_date)->format('Y/m/d');
                        $to_date = Carbon\Carbon::createFromFormat('d-m-Y',  $past -> to_date)->format('Y/m/d');
                        $Try_from_date =Carbon\Carbon::parse($from_date);
                        $Try_to_date =Carbon\Carbon::parse($to_date);

                        $check_date = Carbon\Carbon::createFromFormat('d-m-Y', $new[0])->format('Y/m/d');
                        $check_enddate = Carbon\Carbon::createFromFormat('d-m-Y', $old[0])->format('Y/m/d');
    
                        $Try_check_date =Carbon\Carbon::parse($check_date);
                        $Try_check_enddate =Carbon\Carbon::parse($check_enddate);
                        if($Try_check_date->between($Try_from_date, $Try_to_date) && $Try_check_enddate -> between($Try_from_date, $Try_to_date)){
                          if($past->leave_days=="half"){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.5;
                          }
                          elseif($past->leave_days=="hourly" && $past->hourly_hours==1){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.125;
                          }
                          elseif($past->leave_days=="hourly" && $past->hourly_hours==2){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.250;
                          }
                          elseif($past->leave_days=="hourly" && $past->hourly_hours==3){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.375;
                          }
                          elseif($past->leave_days=="hourly" && $past->hourly_hours==5){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.625;
                          }
                          elseif($past->leave_days=="hourly" && $past->hourly_hours==6){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.750;
                          }
                          elseif($past->leave_days=="full" || $past->leave_days=="multiple"){
                            $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+1;
                          }elseif($past->leave_days=="intermittent"){
                            // $daes = explode(',',$past->start_date);
                            $difdays=count($new);
                          }
                        }
                      }elseif($past ->leave_cycle == "Fiscal Year"){
                        $new=explode(',',$past->start_date);
                        $old=explode(',',$past->end_date);
                        $period = Carbon\CarbonPeriod::create(
                          now()->month(4)->startOfMonth()->format('Y-m-d'),
                          '1 month',
                          now()->month(3)->addMonths(12)->format('Y-m-d')
                      );
                      $finYear = [];
                      foreach ($period as $p) {
                          $finYear[] = $p->format('Y/m/d');
                      }
                      // dd($finYear);
                      $st=$finYear[0];
                      $en=$finYear[11];
                      $try_en=Carbon\Carbon::parse($en)->endOfMonth()->toDateString();
                      $try_st=Carbon\Carbon::parse($st)->startOfMonth()->toDateString();
                      // dd($try_st);
                      // dd($try_en);
                      $try_st_new = Carbon\Carbon::createFromFormat('Y-m-d', $try_st)->format('Y/m/d');
                      $try_en_new = Carbon\Carbon::createFromFormat('Y-m-d', $try_en)->format('Y/m/d');
                      // dd($try_st_new);
                      // dd($try_en_new);

                      $Try_New =Carbon\Carbon::parse($try_st_new);
                      $Try_New_end =Carbon\Carbon::parse($try_en_new);

                      // dd($Try_New);
                      // dd($Try_New_end);

                      $check_date = Carbon\Carbon::createFromFormat('d-m-Y', $new[0])->format('Y/m/d');
                      $check_enddate = Carbon\Carbon::createFromFormat('d-m-Y', $old[0])->format('Y/m/d');

                      $Try_check_date =Carbon\Carbon::parse($check_date);
                      $Try_check_enddate =Carbon\Carbon::parse($check_enddate);

                      if($Try_check_date -> between($Try_New, $Try_New_end) && $Try_check_enddate -> between($Try_New, $Try_New_end)){
                        if($past->leave_days=="half"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.5;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==1){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.125;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==2){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.250;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==3){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.375;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==5){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.625;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==6){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.750;
                        }
                        elseif($past->leave_days=="full" || $past->leave_days=="multiple"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+1;
                        }elseif($past->leave_days=="intermittent"){
                          // $daes = explode(',',$past->start_date);
                          $difdays=count($new);
                        }
                      } 
                      else{
                        if($past->leave_days=="half"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.5;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==1){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.125;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==2){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.250;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==3){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.375;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==5){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.625;
                        }
                        elseif($past->leave_days=="hourly" && $past->hourly_hours==6){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+0.750;
                        }
                        elseif($past->leave_days=="full" || $past->leave_days=="multiple"){
                          $difdays=Carbon\Carbon::parse($past->end_date)->diffInDays($past->start_date)+1;
                        }elseif($past->leave_days=="intermittent"){
                          // $daes = explode(',',$past->start_date);
                          $difdays=count($new);
                        }
                      }
                      }
                        ?>
                          <tr>
                            @if($past -> leave_cycle == "Anniversary Year")
                            @if($check_date_c == $date && $check_enddate_d == $date)
                            <td>{{$past->name}}</td>
                            @if($past->leave_days == "half")
                            <td>{{$past->leave_days}} Leave in {{$past->half_leave}}</td>
                            @elseif($past->leave_days == "hourly")
                            <td>{{$past->leave_days}} Leave ( {{$past->hourly_hours}} Hours)</td>
                            @elseif($past->leave_days == "full")
                            <td>{{$past->leave_days}} day</td>
                            @else
                            <td>{{$past->leave_days}} days</td>
                            @endif
                            <td>{{$difdays}} days</td>
                            <td>{{$past->start_date}}</td>
                            <td>{{$past->end_date}}</td>
                            @if($past->reason == "Other")
                            <td>{{$past->other_reason}}</td>
                            @else
                            <td>{{$past->reason}}</td>
                            @endif
                            @if(Auth::user()->role == "Employee")
                            <td>@if($past->hou_status != null && $past->hou_status != 0){{$past->hou_status}}@else Head Of Unit Does Not Exists @endif</td>
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOU")
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOD")
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @else
                            <td>{{$past->status}}</td>
                            @endif
                            @if($past->status == "Pending")
                            <td><a href="{{route('leaveRequest.delete',[$past->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$past->name}}"></a></td>
                            @endif
                            @endif
                            @elseif($past -> leave_cycle == "Other")
                            @if($Try_check_date->between($Try_from_date, $Try_to_date) && $Try_check_enddate -> between($Try_from_date, $Try_to_date))
                            <td>{{$past->name}}</td>
                            @if($past->leave_days == "half")
                            <td>{{$past->leave_days}} Leave in {{$past->half_leave}}</td>
                            @elseif($past->leave_days == "hourly")
                            <td>{{$past->leave_days}} Leave ( {{$past->hourly_hours}} Hours)</td>
                            @elseif($past->leave_days == "full")
                            <td>{{$past->leave_days}} day</td>
                            @else
                            <td>{{$past->leave_days}} days</td>
                            @endif
                            <td>{{$difdays}} days</td>
                            <td>{{$past->start_date}}</td>
                            <td>{{$past->end_date}}</td>
                            @if($past->reason == "Other")
                            <td>{{$past->other_reason}}</td>
                            @else
                            <td>{{$past->reason}}</td>
                            @endif
                            @if(Auth::user()->role == "Employee")
                            <td>@if($past->hou_status != null && $past->hou_status != 0){{$past->hou_status}}@else Head Of Unit Does Not Exists @endif</td>
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOU")
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOD")
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @else
                            <td>{{$past->status}}</td>
                            @endif
                            @if($past->status == "Pending")
                            <td><a href="{{route('leaveRequest.delete',[$past->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$past->name}}"></a></td>
                            @endif
                            @endif
                            @elseif($past -> leave_cycle == "Fiscal Year")
                            @if($Try_check_date -> between($Try_New, $Try_New_end) && $Try_check_enddate -> between($Try_New, $Try_New_end))
                            <td>{{$past->name}}</td>
                            @if($past->leave_days == "half")
                            <td>{{$past->leave_days}} Leave in {{$past->half_leave}}</td>
                            @elseif($past->leave_days == "hourly")
                            <td>{{$past->leave_days}} Leave ( {{$past->hourly_hours}} Hours)</td>
                            @elseif($past->leave_days == "full")
                            <td>{{$past->leave_days}} day</td>
                            @else
                            <td>{{$past->leave_days}} days</td>
                            @endif
                            <td>{{ isset($difdays) ?  $difdays : 0 }} days</td>
                            <td>{{$past->start_date}}</td>
                            <td>{{$past->end_date}}</td>
                            @if($past->reason == "Other")
                            <td>{{$past->other_reason}}</td>
                            @else
                            <td>{{$past->reason}}</td>
                            @endif
                            @if(Auth::user()->role == "Employee")
                            <td>@if($past->hou_status != null && $past->hou_status != 0){{$past->hou_status}}@else Head Of Unit Does Not Exists @endif</td>
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOU")
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOD")
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @else
                            <td>{{$past->status}}</td>
                            @endif
                            @if($past->status == "Pending")
                            <td><a href="{{route('leaveRequest.delete',[$past->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$past->name}}"></a></td>
                            @endif
                            @else
                            <td>{{$past->name}}</td>
                            @if($past->leave_days == "half")
                            <td>{{$past->leave_days}} Leave in {{$past->half_leave}}</td>
                            @elseif($past->leave_days == "hourly")
                            <td>{{$past->leave_days}} Leave ( {{$past->hourly_hours}} Hours)</td>
                            @elseif($past->leave_days == "full")
                            <td>{{$past->leave_days}} day</td>
                            @else
                            <td>{{$past->leave_days}} days</td>
                            @endif
                            <td>{{ isset($difdays) ?  $difdays : 0 }} days</td>
                            <td>{{$past->start_date}}</td>
                            <td>{{$past->end_date}}</td>
                            @if($past->reason == "Other")
                            <td>{{$past->other_reason}}</td>
                            @else
                            <td>{{$past->reason}}</td>
                            @endif
                            @if(Auth::user()->role == "Employee")
                            <td>@if($past->hou_status != null && $past->hou_status != 0){{$past->hou_status}}@else Head Of Unit Does Not Exists @endif</td>
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOU")
                            <td>{{$past->hod_status}}</td>
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @elseif(Auth::user()->role == "HOD")
                            <td>{{$past->hof_status}}</td>
                            <td>{{$past->status}}</td>
                            @else
                            <td>{{$past->status}}</td>
                            @endif
                            @if($past->status == "Pending")
                            <td><a href="{{route('leaveRequest.delete',[$past->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$past->name}}"></a></td>
                            @endif
                            @endif
                            @endif
                          </tr>
                          @empty
                            <tr>
                            @if(Auth::user()->role == "Employee")
                            <td colspan="11" style="text-align: center" class="nodata"><b>No Data</b></td>
                              @elseif(Auth::user()->role == "HOU")
                              <td colspan="10" style="text-align: center" class="nodata"><b>No Data</b></td>
                              @elseif(Auth::user()->role == "HOD")
                              <td colspan="9" style="text-align: center" class="nodata"><b>No Data</b></td>
                              @else
                              <td colspan="8" style="text-align: center" class="nodata"><b>No Data</b></td>
                              @endif
                              
                            </tr>
                          @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

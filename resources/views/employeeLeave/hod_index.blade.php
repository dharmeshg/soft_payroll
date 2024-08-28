{{--@extends('layouts.institute')--}}
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
              <h4 class="page-title">View Leave Request</h4>
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
                  <h5 class="card-title">Leave Request List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Employee Name</th>
                          <th>Leave Type</th>
                          <th>Leave Days</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Reason For Leave</th>
                          <th>Head of Unit Status</th>
                          <th>Your Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($col !=null)
                          @foreach($col as $key=>$cols)
                          <?php 
                            
                              $offcial = App\Models\OfficialInfo::where('employee_id',$cols->employee->id)->first();
                            
                            ?>
                          <tr>
                            <th>{{$key+1}}</th>
                            <td>{{$cols->employee->fname}}{{$cols->employee->mname}}{{$cols->employee->lname}}</td>
                            <td>{{$cols->name}}</td>
                            @if($cols->leave_days == "half")
                            <td>{{$cols->leave_days}} Leave in {{$cols->half_leave}}</td>
                            @elseif($cols->leave_days == "hourly")
                            <td>{{$cols->leave_days}} Leave For {{$cols->hourly_hours}} Hour</td>
                            @else
                            <td>{{$cols->leave_days}}</td>
                            @endif
                            <td>{{$cols->start_date}}</td>
                            <td>{{$cols->end_date}}</td>
                            @if($cols->reason == "Other")
                            <td>{{$cols->other_reason}}</td>
                            @else
                            <td>{{$cols->reason}}</td>
                            @endif
                            <td>@if($cols->hou_status != null && $cols->hou_status != 0){{$cols->hou_status}}@elseif($cols->hou_status == null && $offcial->role != "HOU") I Can't Authorize to Accept this Leave Request @elseif($cols->hou_status == null && $offcial->role == "HOU") I Can't Accept this Leave Request Because It's Mine @else Head Of Unit Does Not Exists @endif</td>
                            <td>{{$cols->hod_status}}</td>
                            <td> <a href="{{route('EmployeeLeave.edit',[$cols->id])}}" class="fas fa-edit"></a></td>
                          </tr>
                           @endforeach
                           @else
                           <td colspan="9" style="text-align: center" class="nodata">No Data</td>
                           @endif
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
     @section('script')
     
       @endsection
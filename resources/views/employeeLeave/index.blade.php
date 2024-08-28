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
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($leaves as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>
                            <td>{{$item->fname}}{{$item->mname}}{{$item->lname}}</td>
                            <td>{{$item->name}}</td>
                            @if($item->leave_days == "half")
                            <td>{{$item->leave_days}} Leave in {{$item->half_leave}}</td>
                            @else
                            <td>{{$item->leave_days}}</td>
                            @endif
                            <td>{{$item->start_date}}</td>
                            <td>{{$item->end_date}}</td>
                            @if($item->reason == "Other")
                            <td>{{$item->other_reason}}</td>
                            @else
                            <td>{{$item->reason}}</td>
                            @endif
                            <td>{{$item->status}}</td>
                            <td> <a href="{{route('EmployeeLeave.edit',[$item->id])}}" class="fas fa-edit"></a></td>
                          </tr>
                           @endforeach
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
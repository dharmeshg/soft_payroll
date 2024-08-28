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
              <h4 class="page-title">Leave Types</h4>
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
                          <th>Sr.No</th>
                          <th>Leave Name</th>
                          <th>Per Year Total Leave Days</th>
                          <th>Description</th>
                          <th>Leave Cycle</th>
                          <th>Accrual method</th>
                          <th>Maximum allowed leave days</th>
                          <th>Rules</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($leavetypes as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['days']}}</td>
                            <td>{{$item['description']}}</td>
                            <td>{{$item['leave_cycle']}}</td>
                            <td>{{$item['accrual_method']}}</td>
                            <td>{{$item['max_allow_days']}}</td>
                            <td>{{$item['rules']}}</td>
                            <td> <a href="{{route('leavetype.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a  onclick="return confirm('Are you sure Want to Delete?')" href="{{route('leavetype.delete',[$item->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$item->name}}"></a></td>
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
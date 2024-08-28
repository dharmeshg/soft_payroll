@extends('layouts.employee')

@section('content')

<style>
  .fa-edit{
      padding: 6px 5px;
      background-color: #2255a4;
      color: #fff;
      font-size: 16px;
      margin: 0 6px;
  }
  .fa-trash{
      padding: 6px 5px;
      color: #fff;
      background-color: #da542e;
      font-size: 16px;
  }
  .next-page{
    display: inline-block;
    color: #fff;
    border-radius: 0.25rem;
    background-color: #2255a4;
    padding: 4px 10px;
    text-align: center;
    margin: 2px 0 0 0;
  }
</style>

      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Approve Transfer List</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
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
                  <h5 class="card-title">Transfer List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Staff ID No</th>
                          <th>Staff Name</th>
                          <th>Department</th>
                          <th>Application Type</th>
                          <th>Transfer Class</th>
                          <th>Action</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>                            
                            <td>{{$item->staffid}}</td>
                            <td>{{$item->employee_trf_detail->fname}}{{$item->employee_trf_detail->mname}}{{$item->employee_trf_detail->lname}}</td>
                            <td>{{$item->departments_trf_dt->departmentname}}</td>
                            <td>{{$item->transfertype}}</td>
                            <td>{{$item->transferclass}}</td>
                            <td>
                              <a href="{{route('destination.edit',[$item->id])}}" class="next-page">Confirm New Transfer Request</a>
                            </td> 
                            <td>
                            <a href="{{route('destination.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('destination.delete',[$item->id])}}" class="fas fa-trash delete"></a>
                          </td>
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
     
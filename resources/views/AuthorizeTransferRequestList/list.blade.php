<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')
{{-- @extends('layouts.institute') --}}

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
              <h4 class="page-title">Authorize Transfer Request</h4>
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
                  <h5 class="card-title">Authorize Transfer List</h5>
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
                          @if(Auth::user()->role == null)
                          <th>HOU Status</th>
                          <th>HOD Status</th>
                          <th>HOS Status</th>
                          @else
                          <th>Action</th>
                          <th></th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>                            
                            <td>{{$item->staffid}}</td>
                            <td>{{isset($item->employee_trf_detail->fname) ? $item->employee_trf_detail->fname : ''}}{{isset($item->employee_trf_detail->mname) ? $item->employee_trf_detail->mname : ''}}{{isset($item->employee_trf_detail->lname) ? $item->employee_trf_detail->lname : ''}}</td>
                            <td>{{$item->departments_trf_dt->departmentname}}</td>
                            <td>{{$item->transfertype}}</td>
                            <td>{{$item->transferclass}}</td>
                            @if(Auth::user()->role == null)
                              <td>@if($item->hou_status == 1) Approved @elseif($item->hou_status == 0) Unit Is Does Not Exists. @else Pending @endif</td>
                              <td>@if($item->hod_status == 1) Approved @else Pending @endif</td>
                              <td>@if($item->hof_status == 1) Approved @else Pending @endif</td>
                              @else
                              <td><a href="{{route('authorizetransfer.edit',[$item->id])}}" class="next-page">Review Authorized Transfer Request</a></td>
                              <td><a href="{{route('authorizetransfer.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('authorizetransfer.delete',[$item->id])}}" class="fas fa-trash delete"></a></td>
                              @endif
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
     
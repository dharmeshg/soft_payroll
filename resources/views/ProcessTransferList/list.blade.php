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
              <h4 class="page-title">Process Transfer</h4>
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
                  <h5 class="card-title">Process Transfer List</h5>
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
                            <td>{{$item->nameofstaff}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->transfertype}}</td>
                            <td>{{$item->transferclass}}</td>
                            <td>@if(Auth::user()->role == 'Dean')
                              <a href="{{route('authorizetransfer.edit',[$item->id])}}" class="next-page">Authorize Transfer Request</a>
                              @else
                              <a href="">#</a>
                              @endif</td> 
                            <td>
                            <a href="{{route('processtransfer.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('processtransfer.delete',[$item->id])}}" class="fas fa-trash delete"></a>
                            <!-- <a href="">#</a> -->
                            #
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
     
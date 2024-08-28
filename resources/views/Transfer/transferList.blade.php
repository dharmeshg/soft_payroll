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
              <h4 class="page-title">Transfer</h4>
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
                  <h5 class="card-title">Previous Transfer Outgoing List</h5>
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
                          <th>Transfer Class</th>
                          <th>From Institute</th>
                          <th>From School/Directorate</th>
                          <th>From Department</th>
                          <th>From Unit</th>
                          <th>To Institute</th>
                          <th>To School/Directorate</th>
                          <th>To Department</th>
                          <th>To Unit</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($transfer_out as $key=>$item)
                          <tr>
                            <td>{{$key+1}}</td>                            
                            <td>{{$item->staffid}}</td>
                            <td>{{$item->employee_trf_detail->fname}}{{$item->employee_trf_detail->mname}}{{$item->employee_trf_detail->lname}}</td>
                            <td>{{$item->transferclass}}</td>
                             <td>{{Auth::user()->institutionname}}</td>                            
                            <td><?php $from_fac =App\Models\FacultyDirectorate::where('id',$item->faculty)->first(); ?>{{$from_fac->facultyname}}</td>
                            <td><?php $from_de = App\Models\Department::where('id',$item->department)->first(); ?>{{$from_de->departmentname}}</td>
                            <td><?php $from_un = App\Models\Unit::where('id',$item->unit)->first(); ?>{{$from_un->name}}</td>
                            <td><?php $uu =App\Models\User::where('id',$item->institutionname)->first(); ?>{{$uu->institutionname}}</td>
                            <td><?php $ue =App\Models\FacultyDirectorate::where('id',$item->transferfaculty)->first(); ?>{{$ue->facultyname}}</td>
                            <td><?php $de = App\Models\Department::where('id',$item->transferdepartment)->first(); ?>{{$de->departmentname}}</td>
                            <td><?php $di = App\Models\Unit::where('id',$item->transferunit)->first(); ?>{{$di->name}}</td>
                          </tr>
                         @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Previous Transfer Incoming List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config1"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Staff ID No</th>
                          <th>Staff Name</th>
                          <th>Transfer Class</th>
                          <th>From Institute</th>
                          <th>From School/Directorate</th>
                          <th>From Department</th>
                          <th>From Unit</th>
                          <th>To Institute</th>
                          <th>To School/Directorate</th>
                          <th>To Department</th>
                          <th>To Unit</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($transfer_in as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>                            
                            <td>{{$item->staffid}}</td>
                            <td>{{$item->employee_trf_detail->fname}}{{$item->employee_trf_detail->mname}}{{$item->employee_trf_detail->lname}}</td>
                            <td>{{$item->transferclassIn}}</td>
                            <td><?php $uu =App\Models\User::where('id',$item->institution_id)->first(); ?>{{$uu->institutionname}}</td>
                            <td><?php $ue =App\Models\FacultyDirectorate::where('id',$item->faculty)->first(); ?>{{$ue->facultyname}}</td>
                            <td><?php $de = App\Models\Department::where('id',$item->department)->first(); ?>{{$de->departmentname}}</td>
                            <td><?php $di = App\Models\Unit::where('id',$item->unit)->first(); ?>{{$di->name}}</td>
                            <td>{{Auth::user()->institutionname}}</td>
                            <td><?php $to_fac =App\Models\FacultyDirectorate::where('id',$item->transferfaculty)->first(); ?>{{$to_fac->facultyname}}</td>
                            <td><?php $to_de = App\Models\Department::where('id',$item->transferdepartment)->first(); ?>{{$to_de->departmentname}}</td>
                            <td><?php $to_di = App\Models\Unit::where('id',$item->transferunit)->first(); ?>{{$to_di->name}}</td>
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
     <script>
      $('#zero_config1').DataTable({});
      </script>
     @endsection
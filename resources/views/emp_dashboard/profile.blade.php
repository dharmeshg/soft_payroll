<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@extends('layouts.employee')

@section('content')
<style type="text/css">
  .img-height-100 { width: auto;
    height: 100px; }
  .docpreview {
    margin: 20px 0 0 0 !important;
}
.docpreview img {
    width: 100px;
}
a.docpreview { color: #3e5569; font-size: 16px; line-height: 40px; }
  .form-check-label {
    line-height: 22px;
    font-size: 12px !important;
  }

  .select2-container {
    display: block;
    width:100% !important;
  }

  /*#show{
    display: none;
  }*/
  #officialinfoshow {
    display: none;
  }

  #academicother {
    display: none;
  }

  .download-btn {
    display: inline-block;
    color: #fff;
    border-radius: 0.25rem;
    /*background-color: #2962ff;*/
    padding: 4px 10px !important;
    text-align: center;
    margin: 2px 0 0 0;
  }
  .view-service-history{
    margin-top: 27px;
  }
  .upload-btn{
    background-color: #7460ee;
    border-color: #7460ee;
    color: #fff;
    padding: 5px 13px;
    margin-top: 46px;
    text-align: center;
  }
  /*.employee-page ul{
    display: inline-flex !important;
    width: 100%!important;
    flex-wrap: wrap!important;
  }*/
 /* .employee-page ul li{
    float: left;
    display: inline-flex!important;
    flex: 1 0 20%;
    margin: 0;
  }
  .employee-content .steps a{
  	width: 274px!important;
    margin: 0 0 10px 0.5em!important;
    padding: 4px 0!important;
    text-decoration: none;
    border-radius: 5px;
    font-size: 17px!important;
    line-height: 35px;
    font-weight: 100;
  }*/
</style>

<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Employee</h4>
       <!--  <div class="ms-auto text-end">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                Library
              </li>
            </ol>
          </nav>
        </div> -->
      </div>
    </div>
  </div>
  <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content employee-content">
            
                    <h4 class="card-title">Edit EmployeeProfile</h4>
                    <form id="example-form" action="{{route('emp_dashboard.profile.update')}}" class="mt-5" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="employee-page">
                            <div class="row">
                              <input type="hidden" name="id" id="" value="{{$employee->id}}">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="title">Title</label>
                                        <select class="js-example-basic-single" name="title">
                                        <option></option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Prof.' ) ? 'selected' : '' )}} value="Prof.">Prof.</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Dr.' ) ? 'selected' : '')}} value="Dr.">Dr.</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Mr.' ) ? 'selected' : '')}} value="Mr.">Mr.</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Mrs.' ) ? 'selected' : '')}} value="Mrs.">Mrs.</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Miss' ) ? 'selected' : '')}} value="Miss">Miss</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Master' ) ? 'selected' : '')}} value="Master">Master</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Ms' ) ? 'selected' : '')}} value="Ms">Ms</option>
                                        <option {{ ( isset($employee->title) && ( $employee->title == 'Other' ) ? 'selected' : '')}} value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="fname">First Name</label>
                                    <input id="fname" name="fname" type="text" class=" required form-control" required="" data-parsley-required-message="Please Enter First Name" value="{{ (( isset($employee->fname) ) ? $employee->fname: '')}}" />
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="mname">Middle Name</label>
                                    <input id="mname" name="mname" type="text" class="required form-control" data-parsley-required-message="Please Enter Middle Name" value="{{ (( isset($employee->mname) ) ? $employee->mname: '')}}" />
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="lname">Last Name</label>
                                    <input id="lname" name="lname" type="text" class="required form-control" data-parsley-required-message="Please Enter Last Name" value="{{ (( isset($employee->lname) ) ? $employee->lname: '')}}" />
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="maidenname">Maiden Name</label>
                                    <input id="maidenname" name="maidenname" type="text" class="form-control" data-parsley-required-message="Please Enter Maiden Name" value="{{ (( isset($employee->maidenname) ) ? $employee->maidenname: '')}}" />
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="formername">Former Name</label>
                                    <input id="formername" name="formername" type="text" class="form-control" data-parsley-required-message="Please Enter Former Name" value="{{ (( isset($employee->formername) ) ? $employee->formername: '')}}" />
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="email">Email</label>
                                    <input id="employeeemail" name="employeeemail" type="text" class="required form-control" data-parsley-required-message="Please Enter Email" value="{{ (( isset($employee->employeeemail) ) ? $employee->employeeemail: '')}}" />
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>    
    </div>    

</div> 
@endsection
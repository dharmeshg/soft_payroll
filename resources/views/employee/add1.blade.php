<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

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
  .select2-container--default .select2-selection--single{
    border-color: #e9ecef !important;
    height: 35px !important;
    color: #3e5569;
    line-height: 40px;
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
        @if( isset($employee) )
        <h4 class="card-title">Edit Employee</h4>
        @else
        <h4 class="card-title">Add Employee</h4>
        @endif
        <h6 class="card-subtitle"></h6>

        @if( isset($employee) )
        <form id="example-form" action="{{ route('employee.update',[$employee->id])}}" class="mt-5" method="POST" data-parsley-validate="" enctype="multipart/form-data">
          {{ csrf_field() }}
          @else
          <form id="example-form" action="{{ route('employee.store') }}" class="mt-5" method="POST" data-parsley-validate="" enctype="multipart/form-data">
            {{ csrf_field() }}
            @endif

            <div class="employee-page">
              <h3>Basic Info</h3>
              <section>
                <div class="row">
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
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="dateofbirth">Date of Birth</label>
                    <input id="dateofbirth" name="dateofbirth" type="text" class="required form-control" data-parsley-required-message="Please Enter Date of Birth" value="{{ (( isset($employee->dateofbirth) ) ? $employee->dateofbirth->format('Y/m/d'): '')}}" />
                  </div>
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 form-group">
                    <label for="age">Age</label>
                    <input id="age" name="age" type="text" class="form-control age" value="{{ (( isset($employee->age) ) ? $employee->age : '')}}" />
                  </div>
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 form-group"> 
                    <label for="password">Password @if(!isset($employee))*@endif</label>
                    <input
                      id="anotherfield"
                      name="password"
                      type="password"
                      class="@if(!isset($employee)) required @endif form-control" 
                      value="" @if(!isset($employee)) required="true" @endif
                    />
                  </div> 
                  
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                    <label for="sex">Sex</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" id="male" value="male" {{ ( isset( $employee->sex ) && $employee->sex == 'male' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="sex" id="female" value="female" {{ ( isset( $employee->sex ) && $employee->sex == 'female' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Female</label>
                    </div>
                    <div class="form-check form-check-inline" disabled="disabled">
                      <input class="form-check-input" type="radio" name="sex" id="othersex" value="other" {{ ( isset( $employee->sex ) && $employee->sex == 'other' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Other</label>
                    </div>
                  </div>
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 form-group" id="show" disabled="disabled">
                    <label for="otherfield">Other</label>
                    <input id="otherfield" name="otherfield" type="text" class=" @if( isset( $employee->sex ) && $employee->sex == 'other' )required @endif form-control" value="{{ (( isset($employee->otherfield) ) ? $employee->otherfield: '')}}" @if( isset( $employee->sex ) && $employee->sex != 'other' )disabled @endif
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                    <label for="maritalstatus">Marital Status</label>
                    <div class="form-check form-check-inline" disabled="disabled">
                      <input class="form-check-input" type="radio" name="maritalstatus" id="maritalstatus" value="married" {{ ( isset( $employee->maritalstatus ) && $employee->maritalstatus == 'married' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Married</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="maritalstatus" id="unmarried" value="unmrried" {{ ( isset( $employee->maritalstatus ) && $employee->maritalstatus == 'unmrried' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Unmarried</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="maritalstatus" id="single" value="single" {{ ( isset( $employee->maritalstatus ) && $employee->maritalstatus == 'single' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Single</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="maritalstatus" id="other" value="other" {{ ( isset( $employee->maritalstatus ) && $employee->maritalstatus == 'other' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Other</label>
                    </div>
                  </div>
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-12 col-12 form-group">
                    <label for="noofchildren">No of Children</label>
                    <input id="noofchildren" name="noofchildren" type="text" class="@if( isset( $employee->maritalstatus ) && $employee->maritalstatus == 'married' )required @endif form-control" data-parsley-required-message="Please Enter No of Children" value="{{ (( isset($employee->noofchildren) ) ? $employee->noofchildren: '')}}" @if( isset( $employee->maritalstatus ) && $employee->maritalstatus != 'married' )disabled @endif
                    />
                  </div>
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-4 col-sm-12 col-12 form-group btn1">
                    <label for="spousename">Spouse Name</label>
                    <input id="spousename" name="spousename" type="text" class="required form-control" data-parsley-required-message="Please Enter Spouse Name" value="{{ (( isset($employee->spousename) ) ? $employee->spousename: '')}}" @if( isset( $employee->maritalstatus ) && $employee->maritalstatus != 'married' )disabled @endif
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="phoneno">Phone No</label>
                    <input id="phoneno" name="phoneno" type="text" class="required form-control phoneno-inputmask" data-parsley-required-message="Please Enter Phone no" value="{{ (( isset($employee->phoneno) ) ? $employee->phoneno: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="religion">Religion</label>
                    <select class="js-example-basic-single" name="religion">
                      <option></option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Atheism/Agnosticism' ) ? 'selected' : '')}} value="Atheism/Agnosticism">Atheism/Agnosticism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Bahá’í' ) ? 'selected' : '')}} value="Bahá’í">Bahá’í</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Buddhism' ) ? 'selected' : '')}} value="Buddhism">Buddhism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Christianity' ) ? 'selected' : '')}} value="Christianity">Christianity</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Confucianism' ) ? 'selected' : '')}} value="Confucianism">Confucianism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Druze' ) ? 'selected' : '')}} value="Druze">Druze</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Gnosticism' ) ? 'selected' : '')}} value="Gnosticism">Gnosticism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Hinduism' ) ? 'selected' : '')}} value="Hinduism">Hinduism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Islam' ) ? 'selected' : '')}} value="Islam">Islam</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Jainism' ) ? 'selected' : '')}} value="Jainism">Jainism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Judaism' ) ? 'selected' : '')}} value="Judaism">Judaism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Rastafarianism' ) ? 'selected' : '')}} value="Rastafarianism">Rastafarianism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Shinto' ) ? 'selected' : '')}} value="Shinto">Shinto</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Sikhism' ) ? 'selected' : '')}} value="Sikhism">Sikhism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Zoroastrianism' ) ? 'selected' : '')}} value="Zoroastrianism">Zoroastrianism</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Traditional-African-Religions' ) ? 'selected' : '')}} value="Traditional-African-Religions">Traditional African Religions</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'African-Diaspora-Religions' ) ? 'selected' : '')}} value="African-Diaspora-Religions">African Diaspora Religions</option>
                      <option {{ ( isset($employee->religion) && ( $employee->religion == 'Indigenous-American-Religions' ) ? 'selected' : '')}} value="Indigenous-American-Religions">Indigenous American Religions</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                    <label for="denomination">Denomination</label>
                    <select class="js-example-basic-single" name="denomination">
                      <option></option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Roman-Catholic-Church-Protestantism' ) ? 'selected' : '')}} value="Roman-Catholic-Church-Protestantism">Roman Catholic Church Protestantism</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Pentecostalism-Charismatic-Assemblies-of-God' ) ? 'selected' : '')}} value="Pentecostalism-Charismatic-Assemblies-of-God">Pentecostalism/Charismatic Assemblies of God</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'New-Apostolic-Church' ) ? 'selected' : '')}} value="New-Apostolic-Church">New Apostolic Church</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Foursquare-Church' ) ? 'selected' : '')}} value="Foursquare-Church">Foursquare Church</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Church-of-God-in-Christ' ) ? 'selected' : '')}} value="Church-of-God-in-Christ">Church of God in Christ</option>
                      <optgroup label="Baptist">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Southern-Baptist-Convention' ) ? 'selected' : '')}} value="Southern-Baptist-Convention">Southern Baptist Convention</option>
                      </optgroup>
                      <optgroup label="Lutheranism">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Evangelical-Lutheran-Church-in-America' ) ? 'selected' : '')}} value="Evangelical-Lutheran-Church-in-America">Evangelical Lutheran Church in America</option>
                      </optgroup>
                      <optgroup label="Methodism">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'United-Methodist-Church' ) ? 'selected' : '')}} value="United-Methodist-Church">United Methodist Church</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'African-Methodist-Episcopal-Church' ) ? 'selected' : '')}} value="African-Methodist-Episcopal-Church">African Methodist Episcopal Church</option>
                      </optgroup>
                      <optgroup label="Reformed Churches">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Presbyterian-Church' ) ? 'selected' : '')}} value="Presbyterian-Church">Presbyterian Church</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'United-Church-of-Christ' ) ? 'selected' : '')}} value="United-Church-of-Christ">United Church of Christ</option>
                      </optgroup>
                      <optgroup label="Non-Denominational Evangelicalism">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Calvary-Chapel' ) ? 'selected' : '')}} value="Calvary-Chapel">Calvary Chapel</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'The-Vineyard' ) ? 'selected' : '')}} value="The-Vineyard">The Vineyard</option>
                      </optgroup>
                      <optgroup label="Restorationism">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Seventh-day-Adventists' ) ? 'selected' : '')}} value="Seventh-day-Adventists">Seventh-day Adventists</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Church-of-Christ' ) ? 'selected' : '')}} value="Church-of-Christ">Church of Christ</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Christian-Church' ) ? 'selected' : '')}} value="Christian-Church">Christian Church</option>
                      </optgroup>
                      <optgroup label="Anabaptism">
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Mennonites' ) ? 'selected' : '')}} value="Mennonites">Mennonites</option>
                        <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Amish' ) ? 'selected' : '')}} value="Amish">Amish</option>
                      </optgroup>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Eastern-Orthodoxy' ) ? 'selected' : '')}} value="Eastern-Orthodoxy">Eastern Orthodoxy</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Oriental-Orthodox-Church' ) ? 'selected' : '')}} value="Oriental-Orthodox-Church">Oriental Orthodox Church</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Anglicanism' ) ? 'selected' : '')}} value="Anglicanism">Anglicanism</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Episcopal-Church' ) ? 'selected' : '')}} value="Episcopal-Church">Episcopal Church</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Nontrinitarianism' ) ? 'selected' : '')}} value="Nontrinitarianism">Nontrinitarianism</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Jehovah’s-Witnesses' ) ? 'selected' : '')}} value="Jehovah’s-Witnesses">Jehovah’s Witnesses</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Mormonism' ) ? 'selected' : '')}} value="Mormonism">Mormonism</option>
                      <option {{ ( isset($employee->denomination) && ( $employee->denomination == 'Nestorianisms' ) ? 'selected' : '')}} value="Nestorianisms">Nestorianism</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="genotype">Genotype</label>
                    <select class="js-example-basic-single" name="genotype">
                      <option></option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'AA' ) ? 'selected' : '')}} value="AA">AA</option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'AS' ) ? 'selected' : '')}} value="AS">AS</option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'AC' ) ? 'selected' : '')}} value="AC">AC</option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'SS' ) ? 'selected' : '')}} value="SS">SS</option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'SC' ) ? 'selected' : '')}} value="SC">SC</option>
                      <option {{ ( isset($employee->genotype) && ( $employee->genotype == 'CC' ) ? 'selected' : '')}} value="CC">CC</option>
                    </select>
                  </div>
                  <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="bloodgroup">Blood Group</label>
                    <select class="js-example-basic-single" name="bloodgroup">
                      <option></option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'O-' ) ? 'selected' : '' )}} value="O-">O-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'O+' ) ? 'selected' : '')}} value="O+">O+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'A-' ) ? 'selected' : '')}} value="A-">A-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'A+' ) ? 'selected' : '')}} value="A+">A+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'B-' ) ? 'selected' : '')}} value="B-">B-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'B+' ) ? 'selected' : '')}} value="B+">B+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'AB-' ) ? 'selected' : '')}} value="AB-">AB-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'AB+' ) ? 'selected' : '')}} value="AB+">AB+</option>
                    </select>
                  </div> -->
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="bloodgroup">Blood Group</label>
                    <select class="js-example-basic-single" name="bloodgroup">
                      <option></option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'O-' ) ? 'selected' : '' )}} value="O-">O-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'O+' ) ? 'selected' : '')}} value="O+">O+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'A-' ) ? 'selected' : '')}} value="A-">A-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'A+' ) ? 'selected' : '')}} value="A+">A+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'B-' ) ? 'selected' : '')}} value="B-">B-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'B+' ) ? 'selected' : '')}} value="B+">B+</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'AB-' ) ? 'selected' : '')}} value="AB-">AB-</option>
                      <option {{ ( isset($employee->bloodgroup) && ( $employee->bloodgroup == 'AB+' ) ? 'selected' : '')}} value="AB+">AB+</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="country">Country</label>
                    <select class="js-example-basic-single" name="country" id="country-dropdown">
                      <option></option>
                      @foreach($countries as $country)
                      <option {{ ( isset( $employee->country ) && ($employee->country == $country->id) ? 'selected' : '' ) }} value="{{ $country->id }}">{{$country->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="nationality">Nationality</label>
                    <select class="js-example-basic-single" name="nationality">
                      <option></option>
                      @foreach($nationalities as $nationality)
                      <option {{ ( isset( $employee->nationality ) && ($employee->nationality == $nationality->name) ? 'selected' : '' ) }} value="{{ $nationality->name }}">{{$nationality->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                    <label for="state">State</label>
                    <select class="js-example-basic-single" id="state-dropdown" name="state">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="localgovermentoforigin">Local Government of Origin</label>
                    <select class="js-example-basic-single" id="Local-Goverment" name="localgovermentoforigin">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="city">City</label>
                    <select class="js-example-basic-single" id="city-dropdown" name="city">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="hometown">Home Town</label>
                    <input id="hometown" name="hometown" type="text" class="required form-control" data-parsley-required-message="Please Enter Home Twon" value="{{ (( isset($employee->hometown) ) ? $employee->hometown: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="tribe">Tribe</label>
                    <input id="tribe" name="tribe" type="text" class="required form-control" data-parsley-required-message="Please Enter Tribe" value="{{ (( isset($employee->tribe) ) ? $employee->tribe: '')}}" />
                  </div>
                </div>
                  <div class="row">
                  <div class="col-lg-9">
                  <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="disability">Disability</label>
                          <div class="form-check form-check-inline" disabled="disabled">
                            <input class="form-check-input" type="radio" name="disability" id="Yes" value="Yes" {{ ( isset( $employee->disability ) && $employee->disability == 'Yes' ) ? 'checked' : '' }}>
                            <label class="form-check-label">Yes</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input clearAll" type="radio" name="disability" id="No" value="No" @if(isset($employee)) @else checked @endif {{ ( isset( $employee->disability ) && $employee->disability == 'No' ) ? 'checked' : '' }} @if(!isset($employee)) 'checked' @endif>
                            <label class="form-check-label">No</label>
                          </div>
                            </div>
                            <?php
                            $ar = [];
                            if(isset($employee->disabilitytype)){
                              if(!empty($employee->disabilitytype)) {
                                $ar = explode(',',$employee->disabilitytype);
                              }
                            }
                            ?>
                            <div class="col-md-8 form-group">
                              <label for="disabilitytype">Disability Type</label>
                                <select class="js-example-basic-single js-select2 remove-disability" id="disabilitytype" name="disabilitytype[]" multiple="multiple" @if(!isset($employee)) disabled @endif>
                                  <option></option>
                                  <option {{ ( isset($employee->disabilitytype) && (in_array('Blindness',$ar)) ? 'selected' : '' )}} value="Blindness">Blindness</option>
                                  <option {{ ( isset($employee->disabilitytype) && (in_array('Low-vision',$ar)) ? 'selected' : '')}} value="Low-vision">Low-vision</option>
                                  <option {{ ( isset($employee->disabilitytype) && (in_array('HearingImpairment',$ar)) ? 'selected' : '')}} value="HearingImpairment">HearingImpairment</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="employeestatus">Employee Status</label>
                              <select class="js-example-basic-single" name="employeestatus" id="employeestatus">
                                <option></option>
                                <option {{ ( isset($employee->employeestatus) && ( $employee->employeestatus == 'Dead' ) ? 'selected' : '' )}} value="Dead">Dead</option>
                                <option {{ ( isset($employee->employeestatus) && ( $employee->employeestatus == 'Alive' ) ? 'selected' : '')}} value="Alive">Alive</option>
                              </select>
                      </div>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                    <label for="dateofdeath">Date of Death</label>
                    <input id="dateofdeath" name="dateofdeath" type="text" class="form-control datepicker" data-parsley-required-message="Please Enter Date of Death" value="{{ (( isset($employee->dateofdeath) ) ? $employee->dateofdeath: '')}}" {{ ( isset($employee->employeestatus) && ( $employee->employeestatus == 'Dead' ) ? '' : 'disabled' )}} />
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 form-group">
                    <label for="causeofdeath">Cause of Death</label>
                    <input id="causeofdeath" name="causeofdeath" type="text" class="form-control" data-parsley-required-message="Please Enter Cause of Death" value="{{ (( isset($employee->causeofdeath) ) ? $employee->causeofdeath: '')}}" {{ ( isset($employee->employeestatus) && ( $employee->employeestatus == 'Dead' ) ? '' : 'disabled' )}}/>
                  </div>
                        </div>
                    </div>

                    @if(isset($employee->profile_image) && $employee->profile_image != '')
                        <div class="col-lg-3 col-sm-3 col-md-3">
                          <a id="imgs_delected" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Click To Capture"><img src="{{ url('public/employee/'.$employee->profile_image) }}" alt="" title="" id="img" class="img-fluid"/></a>
                          </div>
                    @else
                    <div class="col-lg-3 col-sm-3 col-md-3">
                    <a id="imgs_delected" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><img src="{{ asset('assets/images/capture_icon.png') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Click To Capture"></a>
                      </div>
                      @endif

                      

                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content p-3">
                              <div class="modal-header">
                                <!-- <button type="button" class="close" data-dismiss="bd-example-modal-lg" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button> -->
                                <h4 class="modal-title" id="exampleModalLabel">Capture Image</h4>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                      <div id="my_camera"></div>
                                      <br/>
                                      <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                      <input type="hidden" name="profile_image" class="image-tag">
                                  </div>
                                  <div class="col-md-6">
                                      <div id="results">Your captured image will appear here...</div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                    </div>
                    <div class="row">
                      
                  <!--<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                  <button class="btn btn-primary view-service-history">View Service History</button>
                  </div>-->
                    </div>
              </section>
              <h3>Official Info</h3>
              <section>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="staff_id">Staff ID*</label>
                    <input id="staff_id" name="staff_id" type="text" class="required form-control" readonly data-parsley-required-message="Please Enter Staff ID" value="{{ ( ( isset($employee->official_information->staff_id) ) ? $employee->official_information->staff_id : date('Y').$order_next_id )}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="staff_id">Category</label>
                    <select class="category_unit" name="category_unit" id="category_unit" @if (isset($employee->official_information->category) || Auth::user()->category != '') disabled @endif>
                                        <option
                                            {{ (isset($employee->official_information->category) && $employee->official_information->category) || Auth::user()->category == 'Academic' ? 'selected' : '' }}
                                            value="Academic">Academic</option>
                                        <option
                                            {{ (isset($employee->official_information->category) && $employee->official_information->category) || Auth::user()->category == 'Non-Academic' ? 'selected' : '' }}
                                            value="Non-Academic">Non-Academic</option>
                                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group non_academic_form" style="display:none;">
                    <label for="directorate">Department (Non-Academic)</label>
                    <select class="js-example-basic-single"  name="department_non_Academic" id="department_non_Academic">
                      <option></option>
                      @foreach($non_academic_departments as $facultydirectorate)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->non_Academic_department == $facultydirectorate->id) ? 'selected' : '' ) }} value="{{ $facultydirectorate->id }}">{{$facultydirectorate->departmentname}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group academic_form">
                    <label for="directorate">School/Directorate (Academic)</label>
                    <select class="js-example-basic-single" required name="directorate" id="directorate-dropdown">
                      <option></option>
                      @foreach($facultydirectorates as $facultydirectorate)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->directorate == $facultydirectorate->id) ? 'selected' : '' ) }} value="{{ $facultydirectorate->id }}">{{$facultydirectorate->facultyname}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group non_academic_form" style="display:none;">
                    <label for="directorate">Division (Non-Academic)</label>
                    <select class="js-example-basic-single" name="division_non_Academic" id="division_non_Academic">
                      <option></option>
                      @foreach($division as $divisions)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->non_Academic_division == $divisions->id) ? 'selected' : '' ) }} value="{{ $divisions->id }}">{{$divisions->departmentname}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group academic_form">
                    <label for="department">Department (Academic)</label>
                    <select class="js-example-basic-single" required name="department" id="department-dropdown" >
                      <!-- <option>--Select Department--</option>departments -->
                      <option></option>
                      @foreach($departments as $department)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->department == $department->id) ? 'selected' : '' ) }} value="{{ $department->id }}">{{$department->departmentname}}</option>
                      @endforeach
                    </select>
                  </div>
                  </div>
                  <div class="row">

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group non_academic_form" style="display:none;">
                    <label for="role">Role/Post Held (Non-Academic)</label>
                    <select class="js-example-basic-single" name="role_non_Academic" id="role_non_Academic">
                      <option></option>
                      @if(Auth::user()->category == '')
                        <option {{ ( isset($employee->official_information) && ( $employee->official_information->non_Academic_role == 'HOD' ) ? 'selected' : '')}} value="HOD">HOD</option>
                      @endif
                      @if(Auth::user()->category == '' || Auth::user()->role == 'HOD')
                        <option {{ ( isset($employee->official_information) && ( $employee->official_information->non_Academic_role == 'HODV' ) ? 'selected' : '')}} value="HODV">HODV</option>
                      @endif
                      @if(Auth::user()->category == '' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV')
                        <option {{ ( isset($employee->official_information) && ( $employee->official_information->non_Academic_role == 'HOU' ) ? 'selected' : '')}} value="HOU">HOU</option>
                      @endif
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->non_Academic_role == 'Employee' ) ? 'selected' : '')}} value="Employee">Employee</option>
                      
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group academic_form">
                    <label for="role">Role/Post Held (Academic)</label>
                    <select class="js-example-basic-single" required name="role" id="role">
                      <option></option>
                      @if(Auth::user()->category == '')
                        <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'HOF' ) ? 'selected' : '')}} value="HOF">HOS</option>
                      @endif
                      @if(Auth::user()->category == '' || Auth::user()->role == 'HOF')
                         <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'HOD' ) ? 'selected' : '')}} value="HOD">HOD</option>
                      @endif
                      @if(Auth::user()->category == '' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOD')
                         <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'HOU' ) ? 'selected' : '')}} value="HOU">HOU</option>
                      @endif
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'Employee' ) ? 'selected' : '')}} value="Employee">Employee</option>
                      
                    </select>
                  </div>
             
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group academic_form">
                    <label for="designation">Designation (Academic)</label>
                    <select class="js-example-basic-single" required name="designation" id="designation">
                      <option></option>
                      @foreach($designations as $designation)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->designation == $designation->id) ? 'selected' : '' ) }} value="{{ $designation->id }}">{{$designation->title}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group non_academic_form" style="display:none">
                    <label for="designation">Designation (Non-Academic)</label>
                    <select class="js-example-basic-single" name="designation_non_Academic" id="designation_non_Academic">
                      <option></option>
                      @foreach($non_academic_designations as $non_academic_designation)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->non_Academic_designation == $non_academic_designation->id) ? 'selected' : '' ) }} value="{{ $non_academic_designation->id }}">{{$non_academic_designation->title}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group academic_form">
                    <label for="unit">Unit (Academic)</label>
                    <select class="js-example-basic-single js-unit" required name="unit" id="unit-dropdown" >
                      <option></option>
                      @foreach($units as $unit_data)
                      <option {{ ( isset( $employee->official_information->unit ) && ($employee->official_information->unit == $unit_data->id) ? 'selected' : '' ) }} value="{{ $unit_data->id }}">{{$unit_data->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group non_academic_form" style="display:none;">
                    <label for="unit">Unit (Non-Academic)</label>
                    <select class="js-example-basic-single js-unit" name="unit_non_Academic" id="unit_non_Academic" >
                      <option></option>
                      @foreach($non_academic_units as $non_academic_unit)
                      <option {{ ( isset( $employee->official_information->non_Academic_unit ) && ($employee->official_information->non_Academic_unit == $non_academic_unit->id) ? 'selected' : '' ) }} value="{{ $non_academic_unit->id }}">{{$non_academic_unit->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="cadre">Cadre</label>
                    <input id="cadre" name="cadre" type="text" class="required form-control" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->cadre: '')}}" />
                  </div> -->
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="cadre">Cadre</label>
                         <select class="js-example-basic-single required" name="cadre">
                          <option></option>
                            <optgroup label="generalist cadre">
                              <option {{ ( ( ( isset($employee->official_information) && $employee->official_information->cadre == 'administrative-class') ) ? 'selected' : '' ) }} value="administrative-class">administrative class</option>
                              <option {{ ( ( ( isset($employee->official_information) && $employee->official_information->cadre == 'executive-class') ) ? 'selected' : '' ) }} value="executive-class">executive class</option>
                              <option {{ ( ( ( isset($employee->official_information) && $employee->official_information->cadre == 'clerical-class') ) ? 'selected' : '' ) }} value="clerical-class">clerical class</option>
                              <option {{ ( ( ( isset($employee->official_information) && $employee->official_information->cadre == 'operative-class') ) ? 'selected' : '' ) }} value="operative-class">operative class</option>
                            </optgroup>
                            <optgroup label="specialist cadre">
                              <option {{ ( ( ( isset($employee->official_information) && $employee->official_information->cadre == 'specialist-cadre') ) ? 'selected' : '' ) }} value="specialist-cadre">specialist cadre</option>
                            </optgroup>
                         </select>
                      </div>
                      </div>
                      <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="highestqualification">Highest Qualification</label>
                    <input id="highestqualification" name="highestqualification" type="text" class="required form-control" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->highestqualification: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="gradelevel">Grade Level</label>
                    <select class="js-example-basic-single required form-control" name="gradelevel">
                      <option></option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->gradelevel == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                  </div>
                
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="step">Step</label>
                    <select class="js-example-basic-single required" name="step">
                      <option></option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->step == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="areaofstudy">Area of study</label>
                    <input id="areaofstudy" name="areaofstudy" type="text" class="required form-control" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->areaofstudy: '')}}" />
                  </div>
                  </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="dateofemployment">Date of Employment*</label>
                    <input id="dateofemployment" name="dateofemployment" type="text" class="required form-control datepicker" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->dateofemployment->format('d/m/Y'): '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="expectedretirementdate">Expected Retirement Date:*</label>
                    <input id="expectedretirementdate" name="expectedretirementdate" type="text" class="required form-control datepicker" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->expectedretirementdate: '')}}" />
                  </div>
           
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="typeofemployment">Type of Employment</label>
                    <select class="js-example-basic-single typeofemploymentfield" name="typeofemployment">
                      <option></option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->typeofemployment == 'Part-Time' ) ? 'selected' : '')}} value="Part-Time">Part-Time</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->typeofemployment == 'Full-Time' ) ? 'selected' : '')}} value="Full-Time">Full-Time</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->typeofemployment == 'Regular' ) ? 'selected' : '')}} value="Regular">Regular</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->typeofemployment == 'Irregular' ) ? 'selected' : '')}} value="Irregular">Irregular</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->typeofemployment == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="reporting_employee_id">Reporting Employee</label>
                    <select class="js-reporting_employee" name="reporting_employee_id" id="reporting_employee_id-dropdown">
                      <option></option>
                      @foreach($data as $dataemp)
                      <option {{ ( isset( $employee->official_information ) && ($employee->official_information->reporting_employee_id == $dataemp->id) ? 'selected' : '' ) }} value="{{ $dataemp->id }}">{{$dataemp->fname}}{{$dataemp->mname}}{{$dataemp->lname}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="role">Role</label>
                    <select class="js-example-basic-single" name="role">
                      <option>--Select Role--</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'HOD' ) ? 'selected' : '')}} value="HOD">HOD</option>
                      <option {{ ( isset($employee->official_information) && ( $employee->official_information->role == 'Employee' ) ? 'selected' : '')}} value="Employee">Employee</option>
                    </select>
                  </div> -->
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group" id="officialinfoshow">
                    <label for="officialinfoother">Other</label>
                    <input id="resetForm" name="officialinfoother" type="text" class="@if( isset( $official_information->typeofemployment ) && $official_information->typeofemployment != 'other' ) required @endif form-control" value="{{ (( isset($employee->official_information) ) ? $employee->official_information->officialinfoother: '')}}" />
                  </div>
                </div>
              </section>
              <h3>Residential</h3>
              <section>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="houseno">House No</label>
                    <input id="houseno" name="houseno" type="text" class="required form-control" value="{{ (( isset($employee->residentails) ) ? $employee->residentails->houseno: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="streetname">Street Name</label>
                    <input id="streetname" name="streetname" type="text" class="required form-control" value="{{ (( isset($employee->residentails) ) ? $employee->residentails->streetname: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="country">Country</label>
                    <select class="js-example-basic-single" name="residentialcountry" id="Residential-country-dropdown">
                      <option></option>
                      @foreach($countries as $residentialcountrys)
                      <option {{ ( isset( $employee->residentails) && ($employee->residentails->residentialcountry == $residentialcountrys->id) ? 'selected' : '' ) }} value="{{ $residentialcountrys->id }}">{{$residentialcountrys->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="nationality">Nationality</label>
                    <select class="js-example-basic-single" name="residentialnationality">
                      <option></option>
                      @foreach($nationalities as $nationality)
                      <option {{ ( isset( $employee->residentails) && ($employee->residentails->residentialnationality == $nationality->name) ? 'selected' : '' ) }} value="{{ $nationality->name }}">{{$nationality->name}}</option>
                      @endforeach
                    </select>
                  </div>

                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="state">State</label>
                    <select class="js-example-basic-single" id="residential-state-dropdown" name="residentialstate">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="localgoverment">Local Goverment</label>
                    <select class="js-example-basic-single" id="Residential-Local-Goverment" name="localgoverment">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="citytown">City/Town</label>
                    <select class="js-example-basic-single" id="residential-city-dropdown" name="citytown">
                      <option></option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="required form-control" value="{{ (( isset($employee->residentails) ) ? $employee->residentails->email: '')}}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="phone_no_1">Phone No 1</label>
                    <input id="phone_no_1" name="phone_no_1" type="text" class="form-control phoneno-inputmask" value="{{ (( isset($employee->residentails) ) ? $employee->residentails->phone_no_1: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="phone_no_2">Phone No 2</label>
                    <input id="phone_no_2" name="phone_no_2" type="text" class="form-control phoneno-inputmask" value="{{ (( isset($employee->residentails) ) ? $employee->residentails->phone_no_2: '')}}" />
                  </div>

                </div>
              </section>
              <h3>Kin Details</h3>
              <section>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" type="text" class="required form-control" value="{{ (( isset($employee->kin_details) ) ? $employee->kin_details->name: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="relationship">Relationship</label>
                    <select class="js-example-basic-single" name="relationship">
                      <option></option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Husband' ) ? 'selected' : '')}} value="Husband">Husband</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Wife' ) ? 'selected' : '')}} value="Wife">Wife</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Father' ) ? 'selected' : '')}} value="Father">Father</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Mother' ) ? 'selected' : '')}} value="Mother">Mother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Brother' ) ? 'selected' : '')}} value="Brother">Brother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Sister' ) ? 'selected' : '')}} value="Sister">Sister</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Paternal-Grand-Father' ) ? 'selected' : '')}} value="Paternal-Grand-Father">Paternal-Grand Father</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Paternal-Grand-Mother' ) ? 'selected' : '')}} value="Paternal-Grand-Mother">Paternal-Grand Mother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Maternal-Grand-Father' ) ? 'selected' : '')}} value="Maternal-Grand-Father">Maternal-Grand Father</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Maternal-Grand-Mother' ) ? 'selected' : '')}} value="Maternal-Grand-Mother">Maternal-Grand Mother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Uncle' ) ? 'selected' : '')}} value="Uncle">Uncle</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Aunt' ) ? 'selected' : '')}} value="Aunt">Aunt</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Brother' ) ? 'selected' : '')}} value="Brother">Brother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Sister' ) ? 'selected' : '')}} value="Sister">Sister</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Cousin' ) ? 'selected' : '')}} value="Cousin">Cousin</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Nephew' ) ? 'selected' : '')}} value="Nephew">Nephew</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Niece' ) ? 'selected' : '')}} value="Niece">Niece</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Son' ) ? 'selected' : '')}} value="Son">Son</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Daughter' ) ? 'selected' : '')}} value="Daughter">Daughter</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Step-Father' ) ? 'selected' : '')}} value="Step-Father">Step-Father</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Step-Mother' ) ? 'selected' : '')}} value="Step-Mother">Step-Mother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Step-Brother' ) ? 'selected' : '')}} value="Step-Brother">Step-Brother</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Step-Sister' ) ? 'selected' : '')}} value="Step-Sister">Step-Sister</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Friend' ) ? 'selected' : '')}} value="Friend">Friend</option>
                      <option {{ ( isset($employee->kin_details) && ( $employee->kin_details->relationship == 'Others' ) ? 'selected' : '')}} value="Others">Others</option>
                    </select>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label>Sex</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="kindetailssex" id="kindetailsmale" value="male" {{ ( isset( $employee->kin_details ) && $employee->kin_details->kindetailssex == 'male' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="kindetailssex" id="kindetailsfemale" value="female" {{ ( isset( $employee->kin_details ) && $employee->kin_details->kindetailssex == 'female' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="kindetailssex" id="kindetailsother" value="other" {{ ( isset( $employee->kin_details ) && $employee->kin_details->kindetailssex == 'other' ) ? 'checked' : '' }}>
                      <label class="form-check-label">Other</label>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="phoneno">Phone No</label>
                    <input id="phoneno" name="phoneno" type="text" class="required form-control phoneno-inputmask" value="{{ (( isset($employee->kin_details) ) ? $employee->kin_details->phoneno: '')}}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="email">Email</label>
                    <input id="email" name="kinemail" type="email" class="required form-control" value="{{ (( isset($employee->kin_details) ) ? $employee->kin_details->kinemail: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                    <label for="address">Address</label>
                    <input id="address" name="address" type="text" class="required form-control" value="{{ (( isset($employee->kin_details) ) ? $employee->kin_details->address: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="image">Kin Image</label>
                    <input id="kinimage" name="image" type="file" class="form-control" />
                    @error('image')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <div class="prview-image">                      
                      @if(isset($employee->kin_details->image) && $employee->kin_details->image != '' && $employee->kin_details->image != NULL)
                      <img id="image_preview" src="{{asset('public/images')}}/{{$employee->kin_details->image}}" alt="Kin Image" class="img-fluid" />
                      @else
                      @endif
                    </div>
                  </div>
                  
                </div>
              </section>
              <h3>Academic Qualification</h3>
                  <section>
                    @if( isset( $acadamicdata ) )
                  <?php $i = 0; ?>
                  @foreach($acadamicdata as $acadamicdatas)
                  <div class="controls" id="{{$i}}">
                    <?php if( $i != 0 ) { ?>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 d-flex controls-minus">                      
                        <a href="#" class="remove_this1 btn removeacadamicdates" data-delete-acadamicdates="{{ $acadamicdatas->id }}"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>
                      </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                        <label for="institutionname">Institution Name</label>
                        <input
                          id="inst_id"
                          name="inst_id[{{$i}}]"
                          type="hidden"
                          value="{{$acadamicdatas->id}}"
                        />
                        <input
                          id="institutionname"
                          name="institutionname[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $acadamicdatas->institutionname }}"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="institutioncategory">Institution Category</label>
                        <select class="js-example-basic-single itcat institutioncategoryfield{{$i}}" name="institutioncategory[{{$i}}]" data-id='{{$i}}'>
                             <option></option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Pre-Nursery') ) ? 'selected' : '' ) }} value="Pre-Nursery">Pre-Nursery</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Nusery') ) ? 'selected' : '' ) }} value="Nusery">Nusery</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Primary') ) ? 'selected' : '' ) }} value="Primary">Primary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Junior-Secondary') ) ? 'selected' : '' ) }} value="Junior-Secondary">Junior Secondary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Senior-Secondary') ) ? 'selected' : '' ) }} value="Senior-Secondary">Senior Secondary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Post-Secondary') ) ? 'selected' : '' ) }} value="Post-Secondary">Post Secondary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'NCE-Tertiary') ) ? 'selected' : '' ) }} value="NCE-Tertiary">NCE-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'HND-Tertiary') ) ? 'selected' : '' ) }} value="HND-Tertiary">HND-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'ND-Teriary') ) ? 'selected' : '' ) }} value="ND-Teriary">ND-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Post-Graduate-Diploma-Tertiary') ) ? 'selected' : '' ) }} value="Post-Graduate-Diploma-Tertiary">Post Graduate Diploma-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Certification-Tertiary') ) ? 'selected' : '' ) }} value="Certification-Tertiary">Certification-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Certification-Professional') ) ? 'selected' : '' ) }} value="Certification-Professional">Certification-Professional</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Undergraduate-Tertiary') ) ? 'selected' : '' ) }} value="Undergraduate-Tertiary">Undergraduate-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Post-Graduate-Tertiary') ) ? 'selected' : '' ) }} value="Post-Graduate-Tertiary">Post-Graduate-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'Honourary-Tertiary') ) ? 'selected' : '' ) }} value="Honourary-Tertiary">Honourary-Tertiary</option>
                             <option {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'other') ) ? 'selected' : '' ) }} value="other">Other</option>
                         </select>
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group" id="academicother{{$i}}">
                        <label for="academicother">Other</label>
                        <input
                          id="academicotheri"
                          name="academicother[{{$i}}]"
                          type="text"
                          class="form-control"
                          value="{{ $acadamicdatas->academicother }}" {{ ( ( ( isset($acadamicdatas->institutioncategory) && $acadamicdatas->institutioncategory == 'other') ) ? '' : 'readonly = readonly' ) }}
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="courseofstudy">Course of Study</label>
                        <input
                          id="courseofstudy"
                          name="courseofstudy[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $acadamicdatas->courseofstudy }}"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="certificateobtained">Certificate/Honours Obtained</label>
                        <input
                          id="certificateobtained"
                          name="certificateobtained[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $acadamicdatas->certificateobtained }}"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="programmeduration">Programme Start Date</label>
                        <input
                          id="date_picker1{{$i}}"
                          name="programmeduration[{{$i}}]"
                          type="text"
                          class="required form-control datepicker programmeduration"
                          value="{{ $acadamicdatas->programmeduration }}"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="programmedurationenddate">Programme End Date</label>
                        <input
                          id="date_picker2{{$i}}"
                          name="programmedurationenddate[{{$i}}]"
                          type="text"
                          class="required form-control datepicker programmedurationenddate"
                          value="{{ $acadamicdatas->programmedurationenddate }}"
                        />
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="acaduration">Duration</label>
                        <input
                          id="result{{$i}}"
                          name="acaduration[{{$i}}]"
                          type="text"
                          class="required form-control result"
                          value="{{ $acadamicdatas->acaduration }}"
                        />
                      </div>
                    </div>
                      <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="postheldandprojecthandled">Post Held/Project Handled</label>
                            <textarea class="form-control" id="postheldandprojecthandled" name="postheldandprojecthandled[{{$i}}]" rows="3" value="">{{ $acadamicdatas->postheldandprojecthandled }}</textarea>
                      </div>
                      <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                       <button type="" class="upload-btn">Upload Certificate</button>
                      </div> -->
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="academic_upload">Upload Certificate</label>
                        <input id="academic_upload{{$i}}" name="academic_upload[{{$i}}]" type="file" class="@if(!isset($acadamicdatas['academic_upload']) && $acadamicdatas['academic_upload'] == '' && $acadamicdatas['academic_upload'] == NULL) required @endif form-control academicupload" / value="{{ $acadamicdatas['academic_upload'] }}" onchange="readfileURL2(this);">
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        @if(isset($acadamicdatas->academic_upload) && $acadamicdatas->academic_upload != '' && $acadamicdatas->academic_upload != NULL)
                          <?php 
                            $imgname = strrchr($acadamicdatas->academic_upload,'.'); 
                            if($imgname == '.png') {
                          ?>
                          <a download="" id="doc_previews{{$i}}" class="docpreview" href="" ></a>
                          <div class="prview-image">
                            <img id="doc_previews_img{{$i}}" src="{{asset('public/files')}}/{{$acadamicdatas->academic_upload}}" class="img-height-100" />
                          </div>
                        <?php } else { ?>
                          <a download="{{isset($acadamicdatas->academic_upload_name) ? $acadamicdatas->academic_upload_name : $acadamicdatas->academic_upload }}" id="doc_previews{{$i}}" class="docpreview" href="{{asset('public/files')}}/{{$acadamicdatas->academic_upload}}" >{{isset($acadamicdatas->academic_upload_name) ? $acadamicdatas->academic_upload_name : $acadamicdatas->academic_upload }}</a>
                          <?php }  ?>
                          <div class="prview-image">
                            <img id="doc_previews_img{{$i}}" src="" class="img-height-100" />
                          </div>
                        @else 
                          <a download="" id="doc_previews{{$i}}" class="docpreview" href="" ></a>
                          <div class="prview-image">
                            <img id="doc_previews_img{{$i}}" src="" class="img-height-100" />
                          </div>
                        @endif
                      </div>
                      <div class="col-sm-3">
                        <label>&nbsp;</label>
                        @if(isset($acadamicdatas->academic_upload) && $acadamicdatas->academic_upload != '' && $acadamicdatas->academic_upload != NULL)
                          <a download="{{isset($acadamicdatas->academic_upload_name) ? $acadamicdatas->academic_upload_name : $acadamicdatas->academic_upload }}" id="download_previews{{$i}}" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$acadamicdatas->academic_upload}}" >Download</a>
                        @endif
                      </div> 
                      <!-- <div class="col-sm-3">
                        <label>&nbsp;</label>
                        @if(isset($acadamicdatas->courseofstudy) && $acadamicdatas->courseofstudy != '' && $acadamicdatas->courseofstudy != NULL)
                          <a id="aca_preview" class="download-btn" href="{{asset('public/files')}}/{{$acadamicdatas->courseofstudy}}">{{$acadamicdatas->courseofstudy}}</a>
                          @else
                           <a id="aca_preview" href="">Download</a>
                        @endif
                      </div>  -->
                    </div>
                  </div>
                    <?php $i++; ?>
                  @endforeach
                  @else
                  <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                        <label for="institutionname">Institution Name</label>
                        <input
                          id="institutionname"
                          name="institutionname[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="institutioncategory">Institution Category</label>
                        <select class="js-example-basic-single itcat institutioncategoryfield0" name="institutioncategory[0]" data-id=0 >
                             <option ></option>
                             <option value="Pre-Nursery">Pre-Nursery</option>
                             <option value="Nusery">Nusery</option>
                             <option value="Primary">Primary</option>
                             <option value="Junior-Secondary">Junior Secondary</option>
                             <option value="Senior-Secondary">Senior Secondary</option>
                             <option value="Post-Secondary">Post Secondary</option>
                             <option value="NCE-Tertiary">NCE-Tertiary</option>
                             <option value="HND-Tertiary">HND-Tertiary</option>
                             <option value="ND-Teriary">ND-Tertiary</option>
                             <option value="Post-Graduate-Diploma-Tertiary">Post Graduate Diploma-Tertiary</option>
                             <option value="Certification-Tertiary">Certification-Tertiary</option>
                             <option value="Certification-Professional">Certification-Professional</option>
                             <option value="Undergraduate-Tertiary">Undergraduate-Tertiary</option>
                             <option value="Post-Graduate-Tertiary">Post-Graduate-Tertiary</option>
                             <option value="Honourary-Tertiary">Honourary-Tertiary</option>
                             <option value="other">Other</option>
                         </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group" id="academicother0">
                        <label for="academicother">Other</label>
                        <input
                          id="academicotheri"
                          name="academicother[0]"
                          type="text"
                          class="form-control"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="courseofstudy">Course of Study</label>
                        <input
                          id="courseofstudy"
                          name="courseofstudy[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="certificateobtained">Certificate/Honours Obtained</label>
                        <input
                          id="certificateobtained"
                          name="certificateobtained[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="programmeduration">Programme Start Date</label>
                        <input
                          id="date_picker1"
                          name="programmeduration[0]"
                          type="text"
                          class="required form-control datepicker programmeduration"
                        />
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="programmedurationenddate">Programme End Date</label>
                        <input
                          id="date_picker2"
                          name="programmedurationenddate[0]"
                          type="text"
                          class="required form-control datepicker programmedurationenddate"
                        />
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="acaduration">Duration</label>
                        <input
                          id="result"
                          name="acaduration[0]"
                          type="text"
                          class="required form-control result"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="postheldandprojecthandled">Post Held/Project Handled</label>
                            <textarea class="form-control" id="postheldandprojecthandled" name="postheldandprojecthandled[0]" rows="3"></textarea>
                      </div>
                     <!--  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                       <button type="" class="upload-btn">Upload Certificate</button>
                      </div> -->
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="academic_upload">Upload Certificate</label>
                        <input id="academic_upload0" name="academic_upload[0]" type="file" class="required form-control academicupload" onchange="readfileURL2(this);" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <a id="doc_previews0" class="docpreview" href="" ></a>
                        <div class="prview-image">
                          <img id="doc_previews_img0" src="" class="img-height-100" />
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label>&nbsp;</label>                       
                          <a id="download_previews0" class="download-btn btn btn-primary" href="" >Download</a>
                      </div>                    
                    </div>
                    @endif
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
        <script>
        jQuery(document).ready( function () {
        var iaa = $('#steps-uid-0-p-4 .controls:nth-last-child(2)').attr('id');
          if (iaa != undefined) {
            var i = iaa;
          } else {
            var i = 0;
          }

          t= i;

          $('.itcat').change(function(){
            var attrs = $(this).attr('data-id');
            if($(this).val() == 'other') {
                $('#academicother'+''+ attrs).find('input').removeAttr('readonly'); 
            } else {
                $('#academicother'+''+ attrs).find('input').attr('readonly','true'); 
            } 
          });

        $("#append1").unbind().click( function(e) {
          ++i;
          e.preventDefault();
        var html = '<div class="controls">\
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group d-flex controls-minus">\
         <a href="#" class="remove_this1 btn"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>\
        </div>\
               <div class="row">\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">\
                        <label for="institutionname">Institution Name</label>\
                        <input\
                          id="institutionname"\
                          name="institutionname[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="institutioncategory">Institution Category</label>\
                       <select class="js-example-basic-single institutioncategoryfield'+i+'" name="institutioncategory[' + i + ']">\
                             <option></option>\
                             <option value="Pre-Nursery">Pre-Nursery</option>\
                             <option value="Nusery">Nusery</option>\
                             <option value="Primary">Primary</option>\
                             <option value="Junior-Secondary">Junior Secondary</option>\
                             <option value="Senior-Secondary">Senior Secondary</option>\
                             <option value="Post-Secondary">Post Secondary</option>\
                             <option value="NCE-Tertiary">NCE-Tertiary</option>\
                             <option value="HND-Tertiary">HND-Tertiary</option>\
                             <option value="ND-Tertiary">ND-Tertiary</option>\
                             <option value="Post-Graduate-Diploma-Tertiary">Post Graduate Diploma-Tertiary</option>\
                             <option value="Certification-Tertiary">Certification-Tertiary</option>\
                             <option value="Certification-Professional">Certification-Professional</option>\
                             <option value="Undergraduate-Tertiary">Undergraduate-Tertiary</option>\
                             <option value="Post-Graduate-Tertiary">Post-Graduate-Tertiary</option>\
                             <option value="Honourary-Tertiary">Honourary-Tertiary</option>\
                             <option value="other">Other</option>\
                         </select>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group" id="academicother'+i+'">\
                        <label for="academicother' + i + '">Other</label>\
                        <input\
                          id="academicotheri"\
                          name="academicother[' + i + ']"\
                          type="text"\
                          class="form-control"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="courseofstudy">Course of Study</label>\
                        <input\
                          id="courseofstudy"\
                          name="courseofstudy[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                    </div>\
                    <div class="row">\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="certificateobtained">Certificate/Honours Obtained</label>\
                        <input\
                          id="certificateobtained"\
                          name="certificateobtained[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="programmeduration">Programme Start Date</label>\
                        <input\
                          id="date_picker1' + i + '"\
                          name="programmeduration[' + i + ']"\
                          type="text"\
                          class="required form-control datepicker programmeduration"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="programmedurationenddate">Programme End Date</label>\
                        <input\
                          id="date_picker2' + i + '"\
                          name="programmedurationenddate[' + i + ']"\
                          type="text datepicker"\
                          class="required form-control datepicker programmedurationenddate"\
                        />\
                      </div>\
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="acaduration">Duration</label>\
                        <input\
                          id="result' + i + '"\
                          name="acaduration[' + i + ']"\
                          type="text"\
                          class="required form-control result"\
                        />\
                      </div>\
                    </div>\
                     <div class="row">\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="postheldandprojecthandled">Post Held/Project Handled</label>\
                            <textarea class="form-control" id="postheldandprojecthandled" name="postheldandprojecthandled[' + i + ']" rows="3"></textarea>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="academic_upload">Upload Certificate</label>\
                        <input id="academic_upload' + i + '" name="academic_upload[' + i + ']" type="file" class="required form-control academicupload" onchange="readfileURL2(this);" />\
                        @error('image')\
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>\
                        @enderror\
                        <a id="doc_previews' + i + '" class="docpreview" href="" ></a>\
                        <div class="prview-image">\
                          <img id="doc_previews_img' + i + '" src="" class="img-height-100" />\
                        </div>\
                      </div>\
                      <div class="col-sm-3">\
                        <label>&nbsp;</label>\
                        <a id="download_previews' + i + '" class="download-btn btn btn-primary" href="" >Download</a>\
                      </div>\
                    </div>\
                    </div>';
                  $(html).insertBefore('.inc1');
                  $('.js-example-basic-single').select2({
                        placeholder: "--Select--",
                        allowClear: true,
                        tags: true,
                        tokenSeparators: [',', ' '],
                  });
                    $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'd/m/yyyy'
                    });
                    $('.programmeduration').click(function() { 
                      var startDate;
                      var endDate;
                      $( ".programmeduration" ).datepicker({
                          dateFormat: 'd-m-yyyy'
                      });
                      $(".programmedurationenddate" ).datepicker({
                      dateFormat: 'd-m-yyyy'
                      });


                      var elmId = $(this).attr("id");
                      var elementID = "#"+elmId; 
                      $(elementID).change(function() {   
                        startDate = $(this).datepicker('getDate');
                        var elmId2 = $(this).parent().parent().find('.programmedurationenddate').attr('id');
                        var elementID2 = "#"+elmId2;    
                        $(elementID2).datepicker("option", "minDate", startDate );
                        var t1=$(elementID2).val();
                        t1=t1.split('/');
                        dt_t1=new Date(t1[2],t1[1]-1,t1[0]); // YYYY,mm,dd format to create date object
                        dt_t1_tm=dt_t1.getTime(); // time in milliseconds for day 1
                        var t2=$(elementID).val();
                        t2=t2.split('/');
                        dt_t2=new Date(t2[2],t2[1]-1,t2[0]); // YYYY,mm,dd format to create date object
                        dt_t2_tm=dt_t2.getTime(); // time in milliseconds for day 2
                        var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                        var diff_days=Math.abs((dt_t2_tm-dt_t1_tm)/one_day) // difference in days
                        if(isNaN(diff_days)) {
                          diff_days = 0
                        }
                        var result = $(this).parent().parent().find('.result').attr('id');
                        var resultid = "#"+result;
                        $(resultid).val("" + diff_days + "");
                        $(resultid).show();
                      })
                    });

                    $('.programmedurationenddate').click(function() { 
                      var startDate;
                      var endDate;
                      $( ".programmeduration" ).datepicker({
                          dateFormat: 'd-m-yyyy'
                      });
                      $(".programmedurationenddate" ).datepicker({
                      dateFormat: 'd-m-yyyy'
                      });

                      var elmIdend = $(this).attr("id");
                      var elementIDend = "#"+elmIdend; 
                      $(elementIDend).change(function() {
                        endDate = $(this).datepicker('getDate');
                        var elmIdend2 = $(this).parent().parent().find('.programmeduration').attr('id');
                        var elementIDend2 = "#"+elmIdend2;   
                        $(elementIDend2).datepicker("option", "maxDate", endDate );
                        var t1=$(elementIDend2).val();
                        t1=t1.split('/');
                        dt_t1=new Date(t1[2],t1[1]-1,t1[0]); // YYYY,mm,dd format to create date object
                        dt_t1_tm=dt_t1.getTime(); // time in milliseconds for day 1
                        var t2=$(elementIDend).val();
                        t2=t2.split('/');
                        dt_t2=new Date(t2[2],t2[1]-1,t2[0]); // YYYY,mm,dd format to create date object
                        dt_t2_tm=dt_t2.getTime(); // time in milliseconds for day 2
                        var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                        var diff_days=Math.abs((dt_t2_tm-dt_t1_tm)/one_day) // difference in days
                        if(isNaN(diff_days)) {
                          diff_days = 0
                        }
                        var result2 = $(this).parent().parent().find('.result').attr('id');
                        var resultid2 = "#"+result2;
                        $(resultid2).val("" + diff_days + "");
                        $(resultid2).show();
                      })

                    });
                // $("input[name=programmeduration[" + i + "]]").change(function(){
                //     var st = $("input[name=programmeduration[" + i + "]]").val();
                //     var ed = $("input[name=programmeduration[" + i + "]]").val();
                // });
                // $("input[name=programmedurationenddate[" + i + "]]").change(function(){
                //     var st = $("input[name=programmeduration[" + i + "]]").val();
                //     var ed = $("input[name=programmeduration[" + i + "]]").val();
                // });
              $('.institutioncategoryfield'+i).change(function(){
                  if($('.institutioncategoryfield'+i).val() == 'other') {
                      $('#academicother'+i+' input').removeAttr('readonly'); 
                  } else {
                      $('#academicother'+i+' input').attr('readonly','true'); 
                  } 
              });
                  return false;
                });

                jQuery(document).on('click', '.remove_this1', function() {
                jQuery(this).parent().parent().remove();
                return false;
                });
                // $("input[name=programmeduration[0]]").change(function(){
                //     var st = $("input[name=programmeduration[0]]").val();
                //     var ed = $("input[name=programmeduration[0]]").val();
                // });
                //  $("input[name=programmedurationenddate[0]").change(function(){
                //     var st = $("input[name=programmeduration[0]]").val();
                //     var ed = $("input[name=programmeduration[0]]").val();
                // });

                $("input[type=submit]").click(function(e) {
                e.preventDefault();
                $(this).next("[name=textbox]")
                .val(
                $.map($(".inc1 :text"), function(el) {
                return el.value
                   }).join(",\n")
                  )
                 })
               });
           </script>
            <div class="horizontal">
                <div class="control-group">
                    <div class="inc1">
                        <div class="controls">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 d-flex controls-plus form-group">
                            <button class="btn" type="button" id="append1" name="append1">
                            <i class="fas fa-plus-square fa-plus" aria-hidden="true"></i></button>
                            <h3>Add More Academic Qualifiction</h3>
                           </div>
                      </div>
                   </div>
               </div>             
                        </div>
                    </div><!-- academic qulification -->
                  </section>
                   <h3>Work Experience</h3>
                  <section>
                      @if( isset( $workdata ) )
                  <?php $i = 0; ?>
                  @foreach($workdata as $workdatas)
                  <div class="controls" id="{{$i}}">
                    <?php if( $i != 0 ) { ?>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 d-flex controls-minus">
                        <a href="#" class="remove_this1 btn removeacworkexp" data-delete-workexp="{{ $workdatas->id }}"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>
                      </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                        <label for="workinstitutionname">Institution Name</label>
                        <input
                          id="work_id"
                          name="work_id[{{$i}}]"
                          type="hidden"
                          value="{{ $workdatas->id }}"
                        />
                        <input
                          id="workinstitutionname"
                          name="workinstitutionname[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $workdatas->workinstitutionname }}"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workstartdate">Start Date</label>
                        <input
                          id="date_pickers3{{$i}}"
                          name="workstartdate[{{$i}}]"
                          type="text"
                          class="required form-control datepicker workstartdate"
                          value="{{ $workdatas->workstartdate }}"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workenddate">End Date</label>
                        <input
                          id="date_pickers4{{$i}}"
                          name="workenddate[{{$i}}]"
                          type="text"
                          class="required form-control datepicker workenddate"
                          value="{{ $workdatas->workenddate }}"
                        />
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workduration">Work Duration</label>
                        <input
                          id="workdurationresults{{$i}}"
                          name="workduration[{{$i}}]"
                          type="text"
                          class="required form-control workdurationresults"
                          value="{{ $workdatas->workduration }}"
                        />
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workdepartment">Category</label>
                        <select class="category_unit_work_experience" name="category_unit_work_experience[{{$i}}]" id="category_unit_work_experience">
                                        
                                            <option
                                                {{ isset($workdatas->category) && $workdatas->category == 'Academic' ? 'selected' : '' }}
                                                value="Academic">Academic</option>
                                            <option
                                                {{ isset($workdatas->category) && $workdatas->category == 'Non-Academic' ? 'selected' : '' }}
                                                value="Non-Academic">Non-Academic</option>
                                </select>
                      </div>

                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form" @if($workdatas->category == "Academic") style="display:block" @else style="display:none" @endif>
                        <label for="workdepartment">Department (Academic)</label>
                          <select id="workdepartment" name="workdepartment[{{$i}}]" class="workdepartment form-control">
                            <option></option>
                            @foreach($departments as $department)
                            <option {{ ( isset( $workdatas->workdepartment ) && ($workdatas->workdepartment == $department->id) ? 'selected' : '' ) }} value="{{ $department->id }}">{{$department->departmentname}}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form" @if($workdatas->category == "Academic") style="display:block" @else style="display:none" @endif>
                        <label for="workdesignation">Designation (Academic)</label>
                        <select id="workdesignation" name="workdesignation[{{$i}}]" class="workdesignation form-control">
                            <option></option>
                            @foreach($designations as $designation)
                            <option {{ ( isset( $workdatas->workdesignation ) && ($workdatas->workdesignation == $designation->id) ? 'selected' : '' ) }} value="{{ $designation->id }}">{{$designation->title}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form" @if($workdatas->category == "Non-Academic") style="display:block" @else style="display:none" @endif>
                        <label for="workdepartment">Department (Non-Academic)</label>
                        <select id="workdepartment_non_academic" name="workdepartment_non_academic[0]" class="workdepartment_non_academic form-control">
                          
                            @foreach($work_non_academic_departments as $department)
                            <option value="{{ $department->id }}">{{$department->departmentname}}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form" @if($workdatas->category == "Non-Academic") style="display:block" @else style="display:none" @endif>
                        <label for="workdesignation">Designation (Non-Academic)</label>
                        <select id="workdesignation_non_academic" name="workdesignation_non_academic[0]" class="workdesignation_non_academic form-control">
                       
                            @foreach($work_non_academic_designations as $designation)
                            <option value="{{ $designation->id }}">{{$designation->title}}</option>
                            @endforeach
                        </select>
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workpostheld">Post Held</label>
                        <input
                          id="workpostheld"
                          name="workpostheld[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $workdatas->workpostheld }}"
                       
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label>Grade Level</label>
                        <!-- <input
                          id="workgradelevel"
                          name="workgradelevel[{{$i}}]"
                          type="number"
                          class="required form-control"
                          value="{{ $workdatas->workgradelevel }}"
                         
                        /> -->
                    <select class="js-example-basic-single" name="workgradelevel[{{$i}}]">
                      <option></option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                      </div>
                    <!-- </div>
                    <div class="row"> -->
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label>Step</label>
                        <select class="js-example-basic-single" name="workstep[{{$i}}]">
                      <option></option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workcadre">Cadre</label>
                         <select class="js-example-basic-single" name="workcadre[{{$i}}]">
                          <option></option>
                            <optgroup label="generalist cadre">
                              <option {{ ( ( ( isset($workdatas->workcadre) && $workdatas->workcadre == 'administrative-class') ) ? 'selected' : '' ) }} value="administrative-class">administrative class</option>
                              <option {{ ( ( ( isset($workdatas->workcadre) && $workdatas->workcadre == 'executive-class') ) ? 'selected' : '' ) }} value="executive-class">executive class</option>
                              <option {{ ( ( ( isset($workdatas->workcadre) && $workdatas->workcadre == 'clerical-class') ) ? 'selected' : '' ) }} value="clerical-class">clerical class</option>
                              <option {{ ( ( ( isset($workdatas->workcadre) && $workdatas->workcadre == 'operative-class') ) ? 'selected' : '' ) }} value="operative-class">operative class</option>
                            </optgroup>
                            <optgroup label="specialist cadre">
                              <option {{ ( ( ( isset($workdatas->workcadre) && $workdatas->workcadre == 'specialist-cadre') ) ? 'selected' : '' ) }} value="specialist-cadre">specialist cadre</option>
                            </optgroup>
                         </select>
                      </div>
                    </div>
                  </div>
                  <?php $i++; ?>
                  @endforeach
                  @else
                   <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                        <label for="workinstitutionname">Institution Name</label>
                        <input
                          id="workinstitutionname"
                          name="workinstitutionname[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workstartdate">Start Date</label>
                        <input
                          id="date_pickers3"
                          name="workstartdate[0]"
                          type="text"
                          class="required form-control datepicker workstartdate"
                         
                        />
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workenddate">End Date</label>
                        <input
                          id="date_pickers4"
                          name="workenddate[0]"
                          type="text"
                          class="required form-control datepicker workenddate"
                          
                        />
                      </div>
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workduration">Work Duration</label>
                        <input
                          id="workdurationresults"
                          name="workduration[0]"
                          type="text"
                          class="required form-control workdurationresults"
                        />
                      </div>
                    </div>
                    <div class="row">
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="staff_id">Category</label>
                                <select class="category_unit_work_experience" name="category_unit_work_experience[]" id="category_unit_work_experience"
                                            @if (isset($employee->category)) disabled @endif>
                                            <option
                                                {{ isset($employee->category) && $employee->category == 'Academic' ? 'selected' : '' }}
                                                value="Academic">Academic</option>
                                            <option
                                                {{ isset($employee->category) && $employee->category == 'Non-Academic' ? 'selected' : '' }}
                                                value="Non-Academic">Non-Academic</option>
                                </select>
                       </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form">
                        <label for="workdepartment">Department (Academic)</label>
                        <select id="workdepartment" name="workdepartment[0]" required class="workdepartment form-control">
                            <option></option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{$department->departmentname}}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form">
                        <label for="workdesignation">Designation (Academic)</label>
                        <select id="workdesignation" name="workdesignation[0]" required class="workdesignation form-control">
                            <option></option>
                            @foreach($designations as $designation)
                            <option value="{{ $designation->id }}">{{$designation->title}}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form" style="display:none;">
                        <label for="workdepartment">Department (Non-Academic)</label>
                        <select id="workdepartment_non_academic" name="workdepartment_non_academic[0]" class="workdepartment_non_academic form-control">
                            <option></option>
                            @foreach($work_non_academic_departments as $department)
                            <option value="{{ $department->id }}">{{$department->departmentname}}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form" style="display:none;">
                        <label for="workdesignation">Designation (Non-Academic)</label>
                        <select id="workdesignation_non_academic" name="workdesignation_non_academic[0]" class="workdesignation_non_academic form-control">
                            <option></option>
                            @foreach($work_non_academic_designations as $designation)
                            <option value="{{ $designation->id }}">{{$designation->title}}</option>
                            @endforeach
                        </select>
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workpostheld">Post Held</label>
                        <input
                          id="workpostheld"
                          name="workpostheld[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workgradelevel">Grade Level</label>
                        <!-- <input
                          id="workgradelevel"
                          name="workgradelevel[0]"
                          type="number"
                          class="required form-control"
                        /> -->
                        <select class="js-example-basic-single" name="workgradelevel[0]">
                      <option></option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                      </div>
                        
                    <!-- </div>
                    <div class="row"> -->
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workstep">Step</label>
                        <!-- <input
                          id="workstep"
                          name="workstep[0]"
                          type="number"
                          class="required form-control"
                        /> -->
                        <select class="js-example-basic-single" name="workstep[0]">
                      <option></option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '1' ) ? 'selected' : '')}} value="1">1</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '2' ) ? 'selected' : '')}} value="2">2</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '3' ) ? 'selected' : '')}} value="3">3</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '4' ) ? 'selected' : '')}} value="4">4</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '5' ) ? 'selected' : '')}} value="5">5</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '6' ) ? 'selected' : '')}} value="6">6</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '7' ) ? 'selected' : '')}} value="7">7</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '8' ) ? 'selected' : '')}} value="8">8</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '9' ) ? 'selected' : '')}} value="9">9</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '10' ) ? 'selected' : '')}} value="10">10</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '11' ) ? 'selected' : '')}} value="11">11</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '12' ) ? 'selected' : '')}} value="12">12</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '13' ) ? 'selected' : '')}} value="13">13</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '14' ) ? 'selected' : '')}} value="14">14</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '15' ) ? 'selected' : '')}} value="15">15</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '16' ) ? 'selected' : '')}} value="16">16</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '17' ) ? 'selected' : '')}} value="17">17</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '18' ) ? 'selected' : '')}} value="18">18</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '19' ) ? 'selected' : '')}} value="19">19</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '20' ) ? 'selected' : '')}} value="20">20</option>
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == 'other' ) ? 'selected' : '')}} value="other">Other</option>
                    </select>
                      </div>
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="workcadre">Cadre</label>
                         <select class="js-example-basic-single" name="workcadre[0]">
                          <option></option>
                            <optgroup label="generalist cadre">
                              <option {{ ( isset( $employee->workdata->workcadre) == 'administrative-class' ? 'selected' : '')}} value="administrative-class">administrative class</option>
                              <option {{ ( isset( $employee->workdata->workcadre) == 'executive-class' ? 'selected' : '')}} value="executive-class">executive class</option>
                              <option {{ ( isset( $employee->workdata->workcadre) == 'clerical-class' ? 'selected' : '')}} value="clerical-class">clerical class</option>
                              <option {{ ( isset( $employee->workdata->workcadre) == 'operative-class' ? 'selected' : '')}} value="operative-class">operative class</option>
                            </optgroup>
                            <optgroup label="specialist cadre">
                              <option {{ ( isset( $employee->workdata->workcadre) == 'specialist-cadre' ? 'selected' : '')}} value="specialist-cadre">specialist cadre</option>
                            </optgroup>
                         </select>
                      </div>
                    </div>
                    @endif
                      <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
        <script>

        jQuery(document).ready( function () {
       //var iaa = $('.employee-page .row div.controls:last').attr('id');
       var iaa = $('#steps-uid-0-p-5 .controls:nth-last-child(2)').attr('id');
          //console.log(iaa);
          if (iaa != undefined) {
            var i = iaa;
          } else {
            var i = 0;
          }
        $("#append2").unbind().click( function(e) {
          ++i;
          e.preventDefault();
        var html = '<div class="controls">\
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group d-flex controls-minus">\
         <a href="#" class="remove_this2 btn"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>\
        </div>\
             <div class="row">\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">\
                        <label for="workinstitutionname">Institution Name</label>\
                        <input\
                          id="workinstitutionname"\
                          name="workinstitutionname[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workstartdate">Start Date</label>\
                        <input\
                          id="date_pickers3' + i + '"\
                          name="workstartdate[' + i + ']"\
                          type="text"\
                          class="required form-control datepicker workstartdate"\
                        />\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workenddate">End Date</label>\
                        <input\
                          id="date_pickers4' + i + '"\
                          name="workenddate[' + i + ']"\
                          type="text"\
                          class="required form-control datepicker workenddate"\
                        />\
                      </div>\
                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workduration">Work Duration</label>\
                        <input\
                          id="workdurationresults' + i + '"\
                          name="workduration[' + i + ']"\
                          type="text"\
                          class="required form-control workdurationresults"\
                        />\
                      </div>\
                    </div>\
                    <div class="row">\
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="category_unit_work_experience'+ i +'">Category</label>\
                        <select id="category_unit_work_experience'+ i +'" data-id="'+ i +'" name="category_unit_work_experience[' + i + ']" class="required form-control category_unit_work_experience">\
                             @if (isset($unit->category)) disabled @endif>\
                                <option {{ isset($unit->category) && $unit->category == 'Academic' ? 'selected' : '' }} value="Academic">Academic</option>\
                                <option {{ isset($unit->category) && $unit->category == 'Non-Academic' ? 'selected' : '' }} value="Non-Academic">Non-Academic</option>\
                          </select>\
                      </div>\
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form'+ i +'">\
                        <label for="workdepartment">Department (Academic)</label>\
                        <select id="workdepartment'+ i +'" name="workdepartment[' + i + ']" required class="workdepartment form-control">\
                            @foreach($departments as $department)\
                            <option value="{{ $department->id }}">{{$department->departmentname}}</option>\
                            @endforeach\
                          </select>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_academic_form'+ i +'">\
                        <label for="workdesignation">Designation (Academic)</label>\
                        <select id="workdesignation'+ i +'" name="workdesignation[' + i + ']" required class="workdesignation form-control">\
                            @foreach($designations as $designation)\
                            <option value="{{ $designation->id }}">{{$designation->title}}</option>\
                            @endforeach\
                        </select>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form'+ i +'" style="display:none">\
                        <label for="workdepartment_non_academic'+ i +'">Department (Non-Academic)</label>\
                        <select id="workdepartment_non_academic'+ i +'" name="workdepartment_non_academic[' + i + ']" class="workdepartment_non_academic form-control">\
                            <option></option>\
                            @foreach($work_non_academic_departments as $department)\
                            <option value="{{ $department->id }}">{{$department->departmentname}}</option>\
                            @endforeach\
                          </select>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group work_experience_non_academic_form'+ i +'" style="display:none">\
                        <label for="workdesignation_non_academic'+ i +'">Designation (Non-Academic)</label>\
                        <select id="workdesignation_non_academic'+ i +'" name="workdesignation_non_academic[' + i + ']" class="workdesignation_non_academic form-control">\
                            <option></option>\
                            @foreach($work_non_academic_designations as $designation)\
                            <option value="{{ $designation->id }}">{{$designation->title}}</option>\
                            @endforeach\
                        </select>\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workpostheld">Post Held</label>\
                        <input\
                          id="workpostheld"\
                          name="workpostheld[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workgradelevel">Grade Level</label>\
                        <select class="js-example-basic-single" name="workgradelevel[' + i + ']">\
                      <option></option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '1' ) ? 'selected' : '')}} value="1">1</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '2' ) ? 'selected' : '')}} value="2">2</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '3' ) ? 'selected' : '')}} value="3">3</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '4' ) ? 'selected' : '')}} value="4">4</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '5' ) ? 'selected' : '')}} value="5">5</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '6' ) ? 'selected' : '')}} value="6">6</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '7' ) ? 'selected' : '')}} value="7">7</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '8' ) ? 'selected' : '')}} value="8">8</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '9' ) ? 'selected' : '')}} value="9">9</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '10' ) ? 'selected' : '')}} value="10">10</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '11' ) ? 'selected' : '')}} value="11">11</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '12' ) ? 'selected' : '')}} value="12">12</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '13' ) ? 'selected' : '')}} value="13">13</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '14' ) ? 'selected' : '')}} value="14">14</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '15' ) ? 'selected' : '')}} value="15">15</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '16' ) ? 'selected' : '')}} value="16">16</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '17' ) ? 'selected' : '')}} value="17">17</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '18' ) ? 'selected' : '')}} value="18">18</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '19' ) ? 'selected' : '')}} value="19">19</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == '20' ) ? 'selected' : '')}} value="20">20</option>\
                      <option {{ ( isset($workdatas->workgradelevel) && ( $workdatas->workgradelevel == 'other' ) ? 'selected' : '')}} value="other">Other</option>\
                    </select>\
                      </div>\
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workstep">Step</label>\
                        <select class="js-example-basic-single" name="workstep[' + i + ']">\
                      <option></option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '1' ) ? 'selected' : '')}} value="1">1</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '2' ) ? 'selected' : '')}} value="2">2</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '3' ) ? 'selected' : '')}} value="3">3</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '4' ) ? 'selected' : '')}} value="4">4</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '5' ) ? 'selected' : '')}} value="5">5</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '6' ) ? 'selected' : '')}} value="6">6</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '7' ) ? 'selected' : '')}} value="7">7</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '8' ) ? 'selected' : '')}} value="8">8</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '9' ) ? 'selected' : '')}} value="9">9</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '10' ) ? 'selected' : '')}} value="10">10</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '11' ) ? 'selected' : '')}} value="11">11</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '12' ) ? 'selected' : '')}} value="12">12</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '13' ) ? 'selected' : '')}} value="13">13</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '14' ) ? 'selected' : '')}} value="14">14</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '15' ) ? 'selected' : '')}} value="15">15</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '16' ) ? 'selected' : '')}} value="16">16</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '17' ) ? 'selected' : '')}} value="17">17</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '18' ) ? 'selected' : '')}} value="18">18</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '19' ) ? 'selected' : '')}} value="19">19</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == '20' ) ? 'selected' : '')}} value="20">20</option>\
                      <option {{ ( isset($workdatas->workstep) && ( $workdatas->workstep == 'other' ) ? 'selected' : '')}} value="other">Other</option>\
                    </select>\
                      </div>\
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="workcadre">Cadre</label>\
                        <select class="js-example-basic-single" name="workcadre[' + i + ']">\
                        <option></option>\
                            <optgroup label="generalist cadre">\
                              <option {{ ( isset( $employee->workdata->workcadre) == 'administrative-class' ? 'selected' : '')}} value="administrative-class">administrative class</option>\
                              <option {{ ( isset( $employee->workdata->workcadre) == 'executive-class' ? 'selected' : '')}} value="executive-class">executive class</option>\
                              <option {{ ( isset( $employee->workdata->workcadre) == 'clerical-class' ? 'selected' : '')}} value="clerical-class">clerical class</option>\
                              <option {{ ( isset( $employee->workdata->workcadre) == 'operative-class' ? 'selected' : '')}} value="operative-class">operative class</option>\
                            </optgroup>\
                            <optgroup label="specialist cadre">\
                              <option {{ ( isset( $employee->workdata->workcadre) == 'specialist-cadre' ? 'selected' : '')}} value="specialist-cadre">specialist cadre</option>\
                            </optgroup>\
                         </select>\
                      </div>\
                      </div>\
                    </div>';

                $(html).insertBefore('.inc2');
                $('.js-example-basic-single').select2({
                      placeholder: "--Select--",
                      allowClear: true
                });
                $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'd/m/yyyy'
                });
                $('.workstartdate').click(function() {
                  var startDatework1;
                  var endDatework1;
                  $( ".workstartdate" ).datepicker({
                    dateFormat: 'd-m-yyyy'
                  });
                  $( ".workenddate" ).datepicker({
                    dateFormat: 'd-m-yyyy'
                  });
                  var elmIdwork = $(this).attr("id");
                  var elementIDwork = "#"+elmIdwork;
                  $(elementIDwork).change(function() {
                    startDatework1 = $(this).datepicker('getDate');
                    var elmIdwork2 = $(this).parent().parent().find('.workenddate').attr('id');
                    var elementIDwork2 = "#"+elmIdwork2;    
                    $(elementIDwork2).datepicker("option", "minDate", startDatework1 );
                    var t3=$(elementIDwork2).val();
                    t3=t3.split('/');
                    dt_t3=new Date(t3[2],t3[1]-1,t3[0]); // YYYY,mm,dd format to create date object
                    dt_t3_tm=dt_t3.getTime(); // time in milliseconds for day 1
                    var t4=$(elementIDwork).val();
                    t4=t4.split('/');
                    dt_t4=new Date(t4[2],t4[1]-1,t4[0]); // YYYY,mm,dd format to create date object
                    dt_t4_tm=dt_t4.getTime(); // time in milliseconds for day 2
                    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var diff_days=Math.abs((dt_t4_tm-dt_t3_tm)/one_day) // difference in days
                    if(isNaN(diff_days)) {
                      diff_days = 0
                    }
                    var resultwork = $(this).parent().parent().find('.workdurationresults').attr('id');
                    console.log(resultwork);
                    var resultidwork = "#"+resultwork;
                    $(resultidwork).val("" + diff_days + "");
                    $(resultidwork).show();
                  })
                });
                $('.workenddate').click(function() {
                  var startDatework1;
                  var endDatework1;  
                  $( ".workstartdate" ).datepicker({
                    dateFormat: 'd-m-yyyy'
                  });
                  $( ".workenddate" ).datepicker({
                    dateFormat: 'd-m-yyyy'
                  });
                  var elmIdworkend = $(this).attr("id");
                  var elementIDworkend = "#"+elmIdworkend;
                  $(elementIDworkend).change(function() {
                    endDatework1 = $(this).datepicker('getDate');
                    var elmIdworkend2 = $(this).parent().parent().find('.workstartdate').attr('id');
                    var elementIDworkend2 = "#"+elmIdworkend2;  
                    $(elementIDworkend2).datepicker("option", "maxDate", endDatework1 );
                    var t3=$(elementIDworkend2).val();
                    t3=t3.split('/');
                    dt_t3=new Date(t3[2],t3[1]-1,t3[0]); // YYYY,mm,dd format to create date object
                    dt_t3_tm=dt_t3.getTime(); // time in milliseconds for day 1
                    var t4=$(elementIDworkend).val();
                    t4=t4.split('/');
                    dt_t4=new Date(t4[2],t4[1]-1,t4[0]); // YYYY,mm,dd format to create date object
                    dt_t4_tm=dt_t4.getTime(); // time in milliseconds for day 2
                    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var diff_days=Math.abs((dt_t4_tm-dt_t3_tm)/one_day) // difference in days
                    if(isNaN(diff_days)) {
                      diff_days = 0
                    }
                    var resultwork2 = $(this).parent().parent().find('.workdurationresults').attr('id');
                    var resultidwork2 = "#"+resultwork2;
                    $(resultidwork2).val("" + diff_days + "");
                    $(resultidwork2).show();
                  })
                });
                $('.workdesignation').select2();
                $('.workdepartment').select2();
                  return false;
                });
                $('.workdepartment_non_academic').select2();
                $('.workdesignation_non_academic').select2();



                jQuery(document).on('click', '.remove_this2', function() {
                jQuery(this).parent().parent().remove();
                return false;
                });
                $("input[type=submit]").click(function(e) {
                e.preventDefault();
                $(this).next("[name=textbox]")
                .val(
                $.map($(".inc2 :text"), function(el) {
                return el.value
                   }).join(",\n")
                  )
                 })
               });
           </script>

<div class="horizontal">
    <div class="control-group">
        <div class="inc2">
            <div class="controls">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group d-flex controls-plus">
                <button class="btn" type="button" id="append2" name="append2">
                <i class="fas fa-plus-square fa-plus" aria-hidden="true"></i></button>
                <h3>Add More Academic Qualification</h3>
               </div>
          </div>
       </div>
   </div>
                         
            </div>
        </div> 
        <!-- work experience  -->
                  </section>
              <h3>Salary Details</h3>
              <section>
                <div class="row">
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="accountname">Account Name</label>
                    <input id="accountname" name="accountname" type="text" class="required form-control" value="{{ (( isset($employee->salary_details) ) ? $employee->salary_details->accountname: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                    <label for="bankname">Bank Name</label>
                    <input id="bankname" name="bankname" type="text" class="required form-control" value="{{ (( isset($employee->salary_details) ) ? $employee->salary_details->bankname: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="accountnumber">Account Number</label>
                    <input id="accountnumber" name="accountnumber" type="text" class="required form-control" value="{{ (( isset($employee->salary_details) ) ? $employee->salary_details->accountnumber: '')}}" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="bvn">BVN</label>
                    <input id="bvn" name="bvn" type="text" class="required form-control" value="{{ (( isset($employee->salary_details) ) ? $employee->salary_details->bvn: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="tin">TIN</label>
                    <input id="tin" name="tin" type="text" class="required form-control" value="{{ (( isset($employee->salary_details) ) ? $employee->salary_details->tin: '')}}" />
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                    <label for="uploadidcard">Upload ID Card</label>
                    <input id="uploadidcard" name="uploadidcard" type="file" class="@if(isset($employee->salary_details->uploadidcard) && $employee->salary_details->uploadidcard != '' && $employee->salary_details->uploadidcard != NULL) @else required @endif form-control" />
                    @error('image')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <div class="col-sm-3">
                      <label>&nbsp;</label>
                      @if(isset($employee->salary_details->uploadidcard) && $employee->salary_details->uploadidcard != '' && $employee->salary_details->uploadidcard != NULL)
                      <img id="image_preview1" src="{{asset('public/id_cards/')}}/{{$employee->salary_details->uploadidcard}}" alt="Salary Detail" class="img-fluid" />
                      @else
                      
                      @endif
                    </div>
                  </div>
                  
                  </div>
              </section>
               <h3>Referee Info</h3>
                  <section>
                    
                  @if( isset( $refeedata ) )
                  <?php $i = 0; ?>
                  @foreach($refeedata as $refeedatas)
                   <div class="controls" id="{{$i}}">
                    <?php if($i != 0) { ?>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 d-flex controls-minus">
                        <a href="#" class="remove_this1 btn removerefree" data-delete-removerefree="{{ $refeedatas->id }}"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>
                      </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_fullname">Full Name</label>
                        <input
                          id="referee_id"
                          name="referee_id[{{$i}}]"
                          type="hidden"
                          value="{{ $refeedatas['id'] }}"
                        />
                        <input
                          id="referee_info_fullname"
                          name="referee_info_fullname[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $refeedatas['referee_info_fullname'] }}"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_occupation">Occupation</label>
                        <input
                          id="referee_info_occupation"
                          name="referee_info_occupation[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $refeedatas['referee_info_occupation'] }}"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_postheld">Post Held</label>
                        <input
                          id="referee_info_postheld"
                          name="referee_info_postheld[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $refeedatas['referee_info_postheld'] }}"
                        />
                      </div>
                      </div>
                    <div class="row">
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_address">Address</label>
                        <input
                          id="referee_info_address"
                          name="referee_info_address[{{$i}}]"
                          type="text"
                          class="required form-control"
                          value="{{ $refeedatas['referee_info_address'] }}"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_phoneno">Phone No</label>
                        <input
                          id="referee_info_phoneno"
                          name="referee_info_phoneno[{{$i}}]"
                          type="text"
                          class="required form-control phoneno-inputmask"
                          value="{{ $refeedatas['referee_info_phoneno'] }}"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_email">Email</label>
                        <input
                          id="referee_info_email"
                          name="referee_info_email[{{$i}}]"
                          type="email"
                          class="required form-control"
                          value="{{ $refeedatas['referee_info_email'] }}"
                        />
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="refereeconsentletter">Referee Consent Letter</label>
                        <input
                          id="refereeconsentletter{{$i}}"
                          name="refereeconsentletter[{{$i}}]"
                          type="file"
                          class="@if(!isset($refeedatas['refereeconsentletter']) && $refeedatas['refereeconsentletter'] == '' && $refeedatas['refereeconsentletter'] == NULL) required @endif form-control refereeconsentletter"
                          value="{{ $refeedatas['refereeconsentletter'] }}"
                          onchange="readfileURL(this);"
                        />
                        @if(isset($refeedatas->refereeconsentletter) && $refeedatas->refereeconsentletter != '' && $refeedatas->refereeconsentletter != NULL)
                          <?php 
                            $refeeimgname = strrchr($refeedatas->refereeconsentletter,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="doc_preview{{$i}}" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="doc_preview_img{{$i}}" src="{{asset('public/files')}}/{{$refeedatas->refereeconsentletter}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($refeedatas->refereeconsentletter) ? $refeedatas->refereeconsentletter : $refeedatas->refereeconsentletter }}" id="doc_preview{{$i}}" class="docpreview" href="{{asset('public/files')}}/{{$refeedatas->refereeconsentletter}}" >{{isset($refeedatas->refereeconsentletter) ? $refeedatas->refereeconsentletter : $refeedatas->refereeconsentletter }}</a>  
                            <div class="prview-image">
                              <img id="doc_preview_img{{$i}}" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                        @else 
                          <a download="" id="doc_preview{{$i}}" class="docpreview" href="" ></a>
                          <div class="prview-image">
                            <img id="doc_preview_img{{$i}}" src="" class="img-height-100" />
                          </div>
                        @endif
                      </div> 
                      <div class="col-sm-3">
                        <label>&nbsp;</label>
                        @if(isset($refeedatas->refereeconsentletter) && $refeedatas->refereeconsentletter != '' && $refeedatas->refereeconsentletter != NULL)
                          <a download="{{isset($refeedatas->refereeconsentletter) ? $refeedatas->refereeconsentletter : $refeedatas->refereeconsentletter }}" id="download_preview{{$i}}" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$refeedatas->refereeconsentletter}}" >Download</a>
                        @endif
                      </div> 
                    </div>
                  </div>
                     <?php $i++; ?>
                  @endforeach
                  @else
                  <div class="row">
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_fullname">Full Name</label>
                        <input
                          id="referee_info_fullname"
                          name="referee_info_fullname[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_occupation">Occupation</label>
                        <input
                          id="referee_info_occupation"
                          name="referee_info_occupation[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_postheld">Post Held</label>
                        <input
                          id="referee_info_postheld"
                          name="referee_info_postheld[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                      </div>
                    <div class="row">
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_address">Address</label>
                        <input
                          id="referee_info_address"
                          name="referee_info_address[0]"
                          type="text"
                          class="required form-control"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_phoneno">Phone No</label>
                        <input
                          id="referee_info_phoneno"
                          name="referee_info_phoneno[0]"
                          type="text"
                          class="required form-control phoneno-inputmask"
                        />
                      </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                        <label for="referee_info_email">Email</label>
                        <input
                          id="referee_info_email"
                          name="referee_info_email[0]"
                          type="email"
                          class="required form-control"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="refereeconsentletter">Referee Consent Letter</label>
                        <input
                          id="refereeconsentletter0"
                          name="refereeconsentletter[0]"
                          type="file"
                          class="required form-control refereeconsentletter"
                          onchange="readfileURL(this);"
                        />
                        <a id="doc_preview0" class="docpreview" href="" ></a>
                        <div class="prview-image">
                          <img id="doc_preview_img0" src="" class="img-height-100" />
                        </div>
                      </div>
                      <div class="col-sm-3">
                          <a id="download_preview0" class="download-btn btn btn-primary" href="" >Download</a>
                      </div>
                    </div>
                    @endif
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
        <script>

        jQuery(document).ready( function () {
        //var iaa = $('.employee-page .row div.controls:last').attr('id');
        var iaa = $('#steps-uid-0-p-7 .controls:nth-last-child(2)').attr('id');
          //console.log(iaa);
          if (iaa != undefined) {
            var i = iaa;
          } else {
            var i = 0;
          }
        $("#append3").unbind().click( function(e) {
          ++i;
          e.preventDefault();
        var html = '<div class="controls">\
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group d-flex controls-minus">\
         <a href="#" class="remove_this3 btn"><i class="fas fa-minus-square fa-minus" aria-hidden="true"></i></a>\
        </div>\
             <div class="row">\
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_fullname">Full Name</label>\
                        <input\
                          id="referee_info_fullname"\
                          name="referee_info_fullname[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_occupation">Occupation</label>\
                        <input\
                          id="referee_info_occupation"\
                          name="referee_info_occupation[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_postheld">Post Held</label>\
                        <input\
                          id="referee_info_postheld"\
                          name="referee_info_postheld[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                      </div>\
                    <div class="row">\
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_address">Address</label>\
                        <input\
                          id="referee_info_address"\
                          name="referee_info_address[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_phoneno">Phone No</label>\
                        <input\
                          id="referee_info_phoneno"\
                          name="referee_info_phoneno[' + i + ']"\
                          type="text"\
                          class="required form-control phoneno-inputmask"\
                        />\
                      </div>\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="referee_info_email">Email</label>\
                        <input\
                          id="referee_info_email"\
                          name="referee_info_email[' + i + ']"\
                          type="text"\
                          class="required form-control"\
                        />\
                      </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">\
                        <label for="refereeconsentletter">Referee Consent Letter</label>\
                        <input\
                          id="refereeconsentletter' + i + '"\
                          name="refereeconsentletter[' + i + ']"\
                          type="file"\
                          class="required form-control refereeconsentletter"\
                          onchange="readfileURL(this);"\
                        />\
                        <a id="doc_preview' + i + '" class="docpreview" href="" ></a>\
                        <div class="prview-image">\
                          <img id="doc_preview_img' + i + '" src="" class="img-height-100" />\
                        </div>\
                      </div>\
                      <div class="col-sm-3">\
                        <label>&nbsp;</label>\
                        <a id="download_preview' + i + '" class="download-btn btn btn-primary" href="" >Download</a>\
                      </div>\
                      </div>\
                    </div>';

                  $(html).insertBefore('.inc3');
                  $(".phoneno-inputmask").inputmask("+999(9999999999)");
                  return false;
                });
                

                jQuery(document).on('click', '.remove_this3', function() {
                jQuery(this).parent().parent().remove();
                return false;
                });
                $("input[type=submit]").click(function(e) {
                e.preventDefault();
                $(this).next("[name=textbox]")
                .val(
                $.map($(".inc3 :text"), function(el) {
                return el.value
                   }).join(",\n")
                  )
                 })
               });
           </script>

<div class="horizontal">
    <div class="control-group">
        <div class="inc3">
            <div class="controls">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group d-flex controls-plus">
                <button class="btn" type="button" id="append3" name="append3">
                <i class="fas fa-plus-square fa-plus" aria-hidden="true"></i></button>
                <h3>Add More Referee Button</h3>
               </div>
          </div>
       </div>
   </div>
                         
            </div>
        </div><!-- academic qulification -->
       
                  </section>
                    <h3>Additional Certificate/Credentials</h3>
                    <section>
                    <div class="row">
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="birthcerticate">Birth Certificate</label>
                        <input id="birthcerticate" name="birthcerticate" type="file" class="form-control" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="col-sm-12">                          
                          @if(isset($employee->certi_details->birthcerticate) && $employee->certi_details->birthcerticate != '' && $employee->certi_details->birthcerticate != NULL)                          
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->birthcerticate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="birthcerticate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="birthcerticate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->birthcerticate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->birthcerticate) ? $employee->certi_details->birthcerticate : $employee->certi_details->birthcerticate }}" id="birthcerticate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->birthcerticate}}" >{{substr($employee->certi_details->birthcerticate, 12)}}</a>  
                            <div class="prview-image">
                              <img id="birthcerticate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->birthcerticate) && $employee->certi_details->birthcerticate != '' && $employee->certi_details->birthcerticate != NULL)
                            <a download="{{isset($employee->certi_details->birthcerticate) ? $employee->certi_details->birthcerticate : $employee->certi_details->birthcerticate }}" id="birth_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->birthcerticate}}" >Download</a>
                          @endif
                        </div> 
                      </div>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="professionalcertificate">Professional Certificate</label>
                        <input id="professionalcertificate" name="professionalcertificate" type="file" class="form-control" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->professionalcertificate) && $employee->certi_details->professionalcertificate != '' && $employee->certi_details->professionalcertificate != NULL)
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->professionalcertificate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="professionalcertificate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="professionalcertificate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->professionalcertificate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->professionalcertificate) ? $employee->certi_details->professionalcertificate : $employee->certi_details->professionalcertificate }}" id="professionalcertificate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->professionalcertificate}}" >{{substr($employee->certi_details->professionalcertificate, 12) }}</a>  
                            <div class="prview-image">
                              <img id="professionalcertificate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->professionalcertificate) && $employee->certi_details->professionalcertificate != '' && $employee->certi_details->professionalcertificate != NULL)
                            <a download="{{isset($employee->certi_details->professionalcertificate) ? $employee->certi_details->professionalcertificate : $employee->certi_details->professionalcertificate }}" id="professionalcertificate_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->professionalcertificate}}" >Download</a>
                          @endif
                        </div> 
                      </div>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="marriagecertificate">Marriage Certificate</label>
                        <input id="marriagecertificate" name="marriagecertificate" type="file" class="form-control" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->marriagecertificate) && $employee->certi_details->marriagecertificate != '' && $employee->certi_details->marriagecertificate != NULL)
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->marriagecertificate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="marriagecertificate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="marriagecertificate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->marriagecertificate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->marriagecertificate) ? $employee->certi_details->marriagecertificate : $employee->certi_details->marriagecertificate }}" id="marriagecertificate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->marriagecertificate}}" >{{ substr($employee->certi_details->marriagecertificate, 12) }}</a>  
                            <div class="prview-image">
                              <img id="marriagecertificate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->marriagecertificate) && $employee->certi_details->marriagecertificate != '' && $employee->certi_details->marriagecertificate != NULL)
                            <a download="{{isset($employee->certi_details->marriagecertificate) ? $employee->certi_details->marriagecertificate : $employee->certi_details->marriagecertificate }}" id="marriagecertificate_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->marriagecertificate}}" >Download</a>
                          @endif
                        </div> 
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="awardandhonorarycertificate">Award/Honorary Certificate</label>
                        <input id="awardandhonorarycertificate" name="awardandhonorarycertificate" type="file" class="form-control" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->awardandhonorarycertificate) && $employee->certi_details->awardandhonorarycertificate != '' && $employee->certi_details->awardandhonorarycertificate != NULL)
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->awardandhonorarycertificate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="awardandhonorarycertificate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="awardandhonorarycertificate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->awardandhonorarycertificate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->awardandhonorarycertificate) ? $employee->certi_details->awardandhonorarycertificate : $employee->certi_details->awardandhonorarycertificate }}" id="awardandhonorarycertificate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->awardandhonorarycertificate}}" >{{ substr($employee->certi_details->awardandhonorarycertificate, 12) }}</a>  
                            <div class="prview-image">
                              <img id="awardandhonorarycertificate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->awardandhonorarycertificate) && $employee->certi_details->awardandhonorarycertificate != '' && $employee->certi_details->awardandhonorarycertificate != NULL)
                            <a download="{{isset($employee->certi_details->awardandhonorarycertificate) ? $employee->certi_details->awardandhonorarycertificate : $employee->certi_details->awardandhonorarycertificate }}" id="awardandhonorarycertificate_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->awardandhonorarycertificate}}" >Download</a>
                          @endif
                        </div> 
                      </div>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="deathcertificate">Death Certificate</label>
                        <input id="deathcertificate" name="deathcertificate" type="file" class="form-control" />
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->deathcertificate) && $employee->certi_details->deathcertificate != '' && $employee->certi_details->deathcertificate != NULL)
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->deathcertificate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="deathcertificate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="deathcertificate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->deathcertificate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->deathcertificate) ? $employee->certi_details->deathcertificate : $employee->certi_details->deathcertificate }}" id="deathcertificate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->deathcertificate}}" >{{ substr($employee->certi_details->deathcertificate,12) }}</a>  
                            <div class="prview-image">
                              <img id="deathcertificate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->deathcertificate) && $employee->certi_details->deathcertificate != '' && $employee->certi_details->deathcertificate != NULL)
                            <a download="{{isset($employee->certi_details->deathcertificate) ? $employee->certi_details->deathcertificate : $employee->certi_details->deathcertificate }}" id="deathcertificate_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->deathcertificate}}" >Download</a>
                          @endif
                        </div> 
                      </div>
                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
                        <label for="othercertificate">Other Certificate</label>
                        <input id="othercertificate" name="othercertificate" type="file" class="form-control othercertificate" />  
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->othercertificate) && $employee->certi_details->othercertificate != '' && $employee->certi_details->othercertificate != NULL)
                          <?php 
                            $refeeimgname = strrchr($employee->certi_details->othercertificate,'.'); 
                            if($refeeimgname == '.png' || $refeeimgname == '.jpg' || $refeeimgname == '.jpeg') {
                          ?>
                            <a download="" id="othercertificate_preview" class="docpreview" href="">Download</a>
                            <div class="prview-image">
                              <img id="othercertificate_image_preview" src="{{asset('public/files')}}/{{$employee->certi_details->othercertificate}}" class="img-height-100" />
                            </div>
                          <?php } else { ?>
                            <a download="{{isset($employee->certi_details->othercertificate) ? $employee->certi_details->othercertificate : $employee->certi_details->othercertificate }}" id="othercertificate_preview" class="docpreview" href="{{asset('public/files')}}/{{$employee->certi_details->othercertificate}}" >{{substr($employee->certi_details->othercertificate, 12) }}</a>  
                            <div class="prview-image">
                              <img id="othercertificate_image_preview" src="" class="img-height-100" />
                            </div>                        
                          <?php }  ?>
                          @else
                          
                          @endif
                        </div>
                        <div class="col-sm-12">
                          @if(isset($employee->certi_details->othercertificate) && $employee->certi_details->othercertificate != '' && $employee->certi_details->othercertificate != NULL)
                            <a download="{{isset($employee->certi_details->othercertificate) ? $employee->certi_details->othercertificate : $employee->certi_details->othercertificate }}" id="othercertificate_download_preview" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$employee->certi_details->othercertificate}}" >Download</a>
                          @endif
                        </div>                       
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <label>Other Certificate Name</label>
                          <input type="text" name="certificatename" class="form-control certificatename" {{ isset($employee->certi_details->othercertificate)  ? "" : "disabled= 'disabled'" }} value="{{ (( isset($employee->certi_details->othercertificate) ) ? $employee->certi_details->certificatename: '')}}" >
                        </div>
                      </div>
                  </section>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>    
  // Basic Example with form
  var form = $("#example-form");
  form.validate({    
    rules: {
        image: {            
            extension: "png|jpg|jpeg"
        }
    },
    messages: {
        image: {
            extension:"Please select only png, jpg or jpeg files"
        }
    }
  });
  $.validator.addMethod("extension", function (value, element, param) {
      param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
      return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
  });
  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function(event, currentIndex, newIndex) {
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinishing: function(event, currentIndex) {
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function(event, currentIndex) {
      $("#example-form").submit();
    },
  });
  $(document).ready(function() {
    $('.js-example-basic-single').select2({
          placeholder: "--Select--",
          allowClear: true
    });
    $('.js-directorate').select2({
          placeholder: "--Select School/Directorate--",
          allowClear: true
    });
    $('.js-reporting_employee').select2({
          placeholder: "--Select Employee--",
          allowClear: true
    });
    $(".workdepartment").select2();
    $(".workdesignation").select2();
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.datepicker').datepicker({
      todayHighlight: true,
      format: 'd/m/yyyy'
    });
    $('#dateofbirth').datepicker({
      todayHighlight: true,
      format: 'yyyy/mm/dd'
    });
  });
  $(document).on('click', '.removeacadamicdates', function() {
    var data_dealers_buy = $(this).attr('data-delete-acadamicdates');   
    if (data_dealers_buy != '') {
      $.ajax({
        type: "POST",
        url: '{{ route("employee.removedealers") }}',
        data: {
          _token: "{{ csrf_token() }}",
          data_dealers_buy: data_dealers_buy,
        },
        success: function(response) {
        }
      });
    }
  });
  $(document).on('click', '.removeacworkexp', function() {
    var data_dealers_buy_workexp = $(this).attr('data-delete-workexp');    
    if (data_dealers_buy_workexp != '') {
      $.ajax({
        type: "POST",
        url: '{{ route("employee.removeworkexp") }}',
        data: {
          _token: "{{ csrf_token() }}",
          data_dealers_buy_workexp: data_dealers_buy_workexp,
        },
        success: function(response) {
        }
      });
    }
  });  
  $(document).on('click', '.removerefree', function() {
    var data_dealers_buy_removerefree = $(this).attr('data-delete-removerefree');    
    if (data_dealers_buy_removerefree != '') {
      $.ajax({
        type: "POST",
        url: '{{ route("employee.removerefree") }}',
        data: {
          _token: "{{ csrf_token() }}",
          data_dealers_buy_removerefree: data_dealers_buy_removerefree,
        },
        success: function(response) {
        }
      });
    }
  }); 
  $(document).on('change', '#employeeemail', function() {
    var email = $(this).val();
    if (isEmail(email)) {
      $.ajax({
        type: "POST",
        url: '{{ route("employee.checkemail") }}',
        data: {
          _token: "{{ csrf_token() }}",
          value: email,
          @if(isset($employee)) email: '{{$employee->employeeemail}}'@endif
        },
        dataType: "json",
        success: function(response) {
            if(response.status == 'fail'){
              $("#error").remove();
              $("#employeeemail").removeClass("error");
              $("#employeeemail").addClass("valid");
              $("#employeeemail").after('<label id="error" class="error">Email Already Taken.</label>');
              $("#employeeemail").removeClass("valid");
              $("#employeeemail").addClass("error");
            }else{
              $("#error").remove();
              $("#employeeemail").addClass("valid");
              $("#employeeemail").removeClass("error");
            }
        }
      });
    }else{
        $("#error").remove();
        $("#employeeemail").removeClass("error");
        $("#employeeemail").addClass("valid");
        $("#employeeemail").after('<label id="error" class="error">Please Enter Valid Email.</label>');
        $("#employeeemail").removeClass("valid");
        $("#employeeemail").addClass("error");
    }
  });

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#unmarried,#single,#other').click(function() {
      $('#spousename').attr('disabled', 'disabled');
      $('#spousename').removeClass('required');
      $('#spousename').removeClass('error');
    });
    $('#maritalstatus').click(function() {
      $('#spousename').removeAttr('disabled');
      $('#spousename').addClass('required');
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {   
    $('.othercertificate').click(function() {
      $('.certificatename').removeAttr('disabled');
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#single,#other').click(function() {
      $('#noofchildren').attr('disabled', 'disabled');
    });
    $('#unmarried').click(function() {
      $('#noofchildren').removeAttr('disabled');
    });
    $('#maritalstatus').click(function() {
      $('#noofchildren').removeAttr('disabled');
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var disabilitytypevalue = $("input[name='disability']:checked").val();
    if(disabilitytypevalue == 'No') {
      $('#disabilitytype').prop('disabled', true);
      $('#disabilitytype').select2('val',$('#disabilitytype').find('option:selected').val());
    }
    if(disabilitytypevalue == 'Yes') {
      $('#disabilitytype').prop('disabled', false);
    }
    $('#No').click(function() {      
      $('#disabilitytype').select2('val',$('#disabilitytype').find('option:selected').val());
      $('#disabilitytype').prop('disabled', true);
    });
    $('#Yes').click(function() {
       $('#disabilitytype').prop('disabled', false);
    });    
  });
</script>
<!-- Script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        //$('#image_preview').attr('src', e.target.result);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#image_preview').hide();
        }
        else {          
          $('#image_preview').show();
          $('#image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#kinimage").change(function() {
    readURL(this);
  });
  function readURL1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#image_preview1').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#uploadidcard").change(function() {
    readURL1(this);
  });
  function readURLcerti(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#birthcerticate_preview').attr('href', e.target.result);
        $('#birthcerticate_preview').attr('download', fileName);
        $('#birthcerticate_preview').text(fileName);
        $('#birth_download_preview').attr('href', e.target.result);
        $('#birth_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#birthcerticate_image_preview').hide();
          $('#birthcerticate_preview').show();
        }
        else {    
          $('#birthcerticate_preview').hide();      
          $('#birthcerticate_image_preview').show();
          $('#birthcerticate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#birthcerticate").change(function() {
    readURLcerti(this);
  });

  function readURLprof(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#professionalcertificate_preview').attr('href', e.target.result);
        $('#professionalcertificate_preview').attr('download', fileName);
        $('#professionalcertificate_preview').text(fileName);
        $('#professionalcertificate_download_preview').attr('href', e.target.result);
        $('#professionalcertificate_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#professionalcertificate_image_preview').hide();
          $('#professionalcertificate_preview').show();
        }
        else {    
          $('#professionalcertificate_preview').hide();      
          $('#professionalcertificate_image_preview').show();
          $('#professionalcertificate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#professionalcertificate").change(function() {
    readURLprof(this);
  });

  function readURLmrg(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#marriagecertificate_preview').attr('href', e.target.result);
        $('#marriagecertificate_preview').attr('download', fileName);
        $('#marriagecertificate_preview').text(fileName);
        $('#marriagecertificate_download_preview').attr('href', e.target.result);
        $('#marriagecertificate_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#marriagecertificate_image_preview').hide();
          $('#marriagecertificate_preview').show();
        }
        else {    
          $('#marriagecertificate_preview').hide();      
          $('#marriagecertificate_image_preview').show();
          $('#marriagecertificate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#marriagecertificate").change(function() {
    readURLmrg(this);
  });

  function readURLaward(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#awardandhonorarycertificate_preview').attr('href', e.target.result);
        $('#awardandhonorarycertificate_preview').attr('download', fileName);
        $('#awardandhonorarycertificate_preview').text(fileName);
        $('#awardandhonorarycertificate_download_preview').attr('href', e.target.result);
        $('#awardandhonorarycertificate_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#awardandhonorarycertificate_image_preview').hide();
          $('#awardandhonorarycertificate_preview').show();
        }
        else {    
          $('#awardandhonorarycertificate_preview').hide();      
          $('#awardandhonorarycertificate_image_preview').show();
          $('#awardandhonorarycertificate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#awardandhonorarycertificate").change(function() {
    readURLaward(this);
  });

  function readURLdeath(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#deathcertificate_preview').attr('href', e.target.result);
        $('#deathcertificate_preview').attr('download', fileName);
        $('#deathcertificate_preview').text(fileName);
        $('#deathcertificate_download_preview').attr('href', e.target.result);
        $('#deathcertificate_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#deathcertificate_image_preview').hide();
          $('#deathcertificate_preview').show();
        }
        else {    
          $('#deathcertificate_preview').hide();      
          $('#deathcertificate_image_preview').show();
          $('#deathcertificate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#deathcertificate").change(function() {
    readURLdeath(this);
  });

  function readURLother(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {        
        $('#othercertificate_preview').attr('href', e.target.result);
        $('#othercertificate_preview').attr('download', fileName);
        $('#othercertificate_preview').text(fileName);
        $('#othercertificate_download_preview').attr('href', e.target.result);
        $('#othercertificate_download_preview').attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#othercertificate_image_preview').hide();
          $('#othercertificate_preview').show();
        }
        else {    
          $('#othercertificate_preview').hide();      
          $('#othercertificate_image_preview').show();
          $('#othercertificate_image_preview').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#othercertificate").change(function() {
    readURLother(this);
  });

  function readfileURL(input) {
    var refer = $(input).attr('id');
    var res = refer.split("refereeconsentletter");
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {
        $('#doc_preview' + res[1]).attr('href', e.target.result);
        $('#doc_preview' + res[1]).attr('download', fileName);
        $('#doc_preview' + res[1]).text(fileName);
        $('#download_preview' + res[1]).attr('href', e.target.result);
        $('#download_preview' + res[1]).attr('download', fileName);

        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#doc_preview_img' + res[1]).hide();
          $('#doc_preview' + res[1]).show();
        }
        else {
          $('#doc_preview' + res[1]).hide();
          $('#doc_preview_img' + res[1]).show();
          $('#doc_preview_img' + res[1]).attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  function readfileURLS(input) {
    var refer = $(input).attr('id');
    var res = refer.split("courseofstudy");
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {
        $('#aca_preview' + res[1]).attr('href', e.target.result);
        $('#aca_preview' + res[1]).text(fileName);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#courseofstudy").change(function() {
    readfileURLS(this);
  });
</script>
<script> 
  $(document).ready(function() {
    $('#male,#female').click(function() {
      $('#otherfield').attr('disabled', 'disabled');
    });
    $('#othersex').click(function() {
      $('#otherfield').removeAttr('disabled');
    });
    $("input[name='disability']").change(function() {        
      if ($(this).val() == 'Yes') {
        $("input[name='disabilitytype']").addClass('required');
      } else {
        $("input[name='disabilitytype']").removeClass('required');
      }
    });
  });
  $(function() { 
    $('.typeofemploymentfield').change(function() {
      if ($('.typeofemploymentfield').val() == 'other') {
        $('#officialinfoshow').show();
      } else {
        $('#officialinfoshow').hide();
      }
    });
  });

  $(function() { 
    $('.institutioncategoryfield').change(function() {
      if ($('.institutioncategoryfield').val() == 'other') {
        $('#academicother').show();
      } else {
        $('#academicother').hide();
      }
    });
  });
  @if(isset($employee -> official_information) && $employee -> official_information -> typeofemployment == 'other')
  $("#officialinfoshow").show();
  @endif
  @if(isset($acadamicdatas -> institutioncategory) && $acadamicdatas -> institutioncategory == 'other')
  $('#academicother').show();
  @endif
</script>
<script>
  $(document).ready(function() {
    $('#country-dropdown').on('change', function() {
      var country_id = this.value;
      $("#state-dropdown").html('');
      $.ajax({
        url: "{{url('employee/state')}}",
        type: "POST",
        data: {
          country_id: country_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#state-dropdown').html('<option value="">Select State</option>');
          $.each(result.states, function(key, value) {
            $("#state-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $('#city-dropdown').html('<option value="">Select State First</option>');
        }
      });
    });
    $('#employeestatus').on('change', function() {
        var status = this.value;
        $('#dateofdeath').attr('disabled', 'disabled');
        $('#causeofdeath').attr('disabled', 'disabled');
        if(status == 'Dead'){
            $('#dateofdeath').removeAttr('disabled');
            $('#causeofdeath').removeAttr('disabled');
        }
    });
    @if(isset($employee -> state) && $employee -> state != NULL)
    var country_id = '{{$employee->country}}';
    $("#state-dropdown").html('');
    $.ajax({
      url: "{{url('employee/state')}}",
      type: "POST",
      data: {
        country_id: country_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#state-dropdown').html('<option value="">--Select State--</option>');
        var state = '{{$employee->state}}';
        $.each(result.states, function(key, value) {
          var selected = '';
          if (state == value.id) {
            var isselected = 'selected';
          }
          $("#state-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
        });
        $('#city-dropdown').html('<option value="">Select State First</option>');
      }
    });
    @endif
    $('#state-dropdown').on('change', function() {
      var state_id = this.value;
      $("#city-dropdown").html('');
      $.ajax({
        url: "{{url('employee/city')}}",
        type: "POST",
        data: {
          state_id: state_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#city-dropdown').html('<option value="">--Select City--</option>');
          $.each(result.cities, function(key, value) {
            $("#city-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
        }
      });
    });
    @if(isset($employee -> city) && $employee -> city != NULL)
    var state_id = '{{$employee->state}}';
    $("#city-dropdown").html('');
    $.ajax({
      url: "{{url('employee/city')}}",
      type: "POST",
      data: {
        state_id: state_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#city-dropdown').html('<option value="">Select City</option>');
        var city = '{{$employee->city}}';
        $.each(result.cities, function(key, value) {
          var selected = '';
          if (city == value.id) {
            var isselected = 'selected';
          }
          $("#city-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
        });
      }
    });
    @endif
    //For Localgoverment
    $('#state-dropdown').on('change', function() {
      var state_id = this.value;
      $("#Local-Goverment").html('');
      $.ajax({
        url: "{{url('employee/local-goverment')}}",
        type: "POST",
        data: {
          state_id: state_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#Local-Goverment').html('<option value="">--Select Local Government of Origin--</option>');
          $.each(result.local_governments, function(key, value) {
            $("#Local-Goverment").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
        }
      });
    });
    @if(isset($employee -> localgovermentoforigin) && $employee -> localgovermentoforigin != NULL)
    var state_id = '{{$employee->state}}';
    $("#Local-Goverment").html('');
    $.ajax({
      url: "{{url('employee/local-goverment')}}",
      type: "POST",
      data: {
        state_id: state_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#Local-Goverment').html('<option value="">--Select Local Government of Origin--</option>');
        var localgovermentoforigin = '{{$employee->localgovermentoforigin}}';
        $.each(result.local_governments, function(key, value) {
          var selected = '';
          if (localgovermentoforigin == value.id) {
            var isselected = 'selected';
          }
          $("#Local-Goverment").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
        });
      }
    });
    @endif
  });
</script>
<script>
  $('#Residential-country-dropdown').on('change', function() {
    var country_id = this.value;
    $("#residential-state-dropdown").html('');
    $.ajax({
      url: "{{url('employee/state')}}",
      type: "POST",
      data: {
        country_id: country_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#residential-state-dropdown').html('<option value="">Select State</option>');
        $.each(result.states, function(key, value) {
          $("#residential-state-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
        });
        $('#residential-city-dropdown').html('<option value="">Select State First</option>');
      }
    });
  });
  @if(isset($employee->residentails) && $employee->residentails->residentialstate != NULL)
  var country_id = '{{$employee->residentails->residentialcountry}}';
  $("#residential-state-dropdown").html('');
  $.ajax({
    url: "{{url('employee/state')}}",
    type: "POST",
    data: {
      country_id: country_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',
    success: function(result) {
      $('#residential-state-dropdown').html('<option value="">--Select State--</option>');
      var state = '{{$employee->residentails->residentialstate}}';
      $.each(result.states, function(key, value) {
        var selected = '';
        if (state == value.id) {
          var isselected = 'selected';
        }
        $("#residential-state-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
      });
      $('#residential-city-dropdown').html('<option value="">Select State First</option>');
    }
  });
  @endif
</script>
<script>
  $('#residential-state-dropdown').on('change', function() {
    var state_id = this.value;
    $("#residential-city-dropdown").html('');
    $.ajax({
      url: "{{url('employee/city')}}",
      type: "POST",
      data: {
        state_id: state_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#residential-city-dropdown').html('<option value="">--Select City--</option>');
        $.each(result.cities, function(key, value) {
          $("#residential-city-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
        });
      }
    });
  });
  @if(isset($employee->residentails) && $employee->residentails->citytown != NULL)
  var state_id = '{{$employee->residentails->residentialstate}}';
  $("#residential-city-dropdown").html('');
  $.ajax({
    url: "{{url('employee/city')}}",
    type: "POST",
    data: {
      state_id: state_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',
    success: function(result) {
      $('#residential-city-dropdown').html('<option value="">Select City</option>');
      var citytown = '{{$employee->residentails->citytown}}';
      $.each(result.cities, function(key, value) {
        var selected = '';
        if (citytown == value.id) {
          var isselected = 'selected';
        }
        $("#residential-city-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
      });
    }
  });
  @endif
</script>
<script>
  $('#residential-state-dropdown').on('change', function() {
    var state_id = this.value;
    $("#Residential-Local-Goverment").html('');
    $.ajax({
      url: "{{url('employee/local-goverment')}}",
      type: "POST",
      data: {
        state_id: state_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#Residential-Local-Goverment').html('<option value="">--Select Local Government--</option>');
        $.each(result.local_governments, function(key, value) {
          $("#Residential-Local-Goverment").append('<option value="' + value.id + '">' + value.name + '</option>');
        });
      }
    });
  });
  @if(isset($employee->residentails) && $employee->residentails->localgoverment != NULL)
  var state_id = '{{$employee->residentails->residentialstate}}';
  $("#Residential-Local-Goverment").html('');
  $.ajax({
    url: "{{url('employee/local-goverment')}}",
    type: "POST",
    data: {
      state_id: state_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',
    success: function(result) {
      $('#Residential-Local-Goverment').html('<option value="">--Select Local Government--</option>');
      var localgoverment = '{{$employee->residentails->localgoverment}}';
      $.each(result.local_governments, function(key, value) {
        var selected = '';
        if (localgoverment == value.id) {
          var isselected = 'selected';
        }
        $("#Residential-Local-Goverment").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
      });
    }
  });
  @endif
    Webcam.set({
        width: 350,
        height: 260,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            $("#imgs_delected img").attr('src',data_uri);
        } );
    }
</script>
<script>
  $(".js-select2").select2({
      closeOnSelect : false,
      placeholder : "--Select Disability--",
      allowHtml: true,
      allowClear: true,
      tags: true // создает новые опции на лету
    });
</script>
<script>
  function readfileURL2(input) {    
    var refer = $(input).attr('id');
    var res = refer.split("academic_upload");
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fileName = input.files[0].name;
      reader.onload = function(e) {
        $('#doc_previews' + res[1]).attr('href', e.target.result);
        $('#doc_previews' + res[1]).attr('download', fileName);
        $('#doc_previews' + res[1]).text(fileName);
        $('#download_previews' + res[1]).attr('href', e.target.result);
        $('#download_previews' + res[1]).attr('download', fileName);
        //var num = $(input).attr('class').split('-')[2];
        const file = input.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {          
          $('#doc_previews_img' + res[1]).hide();
          $('#doc_previews' + res[1]).show();
        }
        else {
          $('#doc_previews' + res[1]).hide();
          $('#doc_previews_img' + res[1]).show();
          $('#doc_previews_img' + res[1]).attr('src', e.target.result);
        }
        
      }
      reader.readAsDataURL(input.files[0]);
    }
    console.log(refer);
  }
</script>
<script>
  $('.itcat').change(function(){
            var attrs = $(this).attr('data-id');
            if($(this).val() == 'other') {
                $('#academicother'+''+ attrs).find('input').removeAttr('readonly'); 
            } else {
                $('#academicother'+''+ attrs).find('input').attr('readonly','true'); 
            } 
          });
</script>
<script>
$('.programmeduration').click(function() { 
  var startDate;
  var endDate;
  $( ".programmeduration" ).datepicker({
      dateFormat: 'd-m-yyyy'
  });
  $(".programmedurationenddate" ).datepicker({
  dateFormat: 'd-m-yyyy'
  });
  var elmId = $(this).attr("id");
  var elementID = "#"+elmId; 
  $(elementID).change(function() {   
    startDate = $(this).datepicker('getDate');
    var elmId2 = $(this).parent().parent().find('.programmedurationenddate').attr('id');
    var elementID2 = "#"+elmId2;    
    $(elementID2).datepicker("option", "minDate", startDate );
    var t1=$(elementID2).val();
    t1=t1.split('/');
    dt_t1=new Date(t1[2],t1[1]-1,t1[0]); // YYYY,mm,dd format to create date object
    dt_t1_tm=dt_t1.getTime(); // time in milliseconds for day 1
    var t2=$(elementID).val();
    t2=t2.split('/');
    dt_t2=new Date(t2[2],t2[1]-1,t2[0]); // YYYY,mm,dd format to create date object
    dt_t2_tm=dt_t2.getTime(); // time in milliseconds for day 2
    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
    var diff_days=Math.abs((dt_t2_tm-dt_t1_tm)/one_day) // difference in days
    if(isNaN(diff_days)) {
      diff_days = 0
    }
    var result = $(this).parent().parent().find('.result').attr('id');
    var resultid = "#"+result;
    $(resultid).val("" + diff_days + "");
    $(resultid).show();
  })
});
$('.programmedurationenddate').click(function() { 
  var startDate;
  var endDate;
  $( ".programmeduration" ).datepicker({
      dateFormat: 'd-m-yyyy'
  });
  $(".programmedurationenddate" ).datepicker({
  dateFormat: 'd-m-yyyy'
  });
  var elmIdend = $(this).attr("id");
  var elementIDend = "#"+elmIdend; 
  $(elementIDend).change(function() {
    endDate = $(this).datepicker('getDate');
    var elmIdend2 = $(this).parent().parent().find('.programmeduration').attr('id');
    var elementIDend2 = "#"+elmIdend2;   
    $(elementIDend2).datepicker("option", "maxDate", endDate );
    var t1=$(elementIDend2).val();
    t1=t1.split('/');
    dt_t1=new Date(t1[2],t1[1]-1,t1[0]); // YYYY,mm,dd format to create date object
    dt_t1_tm=dt_t1.getTime(); // time in milliseconds for day 1
    var t2=$(elementIDend).val();
    t2=t2.split('/');
    dt_t2=new Date(t2[2],t2[1]-1,t2[0]); // YYYY,mm,dd format to create date object
    dt_t2_tm=dt_t2.getTime(); // time in milliseconds for day 2
    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
    var diff_days=Math.abs((dt_t2_tm-dt_t1_tm)/one_day) // difference in days
    if(isNaN(diff_days)) {
      diff_days = 0
    }
    var result2 = $(this).parent().parent().find('.result').attr('id');
    var resultid2 = "#"+result2;
    $(resultid2).val("" + diff_days + "");
    $(resultid2).show();
  })
});
</script>
<script>
jQuery("#dateofbirth").change(function() {
  // dobvalue = jQuery(this).val();
  // var dbval = dobvalue.split('/');
  // var dobval = dbval[1]+'/'+dbval[0]+'/'+dbval[2];
  // dob = new Date(dobval);  
  // var today = new Date();
  // todaynew = new Date(today[2],today[1]-1,today[0]);
  // var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
  // if(isNaN(age)) {
  //     age = '';
  //   }
  // jQuery('#age').val(age);
  dobvalue = jQuery(this).val();
  // alert(dobvalue);
  var dbval = dobvalue.split('/');
  var dobval = dbval[1]+'/'+dbval[2]+'/'+dbval[0];
  // alert(dobval);
  dob = new Date(dobval);  
  var today = new Date();
  todaynew = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  var diff = todaynew - dob;

  if (isNaN(diff)) {
    jQuery('#age').val('');
    return;
  }
  var years = Math.floor(diff / (365.25 * 24 * 60 * 60 * 1000));
  diff -= years * (365.25 * 24 * 60 * 60 * 1000);
  var months = Math.floor(diff / (30.4375 * 24 * 60 * 60 * 1000));
  diff -= months * (30.4375 * 24 * 60 * 60 * 1000);
  var days = Math.floor(diff / (24 * 60 * 60 * 1000));
  var ageString = years + "Y" + months + "M" + days + "D";
  jQuery('#age').val(ageString);
});
$('.workstartdate').click(function() {
  var startDatework1;
  var endDatework1;
  $( ".workstartdate" ).datepicker({
    dateFormat: 'd-m-yyyy'
  });
  $( ".workenddate" ).datepicker({
    dateFormat: 'd-m-yyyy'
  });
  var elmIdwork = $(this).attr("id");
  var elementIDwork = "#"+elmIdwork;
  $(elementIDwork).change(function() {
    startDatework1 = $(this).datepicker('getDate');
    var elmIdwork2 = $(this).parent().parent().find('.workenddate').attr('id');
    var elementIDwork2 = "#"+elmIdwork2;    
    $(elementIDwork2).datepicker("option", "minDate", startDatework1 );
    var t3=$(elementIDwork2).val();
    t3=t3.split('/');
    dt_t3=new Date(t3[2],t3[1]-1,t3[0]); // YYYY,mm,dd format to create date object
    dt_t3_tm=dt_t3.getTime(); // time in milliseconds for day 1
    var t4=$(elementIDwork).val();
    t4=t4.split('/');
    dt_t4=new Date(t4[2],t4[1]-1,t4[0]); // YYYY,mm,dd format to create date object
    dt_t4_tm=dt_t4.getTime(); // time in milliseconds for day 2
    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
    var diff_days=Math.abs((dt_t4_tm-dt_t3_tm)/one_day) // difference in days
    if(isNaN(diff_days)) {
      diff_days = 0
    }
    var resultwork = $(this).parent().parent().find('.workdurationresults').attr('id');
    var resultidwork = "#"+resultwork;
    $(resultidwork).val("" + diff_days + "");
    $(resultidwork).show();
  })
});
$('.workenddate').click(function() {
  var startDatework1;
  var endDatework1;  
  $( ".workstartdate" ).datepicker({
    dateFormat: 'd-m-yyyy'
  });
  $( ".workenddate" ).datepicker({
    dateFormat: 'd-m-yyyy'
  });
  var elmIdworkend = $(this).attr("id");
  var elementIDworkend = "#"+elmIdworkend;
  $(elementIDworkend).change(function() {
    endDatework1 = $(this).datepicker('getDate');
    var elmIdworkend2 = $(this).parent().parent().find('.workstartdate').attr('id');
    var elementIDworkend2 = "#"+elmIdworkend2;  
    $(elementIDworkend2).datepicker("option", "maxDate", endDatework1 );
    var t3=$(elementIDworkend2).val();
    t3=t3.split('/');
    dt_t3=new Date(t3[2],t3[1]-1,t3[0]); // YYYY,mm,dd format to create date object
    dt_t3_tm=dt_t3.getTime(); // time in milliseconds for day 1
    var t4=$(elementIDworkend).val();
    t4=t4.split('/');
    dt_t4=new Date(t4[2],t4[1]-1,t4[0]); // YYYY,mm,dd format to create date object
    dt_t4_tm=dt_t4.getTime(); // time in milliseconds for day 2
    var one_day = 24*60*60*1000; // hours*minutes*seconds*milliseconds
    var diff_days=Math.abs((dt_t4_tm-dt_t3_tm)/one_day) // difference in days
    if(isNaN(diff_days)) {
      diff_days = 0
    }
    var resultwork2 = $(this).parent().parent().find('.workdurationresults').attr('id');
    var resultidwork2 = "#"+resultwork2;
    $(resultidwork2).val("" + diff_days + "");
    $(resultidwork2).show();
  })
});

$('#directorate-dropdown').on('change', function() {
  var directorate_id = this.value;  
  $("#department-dropdown").html('');
  $.ajax({
    url: "{{url('employee/department')}}",
    type: "POST",
    data: {
      directorate_id: directorate_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',

    success: function(result) {         
      $('#department-dropdown').html('<option value="">Select Department</option>');          
      $.each(result.departmentname, function(key, value) {
        $("#department-dropdown").append('<option value="' + value.id + '">' + value.departmentname + '</option>');
      });
      $('#unit-dropdown').html('<option value="">Select Department First</option>');
    }
  });
});
@if(isset($employee->official_information->department) && $employee->official_information->department != NULL)
  var directorate_id = '{{$employee->official_information->directorate}}';
  $("#department-dropdown").html('');
  $.ajax({
    url: "{{url('unit/department')}}",
    type: "POST",
    data: {
      directorate_id: directorate_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',
    success: function(result) {
      $('#department-dropdown').html('<option value="">--Select Department--</option>');
      var departname = '{{$employee->official_information->department}}';
      $.each(result.departmentname, function(key, value) {
        var selected = '';
        if (departname == value.id) {
          var isselected = 'selected';
        }
        $("#department-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.departmentname + '</option>');
      });
      // $('#unit-dropdown').html('<option value="">Select Department First</option>');
    }
  });
@endif

$('#department-dropdown').on('change', function() {
      var department_id = this.value;
      // console.log(department_id);
      $("#unit-dropdown").html('');
      $("#designation").html('');
      $.ajax({
        url: "{{url('employee/unit')}}",
        type: "POST",
        data: {
          department_id: department_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#unit-dropdown').html('<option value="">--Select Unit--</option>');
          $('#designation').html('<option value="">--Select designation--</option>');
          $.each(result.unit, function(key, value) {
            $("#unit-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $.each(result.desi, function(key, value) {
            $("#designation").append('<option value="' + value.id + '">' + value.title + '</option>');
          });
        }
      });
    });

    $('.category_unit').on('change', function() {
                var category_unit = $(this).val();
                if (category_unit == 'Academic') {
                    $('.academic_form').css('display', 'block');
                    $('.non_academic_form').css('display', 'none');
                    $('#directorate-dropdown').attr('required', true);
                    $('#department-dropdown').attr('required', true);
                    $('#designation').attr('required', true);
                    $('#unit-dropdown').attr('required', true);
                    $('#role').attr('required', true);
                    $('#department_non_Academic').attr('required', false);
                    $('#division_non_Academic').attr('required', false);
                    $('#role_non_Academic').attr('required', false);
                    $('#designation_non_Academic').attr('required', false);
                    $('#unit_non_Academic').attr('required', false);

                } else {
                    $('.academic_form').css('display', 'none');
                    $('.non_academic_form').css('display', 'block');

                    $('#directorate-dropdown').attr('required', false);
                    $('#department-dropdown').attr('required', false);
                    $('#designation').attr('required', false);
                    $('#unit-dropdown').attr('required', false);
                    $('#role').attr('required', false);

                    $('#department_non_Academic').attr('required', true);
                    $('#division_non_Academic').attr('required', true);
                    $('#role_non_Academic').attr('required', true);
                    $('#designation_non_Academic').attr('required', true);
                    $('#unit_non_Academic').attr('required', true);

                }


    });

@if(isset($employee->official_information->unit) && $employee->official_information->unit != NULL)
    var department_id = '{{$employee->official_information->department}}';
    $("#unit-dropdown").html('');
    $.ajax({
      url: "{{url('employee/unit')}}",
      type: "POST",
      data: {
        department_id: department_id,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        console.log(result);
        $('#unit-dropdown').html('<option value="">Select Unit</option>');
        var units = '{{$employee->official_information->unit}}';
        $.each(result.unit, function(key, value) {
          var selected = '';
          if (units == value.id) {
            var isselected = 'selected';
          }
          $("#unit-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
        });
      }
    });
@endif

@if(isset($employee->official_information->designation) && $employee->official_information->designation != NULL)
    var depa = '{{$employee->official_information->department}}';
    $("#designation").html('');
    $.ajax({
      url: "{{url('employee/unit')}}",
      type: "POST",
      data: {
        department_id: depa,
        _token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success: function(result) {
        $('#designation').html('<option value="">Select designation</option>');
        var designations = '{{$employee->official_information->designation}}';
        $.each(result.desi, function(key, value) {
          var selected = '';
          if (designations == value.id) {
            var isselected = 'selected';
          }
          $("#designation").append('<option value="' + value.id + '" ' + isselected + '>' + value.title + '</option>');
        });
      }
    });
@endif

$('#department_non_Academic').on('change', function() {
  var directorate_id = this.value;  
  $("#division_non_Academic").html('');
  $.ajax({
    url: "{{url('employee/division')}}",
    type: "POST",
    data: {
      directorate_id: directorate_id,
      _token: '{{csrf_token()}}'
    },
    dataType: 'json',

    success: function(result) {         
      $('#division_non_Academic').html('<option value="">Select Division</option>');          
      $.each(result.departmentname, function(key, value) {
        $("#division_non_Academic").append('<option value="' + value.id + '">' + value.departmentname + '</option>');
      });
      $('#unit_non_Academic').html('<option value="">Select Unit</option>');
    }
  });
});

$('#division_non_Academic').on('change', function() {
      var department_id = this.value;
      // console.log(department_id);
      $("#unit_non_Academic").html('');
      $("#designation_non_Academic").html('');
      $.ajax({
        url: "{{url('employee/non-academic-unit')}}",
        type: "POST",
        data: {
          department_id: department_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#unit_non_Academic').html('<option value="">--Select Unit--</option>');
          $('#designation_non_Academic').html('<option value="">--Select designation--</option>');
          $.each(result.unit, function(key, value) {
            $("#unit_non_Academic").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $.each(result.desi, function(key, value) {
            $("#designation_non_Academic").append('<option value="' + value.id + '">' + value.title + '</option>');
          });
        }
      });
    });
    
   



    $(document).on('change', '.category_unit_work_experience', function() {
    // $('.category_unit_work_experience').on('change', function() {
                var category_unit = $(this).val();
                 var id = $(this).data('id');
                 if (id > 0) {
                      if (category_unit == 'Academic') {
                        $(".work_experience_academic_form" + id).css('display', 'block');
                        $('.work_experience_non_academic_form' + id).css('display', 'none');

                        $('#workdepartment' + id).attr('required', true);
                        $('#workdesignation' + id).attr('required', true);
                    

                        $('#workdepartment_non_academic' + id).attr('required', false);
                        $('#workdesignation_non_academic' + id).attr('required', false);


                    } else {
                        $('.work_experience_academic_form' + id).css('display', 'none');
                        $('.work_experience_non_academic_form' + id).css('display', 'block');

                        $('#workdepartment' + id).attr('required', false);
                        $('#workdesignation' + id).attr('required', false);
            

                        $('#workdepartment_non_academic' + id).attr('required', true);
                        $('#workdesignation_non_academic' + id).attr('required', true);
                
                    }
                  
                 }else{
                      if (category_unit == 'Academic') {
                        $('.work_experience_academic_form').css('display', 'block');
                        $('.work_experience_non_academic_form').css('display', 'none');

                        $('#workdepartment').attr('required', true);
                        $('#workdesignation').attr('required', true);
                    

                        $('#workdepartment_non_academic').attr('required', false);
                        $('#workdesignation_non_academic').attr('required', false);


                    } else {
                        $('.work_experience_academic_form').css('display', 'none');
                        $('.work_experience_non_academic_form').css('display', 'block');

                        $('#workdepartment').attr('required', false);
                        $('#workdesignation').attr('required', false);
            

                        $('#workdepartment_non_academic').attr('required', true);
                        $('#workdesignation_non_academic').attr('required', true);
                
                    }

                 }
 
    });
        // if($('#department_non_Academic').val()){
        //   var directorate_id = $('#department_non_Academic').val() 
        //   $("#division_non_Academic").html('');
        //   $.ajax({
        //     url: "{{url('employee/division')}}",
        //     type: "POST",
        //     data: {
        //       directorate_id: directorate_id,
        //       _token: '{{csrf_token()}}'
        //     },
        //     dataType: 'json',

        //     success: function(result) {         
        //       $('#division_non_Academic').html('<option value="">Select Division</option>');          
        //       $.each(result.departmentname, function(key, value) {
        //         $("#division_non_Academic").append('<option value="' + value.id + '">' + value.departmentname + '</option>');
        //       });
        //       $('#unit_non_Academic').html('<option value="">Select Unit</option>');
        //     }
        //   });

        // }

            if ($('#category_unit').val()) {
                set_academic($('#category_unit').val());

            }

            function set_academic(category_unit) {
              if (category_unit == 'Academic') {
                    $('.academic_form').css('display', 'block');
                    $('.non_academic_form').css('display', 'none');
                    $('#directorate-dropdown').attr('required', true);
                    $('#department-dropdown').attr('required', true);
                    $('#designation').attr('required', true);
                    $('#unit-dropdown').attr('required', true);
                    $('#role').attr('required', true);
                    $('#department_non_Academic').attr('required', false);
                    $('#division_non_Academic').attr('required', false);
                    $('#role_non_Academic').attr('required', false);
                    $('#designation_non_Academic').attr('required', false);
                    $('#unit_non_Academic').attr('required', false);

                } else {
                    $('.academic_form').css('display', 'none');
                    $('.non_academic_form').css('display', 'block');

                    $('#directorate-dropdown').attr('required', false);
                    $('#department-dropdown').attr('required', false);
                    $('#designation').attr('required', false);
                    $('#unit-dropdown').attr('required', false);
                    $('#role').attr('required', false);

                    $('#department_non_Academic').attr('required', true);
                    $('#division_non_Academic').attr('required', true);
                    $('#role_non_Academic').attr('required', true);
                    $('#designation_non_Academic').attr('required', true);
                    $('#unit_non_Academic').attr('required', true);

                }
            }


</script>
@endsection
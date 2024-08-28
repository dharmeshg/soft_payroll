<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://softwiaamcl.com/public/assets/buttons.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>   


{{--@extends('layouts.institute')--}}
@extends('layouts.employee')
@section('content')
<style>
    .dtr-details{
      padding:0;
      list-style:none;
    }
    .dtr-details li{
      padding : 5px 0;
      border-bottom:1px solid #e3e3e3;
    }
    .dtr-details .dtr-title{
      font-weight:bold;
    }
    div.dt-button-collection{
      left:45px !important;
    }
    .collapsed .odd td:first-child, .even td:first-child{
      font-family: 'Font Awesome 5 Free';
      font-weight: 900;
    }
    .collapsed .odd td:first-child:before, .even td:first-child:before {
        content: "\f055";
    }
    .parent td:first-child:before {
        content: "\f056";
    }
    .select2-container {
        display: block;
        width: 100% !important;
    }

    .search-btn {
        margin-top: 31px;
    }
    table#employee_data th {
        font-weight: bold;
    }
    table#employee_data td {
        background: none;
    }
    .download-btn{
    color: #fff;
    font-size: 16px;
    line-height: 30px;
    border-radius: 2px;
    padding: 2px 24px!important;
    }
    a:hover{
        color: #fff;
    }
    .employee_history{
        background-color: #d1d5da;
    }
    li.parsley-required{
        float: left;
    position: absolute;
    bottom: 12px;
    }
    .btn{
        padding: 10px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered{
        overflow-y: scroll;
        height: 100%;
    }
    .table td, .table th{
        padding: 1em 0.5em;
    }
    .dt-buttons {
        top: 20px;
        right: 50px;
        position: absolute !important;
        border-radius: unset !important;
        
    }
    button.dt-button, div.dt-button, a.dt-button {
        line-height: 30px;
        height: 28px;
        padding: 1px 6px;
    }
    div.dt-buttons {
        padding: 0px;
        display: flex;
    }
    #employee_data ul{
      list-style: none;
    padding: 0px;
    }
    #employee_data ul li{
      padding: 5px 0;
    border-bottom: 1px solid #e3e3e3;
    }
    #employee_data .dtr-title{
      font-weight: bold;
    }
</style>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Employee Report</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content employee-content">
                <div class="employee-page">
                    <section>
                        <form method="post" data-parsley-validate="">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                                    <label for="faculty">School</label>
                                    <select id="faculty" name="faculty" class="faculty form-control" >
                                        <option value="">--Select School--</option>
                                        @if(isset($facultyfilter))
                                            @foreach($facultyfilter as $facultyfilters)
                                                <option <?php echo isset( $faculty_data) && $faculty_data == $facultyfilters['id']
                                            ? 'selected' : '' ?> value="{{ $facultyfilters->id }}">{{ isset($facultyfilters->facultyname) ? $facultyfilters->facultyname : '' }}
                                                </option>
                                            @endforeach
                                        @endif                                       
                                    </select>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                                    <label for="department">Department </label>
                                    <select id="department" name="department" class="department required form-control">
                                        <option value="">--Select Department--</option>
                                    </select>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                                    <label for="unit">Unit </label>
                                    <select id="unit" name="unit" class="unit required form-control">
                                        <option value="">--Select Unit--</option>  
                                    </select>
                                </div>                                
                                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 form-group">
                                    <label for="employee">Employee </label>
                                    <select id="employee" name="employee" class="employee required form-control">
                                        <option value="">--Select Employee--</option>
                                    </select>
                                </div>
                                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 form-group">
                                    <label for="filtecontnet">Column Name </label>
                                    <select id="filtecontnet" name="filtecontnet[]" class="filtecontnet required form-control" multiple="multiple">
                                        <option value="">--Select Column--</option>
                                        <option value="title" {{ isset($selectfiltecontnet) && in_array('title', $selectfiltecontnet) ? 'selected' : '' }}>Title</option>
                                        <option value="lastname" {{ isset($selectfiltecontnet) && in_array('lastname', $selectfiltecontnet) ? 'selected' : '' }}>Last Name</option>
                                        <option value="firstname" {{ isset($selectfiltecontnet) && in_array('firstname', $selectfiltecontnet) ? 'selected' : '' }}>First Name</option>
                                        <option value="middlename" {{ isset($selectfiltecontnet) && in_array('middlename', $selectfiltecontnet) ? 'selected' : '' }}>Middle Name</option>
                                        <option value="maidenname" {{ isset($selectfiltecontnet) && in_array('maidenname', $selectfiltecontnet) ? 'selected' : '' }}>Maiden Name</option>
                                        <option value="formername" {{ isset($selectfiltecontnet) && in_array('formername', $selectfiltecontnet) ? 'selected' : '' }}>Former Name</option>
                                        <option value="gender" {{ isset($selectfiltecontnet) && in_array('gender', $selectfiltecontnet) ? 'selected' : '' }}>Gender/Sex</option>
                                        <option value="maritalstatus" {{ isset($selectfiltecontnet) && in_array('maritalstatus', $selectfiltecontnet) ? 'selected' : '' }}>Marital Status</option>
                                        <option value="religion" {{ isset($selectfiltecontnet) && in_array('religion', $selectfiltecontnet) ? 'selected' : '' }}>Religion</option>
                                        <option value="disability" {{ isset($selectfiltecontnet) && in_array('disability', $selectfiltecontnet) ? 'selected' : '' }}>Disability</option>                                        
                                        <option value="localgovernmentoforigin"{{ isset($selectfiltecontnet) && in_array('localgovernmentoforigin', $selectfiltecontnet) ? 'selected' : '' }}>Local Government of Origin</option>
                                        <option value="designation" {{ isset($selectfiltecontnet) && in_array('designation', $selectfiltecontnet) ? 'selected' : '' }}>Designation</option>
                                        <option value="cadre" {{ isset($selectfiltecontnet) && in_array('cadre', $selectfiltecontnet) ? 'selected' : '' }}>Cadre</option>
                                        <option value="gradelevel" {{ isset($selectfiltecontnet) && in_array('gradelevel', $selectfiltecontnet) ? 'selected' : '' }}>Grade Level</option>
                                        <option value="step" {{ isset($selectfiltecontnet) && in_array('step', $selectfiltecontnet) ? 'selected' : '' }}>Step</option>
                                        <option value="age" {{ isset($selectfiltecontnet) && in_array('age', $selectfiltecontnet) ? 'selected' : '' }}>Age/Date of Birth</option>
                                        <option value="joindate" {{ isset($selectfiltecontnet) && in_array('joindate', $selectfiltecontnet) ? 'selected' : '' }}>join date</option>
                                        <option value="serviceyears" {{ isset($selectfiltecontnet) && in_array('serviceyears', $selectfiltecontnet) ? 'selected' : '' }}>Service Years</option>
                                        <option value="retirmentdate" {{ isset($selectfiltecontnet) && in_array('retirmentdate', $selectfiltecontnet) ? 'selected' : '' }}>Retirment date</option>
                                        <option value="spouse" {{ isset($selectfiltecontnet) && in_array('spouse', $selectfiltecontnet) ? 'selected' : '' }}>spouse</option>
                                        <option value="certificatesobtained" {{ isset($selectfiltecontnet) && in_array('certificatesobtained', $selectfiltecontnet) ? 'selected' : '' }}>certificates obtained</option>
                                        <option value="accountname" {{ isset($selectfiltecontnet) && in_array('accountname', $selectfiltecontnet) ? 'selected' : '' }}>Account Name</option>
                                        <option value="bankaname" {{ isset($selectfiltecontnet) && in_array('bankaname', $selectfiltecontnet) ? 'selected' : '' }}>bank Name</option>
                                        <option value="bvn" {{ isset($selectfiltecontnet) && in_array('bvn', $selectfiltecontnet) ? 'selected' : '' }}>BVN</option>
                                        <option value="tin" {{ isset($selectfiltecontnet) && in_array('tin', $selectfiltecontnet) ? 'selected' : '' }}>TIN</option>
                                        <option value="accountno" {{ isset($selectfiltecontnet) && in_array('accountno', $selectfiltecontnet) ? 'selected' : '' }}>Account No</option>
                                        <option value="nextofkin" {{ isset($selectfiltecontnet) && in_array('nextofkin', $selectfiltecontnet) ? 'selected' : '' }}>Name of Kin</option>
                                        <option value="employeeemail" {{ isset($selectfiltecontnet) && in_array('employeeemail', $selectfiltecontnet) ? 'selected' : '' }}>Employee Email</option>
                                        <option value="genotype" {{ isset($selectfiltecontnet) && in_array('genotype', $selectfiltecontnet) ? 'selected' : '' }}>GenoType</option>
                                        <option value="phoneno" {{ isset($selectfiltecontnet) && in_array('phoneno', $selectfiltecontnet) ? 'selected' : '' }}>Phone Number</option>
                                        
                                        <option value="bloodgroup" {{ isset($selectfiltecontnet) && in_array('bloodgroup', $selectfiltecontnet) ? 'selected' : '' }}>Blood Group</option>
                                        <option value="denomination" {{ isset($selectfiltecontnet) && in_array('denomination', $selectfiltecontnet) ? 'selected' : '' }}>Denomination</option>
                                        <option value="nationality" {{ isset($selectfiltecontnet) && in_array('nationality', $selectfiltecontnet) ? 'selected' : '' }}>Nationality</option>
                                        <!-- <option value="country" {{ isset($selectfiltecontnet) && in_array('country', $selectfiltecontnet) ? 'selected' : '' }}>Country</option> -->
                                        <option value="tribe" {{ isset($selectfiltecontnet) && in_array('tribe', $selectfiltecontnet) ? 'selected' : '' }}>Tribe</option>
                                        <option value="disabilitytype" {{ isset($selectfiltecontnet) && in_array('disabilitytype', $selectfiltecontnet) ? 'selected' : '' }}>Disability Status</option>
                                        <option value="employeestatus" {{ isset($selectfiltecontnet) && in_array('employeestatus', $selectfiltecontnet) ? 'selected' : '' }}>Employee Status</option>
                                        <!-- <option value="dateofdeath" {{ isset($selectfiltecontnet) && in_array('dateofdeath', $selectfiltecontnet) ? 'selected' : '' }}>Date of Death</option>
                                        <option value="causeofdeath" {{ isset($selectfiltecontnet) && in_array('causeofdeath', $selectfiltecontnet) ? 'selected' : '' }}>Cause of Death</option> -->
                                        
                                        <option value="noofchildren" {{ isset($selectfiltecontnet) && in_array('noofchildren', $selectfiltecontnet) ? 'selected' : '' }}>Number of Children</option>
                                        <option value="profile_image" {{ isset($selectfiltecontnet) && in_array('profile_image', $selectfiltecontnet) ? 'selected' : '' }}>Profile Image</option>
                                        <option value="staff_id" {{ isset($selectfiltecontnet) && in_array('staff_id', $selectfiltecontnet) ? 'selected' : '' }}>Staff ID</option>
                                        <option value="directorate" {{ isset($selectfiltecontnet) && in_array('directorate', $selectfiltecontnet) ? 'selected' : '' }}>Directorate/School</option>
                                        <option value="department" {{ isset($selectfiltecontnet) && in_array('department', $selectfiltecontnet) ? 'selected' : '' }}>Department</option>
                                        <option value="unit" {{ isset($selectfiltecontnet) && in_array('unit', $selectfiltecontnet) ? 'selected' : '' }}>Unit</option>
                                        <option value="postheldandprojecthandled" {{ isset($selectfiltecontnet) && in_array('postheldandprojecthandled', $selectfiltecontnet) ? 'selected' : '' }}>Post Held</option>
                                        
                                        <option value="highestqualification" {{ isset($selectfiltecontnet) && in_array('highestqualification', $selectfiltecontnet) ? 'selected' : '' }}>Highest Qualification</option>
                                        <option value="areaofstudy" {{ isset($selectfiltecontnet) && in_array('areaofstudy', $selectfiltecontnet) ? 'selected' : '' }}>Area of Study</option>
                                        <option value="expectedretirementdate" {{ isset($selectfiltecontnet) && in_array('expectedretirementdate', $selectfiltecontnet) ? 'selected' : '' }}>Expected Retirementdate</option>
                                        <option value="typeofemployment" {{ isset($selectfiltecontnet) && in_array('typeofemployment', $selectfiltecontnet) ? 'selected' : '' }}>Type of Employment</option>
                                        <option value="institutionname" {{ isset($selectfiltecontnet) && in_array('institutionname', $selectfiltecontnet) ? 'selected' : '' }}>Institution Attended Name</option>
                                        <option value="courseofstudy" {{ isset($selectfiltecontnet) && in_array('courseofstudy', $selectfiltecontnet) ? 'selected' : '' }}>Course of Study</option>
                                        <option value="programmeduration" {{ isset($selectfiltecontnet) && in_array('programmeduration', $selectfiltecontnet) ? 'selected' : '' }}>Programme StartDate</option>
                                        <option value="programmedurationenddate" {{ isset($selectfiltecontnet) && in_array('programmedurationenddate', $selectfiltecontnet) ? 'selected' : '' }}>programme EndDate</option>
                                        <option value="acaduration" {{ isset($selectfiltecontnet) && in_array('acaduration', $selectfiltecontnet) ? 'selected' : '' }}>Duration</option>
                                        <option value="workinstitutionname" {{ isset($selectfiltecontnet) && in_array('workinstitutionname', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Institution Name</option>
                                        <option value="workdepartment" {{ isset($selectfiltecontnet) && in_array('workdepartment', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Department</option>
                                        <option value="workdesignation" {{ isset($selectfiltecontnet) && in_array('workdesignation', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Designation</option>
                                        
                                        <option value="workcadre" {{ isset($selectfiltecontnet) && in_array('workcadre', $selectfiltecontnet) ? 'selected' : '' }}>Cadre</option>
                                        <option value="workgradelevel" {{ isset($selectfiltecontnet) && in_array('workgradelevel', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Grade Level</option>
                                        <option value="workpostheld" {{ isset($selectfiltecontnet) && in_array('workpostheld', $selectfiltecontnet) ? 'selected' : '' }}>Employeing PostHeld</option>
                                        <option value="workstartdate" {{ isset($selectfiltecontnet) && in_array('workstartdate', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Start Date</option>
                                        <option value="workenddate" {{ isset($selectfiltecontnet) && in_array('workenddate', $selectfiltecontnet) ? 'selected' : '' }}>Employeing End Date</option>
                                        <option value="workduration" {{ isset($selectfiltecontnet) && in_array('workduration', $selectfiltecontnet) ? 'selected' : '' }}>Employeing Duration</option>
                                        <option value="uploadidcard" {{ isset($selectfiltecontnet) && in_array('uploadidcard', $selectfiltecontnet) ? 'selected' : '' }}>ID Card</option>
                                        <option value="referee_info_fullname" {{ isset($selectfiltecontnet) && in_array('referee_info_fullname', $selectfiltecontnet) ? 'selected' : '' }}>Referee Name</option>
                                        <option value="referee_info_occupation" {{ isset($selectfiltecontnet) && in_array('referee_info_occupation', $selectfiltecontnet) ? 'selected' : '' }}>Occupation</option>
                                        <option value="referee_info_postheld" {{ isset($selectfiltecontnet) && in_array('referee_info_postheld', $selectfiltecontnet) ? 'selected' : '' }}>Referee Post Held</option>
                                        <option value="referee_info_phoneno" {{ isset($selectfiltecontnet) && in_array('referee_info_phoneno', $selectfiltecontnet) ? 'selected' : '' }}>Referee Phoneno</option>
                                        <option value="referee_info_email" {{ isset($selectfiltecontnet) && in_array('referee_info_email', $selectfiltecontnet) ? 'selected' : '' }}>Referee E-mail</option>
                                        <option value="listofcertificate" {{ isset($selectfiltecontnet) && in_array('listofcertificate', $selectfiltecontnet) ? 'selected' : '' }}>List of Certificates Uploaded</option>
                                        
                                        <!-- <option value="hometown" {{ isset($selectfiltecontnet) && in_array('hometown', $selectfiltecontnet) ? 'selected' : '' }}>HomeTown</option> -->
                                        <option value="country" {{ isset($selectfiltecontnet) && in_array('country', $selectfiltecontnet) ? 'selected' : '' }}>Country</option>     
                                        <option value="state" {{ isset($selectfiltecontnet) && in_array('state', $selectfiltecontnet) ? 'selected' : '' }}>State</option>
                                        <option value="city" {{ isset($selectfiltecontnet) && in_array('city', $selectfiltecontnet) ? 'selected' : '' }}>City</option>
                                        <option value="lga" {{ isset($selectfiltecontnet) && in_array('lga', $selectfiltecontnet) ? 'selected' : '' }}>LGA</option>
                                        
                                        
                                    </select>
                                </div>
                                <div
                                    class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 form-group search-button">
                                    <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-8 col-lg-8"><h5 class="card-title">Employee List</h5></div>
                </div> 
               
                  <div class="table-responsive">                   
                    @if(isset($data) && !empty($data) && count($data) > 0)
                    <table
                      id="employee_data"
                      class="table table-striped table-bordered"
                      style="width:100%">
                      <thead>
                        <tr>  
                            <th></th>
                            @if(isset($filtecontnet) && in_array("title", $filtecontnet))
                                <th>Title</th>
                            @endif                          
                            @if(isset($filtecontnet) && in_array("firstname", $filtecontnet))
                                <th>First Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("middlename", $filtecontnet))
                                <th>Middle Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("lastname", $filtecontnet))
                                <th>Last Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("maidenname", $filtecontnet))
                                <th>Maiden Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("formername", $filtecontnet))
                                <th>Former Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("gender", $filtecontnet))
                                <th>Gender/Sex</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("maritalstatus", $filtecontnet))
                                <th>Marital Status</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("religion", $filtecontnet))
                                <th>Religion</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("disability", $filtecontnet))
                                <th>Disability</th>
                            @endif
                            <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                <th>Country</th>
                            @endif -->
                            <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                <th>State</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                <th>LGA</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))                            
                                <th>City</th>
                            @endif -->
                            @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                <th>Home Town</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("designation", $filtecontnet))
                                <th>Designation</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("cadre", $filtecontnet))
                            <th>Cadre</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("gradelevel", $filtecontnet))
                            <th>Grade Level</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("step", $filtecontnet))
                            <th>Step</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("age", $filtecontnet))
                            <th>Age/Date of Birth</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("joindate", $filtecontnet))
                            <th>join date</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("serviceyears", $filtecontnet))
                            <th>Service Years</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("retirmentdate", $filtecontnet))
                            <th>Retirment date</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("spouse", $filtecontnet))
                            <th>spouse</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("certificatesobtained", $filtecontnet))
                            <th>certificates obtained</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("accountname", $filtecontnet))
                            <th>Account Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("bankaname", $filtecontnet))
                            <th>bank Name</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("bvn", $filtecontnet))
                            <th>BVN</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("tin", $filtecontnet))
                            <th>TIN</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("accountno", $filtecontnet))
                            <th>Account No</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("nextofkin", $filtecontnet))
                            <th>Next of Kin</th>     
                            @endif 
                            @if(isset($filtecontnet) && in_array("employeeemail", $filtecontnet))
                            <th>Employee Email</th>     
                            @endif   
                            @if(isset($filtecontnet) && in_array("genotype", $filtecontnet))
                            <th>Geno Type</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("phoneno", $filtecontnet))
                            <th>Phone Number</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("bloodgroup", $filtecontnet))
                            <th>Blood Group</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("denomination", $filtecontnet))
                            <th>Denomination</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("nationality", $filtecontnet))
                            <th>Nationality</th>     
                            @endif 
                            <!-- @if(isset($filtecontnet) && in_array("country", $filtecontnet))
                            <th>Country</th>     
                            @endif      -->
                            @if(isset($filtecontnet) && in_array("tribe", $filtecontnet))
                            <th>Tribe</th>     
                            @endif 
                            @if(isset($filtecontnet) && in_array("disabilitytype", $filtecontnet))
                            <th>Disability Status</th>     
                            @endif 
                            @if(isset($filtecontnet) && in_array("employeestatus", $filtecontnet))
                            <th>Employee Status</th>     
                            @endif    
                            @if(isset($filtecontnet) && in_array("noofchildren", $filtecontnet))
                            <th>Number of Children</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("profile_image", $filtecontnet))
                            <th>Profile Image</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("staff_id", $filtecontnet))
                            <th>Staff ID</th>     
                            @endif   
                            @if(isset($filtecontnet) && in_array("directorate", $filtecontnet))
                            <th>Directorate/School</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("department", $filtecontnet))
                            <th>Department</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("unit", $filtecontnet))
                            <th>Unit</th>     
                            @endif  
                            
                            @if(isset($filtecontnet) && in_array("postheldandprojecthandled", $filtecontnet))
                            <th>Post Held</th>     
                            @endif  

                            @if(isset($filtecontnet) && in_array("highestqualification", $filtecontnet))
                            <th>Highest Qualification</th>     
                            @endif  

                            @if(isset($filtecontnet) && in_array("areaofstudy", $filtecontnet))
                            <th>Area of Study</th>     
                            @endif  
                            @if(isset($filtecontnet) && in_array("expectedretirementdate", $filtecontnet))
                            <th> Expected Retirementdate</th>     
                            @endif 

                            @if(isset($filtecontnet) && in_array("typeofemployment", $filtecontnet))
                            <th>Type of Employment</th>     
                            @endif 

                            @if(isset($filtecontnet) && in_array("institutionname", $filtecontnet))
                            <th>Institution Attended Name</th>     
                            @endif 
                            
                            @if(isset($filtecontnet) && in_array("courseofstudy", $filtecontnet))
                            <th>Course of Study</th>     
                            @endif 
                            @if(isset($filtecontnet) && in_array("programmeduration", $filtecontnet))
                            <th>Programme StartDate</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("programmedurationenddate", $filtecontnet))
                            <th>Programme EndDate</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("acaduration", $filtecontnet))
                            <th>Duration</th>     
                            @endif
                        <!-- WorkExperiance modal -->
                            @if(isset($filtecontnet) && in_array("workinstitutionname", $filtecontnet))
                            <th>Employeing Institution Name</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workdepartment", $filtecontnet))
                            <th>Employeing Department</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workdesignation", $filtecontnet))
                            <th>Employeing Designation</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workcadre", $filtecontnet))
                            <th>Employeing Cadre</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workgradelevel", $filtecontnet))
                            <th>Employeing Grade Level</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workpostheld", $filtecontnet))
                            <th>Employeing PostHeld</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workstartdate", $filtecontnet))
                            <th>Employeing Start Date</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workenddate", $filtecontnet))
                            <th>Employeing End Date</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("workduration", $filtecontnet))
                            <th>Employeing Duration</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("uploadidcard", $filtecontnet))
                            <th>ID Card</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("referee_info_fullname", $filtecontnet))
                            <th>Referee Name</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("referee_info_occupation", $filtecontnet))
                            <th>Occupation</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("referee_info_postheld", $filtecontnet))
                            <th>Referee Post Held</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("referee_info_phoneno", $filtecontnet))
                            <th>Referee Phoneno</th>     
                            @endif
                            @if(isset($filtecontnet) && in_array("referee_info_email", $filtecontnet))
                            <th>Referee E-mail</th>     
                            @endif

                            @if(isset($filtecontnet) && in_array("listofcertificate", $filtecontnet))
                            <th>List of Certificates Uploaded</th>     
                            @endif 

                            <!-- @if(isset($filtecontnet) && in_array("hometown", $filtecontnet))
                                <th>HomeTown</th>
                            @endif -->
                            @if(isset($filtecontnet) && in_array("state", $filtecontnet))
                                <th>State</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("lga", $filtecontnet))
                                <th>LGA</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("city", $filtecontnet))                            
                                <th>City</th>
                            @endif
                            @if(isset($filtecontnet) && in_array("country", $filtecontnet))                            
                                <th>Country</th>
                            @endif
                            
                          

                        </tr>
                      </thead>
                      <tbody>  
                         @foreach($data as $key=>$Employee)
                            <tr>   
                                <td></td>  
                                @if(isset($filtecontnet) && in_array("title", $filtecontnet))
                                    <td>@if(isset($Employee->title)){{$Employee->title}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("firstname", $filtecontnet))
                                    <td>@if(isset($Employee->fname)){{$Employee->fname}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("middlename", $filtecontnet))
                                    <td>@if(isset($Employee->mname)){{$Employee->mname}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("lastname", $filtecontnet))
                                    <td>@if(isset($Employee->lname)){{$Employee->lname}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("maidenname", $filtecontnet))
                                    <td>@if(isset($Employee->maidenname)){{$Employee->maidenname}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("formername", $filtecontnet))
                                    <td>@if(isset($Employee->formername)){{$Employee->formername}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("gender", $filtecontnet))
                                    <td>@if(isset($Employee->sex)){{$Employee->sex}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("maritalstatus", $filtecontnet))
                                    <td>@if(isset($Employee->maritalstatus)){{$Employee->maritalstatus}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("religion", $filtecontnet))
                                    <td>@if(isset($Employee->religion)){{$Employee->religion}} @endif</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("disability", $filtecontnet))
                                    <td>@if(isset($Employee->disability)){{$Employee->disability}} @endif</td>
                                @endif
                                <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                    <td>@if(isset($Employee->countrys->name)){{$Employee->countrys->name}} @endif</td>
                                @endif -->
                                <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet)  )
                                    <td>@if( isset($Employee->states) ){{$Employee->states->name}} @endif</td>
                                @endif -->
                                <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                    <td>{{$Employee->lga}}</td>
                                @endif -->
                                <!-- @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet)) 
                                    <td> 
                                        @if(isset($Employee->cities->name))
                                           {{$Employee->cities->name}}
                                        @endif
                                    </td>
                                @endif -->
                                @if(isset($filtecontnet) && in_array("localgovernmentoforigin", $filtecontnet))
                                    <td>{{$Employee->hometown}}</td>     
                                @endif
                                @if(isset($filtecontnet) && in_array("designation", $filtecontnet))                           
                                    <td>{{$Employee->official_information->designations->title}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("cadre", $filtecontnet))
                                    <td>{{$Employee->official_information->cadre}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("gradelevel", $filtecontnet))
                                    <td>{{$Employee->official_information->gradelevel}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("step", $filtecontnet))
                                    <td>{{$Employee->official_information->step}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("age", $filtecontnet))
                                    <td>{{$Employee->dateofbirth->format('d/m/Y')}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("joindate", $filtecontnet))
                                    <td>{{$Employee->official_information->dateofemployment->format('d/m/Y')}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("serviceyears", $filtecontnet))
                                    <?php 
                                        $dateofemployment = $Employee->official_information->dateofemployment;
                                        $today = date('Y/m/d');
                                        $diff = date_diff(date_create($dateofemployment), date_create($today));
                                    ?>
                                    <td><?php  echo $diff->format('%y'); ?></td>                                    
                                @endif
                                @if(isset($filtecontnet) && in_array("retirmentdate", $filtecontnet))
                                    <td>{{ isset($Employee->official_information->expectedretirmentdate) && ($Employee->official_information->expectedretirmentdate != Null) ? $Employee->official_information->expectedretirmentdate->format('d/m/Y') : '-'}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("spouse", $filtecontnet))
                                    <td>{{isset($Employee->spousename) && ($Employee->spousename != Null) ? $Employee->spousename : '-'}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("certificatesobtained", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->academic_qualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->academic_qualification as $key=>$val)
                                            {{$val['certificateobtained']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif
                                @if(isset($filtecontnet) && in_array("accountname", $filtecontnet))
                                    <td>{{$Employee->salary_details->accountname}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("bankaname", $filtecontnet))
                                    <td>{{$Employee->salary_details->bankname}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("bvn", $filtecontnet))
                                    <td>{{$Employee->salary_details->bvn}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("tin", $filtecontnet))
                                    <td>{{$Employee->salary_details->tin}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("accountno", $filtecontnet))
                                    <td>{{$Employee->salary_details->accountnumber}}</td>
                                @endif
                                @if(isset($filtecontnet) && in_array("nextofkin", $filtecontnet))
                                    <td>Full Name: <strong>{{$Employee->kin_details->name}}</strong> , Relationship: <strong>{{$Employee->kin_details->relationship}}</strong>, Gender: <strong>{{$Employee->kin_details->kindetailssex}}</strong>, Phone Number: <strong>{{$Employee->kin_details->phone_no}}</strong>,  E-mail: <strong>{{$Employee->kin_details->kinemail}}</strong>, Image: <strong><img src="{{asset('public/images/'.$Employee->kin_details->image)}}" width="100px" height="100px" alt="KinImage"></strong></td>
                                @endif
                                @if(isset($filtecontnet) && in_array("employeeemail", $filtecontnet))
                                    <td>@if(isset($Employee->employeeemail)){{$Employee->employeeemail}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("genotype", $filtecontnet))
                                    <td>@if(isset($Employee->genotype)){{$Employee->genotype}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("phoneno", $filtecontnet))
                                    <td>@if(isset($Employee->phoneno)){{$Employee->phoneno}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("bloodgroup", $filtecontnet))
                                    <td>@if(isset($Employee->bloodgroup)){{$Employee->bloodgroup}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("denomination", $filtecontnet))
                                    <td>@if(isset($Employee->denomination)){{$Employee->denomination}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("nationality", $filtecontnet))
                                    <td>@if(isset($Employee->nationality)){{$Employee->nationality}} @endif</td>
                                @endif 
                                <!-- @if(isset($filtecontnet) && in_array("country", $filtecontnet))
                                    <td>@if(isset($Employee->country)){{$Employee->country}} @endif</td>
                                @endif  -->
                                @if(isset($filtecontnet) && in_array("tribe", $filtecontnet))
                                    <td>@if(isset($Employee->tribe)){{$Employee->tribe}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("disabilitytype", $filtecontnet))
                                    <td>@if(isset($Employee->disabilitytype)){{$Employee->disabilitytype}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("employeestatus", $filtecontnet))
                                    <td>@if(isset($Employee->employeestatus)){{$Employee->employeestatus}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("noofchildren", $filtecontnet))
                                    <td>@if(isset($Employee->noofchildren)){{$Employee->noofchildren}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("profile_image", $filtecontnet))
                                    <td>@if(isset($Employee->profile_image))<img src="/public/public/employee/{{$Employee->profile_image}}" width="300px" height="300px" alt="profile image"> @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("staff_id", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->staff_id)){{$Employee->official_information->staff_id}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("directorate", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->faculty_dt->facultyname)){{$Employee->official_information->faculty_dt->facultyname}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("department", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->departments_dt->departmentname)){{$Employee->official_information->departments_dt->departmentname}} @endif</td>
                                @endif 
                                @if(isset($filtecontnet) && in_array("unit", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->unit_dt->name)){{$Employee->official_information->unit_dt->name}} @endif</td>
                                @endif 

                                @if(isset($filtecontnet) && in_array("postheldandprojecthandled", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->academic_qualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->academic_qualification as $key=>$val)
                                            {{$val['postheldandprojecthandled']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif
                                
                                @if(isset($filtecontnet) && in_array("highestqualification", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->highestqualification)){{$Employee->official_information->highestqualification}} @endif</td>
                                @endif 

                                @if(isset($filtecontnet) && in_array("areaofstudy", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->areaofstudy)){{$Employee->official_information->areaofstudy}} @endif</td>
                                @endif 

                                @if(isset($filtecontnet) && in_array("expectedretirementdate", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->expectedretirementdate)){{$Employee->official_information->expectedretirementdate}} @endif</td>
                                @endif 

                                @if(isset($filtecontnet) && in_array("typeofemployment", $filtecontnet))
                                    <td>@if(isset($Employee->official_information->typeofemployment)){{$Employee->official_information->typeofemployment}} @endif</td>
                                @endif 
                                       
                                @if(isset($filtecontnet) && in_array("institutionname", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->AcademicQualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->AcademicQualification as $key=>$val)
                                            {{$val['institutionname']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("courseofstudy", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->AcademicQualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->AcademicQualification as $key=>$val)
                                            {{$val['courseofstudy']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("programmeduration", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->AcademicQualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->AcademicQualification as $key=>$val)
                                            {{$val['programmeduration']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("programmedurationenddate", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->AcademicQualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->AcademicQualification as $key=>$val)
                                            {{$val['programmedurationenddate']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("acaduration", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->AcademicQualification);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->AcademicQualification as $key=>$val)
                                            {{$val['acaduration']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workinstitutionname", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workinstitutionname']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workdepartment", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workdepartment']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workdesignation", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workdesignation']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workcadre", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workcadre']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workgradelevel", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workgradelevel']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workpostheld", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workpostheld']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workstartdate", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workstartdate']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workenddate", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workenddate']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("workduration", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->work_experiences);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->work_experiences as $key=>$val)
                                            {{$val['workduration']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("uploadidcard", $filtecontnet))
                                    <td>{{$Employee->salary_details->uploadidcard}}</td>
                                @endif

                                @if(isset($filtecontnet) && in_array("referee_info_fullname", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->Referee_infos);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->Referee_infos as $key=>$val)
                                            {{$val['referee_info_fullname']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("referee_info_occupation", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->Referee_infos);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->Referee_infos as $key=>$val)
                                            {{$val['referee_info_occupation']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("referee_info_postheld", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->Referee_infos);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->Referee_infos as $key=>$val)
                                            {{$val['referee_info_postheld']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("referee_info_phoneno", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->Referee_infos);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->Referee_infos as $key=>$val)
                                            {{$val['referee_info_phoneno']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("referee_info_email", $filtecontnet))
                                    <td>
                                        <?php
                                            $num_of_items = count($Employee->Referee_infos);
                                            $num_count = 0;
                                        ?>
                                        @foreach($Employee->Referee_infos as $key=>$val)
                                            {{$val['referee_info_email']}}  
                                            <?php 
                                            $num_count = $num_count + 1; 
                                            if ($num_count < $num_of_items) {
                                              echo ",";
                                            }
                                            ?>                                                                              
                                        @endforeach
                                    </td>
                                @endif

                                @if(isset($filtecontnet) && in_array("listofcertificate", $filtecontnet))
                                     @if(isset($Employee->certi_details))
                                        <td>
                                            @if(isset($Employee->certi_details->awardandhonorarycertificate))Awardandhonorary Certificate: <strong>{{$Employee->certi_details->awardandhonorarycertificate}}</strong><br>@endif
                                            @if(isset($Employee->certi_details->birthcerticate)) Birth Certificate: <strong>{{$Employee->certi_details->birthcerticate}}</strong><br>@endif
                                            @if(isset($Employee->certi_details->certificatename)) Certificate Name: <strong>{{$Employee->certi_details->certificatename}}</strong><br>@endif
                                            @if(isset($Employee->certi_details->deathcertificate)) Death Certificate: <strong>{{$Employee->certi_details->deathcertificate}}</strong><br>@endif
                                            @if(isset($Employee->certi_details->marriagecertificate)) Marriage Certificate: <strong>{{$Employee->certi_details->marriagecertificate}}</strong><br>@endif
                                            @if(isset($Employee->certi_details->professionalcertificate)) Professional Certificate: <strong>{{$Employee->certi_details->professionalcertificate}}</strong><br>@endif  
                                            @if(isset($Employee->certi_details->othercertificate)) Other Certificate: <strong>{{$Employee->certi_details->othercertificate}}</strong>@endif
                                        </td>
                                    @endif
                                @endif

                                @if(isset($filtecontnet) && in_array("country", $filtecontnet))
                                     <td>@if(isset($Employee->countrys->name)){{$Employee->countrys->name}} @endif</td>     
                                @endif
                                @if(isset($filtecontnet) && in_array("state", $filtecontnet))
                                    <td>@if( isset($Employee->states) ){{$Employee->states->name}} @endif</td>     
                                @endif
                                @if(isset($filtecontnet) && in_array("city", $filtecontnet))
                                    <td>
                                        @if(isset($Employee->cities->name))
                                           {{$Employee->cities->name}}
                                        @endif
                                    </td>     
                                @endif
                                @if(isset($filtecontnet) && in_array("lga", $filtecontnet))
                                    <td>@if(isset($Employee->lga)){{$Employee->lga}}@endif</td>     
                                @endif

                            </tr>
                            </tr>
                            </tr>
                        @endforeach
                       
                       
                    </table>
                    @else
                        <h3>No data found</h3>
                    @endif
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.colVis.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.print.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.html5.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/dataTables.buttons.min.js"></script>
    <script data-require="datatables-responsive@*" data-semver="2.1.0" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script>
jQuery(document).ready(function () {
    jQuery('.faculty').select2();
    jQuery('.department').select2();
    jQuery('.unit').select2();
    jQuery('.employee').select2();
    jQuery('.filtecontnet').select2();
    $('#faculty').on('change', function() {
      var directorate_id = this.value;  
      //alert(directorate_id);
      $("#department").html('');
      $.ajax({
        url: "{{url('employee/department')}}",
        type: "POST",
        data: {
          directorate_id: directorate_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#department').html('<option value="">Select Department</option>');          
          $.each(result.departmentname, function(key, value) {
            $("#department").append('<option value="' + value.id + '">' + value.departmentname + '</option>');
          });
          $('#unit').html('<option value="">Select Department First</option>');
          $('#employee').html('<option value="">Select Unit First</option>');
        }
      });
    });
    @if(isset($faculty_data) && $faculty_data != NULL)
        var directorate_id = '{{$faculty_data}}';
        $("#department").html('');
        $.ajax({
          url: "{{url('employee/department')}}",
          type: "POST",
          data: {
            directorate_id: directorate_id,
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(result) {
            $('#department').html('<option value="">Select Department</option>');
            var department_data = '{{$department_data}}';
            $.each(result.departmentname, function(key, value) {
              var selected = '';
              if (department_data == value.id) {
                var isselected = 'selected';
              }
              $("#department").append('<option value="' + value.id + '" ' + isselected + '>' + value.departmentname + '</option>');
            });
          }
        });
    @endif
    $('#department').on('change', function() {
      var department_id = this.value;  
      $("#unit").html('');
      $.ajax({
        url: "{{url('employee/unit')}}",
        type: "POST",
        data: {
          department_id: department_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#unit').html('<option value="">Select Unit</option>');          
          $.each(result.unit, function(key, value) {
            $("#unit").append('<option value="' + value.id + '">' + value.name + '</option>');
          });          
          $('#employee').html('<option value="">Select Unit First</option>');
        }
      });
    });
    @if(isset($department_data) && $department_data != NULL)
        var department_id = '{{$department_data}}';
        $("#unit").html('');
        $.ajax({
          url: "{{url('employee/unit')}}",
          type: "POST",
          data: {
            department_id: department_id,
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(result) {
            $('#unit').html('<option value="">Select Unit</option>');
            var unit_data = '{{$unit_data}}';
            $.each(result.unit, function(key, value) {
              var selected = '';
              if (unit_data == value.id) {
                var isselected = 'selected';
              }
              $("#unit").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
            });
          }
        });
    @endif
    $('#unit').on('change', function() {
      var unit_id = this.value;  
      $("#employee").html('');
      $.ajax({
        url: "{{url('employee/employeelist')}}",
        type: "POST",
        data: {
          unit_id: unit_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#employee').html('<option value="">Select Unit</option>');          
          $.each(result.employeename, function(key, value) {
            $("#employee").append('<option value="' + value.id + '">' + value.title + value.fname + value.mname + value.lname + value.staff_id + '</option>');
          });

           
        }
      });
    });
    @if(isset($unit_data) && $unit_data != NULL)
        var unit_id = '{{$unit_data}}';
        $("#unit").html('');
        $.ajax({
          url: "{{url('employee/employeelist')}}",
          type: "POST",
          data: {
            unit_id: unit_id,
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(result) {
            $('#employee').html('<option value="">Select Employee</option>');
            var employee_data = '{{$employee_data}}';
            
            $.each(result.employeename, function(key, value) {
              var selected = '';
              if (employee_data == value.id) {
                var isselected = 'selected';
              }
              $("#employee").append('<option value="' + value.id + '" ' + isselected + '>' + value.title + value.fname + value.mname + value.lname + value.staff_id + '</option>');

            });
          }
        });
    @endif
});


var table = $("#employee_data").DataTable({
    bLengthChange: false,
    bDestroy: true,
    dom: "Bfrtip",
    buttons: [
        {
            extend: "excelHtml5",
            text: '<i class="fa fa-file-excel-o"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ':not(:first-child)',
            },
        },
        {
            extend: "csvHtml5",
            text: '<i class="fas fa-file-csv"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ":visible",
                columns: ":not(:first-child)",
            },
        },
        {
            extend: "pdfHtml5",
            pageSize: 'LEGAL',
            text: '<i class="fa fa-file-pdf-o"></i>',
            exportOptions: {
                page: 'current',
                columns: ":visible",
                columns: ":not(:first-child)",
                order: "applied",
                columnGap: 10,
                order: 'applied',
            },
            customize: function (doc) {
                doc.header = function () {
            return {
                text: "Employee Details",
                fontSize: 18,
                alignment: "center"
            };
        };
        
        doc.filename = "CustomFileName";
        },
            orientation: "landscape",
            pageSize: "A4",
            alignment: "center",
            header: true,
            margin: 5,                    
        },
        {
            extend: "print",
            text: '<i class="fa fa-print"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ":visible",
                columns: ":not(:first-child)",
            },
        },
        ],
    columnDefs: [{
        visible: false,
    }, ],
    responsive: true,
});
// For Export Button

// $(document).on('click','#export_excel', function(e){
//     e.preventDefault();
//     var faculty = $("#faculty").val();
//     var department = $("#department").val();
//     var unit = $("#unit").val();
//     var faculty = $("#faculty").val();
//     var filtecontnet = $("#filtecontnet").val();
//     var employee = $("#employee").val();
//     $.ajax({
//         type: "post",
//         url: '{{ route("filter.export") }}',
//         data: {
//             _token: "{{ csrf_token() }}",
//             faculty_id : faculty,
//             department_id : department,
//             unit_id : unit,
//             filtecontnet : filtecontnet,
//             employee : employee,
//         },
//         success: function(response) {
//             const data = JSON.parse( response );
//             $("#dvjson").excelexportjs({
//               containerid: "dvjson", 
//               datatype: 'json', 
//               worksheetName:"user-data",
//               dataset: data, 
//               columns: getColumns(data)     
//             });
//        }
//    });
// });
function ExportToExcel(type, fn, dl) {
  var elt = document.getElementById('employee_data');
  var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

  var ws = wb.Sheets["sheet1"];

  // Remove the first column from the worksheet
  for (var row in ws) {
    if (row[0] === 'A') {
      delete ws[row];
    }
  }

  // Adjust the column widths for the remaining columns
  var columnWidths = [
    { wch: -5 },
    { wch: 10 },
    { wch: 15 },
    { wch: 10 },
    { wch: 15 },
    { wch: 10 },
    { wch: 15 },
    { wch: 10 },
    { wch: 10 },
    { wch: 10 },
    { wch: 10 },
    { wch: 10 },
    { wch: 10 },
    { wch: 10 },
    { wch: 15 },
    { wch: 20 },
    { wch: 15 }
  ];

  ws['!cols'] = columnWidths;

  var headingText = "Excel File Heading";
  var mergeCellStart = { c: 0, r: 0 }; // Adjust the starting column index to skip the first column
  var mergeCellEnd = { c: columnWidths.length - 1, r: 0 }; // Adjust the ending column index accordingly
  var headingCellStyle = {
    v: headingText,
    s: {
      alignment: { horizontal: "center" },
      font: { bold: true }
    }
  };
  var headingMergeRange = XLSX.utils.encode_cell(mergeCellStart) + ":" + XLSX.utils.encode_cell(mergeCellEnd);
  ws[headingMergeRange] = headingCellStyle;

  return dl ?
    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
    XLSX.writeFile(wb, fn || ('Employeefilter.' + (type || 'xlsx')));
}
</script>
<script>
// $('#export_pdf').click(function() {
//     var dataTable = $('#employee_data').DataTable();
//     var tableData = dataTable.rows().data().toArray();
//         var tableColumns = dataTable.columns().header().toArray().map(function(column) {
//           return column.innerText;
//         });

//         var docDefinition = {
//           content: [],
//           pageOrientation: 'landscape',
//           styles: {
//             header: { fontSize: 16, bold: true },
//             table: { margin: [0, 10, 0, 10], fontSize: 10 }
//           }
//         };

//         tableData.forEach(function(row) {
//           var rowData = [];
//           for (var i = 0; i < tableColumns.length; i++) {
//             rowData.push({ text: row[i], style: 'tableCell' });
//           }
//           docDefinition.content.push({
//             table: {
//               headerRows: 1,
//               widths: Array(tableColumns.length).fill('*'),
//               body: [[tableColumns]].concat([rowData])
//             },
//             layout: {
//               hLineWidth: function(i, node) { return (i === 0 || i === node.table.body.length) ? 1 : 0; },
//               vLineWidth: function(i, node) { return 0; },
//               hLineColor: function(i, node) { return (i === 0 || i === node.table.body.length) ? 'black' : 'white'; },
//               paddingLeft: function(i, node) { return 5; },
//               paddingRight: function(i, node) { return 5; },
//               paddingTop: function(i, node) { return 5; },
//               paddingBottom: function(i, node) { return 5; }
//             }
//           });
//           docDefinition.content.push({ text: '\n\n\n\n', pageBreak: 'after' });
//         });

//         pdfMake.createPdf(docDefinition).download('datatable.pdf');
// });

</script>
@endsection
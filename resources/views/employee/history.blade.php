<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')

@section('content')

<style>
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
    /*background-color: #2255a4;*/
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
    .data{
        text-align: center;
        font-size: 18px;
    }
</style>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Reports History and Count</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content employee-content employee_history">
                <div class="employee-page">
                    <section>
                        <form action="{{ route('history_report') }}" method="post" data-parsley-validate="">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                                    <label for="employeename">Employee</label>
                                    <select id="employeename" name="employeename"
                                        class="employeename required form-control" required="" data-parsley-required-message="Please Enter Employee">
                                        <option value="">--Select Employee--</option>
                                        @if(isset($historyemployee))
                                        @foreach($historyemployee as $historyemployees)
                                        <option <?php echo isset( $employeeid) && $employeeid==$historyemployees['id']
                                            ? 'selected' : '' ?> value="{{ $historyemployees['id'] }}"> {{
                                            isset($historyemployees['title']) ? $historyemployees['title'] : '' }} {{
                                            $historyemployees['fname'] }} {{ $historyemployees['mname'] }} {{
                                            $historyemployees['lname'] }} ({{ $historyemployees['staff_id'] }})
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="historytype">History Type </label>
                                    <select id="historytype" name="historytype[]"
                                        class="historytype required form-control"multiple="multiple">
                                        <!-- <option value="">--Select History Type--</option> -->
                                        <option value="academicqualification" {{ isset($history_type) && in_array('academicqualification', $history_type) ? 'selected' : '' }}>Academic Qualification</option>
                                        <option value="workexperience" {{ isset($history_type) &&  in_array('workexperience', $history_type) ? 'selected' : '' }}>Work Experience</option>
                                        <option value="certificates" {{ isset($history_type) &&  in_array('certificates', $history_type) ? 'selected' : '' }}>Certificates</option>
                                        <option value="death" {{ isset($history_type) &&  in_array('death', $history_type) ? 'selected' : '' }}>Death</option>
                                        <option value="refreedetails" {{ isset($history_type) &&  in_array('refreedetails', $history_type) ? 'selected' : '' }}>Refree Details </option>
                                        <option value="salary_details" {{ isset($history_type) &&  in_array('salary_details', $history_type) ? 'selected' : '' }}>Salary Details</option>
                                        <option value="kin_detail" {{ isset($history_type) &&  in_array('kin_detail', $history_type) ? 'selected' : '' }}>Kin Details</option>
                                        <option value="retirement" {{ isset($history_type) &&  in_array('retirement', $history_type) ? 'selected' : '' }}>Retirement</option>
                                        <option value="children_count" {{ isset($history_type) &&  in_array('children_count', $history_type) ? 'selected' : '' }}>Children Count</option>
                                        <option value="contact_details" {{ isset($history_type) &&  in_array('contact_details', $history_type) ? 'selected' : '' }}>Contact Details</option>
                                        <option value="residential_contact" {{ isset($history_type) &&  in_array('residential_contact', $history_type) ? 'selected' : '' }}>Residential Contact Details</option>
                                        <option value="leave_details" {{ isset($history_type) &&  in_array('leave_details', $history_type) ? 'selected' : '' }}>Leave Details</option>
                                        <option value="transfer_details" {{ isset($history_type) &&  in_array('transfer_details', $history_type) ? 'selected' : '' }}>Transfer Details</option>
                                    </select>
                                </div>

                                <div
                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 form-group search-button">
                                    <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search"
                                            aria-hidden="true"></i></button>
                                </div>

                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>

        @if(isset($Leave_details))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Leave Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Leave Type</th>
                                            <th>Leave Days</th>
                                            <th>Start_Date</th>
                                            <th>End_Date</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($Leave_details) > 0 )
                                        @foreach($Leave_details as $Leave_detail)
                                        <tr>
                                            <td>@if(isset($Leave_detail['leavetype_id'])){{$Leave_detail['name']}}@endif
                                            </td>
                                            <td>@if(isset($Leave_detail['leave_days'])){{$Leave_detail['leave_days']}}@endif
                                            </td>
                                            <td>@if(isset($Leave_detail['start_date'])){{$Leave_detail['start_date']}}@endif
                                            </td>
                                            <td>@if(isset($Leave_detail['end_date'])){{$Leave_detail['end_date']}}@endif
                                            </td>
                                            <td>@if(isset($Leave_detail['reason'])){{$Leave_detail['reason']}}@endif
                                            </td>
                                            <td>@if(isset($Leave_detail['status'])){{$Leave_detail['status']}}@endif
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($Trf_details_out))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Transfer Outgoing Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Transfer Class</th>
                                            <th>Transfer Type</th>
                                            <th>Transfer Category</th>
                                            <th>Transfer Reason</th>
                                            <th>From Institute</th>
                                            <th>From School</th>
                                            <th>From Department</th>
                                            <th>From Unit</th>
                                            <th>From Role</th>
                                            <th>To Institute</th>
                                            <th>To School</th>
                                            <th>To Department</th>
                                            <th>To Unit</th>
                                            <th>To Role</th>
                                            <th>Final Approval Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($Trf_details_out) > 0 )
                                        @foreach($Trf_details_out as $Trf_detail)
                                        <tr>
                                            <td>@if(isset($Trf_detail['transferclass'])){{$Trf_detail['transferclass']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transfertype'])){{$Trf_detail['transfertype']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transfercategory'])){{$Trf_detail['transfercategory']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transferreason'])){{$Trf_detail['transferreason']}}@endif
                                            </td>
                                            <td>{{Auth::user()->institutionname}}
                                            </td>
                                            <td>@if(isset($Trf_detail['faculty'])){{$pr_fac['facultyname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['department'])){{$pr_depa['departmentname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['previous_role'])){{$Trf_detail['previous_role']}}@endif</td>
                                            <td>@if(isset($Trf_detail['unit'])){{$pr_un['name']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['institutionname'])){{$institute['institutionname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transferfaculty'])){{$fac['facultyname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transferdepartment'])){{$depa['departmentname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['transferunit'])){{$un['name']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['role'])){{$Trf_detail['role']}}@endif</td>
                                            <td>@if(isset($Trf_detail['final_insti_datetime'])){{$Trf_detail['final_insti_datetime']}}@endif</td>
                                            <td>@if(isset($Trf_detail['status']))@if($Trf_detail['status'] == 4) Approved @else Pending @endif @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="12" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($Trf_details_in))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Transfer Incoming Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Transfer Class</th>
                                            <th>Transfer Type</th>
                                            <th>Transfer Category</th>
                                            <th>Transfer Reason</th>
                                            <th>From Institute</th>
                                            <th>From School</th>
                                            <th>From Department</th>
                                            <th>From Unit</th>
                                            <th>From Role</th>
                                            <th>To Institute</th>
                                            <th>To School</th>
                                            <th>To Department</th>
                                            <th>To Unit</th>
                                            <th>To Role</th>
                                            <th>Final Approval Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($Trf_details_in) > 0 )
                                        @foreach($Trf_details_in as $Trf_detail_in)
                                        <tr>
                                            <td>@if(isset($Trf_detail_in['transferclass'])){{$Trf_detail_in['transferclassIn']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['transfertype'])){{$Trf_detail_in['transfertype']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['transfercategory'])){{$Trf_detail_in['transfercategory']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['transferreason'])){{$Trf_detail_in['transferreason']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['institution_id']))<?php $insti_in =App\Models\User::where('id',$Trf_detail_in['institution_id'])->first(); ?>{{$insti_in['institutionname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['faculty']))<?php $fac_to =App\Models\FacultyDirectorate::where('id',$Trf_detail_in['faculty'])->first(); ?>{{$fac_to['facultyname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['department']))<?php $depa_to =App\Models\Department::where('id',$Trf_detail_in['department'])->first(); ?>{{$depa_to['departmentname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['unit']))<?php $uni_to =App\Models\Unit::where('id',$Trf_detail_in['unit'])->first(); ?>{{$uni_to['name']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['previous_role'])){{$Trf_detail_in['previous_role']}}@endif</td>
                                            <td>{{Auth::user()->institutionname}}</td>
                                            <td>@if(isset($Trf_detail_in['transferfaculty']))<?php $facnew_in =App\Models\FacultyDirectorate::where('id',$Trf_detail_in['transferfaculty'])->first(); ?>{{$facnew_in['facultyname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['transferdepartment']))<?php $depa_in =App\Models\Department::where('id',$Trf_detail_in['transferdepartment'])->first(); ?>{{$depa_in['departmentname']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['transferunit']))<?php $uni_in =App\Models\Unit::where('id',$Trf_detail_in['transferunit'])->first(); ?>{{$uni_in['name']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['role'])){{$Trf_detail_in['role']}}@endif</td>
                                            <td>@if(isset($Trf_detail_in['final_insti_datetime'])){{$Trf_detail_in['final_insti_datetime']}}@endif</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="11" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($academic_data))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Academic Qualification</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Institution Name</th>
                                            <th>Institution Category</th>
                                            <th>Other</th>
                                            <th>Course of Study</th>
                                            <th>Certificate/Honours Obtained</th>
                                            <th>Programme Start Date</th>
                                            <th>Programme End Date</th>
                                            <th>Duration</th>
                                            <th>Post Held/Project Handled</th>
                                            <th>Certificate</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($academic_data as $academic_datas)
                                        <tr>
                                            <td>@if(isset($academic_datas['institutionname'])){{$academic_datas['institutionname']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['institutioncategory'])){{$academic_datas['institutioncategory']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['academicother'])){{$academic_datas['academicother']}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>@if(isset($academic_datas['courseofstudy'])){{$academic_datas['courseofstudy']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['certificateobtained'])){{$academic_datas['certificateobtained']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['programmeduration'])){{$academic_datas['programmeduration']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['programmedurationenddate'])){{$academic_datas['programmedurationenddate']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['acaduration'])){{$academic_datas['acaduration']}}@endif
                                            </td>
                                            <td>@if(isset($academic_datas['postheldandprojecthandled'])){{$academic_datas['postheldandprojecthandled']}}@endif
                                            </td>
                                            @if(isset($academic_datas['academic_upload']) && ($academic_datas['academic_upload'] != '' && ($academic_datas['academic_upload']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$academic_datas['academic_upload']}}" target="_blank">View</a></td>
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
        @endif

        @if(isset($work_experiences))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Work Experience</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Institution</th>
                                            <th>Designation</th>
                                            <th>Post Held</th>
                                            <th>Cadre</th>
                                            <th>Grade Level</th>
                                            <th>Steps</th>
                                            <th>Work Start Date</th>
                                            <th>Work End Date</th>
                                            <th>Work Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($work_experiences as $work_experience)
                                        <tr>
                                            <td>@if(isset($work_experience['workinstitutionname'])){{$work_experience['workinstitutionname']}}@endif</td>
                                            <td>@if(isset($work_experience['title'])){{$work_experience['title']}}@endif</td>
                                            <td>@if(isset($work_experience['workpostheld'])){{$work_experience['workpostheld']}}@endif
                                            </td>
                                            <td>@if(isset($work_experience['workcadre'])){{$work_experience['workcadre']}}@endif
                                            </td>
                                            <td>@if(isset($work_experience['workgradelevel'])){{$work_experience['workgradelevel']}}@endif
                                            </td>
                                            <td>@if(isset($work_experience['workstep'])){{$work_experience['workstep']}}@endif
                                            </td>
                                            <td>@if(isset($work_experience['workstartdate'])){{$work_experience['workstartdate']}}@endif</td>
                                            <td>@if(isset($work_experience['workenddate'])){{$work_experience['workenddate']}}@endif</td>
                                            <td>@if(isset($work_experience['workduration'])){{$work_experience['workduration']}}@endif
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
        @endif

        @if(isset($certificates))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Certificates</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Birth Certificate</th>
                                            <th>Professional Certificate</th>
                                            <th>Marriage Certificate</th>
                                            <th>Award and Honorary Certificate</th>
                                            <th>Other Certificate</th>
                                            <th>Death Certificate</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @if(count($certificates) > 0 )
                                        @foreach($certificates as $certificate)
                                        <tr>
                                            @if(isset($certificate['birthcerticate']) && ($certificate['birthcerticate'] != '' && ($certificate['birthcerticate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['birthcerticate']}}" target="_blank">View</a></td>
                                            @endif
                                            @if(isset($certificate['professionalcertificate']) && ($certificate['professionalcertificate'] != '' && ($certificate['professionalcertificate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['professionalcertificate']}}" target="_blank">View</a></td>
                                            @endif
                                            @if(isset($certificate['marriagecertificate']) && ($certificate['marriagecertificate'] != '' && ($certificate['marriagecertificate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['marriagecertificate']}}" target="_blank">View</a></td>
                                            @endif
                                            @if(isset($certificate['awardandhonorarycertificate']) && ($certificate['awardandhonorarycertificate'] != '' && ($certificate['awardandhonorarycertificate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['awardandhonorarycertificate']}}" target="_blank">View</a></td>
                                            @endif
                                            @if(isset($certificate['othercertificate']) && ($certificate['othercertificate'] != '' && ($certificate['othercertificate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['othercertificate']}}" target="_blank">View</a></td>
                                            @endif
                                            @if(isset($certificate['deathcertificate']) && ($certificate['deathcertificate'] != '' && ($certificate['deathcertificate']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$certificate['deathcertificate']}}" target="_blank">View</a></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($deaths))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Death</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date of Death</th>
                                            <th>Cause of Death</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($deaths) > 0 )
                                        @foreach($deaths as $death)
                                        <tr>
                                            <td>@if(isset($death['dateofdeath'])){{$death['dateofdeath']}}@endif</td>
                                            <td>@if(isset($death['causeofdeath'])){{$death['causeofdeath']}}@endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="2" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($referee_infos))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Refree Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Refree Info Fullname</th>
                                            <th>Refree Info Occuption</th>
                                            <th>Refree Info Postheld</th>
                                            <th>Refree Info Address</th>
                                            <th>Refree Info Phone NO.</th>
                                            <th>Refree Info Email</th>
                                            <th>Refree Consentletter</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($referee_infos as $referee_info)
                                        <tr>
                                            <td>@if(isset($referee_info['referee_info_fullname'])){{$referee_info['referee_info_fullname']}}@endif</td>
                                            <td>@if(isset($referee_info['referee_info_occupation'])){{$referee_info['referee_info_occupation']}}@endif
                                            </td>
                                            <td>@if(isset($referee_info['referee_info_postheld'])){{$referee_info['referee_info_postheld']}}@endif
                                            </td>
                                            <td>@if(isset($referee_info['referee_info_address'])){{$referee_info['referee_info_address']}}@endif
                                            </td>
                                            <td>@if(isset($referee_info['referee_info_phoneno'])){{$referee_info['referee_info_phoneno']}}@endif
                                            </td>
                                            <td>@if(isset($referee_info['referee_info_email'])){{$referee_info['referee_info_email']}}@endif
                                            </td>
                                            @if(isset($referee_info['refereeconsentletter']) && ($referee_info['refereeconsentletter'] != '' && ($referee_info['refereeconsentletter']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/files')}}/{{$referee_info['refereeconsentletter']}}" target="_blank">View</a></td>
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
        @endif

        @if(isset($salary_details))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Salary Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th>Upload ID Card</th>
                                            <th>Account Number</th>
                                            <th>Bvn</th>
                                            <th>Tin</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($salary_details as $salary_detail)
                                        <tr>
                                            <td>@if(isset($salary_detail['bankname'])){{$salary_detail['bankname']}}@endif</td>
                                            <td>@if(isset($salary_detail['accountname'])){{$salary_detail['accountname']}}@endif
                                            </td>
                                            @if(isset($salary_detail['uploadidcard']) && ($salary_detail['uploadidcard'] != '' && ($salary_detail['uploadidcard']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/id_cards')}}/{{$salary_detail['uploadidcard']}}" target="_blank">View</a></td>
                                            @endif
                                            
                                            <td>@if(isset($salary_detail['accountnumber'])){{$salary_detail['accountnumber']}}@endif
                                            </td>
                                            <td>@if(isset($salary_detail['bvn'])){{$salary_detail['bvn']}}@endif
                                            </td>
                                            <td>@if(isset($salary_detail['tin'])){{$salary_detail['tin']}}@endif
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
        @endif

        @if(isset($Kin_details))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Kin Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Relationship</th>
                                            <th>Sex</th>
                                            <th>Phone No</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Kin_details as $Kin_detail)
                                        <tr>
                                            <td>@if(isset($Kin_detail['name'])){{$Kin_detail['name']}}@endif</td>
                                            <td>@if(isset($Kin_detail['relationship'])){{$Kin_detail['relationship']}}@endif
                                            </td>
                                            <td>@if(isset($Kin_detail['kindetailssex'])){{$Kin_detail['kindetailssex']}}@endif
                                            </td>
                                            <td>@if(isset($Kin_detail['phoneno'])){{$Kin_detail['phoneno']}}@endif
                                            </td>
                                            <td>@if(isset($Kin_detail['kinemail'])){{$Kin_detail['kinemail']}}@endif
                                            </td>
                                            <td>@if(isset($Kin_detail['address'])){{$Kin_detail['address']}}@endif
                                            </td>
                                            @if(isset($Kin_detail['image']) && ($Kin_detail['image'] != '' && ($Kin_detail['image']) != NULL))
                                            <td><a id="" class="download-btn btn btn-primary" href="{{asset('public/images')}}/{{$Kin_detail['image']}}" target="_blank">View</a></td>
                                            @endif
                                            <!-- <td>@if(isset($Kin_detail['image'])){{$Kin_detail['image']}}@endif
                                            </td> -->
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
        @endif

        @if(isset($retirement_historys))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Retirement</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Expected Retirement Date</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($retirement_historys as $retirement_history)
                                        <tr>
                                            <td>@if(isset($retirement_history['expectedretirementdate'])){{$retirement_history['expectedretirementdate']}}@endif</td>
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
        @endif

        @if(isset($children_counts))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Children Count</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Children Count</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($children_counts) > 0 )
                                        @foreach($children_counts as $children_count)
                                        <tr>
                                            <td>@if(isset($children_count['noofchildren'])){{$children_count['noofchildren']}}@endif</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($contacts))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Contact Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>State</th>    
                                            <th>Local Government Area of Origin</th>                                          
                                            <th>City</th>
                                            <th>Home Town</th>
                                            <th>Tribe</th>                                            
                                            <th>Phone No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)
                                        <tr>
                                            <td>@if(isset($contact['country_name'])){{$contact['country_name']}}@endif</td>
                                            <td>@if(isset($contact['states_name'])){{$contact['states_name']}}@endif</td>
                                            <td>@if(isset($lgaa['lgas'])){{$lgaa['lgas']}}@endif</td>
                                            <td>@if(isset($contact['city_name'])){{$contact['city_name']}}@endif</td>
                                            <td>@if(isset($contact['hometown'])){{$contact['hometown']}}@endif</td>
                                            <td>@if(isset($contact['tribe'])){{$contact['tribe']}}@endif</td>
                                            <td>@if(isset($contact['phoneno'])){{$contact['phoneno']}}@endif</td>
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
        @endif

        @if(isset($residential_contacts))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Residential Contact Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="employee_data" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>House No</th>
                                            <th>Street Name</th>
                                            <th>Country</th>
                                            <th>Nationality</th>
                                            <th>State</th>
                                            <th>City / Town</th>
                                            <th>Phone No 1</th>
                                            <th>Phone No 2</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($residential_contacts as $residential_contact)
                                        <tr>
                                            <td>@if(isset($residential_contact['houseno'])){{$residential_contact['houseno']}}@endif</td>
                                            <td>@if(isset($residential_contact['streetname'])){{$residential_contact['streetname']}}@endif</td>
                                            <td>@if(isset($residential_contact['residential_name'])){{$residential_contact['residential_name']}}@endif</td>
                                            <td>@if(isset($residential_contact['residentialnationality'])){{$residential_contact['residentialnationality']}}@endif</td>
                                            <td>@if(isset($residential_contact['residential_state'])){{$residential_contact['residential_state']}}@endif</td>
                                            <td>@if(isset($residential_contact['residential_city'])){{$residential_contact['residential_city']}}@endif</td>
                                            <td>@if(isset($residential_contact['phone_no_1'])){{$residential_contact['phone_no_1']}}@endif</td>
                                            <td>@if(isset($residential_contact['phone_no_2'])){{$residential_contact['phone_no_2']}}@endif</td>
                                            <td>@if(isset($residential_contact['email'])){{$residential_contact['email']}}@endif</td>
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
        @endif

        @if(isset($records))
          <p>No Records Founds</p>
        @endif
    </div>
</div>

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    jQuery(document).ready(function () {
        jQuery('.employeename').select2();
        // jQuery('.historytype').select2();
    });
    $('.historytype').select2({
          placeholder: "--Select History Type--",
          allowClear: true
    });
</script>
@endsection
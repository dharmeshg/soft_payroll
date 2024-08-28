<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')

<style type="text/css">
   .form-check .form-check-label {
    font-size: 15px;
}
.radio_parsley .parsley-required{position: relative; top: 18px; right: 90px; padding-bottom: 14px; padding-top: 3px; white-space: nowrap;}
</style>
<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Leave Request</h4>
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
          <div class="card">
            <div class="card-body wizard-content">
              <h4 class="card-title">Add Leave Request</h4>
             
              <form id="example-form" action="{{url('InstituteLeaveRequestAdd')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="faculty_id">School*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select School" name="faculty_id" id="faculty_id">
                        <option></option>
                        @foreach($facultydirectorates as $facultydirectorate)
                          <option value="{{ $facultydirectorate->id }}">{{$facultydirectorate->facultyname}}</option>
                        @endforeach 
                      </select>
                    </div>

                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="department_id">Department*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Department" name="department_id" id="department_id">
                        <option></option>
                        @foreach($departments as $department)
                          <option value="{{ $department->id }}">{{$department->departmentname}}</option>
                        @endforeach
                      </select>
                    </div>
                  
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="unit_id">Unit</label>
                      <select class="js-directorate" name="unit_id" id="unit_id">
                        <option></option>                       
                      </select>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="employee_id">Employee Details*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Employee" name="employee_id" id="employee_id">
                        <option></option>
                        @foreach($emp_detail as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->fname}}{{ $emp->mname}}{{ $emp->lname}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leavetype_id">Leave Type Select*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Leave Type" name="leavetype_id" id="leavetype_id" >
                        <option></option>
                        @foreach($leavetypes as $leavetype)
                            <option value="{{ $leavetype->id }}">{{ $leavetype->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <select class="js-directorate" name="count_leavetype_id" id="count_leavetype_id" hidden>
                        <option></option>
                        @foreach($leavetypes as $leavetype)
                            <option value="{{ $leavetype->id }}">{{$leavetype->days}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                       <input
                        id="count_data"
                        name="count_data"
                        type="text"
                        class="form-control"
                        hidden
                      />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_days">Select Leave Days*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Selct Leave Day" name="leave_days" id="leave_days" onchange="CheckLeaveDay(this)">
                        <option></option>
                        <option value="half">Half Day</option>
                        <option value="full">Full Day</option>
                        <option value="multiple">Multiple Days</option>
                        <option value="intermittent">Intermittent Leave</option>
                        <option value="hourly">Hourly Leave</option>
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="hourly_hours" id="hour" style="display: none;">Select Hours*</label>
                      <select class="js-directorate"  data-parsley-required-message="Please Selct Hours" name="hourly_hours" id="hourly_hours" style="display: none;" onchange="diffHours()">
                        <option></option>
                        <option value="1">1 Hour</option>
                        <option value="2">2 Hours</option>
                        <option value="3">3 Hours</option>
                        <option value="4" disabled>4 Hours (If you want 4 Hours leave then Please Select half Leave)</option>
                        <option value="5">5 Hours</option>
                        <option value="6">6 Hours</option>
                      </select>
                      <!-- <label for="hourly_hours">Hours*</label> -->
                      <!-- <input
                        id="hourly_hours"
                        name="hourly_hours"
                        type="text"
                        class="required form-control"
                        style="display: none;"
                        
                        placeholder="Please Enter Hours"
                      /> -->
                    </div>
                    <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group d-flex radio_parsley" >
                    <div class="form-check form-check-inline" style="display: none;" id="halfday">
                      <input class="form-check-input" type="radio" name="half_leave" id="half_leave" value="morning" data-parsley-required-message="Please Select Half Leave Type" onchange="diffHalf()">
                      <label class="form-check-label">Morning</label>
                    </div>
                    <div class="form-check form-check-inline" style="display: none;" id="halfDay">
                      <input class="form-check-input" type="radio" name="half_leave" id="half_leave" value="afternoon" onchange="diffHalf()">
                      <label class="form-check-label">Afternoon</label>
                    </div>
                    <div data-parsley-errors-container="#half_leave"></div>
                    </div>
                  </div>
                    <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="start_date">Start Date*</label>
                      <input type="text" name="start_date" id="start_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter Start Date" onchange="diffStart()">
                      <input type="text" name="start_dates[]" id="start_dates" class="required form-control datepicker1" required="" data-parsley-required-message="Please Enter Start Date" >
                    </div>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="end_date">End Date*</label>
                      <input type="text" name="end_date" id="end_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter End Date" onchange="diffDays()">
                      <input type="text" name="end_dates[]" id="end_dates" class="required form-control datepicker1" required="" data-parsley-required-message="Please Enter End Date">
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                       <input
                        id="duration"
                        name="duration"
                        type="text"
                        class="form-control"
                        hidden
                      />
                    </div>
                    </div>
                    
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="reason">Reason For Leave*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Reason" name="reason" id="reason" onchange="CheckReason(this)">
                        <option></option>
                        <option value="Illness">Illness(Illness or medical condition requiring time off for recovery)</option>
                        <option value="Family Care">Family Care(Taking leave to care for a sick family member or attending to family-related responsibilities)</option>
                        <option value="Personal Needs">Personal Needs(Requesting leave for personal matters, such as appointments, personal events, or self-care)</option>
                        <option value="Bereavement">Bereavement(Leave taken due to the death of a family member or close relative)</option>
                        <option value="Vacation">Vacation(Planned time off for leisure, travel, or rest and relaxation)</option>
                        <option value="Jury Duty">Jury Duty(Leave requested when an employee is summoned for jury duty)</option>
                        <option value="Other">  
                          Other
                        </option>
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <textarea class="form-control other" id="otherReason" name="other_reason" rows="3"  data-parsley-required-message="Please Enter Reason" style="display: none;"></textarea>
                    </div>
                    </div>
                  </section>
                  </div>
                  <div class="row">
                    <div class="col-12 change-btn">
                      <button type="submit" class="btn btn-primary">save</button>
                    </div>
                  </div>
                  
                </div>
              </form>
            </div>
          </div>
        
        </div>
      </div>
      <script>
        function getCurrentFinancialYear() {
          var startYear = "";
          var endYear = "";
          var docDate = new Date();
          var aniv = docDate.getFullYear();
          if ((docDate.getMonth() + 1) <= 3) {
            startYear = docDate.getFullYear() - 1;
            endYear = docDate.getFullYear();
          } else {
            startYear = docDate.getFullYear();
            endYear = docDate.getFullYear() + 1;
          }
          return {stDate : "01/04/" + startYear, enDate: "31/03/" + endYear, stYear : "01/01/" + aniv, enYear: "31/12/" + aniv};
        }
      </script>
        <script>
            jQuery(document).ready( function () {
              var Picker = $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                });

              var MultiPicker = $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                });

                MultiPicker.hide();
                MultiPicker.prop('required',false);
                $('#leave_days').on('change', function () {
                var day = this.value;
                if(day == "intermittent"){
                  Picker.prop('required',false);
                  MultiPicker.prop('required',true);
                  Picker.hide();
                  MultiPicker.show();
                }else{
                  Picker.prop('required',true);
                  MultiPicker.prop('required',false);
                  Picker.show();
                  MultiPicker.hide();
                }
            });

            $('#start_dates').on('change', function () {
                var dates = $('#start_dates').val();
                var Enddates = $('#end_dates').val(dates);
                  Enddates.prop('disabled',true);
                var datesCount = $('#start_dates').val().split(',').length;
                var dateCount = $('#duration').val(datesCount);
            });

                $('#faculty_id').on('change', function () {
                var idfac = this.value;
                $("#department_id").html('');
                $.ajax({
                    url: "{{url('fetch-department')}}",
                    type: "POST",
                    data: {
                      faculty_id: idfac,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#department_id').html('<option value="">-- Select Department --</option>');
                        $.each(result.depart, function (key, value) {
                            $("#department_id").append('<option value="' + value
                                .id + '">' + value.departmentname + '</option>');
                        });
                        $('#unit_id').html('<option value="">-- Select Unit --</option>');
                    }
                });
            });
  
            $('#department_id').on('change', function () {
                var idUnit = this.value;
                $("#unit_id").html('');
                $.ajax({
                    url: "{{url('fetch-unit')}}",
                    type: "POST",
                    data: {
                        department_id: idUnit,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#unit_id').html('<option value="">-- Select Unit --</option>');
                        $.each(res.units, function (key, value) {
                            $("#unit_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });


            $('#department_id').on('change', function () {
                var idEmp = this.value;
                
                $("#employee_id").html('');
                $.ajax({
                    url: "{{url('fetch-department-employee')}}",
                    type: "POST",
                    data: {
                      department_id: idEmp,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#employee_id').html('<option value="">-- Select Employee --</option>');
                        $.each(res.department_employee, function (key, value) {
                            $("#employee_id").append('<option value="' + value
                                .id + '">' + value.fname + ''+ value.mname +''+ value.lname +'</option>');
                        });
                    }
                });
            });


            $('#employee_id').on('change', function () {
                var idLe = this.value;
                
                $("#leavetype_id").html('');
                $.ajax({
                    url: "{{url('fetch-LeaveType')}}",
                    type: "POST",
                    data: {
                      employee_id: idLe,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                      // console.log(res);
                        $('#leavetype_id').html('<option value="">-- Select Leave Type --</option>');
                        $.each(res.leave_type, function (key, value) {
                          if(value.leave_cycle == "Anniversary Year"){
                              if(res.result.year == res.date){
                              $("#leavetype_id").append('<option value="' + value
                                  .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]) +' '+'Remaning Days)'+'</option>');
                              }else{
                                if(value.carry_over_policy == 1 && value.all_remaning_leaves == 1){
                                  $("#leavetype_id").append('<option value="' + value
                                    .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name] + value.days - res.PreviousCount[value.name]) +' '+'Remaning Days)'+'</option>');
                                }else if(value.carry_over_policy == 1 && value.all_remaning_leaves == 0){
                                  if(parseFloat( value.days - res.PreviousCount[value.name]) < value.max_leave_carry_forword){
                                    $("#leavetype_id").append('<option value="' + value
                                    .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name] + value.days - res.PreviousCount[value.name]) +' '+'Remaning Days)'+'</option>');
                                  }else{
                                    $("#leavetype_id").append('<option value="' + value
                                    .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]+ +value.max_leave_carry_forword) +' '+'Remaning Days)'+'</option>');
                                  }
                                }else{
                                  $("#leavetype_id").append('<option value="' + value
                                  .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]) +' '+'Remaning Days)'+'</option>');
                                }
                              }
                            
                          }else if(value.leave_cycle == "Fiscal Year"){
                            if(res.fis_b.created_at > res.Try_New_x && res.fis_b.created_at < res.Try_New_end_x){
                              $("#leavetype_id").append('<option value="' + value
                                .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]) +' '+'Remaning Days)'+'</option>');
                            }else{
                              if(value.carry_over_policy == 1 && value.all_remaning_leaves == 1){
                                $("#leavetype_id").append('<option value="' + value
                                  .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name] + value.days - res.PreviousCount[value.name]) +' '+'Remaning Days)'+'</option>');
                              }else if(value.carry_over_policy == 1 && value.all_remaning_leaves == 0){
                                if(parseFloat( value.days - res.PreviousCount[value.name]) < value.max_leave_carry_forword){
                                  $("#leavetype_id").append('<option value="' + value
                                  .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name] + value.days - res.PreviousCount[value.name]) +' '+'Remaning Days)'+'</option>');
                                }else{
                                  $("#leavetype_id").append('<option value="' + value
                                    .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]+ +value.max_leave_carry_forword) +' '+'Remaning Days)'+'</option>');
                                } 
                              }else{
                                $("#leavetype_id").append('<option value="' + value
                                .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]) +' '+'Remaning Days)'+'</option>');
                              }
                            }
                          }else if(value.leave_cycle == "Other"){
                            var dateParts = value.from_date.split("-");
                            var datePart = value.to_date.split("-");
                            var datePar = res.ok.split("-");
                            var dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
                            var dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
                            var dt_ok = datePar[2] + "-" + datePar[1] + "-" + datePar[0];
                            var frr_ne = new Date(dt);
                            var too_ne = new Date(dt_en);
                            var new_ok = new Date(dt_ok);
                            if(new_ok > frr_ne && new_ok < too_ne){
                              $("#leavetype_id").append('<option value="' + value
                                .id + '">' + value.name +'  '+'('+'  '+ parseFloat(value.days - res.LeavetypeNameCount[value.name]) +' '+'Remaning Days)'+'</option>');
                            }else{
                              $("#leavetype_id").append('<option hidden></option>')
                            }
                          }
                        });
                    }
                });
            });

            $('#leavetype_id').on('change', function () {
              var idLeave = this.value;
                var idCo = $('#employee_id').val();
                Picker.val('');
                MultiPicker.val('');
                Picker.datepicker("destroy");
                MultiPicker.datepicker("destroy");
                $("#count_leavetype_id").html('');
                $.ajax({
                    url: "{{url('fetch-Count')}}",
                    type: "POST",
                    data: {
                      employee_id: idCo,
                      leAve_id: idLeave,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                      if(res.LeCy.leave_cycle == "Anniversary Year"){
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stYear,
                        endDate : getCurrentFinancialYear().enYear
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stYear,
                        endDate : getCurrentFinancialYear().enYear
                        });
                      }else if(res.LeCy.leave_cycle == "Other"){
                        // alert(res.LeCy.from_date);
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : res.LeCy.from_date,
                        endDate : res.LeCy.to_date
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : res.LeCy.from_date,
                        endDate : res.LeCy.to_date
                        });
                      }else{
                        $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                        });
                        $('.datepicker1').datepicker({ 
                        multidate: true,
                        format: 'dd-mm-yyyy',
                        startDate : getCurrentFinancialYear().stDate,
                        endDate : getCurrentFinancialYear().enDate
                        });
                      }
                        $.each(res.leaveTypeCount, function (key, value) {
                          var leave = $('#leavetype_id :selected').val();
                          if(leave==value.id){
                            if(value.leave_cycle == "Anniversary Year"){
                              if(res.CountResult.year == res.CountDate){
                              var counttext = $("#count_leavetype_id").append('<option value="' + value
                              .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]) +'</option>');
                              var countData = $("#count_data").val(counttext.text());
                              }else{
                                if(value.carry_over_policy == 1 && value.all_remaning_leaves == 1){
                                  var counttext = $("#count_leavetype_id").append('<option value="' + value
                                  .id + '">'+ parseFloat(value.days - res.leaveCount[value.name] + value.days - res.PreviousleaveCount[value.name]) +'</option>');
                                  var countData = $("#count_data").val(counttext.text());
                                }else if(value.carry_over_policy == 1 && value.all_remaning_leaves == 0){
                                  if(parseFloat( value.days - res.PreviousleaveCount[value.name]) < value.max_leave_carry_forword){
                                    var counttext = $("#count_leavetype_id").append('<option value="' + value
                                    .id + '">'+ parseFloat(value.days - res.leaveCount[value.name] + value.days - res.PreviousleaveCount[value.name]) +'</option>');
                                    var countData = $("#count_data").val(counttext.text());
                                  }else{
                                    var counttext = $("#count_leavetype_id").append('<option value="' + value
                                    .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]+ +value.max_leave_carry_forword) +'</option>');
                                    var countData = $("#count_data").val(counttext.text());
                                  }
                                }else{
                                  var counttext = $("#count_leavetype_id").append('<option value="' + value
                                  .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]) +'</option>');
                                  var countData = $("#count_data").val(counttext.text());
                                }
                              }
                            }else if(value.leave_cycle == "Fiscal Year"){
                              if(res.Countfis_b.created_at > res.CountTry_New_x && res.Countfis_b.created_at < res.CountTry_New_end_x){
                                var counttext = $("#count_leavetype_id").append('<option value="' + value
                                .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]) +'</option>');
                                var countData = $("#count_data").val(counttext.text());
                              }else{
                                if(value.carry_over_policy == 1 && value.all_remaning_leaves == 1){
                                  var counttext = $("#count_leavetype_id").append('<option value="' + value
                                  .id + '">'+ parseFloat(value.days - res.leaveCount[value.name] + value.days - res.PreviousleaveCount[value.name]) +'</option>');
                                  var countData = $("#count_data").val(counttext.text());
                                }else if(value.carry_over_policy == 1 && value.all_remaning_leaves == 0){
                                  if(parseFloat( value.days - res.PreviousleaveCount[value.name]) < value.max_leave_carry_forword){
                                    var counttext = $("#count_leavetype_id").append('<option value="' + value
                                    .id + '">'+ parseFloat(value.days - res.leaveCount[value.name] + value.days - res.PreviousleaveCount[value.name]) +'</option>');
                                    var countData = $("#count_data").val(counttext.text());
                                  }else{
                                    var counttext = $("#count_leavetype_id").append('<option value="' + value
                                    .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]+ +value.max_leave_carry_forword) +'</option>');
                                    var countData = $("#count_data").val(counttext.text());
                                  }
                                }else{
                                  var counttext = $("#count_leavetype_id").append('<option value="' + value
                                  .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]) +'</option>');
                                  var countData = $("#count_data").val(counttext.text());
                                }
                              }
                            }else if(value.leave_cycle == "Other"){
                              var dateParts = value.from_date.split("-");
                              var datePart = value.to_date.split("-");
                              var datePar = res.Countok.split("-");
                              var dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
                              var dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
                              var dt_ok = datePar[2] + "-" + datePar[1] + "-" + datePar[0];
                              var frr_ne = new Date(dt);
                              var too_ne = new Date(dt_en);  
                              var new_ok = new Date(dt_ok);   

                              if(new_ok > frr_ne && new_ok < too_ne){
                                var counttext = $("#count_leavetype_id").append('<option value="' + value
                                .id + '">'+ parseFloat(value.days - res.leaveCount[value.name]) +'</option>');
                                var countData = $("#count_data").val(counttext.text());
                              }else{
                                $("#count_leavetype_id").append('<option hidden></option>')
                              }
                            }
                          }
                        });
                    }
                });
            });
            $('#unit_id').on('change', function () {
                var idEmpl = this.value;
                
                $("#employee_id").html('');
                $.ajax({
                    url: "{{url('fetch-employee')}}",
                    type: "POST",
                    data: {
                        unit_id: idEmpl,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#employee_id').html('<option value="">-- Select Employee --</option>');
                        $.each(res.emp, function (key, value) {
                            $("#employee_id").append('<option value="' + value
                                .id + '">' + value.fname + ''+ value.mname +''+ value.lname +'</option>');
                        });
                    }
                });
            });

            });
        </script>
        <script>

// function CountFetchData(){
//             var leaveCountId = $('#leavetype_id :selected').val();
//             var countid = $("#count_leavetype_id").val(leaveCountId);
//             var counttext = $('#count_leavetype_id :selected').text();
//             var countData = $("#count_data").val(counttext);
//           }

          function diffStart(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const date1 = $("input[name=start_date]").val();
            const $date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.5);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.125 );
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.250);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.375);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.625);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.750);
          }
          else if($("#leave_days").val() == "full"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(1);
          }
          // else if($("#leave_days").val() == "intermittent"){
          //   const date1 = $("input[name=start_date]").val();
          //   const date2 = $("input[name=end_date]").val();
          //   const diffTime = Date.parse(date2) - Date.parse(date1);
          //   const diffDays = diffTime/1000/60/60/24; 
          //   const dura = $("input[name=duration]").val(diffDays + 1 );
          // }
          else if($("#leave_days").val() == "multiple"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val();
            const dateParts = date1.split("-");
            const datePart = date2.split("-");
            const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
            const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
            const diffTime = Date.parse(dt_en) - Date.parse(dt);
            // alert(diffTime);
            // alert(dura);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const dura = $("input[name=duration]");
            dura.val(diffDays + 1 );
          }
          
          }

        function diffDays(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.5);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.125 );
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.250);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(0.375);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.625);
          }
          else if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1);
            const dura = $("input[name=duration]").val(0.750);
          }
          else if($("#leave_days").val() == "full"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val(date1); 
            const dura = $("input[name=duration]").val(1);
          }
          // else if($("#leave_days").val() == "intermittent"){
          //   const date1 = $("input[name=start_date]").val();
          //   const date2 = $("input[name=end_date]").val();
          //   const diffTime = Date.parse(date2) - Date.parse(date1);
          //   const diffDays = diffTime/1000/60/60/24;
          //   const dura = $("input[name=duration]").val(diffDays + 1 );
          // }
          else if($("#leave_days").val() == "multiple"){
            const date1 = $("input[name=start_date]").val();
            const date2 = $("input[name=end_date]").val();
            const dateParts = date1.split("-");
            const datePart = date2.split("-");
            const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
            const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
            const diffTime = Date.parse(dt_en) - Date.parse(dt);
            const diffDays = diffTime/1000/60/60/24;
            const dura = $("input[name=duration]");
            dura.val(diffDays + 1 );
            
          }
          
          }

          function diffHours(){
          var countId = $('#count_leavetype_id :selected').text();

          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "1"){
            const dura = $("input[name=duration]").val(0.125);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "2"){
            const dura = $("input[name=duration]").val(0.250);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "3"){
            const dura = $("input[name=duration]").val(0.375);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "5"){
            const dura = $("input[name=duration]").val(0.625);
          }
          if($("#leave_days").val() == "hourly" && $("#hourly_hours").val() == "6"){
            const dura = $("input[name=duration]").val(0.750);
          }
          }


          function diffHalf(){
          var countId = $('#count_leavetype_id :selected').text();
          if($("#leave_days").val() == "half"){
            const dura = $("input[name=duration]").val(0.5);
          }
          }

          function CheckReason(reason) {
            var selectedValue = reason.options[reason.selectedIndex].value;
            var txtOther = document.getElementById("otherReason");
            txtOther.required=false;
            // txtOther.style.display.none = selectedValue == "Other" ? false : true;
            if(selectedValue == "Other"){
              txtOther.style.display='block';
              txtOther.focus();
              txtOther.required=true;
            }else {
              txtOther.style.display='none';
              txtOther.required=false;
        }
      }

      function CheckLeaveDay(leave_days) {
            var selectedValue = leave_days.options[leave_days.selectedIndex].value;
            var txtOther = document.getElementById("halfday");
            var txtRadio = document.getElementById("halfDay");
            var txtCheck = document.getElementById("half_leave");
            var txtHours = document.getElementById("hourly_hours");
            var txtlabel = document.getElementById("hour");
            var EndDate = document.getElementById("end_date");
            txtCheck.required=false;
            txtHours.required=false;
            // txtCheck.required=false;
            if(selectedValue == "half"){
              txtOther.style.display='block';
              txtRadio.style.display='block';
              txtCheck.required=true;
            }else {
              txtOther.style.display='none';
              txtRadio.style.display='none';
              txtCheck.required=false;
        }

        if(selectedValue=="hourly"){
              txtHours.style.display='block';
              txtlabel.style.display='block';
              txtHours.required=true;
              txtHours.focus();
     }else{
        txtHours.style.display='none';
        txtlabel.style.display='none';
        txtHours.required=false;
      }
      if(selectedValue=="hourly" || selectedValue == "half" || selectedValue == "full"){
      EndDate.disabled=true;
      EndDate.required=false;
     }else{
        EndDate.disabled=false;
        EndDate.required=true;
     }

     if(selectedValue == "full"){
        const date1 = $("input[name=start_date]").val();
        const date2 = $("input[name=end_date]").val(date1); 
        const dura = $("input[name=duration]").val(1);
     }

    //  if(selectedValue == "intermittent"){
    //     const date1 = $("input[name=start_date]").val();
    //     const date2 = $("input[name=end_date]").val();
    //     const diffTime = Date.parse(date2) - Date.parse(date1);
    //     const diffDays = diffTime/1000/60/60/24;
    //     const dura = $("input[name=duration]").val(diffDays + 1 );
    //  }

     if(selectedValue == "multiple"){
        const date1 = $("input[name=start_date]").val();
        const date2 = $("input[name=end_date]").val();
        const dateParts = date1.split("-");
        const datePart = date2.split("-");
        const dt = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
        const dt_en = datePart[2] + "-" + datePart[1] + "-" + datePart[0];
        const diffTime = Date.parse(dt_en) - Date.parse(dt);
        const diffDays = diffTime/1000/60/60/24;
        const dura = $("input[name=duration]");
        dura.val(diffDays + 1 );
     }
  }
        </script>

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')

@section('content')
<style>
    .transferform h3 {
        text-align: center;
        padding-bottom: 20px;
        margin: 0;
        font-size: 27px;
    }

    .transfer-form {
        padding-bottom: 20px;
    }

    .submit-btn{
        width: 7%;
        text-align: center;
        line-height: 19px;
    }

    .cancle-btn{
        margin-left: 20px;
    }

    #instiorschoolother{
        display: none;
    }
</style>
      <div class="page-wrapper">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body wizard-content">
                @if( isset( $transfer ) )
                <h4 class="card-title">Edit Transfer</h4>
                @else
                <h4 class="card-title">Add Transfer</h4>
                @endif

                @if( isset( $transfer ) )
                <form id="" action="{{route('transfer.update',[$transfer->id])}}" method="POST" autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
                @else
                <form id="example-form" action="{{ route('transfer.store')}}" method="POST" class="mt-3"autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
                @endif

                        <div role="application" class="wizard clearfix" id="steps-uid-0">
                            <div class="content clearfix transferform">
                                <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                    class="body current">
                                    <h3>Transfer Profile</h3>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transferclass">Source Transfer Class*</label>
                                            <input type="text" class="form-control" name="transferclass" readonly value="{{$transferclass->classname}}" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="transfertype">Transfer Type*</label>
                                            <select class="js-example-basic-single" name="transfertype" required>
                                                <option></option>
                                                @foreach($transertype as $transertypes)
                                                <option {{ ( isset( $transfer->transfertype ) &&
                                                    ($transfer->transfertype == $transertypes->typetitle) ? 'selected' :
                                                    '' ) }} value="{{ $transertypes->typetitle
                                                    }}">{{$transertypes->typetitle}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transfercategory">Transfer Category*</label>
                                            
                                            <select class="js-example-basic-single" name="transfercategory" id="transfercategory" required>
                                                <option></option>
                                                @foreach($transfercategory as $transfercategorys)
                                                <option {{ ( isset( $transfer->transfercategory ) &&
                                                    ($transfer->transfercategory == $transfercategorys->categoryname) ?
                                                    'selected' : '' ) }} value="{{ $transfercategorys->categoryname
                                                    }}">{{$transfercategorys->categoryname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <?php   
                                            if(Auth::user()->role != null){
                                                $con = Auth::user()->employee->institution_id;
                                                $us = App\Models\User::where('id',$con)->first();
                                            }else{
                                                $us = Auth::user();
                                            }
                                        ?>
                                        @if(Auth::user()->role != null)
                                            <input type="hidden" name="nothing" id="nothing" readonly value="{{$us->id}}">
                                        @else
                                            <input type="hidden" name="nothing" id="nothing" readonly value="{{$us->id}}">
                                        @endif
                                        <div class="col-6 form-group">
                                            <label for="transferreason">Transfer Reason*</label>
                                            <select class="js-example-basic-single" name="transferreason" required>
                                                <option></option>
                                                @foreach($transferreason as $transferreasons)
                                                <option {{ ( isset( $transfer->transferreason ) &&
                                                    ($transfer->transferreason == $transferreasons->transferreason) ?
                                                    'selected' : '' ) }} value="{{ $transferreasons->transferreason
                                                    }}">{{$transferreasons->transferreason}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="nameofstaff">Name of Staff*</label>
                                            @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                            <input type="hidden" class="form-control" name="nameofstaff" readonly value="{{$employees}}" required>
                                            <input type="text" class="form-control" name="name" readonly value="{{$emp->fname}}" required>
                                            @else
                                                <select class="js-example-basic-single" name="nameofstaff"  id="nameofstaff" required>
                                                <option></option>
                                                @foreach($employee as $employees)
                                                
                                                <option {{ ( isset( $transfer->nameofstaff ) && ($transfer->nameofstaff ==
                                                    $employees->id) ? 'selected' : '' ) }} value="{{$employees->id}}">{{$employees->fname}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="staffid">Staff ID</label>
                                            @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                                <input type="text" class="form-control" name="staffid" readonly value="{{isset($emp->official_information) ? $emp->official_information->staff_id : '';}}" required>
                                            @else
                                                <select class="js-example-basic-single" name="staffid" id="staffid" required>
                                                    <option></option>
                                                    @foreach($officialinfos as $officialinfo)
                                                    <option {{ ( isset( $transfer->staffid ) && ($transfer->staffid ==
                                                        $officialinfo->id) ? 'selected' : '' ) }} value="{{
                                                        $officialinfo->id }}">{{$officialinfo->staff_id}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row transfer-form">
                                        <div class="col-6 form-group">
                                            <label for="faculty">School/Directorate</label>
                                            @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                            <input type="hidden" class="form-control" name="faculty" value="{{isset($emp->official_information) ? $emp->official_information->directorate : ''}}" readonly required>
                                            <input type="text" class="form-control" name="faculty1" value="{{isset($emp->official_information) ? $emp->official_information->faculty_dt->facultyname : ''}}" readonly required>
                                            @else
                                            <select class="js-example-basic-single" name="faculty" id="faculty" required>
                                                <option></option>
                                                @foreach($facultydirectorates as $facultydirectorate)
                                                <option {{ ( isset( $transfer->faculty ) && ($transfer->faculty ==
                                                    $facultydirectorate->id) ? 'selected' : '' ) }} value="{{
                                                    $facultydirectorate->id
                                                    }}">{{$facultydirectorate->facultyname}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="department">Department*</label>
                                           @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                           <input type="hidden" class="form-control" name="department" value="{{isset($emp->official_information) ? $emp->official_information->department : ''}}" readonly required>
                                            <input type="text" class="form-control" name="department1" value="{{isset($emp->official_information) ? $emp->official_information->departments_dt->departmentname : ''}}" readonly required>
                                            @else
                                            <select class="js-example-basic-single" name="department" id="department" required>
                                                <option></option>
                                                @foreach($departments as $department)
                                                <option {{ ( isset( $transfer->department ) && ($transfer->department ==
                                                    $department->id) ? 'selected' : '' ) }} value="{{
                                                    $department->id }}">{{$department->departmentname}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="unit">Unit*</label>
                                           @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                            <input type="hidden" class="form-control" name="unit" value="{{isset($emp->official_information) ? $emp->official_information->unit : ''}}" readonly required>
                                            <input type="text" class="form-control" name="unit1" value="{{isset($emp->official_information->unit_dt) ? $emp->official_information->unit_dt->name : ''}}" readonly>
                                            @else
                                            <select class="js-example-basic-single" name="unit" id="unit" required>
                                                <option></option>
                                                @foreach($units as $unit)
                                                <option {{ ( isset( $transfer->unit ) && ($transfer->unit ==
                                                    $unit->id) ? 'selected' : '' ) }} value="{{
                                                    $unit->id }}">{{$unit->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="previous_role">Role*</label>
                                           @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                           <input type="text" class="form-control" name="previous_role" @if(Auth::user()->role == 'HOF') value="HOS" @else value="{{isset($emp->official_information) ? $emp->official_information->role : ''}}" @endif  readonly required>
                                            @else
                                            <select class="js-example-basic-single" name="previous_role" id="previous_role" required>
                                                <option></option>
                                                <option {{ ( isset( $transfer->previous_role ) && ($transfer->previous_role ==
                                                    "Employee") ? 'selected' : '' ) }} value="Employee">Employee
                                                </option>
                                                <option {{ ( isset( $transfer->previous_role ) && ($transfer->previous_role ==
                                                    "HOU") ? 'selected' : '' ) }} value="HOU">HOU
                                                </option>
                                                <option {{ ( isset( $transfer->previous_role ) && ($transfer->previous_role ==
                                                    "HOD") ? 'selected' : '' ) }} value="HOD">HOD
                                                </option>
                                                <option {{ ( isset( $transfer->previous_role ) && ($transfer->previous_role ==
                                                    "HOF") ? 'selected' : '' ) }} value="HOF">HOS
                                                </option>
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="previous_designation">Designation*</label>
                                            @if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF')
                                            <input type="hidden" class="form-control" name="previous_designation" value="{{isset($emp->official_information) ? $emp->official_information->designation : ''}}" readonly required>
                                            <input type="text" class="form-control" name="previous_designation1" value="{{isset($emp->official_information->designations) ? $emp->official_information->designations->title : ''}}" readonly>
                                            @else
                                            <select class="js-example-basic-single" name="previous_designation" id="previous_designation" required>
                                                <option></option>
                                                @foreach($desig as $desigs)
                                                <option {{ ( isset( $transfer->previous_designation ) &&
                                                    ($transfer->previous_designation == $desigs->id) ? 'selected' : '' ) }}
                                                    value="{{ $desigs->id }}">{{$desigs->title}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <h3>Perferred Destination(Transfer To)</h3>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transferclassIn">Destination Transfer Class*</label>
                                            <input type="text" class="form-control" name="transferclassIn" readonly value="{{$transferclassIn->classname}}" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="institutionname">Institution Name / School/Directorate Name*</label>
                                            <select class="js-example-basic-single instiorschool" name="institutionname" id="institutionname" required>
                                                <option></option>
                                                
                                                @foreach($users as $user)
                                                <option {{ ( isset( $transfer->institutionname ) &&
                                                    ($transfer->institutionname ==
                                                    $user->id) ? 'selected' :
                                                    '' ) }} value="{{ $user->id
                                                    }}">{{$user->institutionname}}</option>
                                                @endforeach
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group" id="instiorschoolother">
                                            <label for="other">Other</label>
                                            <input id="other" name="other" type="text" class="@if( isset( $transfer->other ) && $transfer->other != 'other' ) required @endif form-control" value="{{ (( isset($transfer->other) ) ? $transfer->other->other: '')}}" />
                                          </div>
                                        <div class="col-6 form-group">
                                            <label for="faculty">School/Directorate*</label>
                                            <select class="js-example-basic-single" name="transferfaculty" id="transferfaculty" required>
                                                <option></option>
                                                @foreach($facultydirectorates as $facultydirectorate)
                                                <option {{ ( isset( $transfer->transferfaculty ) &&
                                                    ($transfer->transferfaculty == $facultydirectorate->id) ?
                                                    'selected' : '' ) }} value="{{ $facultydirectorate->id
                                                    }}">{{$facultydirectorate->facultyname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="transferdepartment">Department*</label>
                                            <select class="js-example-basic-single" name="transferdepartment" id="transferdepartment" required>
                                                <option></option>
                                                @foreach($departments as $department)
                                                <option {{ ( isset( $transfer->transferdepartment ) &&
                                                    ($transfer->transferdepartment == $department->id) ?
                                                    'selected' : '' ) }} value="{{ $department->id
                                                    }}">{{$department->departmentname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transferunit">Unit</label>
                                            <select class="js-example-basic-single" name="transferunit" id="transferunit" required>
                                                <option></option>
                                                @foreach($units as $unit)
                                                <option {{ ( isset( $transfer->transferunit ) &&
                                                    ($transfer->transferunit == $unit->id) ? 'selected' : '' ) }}
                                                    value="{{ $unit->id }}">{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="role">Role*</label>
                                            <select class="js-example-basic-single" name="role" id="role" required>
                                                <option></option>
                                                <option {{ ( isset( $transfer->role ) && ($transfer->role ==
                                                    "Employee") ? 'selected' : '' ) }} value="Employee">Employee
                                                </option>
                                                <option {{ ( isset( $transfer->role ) && ($transfer->role ==
                                                    "HOU") ? 'selected' : '' ) }} value="HOU">HOU
                                                </option>
                                                <option {{ ( isset( $transfer->role ) && ($transfer->role ==
                                                    "HOD") ? 'selected' : '' ) }} value="HOD">HOD
                                                </option>
                                                <option {{ ( isset( $transfer->role ) && ($transfer->role ==
                                                    "HOF") ? 'selected' : '' ) }} value="HOF">HOS
                                                </option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-12'>
                                            @if(isset($initiatedata) && $initiatedata != '')
                                            <input type="hidden" name="initiate" value="{{$initiatedata}}" />
                                            @endif
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="designation">Designation*</label>
                                            <select class="js-example-basic-single" name="designation" id="designation" required>
                                                <option></option>
                                                @foreach($desig as $desigs)
                                                <option {{ ( isset( $transfer->designation ) &&
                                                    ($transfer->designation == $desigs->id) ? 'selected' : '' ) }}
                                                    value="{{ $desigs->id }}">{{$desigs->title}}</option>
                                                @endforeach
                                            </select>      
                                        </div>
                                    </div>
                                    
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 change-btn form-group">
                                <button type="submit" class="btn btn-primary submit-btn">Apply</butto>
                                <button href="" class="btn btn-primary cancle-btn submit-btn">Cancel</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            placeholder: "Select",
            allowClear: true
        });

        $("#nameofstaff").on('change', function () {

                var stffname = this.value;
                
                $("#staffid").html('');
                $("#faculty").html('');
                $("#department").html('');
                $("#unit").html('');
                $("#previous_role").html('');
                $("#previous_designation").html('');
                $.ajax({
                    url: "{{url('fetch-OfficialInfo')}}",
                    type: "POST",
                    data: {
                      employee_id: stffname,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        console.log( res.Employee_OfficialInfo.designation);
                        // alert(res.Employee_OfficialInfo.unit);
                        $('#staffid').append('<option value="' + res.Employee_OfficialInfo.staff_id +
                        '">'+ res.Employee_OfficialInfo.staff_id +'</option>');
                        $('#faculty').append('<option value="' + res.Employee_OfficialInfo.directorate +
                        '">'+ res.Employee_OfficialInfo.faculty_dt.facultyname +'</option>');
                        $('#department').append('<option value="' + res.Employee_OfficialInfo.department +
                        '">'+ res.Employee_OfficialInfo.departments_dt.departmentname +'</option>');
                        $('#unit').append('<option value="' + res.Employee_OfficialInfo.unit +
                        '">'+ res.Employee_OfficialInfo.unit_dt.name +'</option>');
                        $('#previous_role').append('<option value="' + res.Employee_OfficialInfo.role +
                        '">'+ res.Employee_OfficialInfo.role +'</option>');
                        $('#previous_designation').append('<option value="' + res.Employee_OfficialInfo.designation +
                        '">'+ res.Employee_OfficialInfo.designations.title +'</option>');
                    }
                });
            });

            $('#institutionname').on('change', function () {
                var idInsti = this.value;
                // alert(idInsti)
                $("#transferfaculty").html('');
                $.ajax({
                    url: "{{url('FetchFaculty')}}",
                    type: "POST",
                    data: {
                      insti_id: idInsti,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#transferfaculty').html('<option value="">-- Select School/Directorate --</option>');
                        $.each(result.fac, function (key, value) {
                            $("#transferfaculty").append('<option value="' + value
                                .id + '">' + value.facultyname + '</option>');
                        });
                    }
                });
            });

            $('#transferfaculty').on('change', function () {
                var idfac = this.value;
                $("#transferdepartment").html('');
                $.ajax({
                    url: "{{url('FetchDepartment')}}",
                    type: "POST",
                    data: {
                      faculty_id: idfac,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#transferdepartment').html('<option value="">-- Select Department --</option>');
                        $.each(result.depart, function (key, value) {
                            $("#transferdepartment").append('<option value="' + value
                                .id + '">' + value.departmentname + '</option>');
                        });
                        $('#transferunit').html('<option value="">-- Select Unit --</option>');
                    }
                });
            });

            $('#transferdepartment').on('change', function () {
                var idDepart = this.value;
                $("#transferunit").html('');
                $("#designation").html('');
                $.ajax({
                    url: "{{url('FetchUnit')}}",
                    type: "POST",
                    data: {
                      depart_id: idDepart,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#transferunit').html('<option value="">-- Select Unit --</option>');
                        $('#designation').html('<option value="">-- Select Designation --</option>');
                        $.each(result.FetchUnits, function (key, value) {
                            $("#transferunit").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $.each(result.FetchDesig, function (key, value) {
                            $("#designation").append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                    }
                });
            });
            $('#transfercategory').on('change', function () {
                var idcategory = this.value;
                var nothing =$("#nothing").val();
                $("#institutionname").html('');
                $('#transferfaculty').html('');
                $("#transferdepartment").html('');
                $("#transferunit").html('');
                $.ajax({
                    url: "{{url('FetchInsti')}}",
                    type: "POST",
                    data: {
                      user_id: nothing,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(idcategory === "Intra"){
                            $("#institutionname").append('<option value="' + result.insti_intra
                            .id + '">' + result.insti_intra.institutionname + '</option>');
                            $('#transferfaculty').html('<option value="">-- Select School/Directorate --</option>');
                            $.each(result.fac_intra, function (key, value) {
                                $("#transferfaculty").append('<option value="' + value
                                    .id + '">' + value.facultyname + '</option>');
                            });
                        }else{
                            $('#institutionname').html('<option value="">-- Select Institute --</option>');
                            $.each(result.Insti_user, function (key, value) {
                                $("#institutionname").append('<option value="' + value
                                    .id + '">' + value.institutionname + '</option>');
                            });
                        }
                    }
                });
            });

    });
</script>
<!-- institution or school other field -->
<script>
    $(function() {
    //$('#officialinfoshow').hide(); 
    $('.instiorschool').change(function() {
      if ($('.instiorschool').val() == 'other') {
        $('#instiorschoolother').show();
      } else {
        $('#instiorschoolother').hide();
      }
    });
  });
</script>
@endsection
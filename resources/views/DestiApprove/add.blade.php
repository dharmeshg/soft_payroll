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

    .submit-btn {
        width: 7%;
        text-align: center;
        line-height: 19px;
    }

    .cancle-btn {
        margin-left: 20px;
    }
    #processinstiorschool{
        display: none;
    }
</style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                @if( isset( $approvetransfer ) )
                <h4 class="card-title">Edit Approve Transfer</h4>
                @else
                <h4 class="card-title">Add Approve Transfer</h4>
                @endif

                @if( isset( $approvetransfer ) )
                <form id="" action="{{route('destination.update',[$approvetransfer->id])}}" method="POST"
                    autocomplete="off" data-parsley-validate="">
                    {{ csrf_field() }}
                    
                    @else
                    <form id="example-form" action="{{ route('approvetransfer.store')}}" method="POST" class="mt-3"
                        autocomplete="off" data-parsley-validate="">
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
                                            <input type="text" class="form-control" name="transferclass" readonly value="{{$approvetransfer->transferclass}}" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="transfertype">Transfer Type*</label>
                                            <select class="js-example-basic-single" name="transfertype">
                                                <option></option>
                                                @foreach($transertype as $transertypes)
                                                <option {{ ( isset( $approvetransfer->transfertype ) &&
                                                    ($approvetransfer->transfertype == $transertypes->typetitle) ? 'selected' :
                                                    '' ) }} value="{{ $transertypes->typetitle
                                                    }}">{{$transertypes->typetitle}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transfercategory">Transfer Category*</label>
                                            <select class="js-example-basic-single" name="transfercategory">
                                                <option></option>
                                                @foreach($transfercategory as $transfercategorys)
                                                <option {{ ( isset( $approvetransfer->transfercategory ) &&
                                                    ($approvetransfer->transfercategory == $transfercategorys->categoryname) ?
                                                    'selected' : '' ) }} value="{{ $transfercategorys->categoryname
                                                    }}">{{$transfercategorys->categoryname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="transferreason">Transfer Reason*</label>
                                            <select class="js-example-basic-single" name="transferreason">
                                                <option></option>
                                                @foreach($transferreason as $transferreasons)
                                                <option {{ ( isset( $approvetransfer->transferreason ) &&
                                                    ($approvetransfer->transferreason == $transferreasons->transferreason) ?
                                                    'selected' : '' ) }} value="{{ $transferreasons->transferreason
                                                    }}">{{$transferreasons->transferreason}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="nameofstaff">Name of Staff*</label>
                                            <select class="js-example-basic-single" name="nameofstaff">
                                                <option></option>
                                                @foreach($employee as $employees)
                                                <option {{ ( isset( $approvetransfer->nameofstaff ) && ($approvetransfer->nameofstaff
                                                    ==
                                                    $employees->id) ? 'selected' : '' ) }} value="{{
                                                    $employees->id }}">{{$employees->fname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="staffid">Staff ID</label>
                                            <select class="js-example-basic-single" name="staffid">
                                                <option></option>
                                                @foreach($officialinfos as $officialinfo)
                                                <option {{ ( isset( $approvetransfer->staffid ) && ($approvetransfer->staffid ==
                                                    $officialinfo->staff_id) ? 'selected' : '' ) }} value="{{
                                                    $officialinfo->staff_id}}">{{$officialinfo->staff_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row transfer-form">
                                        <div class="col-6 form-group">
                                            <label for="faculty">Faculty</label>
                                            <select class="js-example-basic-single" name="faculty">
                                                <option></option>
                                                @foreach($facultydirectorates as $facultydirectorate)
                                                <option {{ ( isset( $approvetransfer->faculty ) && ($approvetransfer->faculty ==
                                                    $facultydirectorate->id) ? 'selected' : '' ) }} value="{{
                                                    $facultydirectorate->id
                                                    }}">{{$facultydirectorate->facultyname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="department">Department*</label>
                                            <select class="js-example-basic-single" name="department">
                                                <option></option>
                                                @foreach($departments as $department)
                                                <option {{ ( isset( $approvetransfer->department ) && ($approvetransfer->department ==
                                                    $department->id) ? 'selected' : '' ) }} value="{{
                                                    $department->id }}">{{$department->departmentname}}
                                                </option>
                                                @endforeach
                                            </select>
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
                                                <option {{ ( isset( $approvetransfer->unit ) && ($approvetransfer->unit ==
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
                                           <input type="text" class="form-control" name="previous_role" value="{{isset($emp->official_information) ? $emp->official_information->role : ''}}" readonly required>
                                            @else
                                            <select class="js-example-basic-single" name="previous_role" id="previous_role" required>
                                                <option></option>
                                                <option {{ ( isset( $approvetransfer->previous_role ) && ($approvetransfer->previous_role ==
                                                    "Employee") ? 'selected' : '' ) }} value="Employee">Employee
                                                </option>
                                                <option {{ ( isset( $approvetransfer->previous_role ) && ($approvetransfer->previous_role ==
                                                    "HOU") ? 'selected' : '' ) }} value="HOU">HOU
                                                </option>
                                                <option {{ ( isset( $approvetransfer->previous_role ) && ($approvetransfer->previous_role ==
                                                    "HOD") ? 'selected' : '' ) }} value="HOD">HOD
                                                </option>
                                                <option {{ ( isset( $approvetransfer->previous_role ) && ($approvetransfer->previous_role ==
                                                    "HOF") ? 'selected' : '' ) }} value="HOF">HOF
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
                                                @foreach($designations as $desigs)
                                                <option {{ ( isset( $approvetransfer->previous_designation ) &&
                                                    ($approvetransfer->previous_designation == $desigs->id) ? 'selected' : '' ) }}
                                                    value="{{ $desigs->id }}">{{$desigs->title}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <h3>Form details</h3>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="transferclass">Destination Transfer Class*</label>
                                            <input type="text" class="form-control" name="transferclassIn" readonly value="{{$approvetransfer->transferclassIn}}" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="institutionname">Institution Name / School Name*</label>
                                            <select class="js-example-basic-single instiorschool" name="institutionname">
                                                <option></option>
                                                @foreach($users as $user)
                                                <option {{ ( isset( $approvetransfer->institutionname ) &&
                                                    ($approvetransfer->institutionname ==
                                                    $user->id) ? 'selected' :
                                                    '' ) }} value="{{ $user->id
                                                    }}">{{$user->institutionname}}</option>
                                                @endforeach
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group" id="processinstiorschool">
                                            <label for="other">Other</label>
                                            <input id="other" name="other" type="text" class="@if( isset( $transfer->other ) && $transfer->other != 'other' ) required @endif form-control" value="{{ (( isset($transfer->other) ) ? $transfer->other->other: '')}}" />
                                          </div>
                                        <div class="col-6 form-group">
                                            <label for="faculty">Faculty*</label>
                                            <select class="js-example-basic-single" name="transferfaculty">
                                                <option></option>
                                                @foreach($facultydirectorates as $facultydirectorate)
                                                <option {{ ( isset( $approvetransfer->transferfaculty ) &&
                                                    ($approvetransfer->transferfaculty == $facultydirectorate->id) ?
                                                    'selected' : '' ) }} value="{{ $facultydirectorate->id
                                                    }}">{{$facultydirectorate->facultyname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="department">Department*</label>
                                            <select class="js-example-basic-single" name="transferdepartment">
                                                <option></option>
                                                @foreach($departments as $department)
                                                <option {{ ( isset( $approvetransfer->transferdepartment ) &&
                                                    ($approvetransfer->transferdepartment == $department->id) ?
                                                    'selected' : '' ) }} value="{{ $department->departmentname
                                                    }}">{{$department->departmentname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="unit">Unit*</label>
                                            <select class="js-example-basic-single" name="transferunit">
                                                <option></option>
                                                @foreach($units as $unit)
                                                <option {{ ( isset( $approvetransfer->transferunit ) &&
                                                    ($approvetransfer->transferunit == $unit->id) ? 'selected' : '' ) }}
                                                    value="{{ $unit->id }}">{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="role">Role*</label>
                                            <select class="js-example-basic-single" name="role" id="role" required>
                                                <option></option>
                                                <option {{ ( isset( $approvetransfer->role ) && ($approvetransfer->role ==
                                                    "Employee") ? 'selected' : '' ) }} value="Employee">Employee
                                                </option>
                                                <option {{ ( isset( $approvetransfer->role ) && ($approvetransfer->role ==
                                                    "HOU") ? 'selected' : '' ) }} value="HOU">HOU
                                                </option>
                                                <option {{ ( isset( $approvetransfer->role ) && ($approvetransfer->role ==
                                                    "HOD") ? 'selected' : '' ) }} value="HOD">HOD
                                                </option>
                                                <option {{ ( isset( $approvetransfer->role ) && ($approvetransfer->role ==
                                                    "HOF") ? 'selected' : '' ) }} value="HOF">HOF
                                                </option>
                                            </select>
                                            
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="designation">Designation*</label>
                                            <select class="js-example-basic-single" name="designation" id="designation" required>
                                                <option></option>
                                                @foreach($designations as $desigs)
                                                <option {{ ( isset( $approvetransfer->designation ) &&
                                                    ($approvetransfer->designation == $desigs->id) ? 'selected' : '' ) }}
                                                    value="{{ $desigs->id }}">{{$desigs->title}}</option>
                                                @endforeach
                                            </select>      
                                        </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-12 change-btn form-group form-group">
                                        <a href="{{route('destination.approveform',[$approvetransfer->id])}}" class="btn btn-primary submit-btn">Process</a>
                                        <a href="#" class="btn btn-primary cancle-btn submit-btn">Cancel</a>
                                      </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(function () {
        $('input[type="file"]').change(function () {
            if ($(this).val() != "") {
                $(this).css('color', '#333');
            } else {
                $(this).css('color', 'transparent');
            }
        });
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            placeholder: "--Select--",
            allowClear: true
        });
    });
</script>
<!-- institution or school other field -->
<script>
    $(function() {
    //$('#officialinfoshow').hide(); 
    $('.instiorschool').change(function() {
      if ($('.instiorschool').val() == 'other') {
        $('#processinstiorschool').show();
      } else {
        $('#processinstiorschool').hide();
      }
    });
  });
</script>
@endsection
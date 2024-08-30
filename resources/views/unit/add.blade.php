<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- @extends('layouts.institute') --}}
@extends('layouts.employee')
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

@section('content')
    <div class="page-wrapper">

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Unit</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <!-- <ol class="breadcrumb">
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
                    @if (isset($unit))
                        <h4 class="card-title">Edit Unit </h4>
                    @else
                        <h4 class="card-title">Add Unit</h4>
                    @endif


                    @if (isset($unit))
                        <form id="" action="{{ route('unit.update', [$unit->id]) }}" method="POST"
                            autocomplete="off" data-parsley-validate="">
                            {{ csrf_field() }}
                        @else
                            <form id="example-form" action="{{ route('unit.store') }}" method="POST" class="mt-3"
                                autocomplete="off" data-parsley-validate="">
                                {{ csrf_field() }}
                    @endif

                    


                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                        <div class="content clearfix">

                            <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                class="body current">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="name">Unit Name*</label>
                                    <input id="name" name="name" type="text" class="required form-control"
                                        required data-parsley-required-message="Please Enter Unit Name"
                                        value="{{ isset($unit->name) ? $unit->name : '' }}" />
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required=""
                                        data-parsley-required-message="Please Enter Description">{{ isset($unit->description) ? $unit->description : '' }}</textarea>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="directorate">Category</label>
                                    <select class="category_unit" name="category_unit" id="category_unit"
                                        @if (isset($unit->category) || Auth::user()->category != '') disabled @endif>
                                        <option
                                            {{ (isset($unit->category) && $unit->category) ||  Auth::user()->category == 'Academic' ? 'selected' : '' }}
                                            value="Academic">Academic</option>
                                        <option
                                            {{ (isset($unit->category) && $unit->category) || Auth::user()->category == 'Non-Academic' ? 'selected' : '' }}
                                            value="Non-Academic">Non-Academic</option>
                                    </select>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group academic_form">
                                    <label for="directorate">School/Directorate</label>
                                    <select class="js-directorate" name="directorate" id="directorate-dropdown" required
                                        data-parsley-required-message="Please Select School/Directorate">
                                        <option></option>
                                        @foreach ($faculty as $faculties)
                                            <option
                                                {{ isset($unit->faculty_id) && $unit->faculty_id == $faculties->id ? 'selected' : '' }}
                                                value="{{ $faculties->id }}">{{ $faculties->facultyname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group academic_form">
                                    <label for="department">Department</label>
                                    <select class="js-department" name="department" id="department-dropdown" required
                                        data-parsley-required-message="Please Select Department">
                                        <option>--Select Department--</option>
                                    </select>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group non_academic_form"
                                    style="display:none;">
                                    <label for="directorate">Department</label>
                                    <select class="js-nonacademic-directorate" name="noe_academic_department"
                                        id="noe_academic_department"
                                        data-parsley-required-message="Please Select Department">
                                        <option></option>
                                        @foreach ($nonAcademicDepartment as $faculties)
                                            <option
                                                {{ isset($unit->faculty_id) && $unit->faculty_id == $faculties->id ? 'selected' : '' }}
                                                value="{{ $faculties->id }}">{{ $faculties->departmentname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group non_academic_form"
                                    style="display:none;">
                                    <label for="department">Division</label>
                                    <select class="js-nonacademic-division" name="noe_academic_division"
                                        id="noe_academic_division" data-parsley-required-message="Please Select Division">
                                        <option>--Select Division--</option>
                                    </select>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if ($('#category_unit').val()) {
                set_academic($('#category_unit').val());

            }
            $('.js-directorate').select2({
                placeholder: "--Select School/Directorate--",
                allowClear: true
            });

            $('.js-department').select2({
                placeholder: "--Select Department--",
                allowClear: true
            });

            $('.js-nonacademic-directorate').select2({
                placeholder: "--Select Department--",
                allowClear: true
            });

            $('.js-nonacademic-division').select2({
                placeholder: "--Select Division--",
                allowClear: true
            });

            function set_academic(category_unit) {
                if (category_unit == 'Academic') {
                    $('.academic_form').css('display', 'block');
                    $('.non_academic_form').css('display', 'none');
                    $('#directorate-dropdown').attr('required', true);
                    $('#department-dropdown').attr('required', true);
                    $('#noe_academic_department').attr('required', false);
                    $('#noe_academic_division').attr('required', false);
                } else {
                    $('.academic_form').css('display', 'none');
                    $('.non_academic_form').css('display', 'block');
                    $('#directorate-dropdown').attr('required', false);
                    $('#department-dropdown').attr('required', false);
                    $('#noe_academic_department').attr('required', true);
                    $('#noe_academic_division').attr('required', true);

                }
            }

            $('#directorate-dropdown').on('change', function() {
                var directorate_id = this.value;
                //console.log(directorate_id);
                $("#department-dropdown").html('');
                $.ajax({
                    url: "{{ url('unit/department') }}",
                    type: "POST",
                    data: {
                        directorate_id: directorate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(result) {
                        $('#department-dropdown').html(
                            '<option value="">Select Department</option>');
                        $.each(result.departmentname, function(key, value) {
                            $("#department-dropdown").append('<option value="' + value
                                .id + '">' + value.departmentname + '</option>');
                        });
                    }
                });
            });
            @if (isset($unit->faculty_id) && $unit->faculty_id != null)
                var directorate_id = '{{ $unit->faculty_id }}';
                //console.log(directorate_id);
                $("#noe_academic_division").html('');
                $.ajax({
                    url: "{{ url('non-academic-unit/department') }}",
                    type: "POST",
                    data: {
                        directorate_id: directorate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(result) {
                        console.log(result);
                        $('#department-dropdown').html(
                            '<option value="">Select Division</option>');
                        $.each(result.division, function(key, value) {
                            $("#noe_academic_division").append('<option value="' + value
                                .id + '">' + value.departmentname + '</option>');
                        });
                    }
                });
            @endif

            $('#noe_academic_department').on('change', function() {
                var directorate_id = this.value;
                //console.log(directorate_id);
                $("#noe_academic_division").html('');
                $.ajax({
                    url: "{{ url('non-academic-unit/department') }}",
                    type: "POST",
                    data: {
                        directorate_id: directorate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(result) {
                        console.log(result);
                        $('#department-dropdown').html(
                            '<option value="">Select Division</option>');
                        $.each(result.division, function(key, value) {
                            $("#noe_academic_division").append('<option value="' + value
                                .id + '">' + value.departmentname + '</option>');
                        });
                    }
                });
            });

            @if (isset($unit->department_id) && $unit->department_id != null)
                var directorate_id = '{{ $unit->faculty_id }}';
                $("#department-dropdown").html('');
                $.ajax({
                    url: "{{ url('unit/department') }}",
                    type: "POST",
                    data: {
                        directorate_id: directorate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        //console.log(value.name);
                        $('#department-dropdown').html(
                            '<option value="">--Select Department--</option>');
                        var departname = '{{ $unit->department_id }}';

                        $.each(result.departmentname, function(key, value) {
                            var selected = '';
                            if (departname == value.id) {
                                var isselected = 'selected';
                            }
                            $("#department-dropdown").append('<option value="' + value.id +
                                '" ' + isselected + '>' + value.departmentname + '</option>'
                            );
                        });
                    }
                });
            @endif

            $('.category_unit').on('change', function() {
                var category_unit = $(this).val();
                if (category_unit == 'Academic') {
                    $('.academic_form').css('display', 'block');
                    $('.non_academic_form').css('display', 'none');

                    $('#directorate-dropdown').attr('required', true);
                    $('#department-dropdown').attr('required', true);
                    $('#noe_academic_department').attr('required', false);
                    $('#noe_academic_division').attr('required', false);
                } else {
                    $('.academic_form').css('display', 'none');
                    $('.non_academic_form').css('display', 'block');

                    $('#directorate-dropdown').attr('required', false);
                    $('#department-dropdown').attr('required', false);
                    $('#noe_academic_department').attr('required', true);
                    $('#noe_academic_division').attr('required', true);

                }


            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

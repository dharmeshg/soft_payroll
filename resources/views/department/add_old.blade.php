<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- @extends('layouts.institute') --}}
@extends('layouts.employee')
<style>
    .page-title-button button{
        padding: 10px 15px;
    }
    .page-title-button-right{
        margin-left: 15px;
    }
    .page-title-button .active{
        background-color: #e3ab27;
    }
</style>

@section('content')
    <div class="page-wrapper">

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    @if (isset($Department))
                        @if ($non_academic_department == '')
                            <h4 class="page-title">Department (Academic)</h4>
                        @else
                            <h4 class="page-title">Department (Non-Academic)</h4>
                        @endif
                    @else
                        <h4 class="page-title-button page-title-button-left"><button id="academic" class="active">Department (Academic)</button></h4>

                        <h4 class="page-title-button page-title-button-right"><button id="non_academic" class="">Department (Non-Academic)</button></h4>
                    @endif


                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <!--  <ol class="breadcrumb">
                                                                                                                                                                                                                                                                                      </ol> -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">

                <div class="card-body wizard-content academic_form"
                    @if ($non_academic_department != '') style="display:none;" @endif>
                    @if (isset($Department))
                        <h4 class="card-title">Edit Department</h4>
                    @else
                        <h4 class="card-title">Add Department</h4>
                    @endif

                    @if (isset($Department))
                        <form id="" action="{{ route('department.update', [$Department->id]) }}" method="POST"
                            class="mt-3 " data-parsley-validate="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        @else
                            <form id="example-form" action="{{ route('department.store') }}" method="POST" class=" mt-3"
                                autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                                {{ csrf_field() }}
                    @endif

                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                        <div class="content clearfix">

                            <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                class="body current">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="name">Department Name*</label>
                                    <input id="departmentname" name="departmentname" type="text"
                                        class="required form-control" required
                                        data-parsley-required-message="Please Enter Department Name"
                                        value="{{ isset($Department->departmentname) ? $Department->departmentname : '' }}" />
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control" id="departmentdescription" name="departmentdescription" rows="3" required=""
                                        data-parsley-required-message="Please Enter Description">{{ isset($Department->departmentdescription) ? $Department->departmentdescription : '' }}</textarea>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="directorate">School/Directorate</label>
                                    <select class="js-directorate" required=""
                                        data-parsley-required-message="Please Select School" name="directorate"
                                        id="directorate-dropdown">
                                        <option></option>
                                        @foreach ($faculty as $faculties)
                                            <option
                                                {{ isset($Department->faculty_id) && $Department->faculty_id == $faculties->id ? 'selected' : '' }}
                                                value="{{ $faculties->id }}">{{ $faculties->facultyname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div
                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 department-image form-group">
                                    <!--  <label for="imageupload">Image Upload*</label> -->
                                    <label for="inputTag">Choose image</label>
                                    <input type="file" name="image"
                                        @if (!isset($Department)) required="" @endif class="fullwidth inputTag"
                                        id="inputTag">
                                    @error('image')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label>&nbsp;</label>
                                    @if (isset($Department->image) && $Department->image != '' && $Department->image != null)
                                        <img id="image_preview"
                                            src="{{ asset('public/images') }}/{{ $Department->image }}" alt="Kin Image"
                                            class="img-fluid" />
                                    @else
                                    @endif
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
                <div class="card-body wizard-content non_academic_form"
                    @if (isset($Department) && $non_academic_department != '') style="display:block;" @else style="display:none;" @endif>
                    @if (isset($Department))
                        <h4 class="card-title">Edit Department</h4>
                    @else
                        <h4 class="card-title">Add Department</h4>
                    @endif

                    @if (isset($Department))
                        <form id="" action="{{ route('non_academic_department.update', [$Department->id]) }}"
                            method="POST" class="mt-3 " data-parsley-validate="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        @else
                            <form id="example-form" action="{{ route('non_academic_department.store') }}" method="POST"
                                class="mt-3" autocomplete="off" data-parsley-validate=""
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                    @endif

                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                        <div class="content clearfix">

                            <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                class="body current">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="name">Department Name*</label>
                                    <input id="departmentname" name="departmentname" type="text"
                                        class="required form-control" required
                                        data-parsley-required-message="Please Enter Department Name"
                                        value="{{ isset($Department->departmentname) ? $Department->departmentname : '' }}" />
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control" id="departmentdescription" name="departmentdescription" rows="3"
                                        required="" data-parsley-required-message="Please Enter Description">{{ isset($Department->departmentdescription) ? $Department->departmentdescription : '' }}</textarea>
                                </div>

                                <div
                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 department-image form-group">
                                    <!--  <label for="imageupload">Image Upload*</label> -->
                                    <label for="inputTag">Choose image</label>
                                    <input type="file" name="image"
                                        @if (!isset($Department)) required="" @endif class="fullwidth inputTag"
                                        id="inputTag">
                                    @error('image')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label>&nbsp;</label>
                                    @if (isset($Department->image) && $Department->image != '' && $Department->image != null)
                                        <img id="image_preview"
                                            src="{{ asset('public/images') }}/{{ $Department->image }}" alt="Kin Image"
                                            class="img-fluid" />
                                    @else
                                    @endif
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-directorate').select2({
                placeholder: "--Select School/Directorate--",
                allowClear: true
            });


            $(document).on("click", "#academic", function() {
                $('.non_academic_form').css('display', 'none');
                $('.academic_form').css('display', 'block');
                $("#non_academic").removeClass("active")
                $("#academic").addClass("active")

            });

            $(document).on("click", "#non_academic", function() {
                $('.academic_form').css('display', 'none');
                $('.non_academic_form').css('display', 'block');
                $("#academic").removeClass("active")
                $("#non_academic").addClass("active")
            });
        });
        $(function() {
            $('input[type="file"]').change(function() {
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
@endsection

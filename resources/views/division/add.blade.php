<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- @extends('layouts.institute') --}}
@extends('layouts.employee')

@section('content')
    <div class="page-wrapper">

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">

                    <h4 class="page-title">Division</h4>



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
                    @if (isset($Department))
                        <h4 class="card-title">Edit Division</h4>
                    @else
                        <h4 class="card-title">Add Division</h4>
                    @endif

                    @if (isset($Department))
                        <form id="" action="{{ route('division.update', [$Department->id]) }}" method="POST"
                            class="mt-3 " data-parsley-validate="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        @else
                            <form id="example-form" action="{{ route('division.store') }}" method="POST" class=" mt-3"
                                autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                                {{ csrf_field() }}
                    @endif

                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                        <div class="content clearfix">

                            <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                class="body current">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="name">Division Name*</label>
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
                                    <label for="directorate">Department</label>
                                    <select class="js-directorate" required=""
                                        data-parsley-required-message="Please Select Department" name="directorate"
                                        id="directorate-dropdown">
                                        <option></option>
                                        @foreach ($faculty as $faculties)
                                            <option
                                                {{ isset($Department->faculty_id) && $Department->faculty_id == $faculties->id ? 'selected' : '' }}
                                                value="{{ $faculties->id }}">{{ $faculties->departmentname }}</option>
                                        @endforeach
                                    </select>
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
                placeholder: "--Select Department--",
                allowClear: true
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

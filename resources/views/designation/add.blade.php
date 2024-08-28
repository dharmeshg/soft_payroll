{{--@extends('layouts.institute')--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')

@section('content')
<style>
  
  input[type='file'] {
  color: transparent;
}
    .select2-container {
        width: 100% !important;
    }
/*.department-image input{
  display: none!important;
}*/

/*.department-image .imageupload{
  font-size: 16px;
    line-height: 25px;
    background-color: #fff;
    text-align: center;
    padding: 3px 0;
    width: 65%;
}*/
</style>
<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Designation</h4>
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
              @if( isset( $designation ) )
              <h4 class="card-title">Edit Designation</h4>
              @else
              <h4 class="card-title">Add Designation</h4>
              @endif
             
              @if( isset( $designation ) )
              <form id="" action="{{route('designation.update',[$designation->id])}}" method="POST" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
              {{ csrf_field() }}
              @else
              <form id="example-form" action="{{ route('designation.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
              @endif

                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                   <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="title">Title*</label>
                    <input
                      id="title"
                      name="title"
                      type="text"
                      class="required form-control"
                      required
                      data-parsley-required-message="Please Enter Title"
                      value="{{ (( isset($designation->title) ) ? $designation->title: '')}}"
                    />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="description">Description*</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required="" data-parsley-required-message="Please Enter Description" name="description">{{ (( isset($designation->description) ) ? $designation->description: '')}}</textarea>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="directorate">Category</label>
                                    <select class="category_unit" name="category_unit" id="category_unit"
                                        @if (isset($designation->category)) disabled @endif>
                                        <option
                                            {{ isset($designation->category) && $designation->category == 'Academic' ? 'selected' : '' }}
                                            value="Academic">Academic</option>
                                        <option
                                            {{ isset($designation->category) && $designation->category == 'Non-Academic' ? 'selected' : '' }}
                                            value="Non-Academic">Non-Academic</option>
                                    </select>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group academic_form">
                      <label for="directorate">School/Directorate</label>
                      <select class="js-directorate" name="directorate" id="directorate-dropdown" required>
                        <option></option>
                        @foreach($faculty as $faculties)
                        <option {{ ( isset( $designation->faculty_id) && ($designation->faculty_id == $faculties->id) ? 'selected' : '' ) }} value="{{ $faculties->id }}">{{$faculties->facultyname}}</option>
                        @endforeach
                      </select>
                    </div>
           
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group academic_form">
                      <label for="department">Department</label>
                      <select class="js-department" name="department" id="department-dropdown" required>
                        <option></option>
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
                                                {{ isset($designation->faculty_id) && $designation->faculty_id == $faculties->id ? 'selected' : '' }}
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
                         <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 department-image form-group">
      
                            <label for="inputTag">Image Upload</label>
                            <input type="file" name="image" @if (!isset($designation)) required="" @endif class="fullwidth input rqd" id="inputTag">
                            @error('image')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                          <label>&nbsp;</label>
                          @if(isset($designation->image) && $designation->image != '' && $designation->image != NULL)
                          <img id="image_preview" src="{{asset('public/images')}}/{{$designation->image}}" alt="Kin Image" style="width:150px; height:150px" class="img-fluid" />
                          @else
                          @endif
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
              $(function () {
                 $('input[type="file"]').change(function () {
                      if ($(this).val() != "") {
                             $(this).css('color', '#333');
                      }else{
                             $(this).css('color', 'transparent');
                      }
                 });
            });
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
              $('#directorate-dropdown').on('change', function() {
                var directorate_id = this.value;
                //console.log(directorate_id);
                $("#department-dropdown").html('');
                $.ajax({
                  url: "{{url('department/designation')}}",
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
                  }
                });
              });

              @if(isset($designation->department_id) && $designation->department_id != NULL)
                var directorate_id = '{{$designation->faculty_id}}';     
                $("#department-dropdown").html('');
                $.ajax({
                  url: "{{url('department/designation')}}",
                  type: "POST",
                  data: {
                    directorate_id: directorate_id,
                    _token: '{{csrf_token()}}'
                  },
                  dataType: 'json',
                  success: function(result) {
                    //console.log(value.name);
                    $('#department-dropdown').html('<option value="">--Select Department--</option>');
                    var departname = '{{$designation->department_id}}';

                    $.each(result.departmentname, function(key, value) {
                      var selected = '';
                      if (departname == value.id) {
                        var isselected = 'selected';
                      }
                      $("#department-dropdown").append('<option value="' + value.id + '" ' + isselected + '>' + value.departmentname + '</option>');
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

            @if (isset($designation->faculty_id) && $designation->faculty_id != null)
                var directorate_id = '{{ $designation->faculty_id }}';
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

            
});
  </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
      @endsection
     
       
        
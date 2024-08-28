{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')


<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">School/Directorate</h4>
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
              @if( isset( $FacultyDirectorate ) )
              <h4 class="card-title">Edit School/Directorate</h4>
              @else
              <h4 class="card-title">Add School/Directorate</h4>
              @endif

              @if( isset( $FacultyDirectorate ) )
              <form id="" action="{{route('facultydirectorate.update',[$FacultyDirectorate->id])}}" method="POST" class="mt-3" data-parsley-validate="">
                {{ csrf_field() }}
              @else
              <form id="example-form" action="{{ route('facultydirectorate.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
              @endif            
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                   <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="name">School/Directorate Name*</label>
                    <input
                      id="facultyname"
                      name="facultyname"
                      type="text"
                      class="required form-control"
                      required
                      data-parsley-required-message="Please Enter Faculty Name"
                      value="{{ (( isset($FacultyDirectorate->facultyname) ) ? $FacultyDirectorate->facultyname: '')}}"
                    />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                    <label for="description">Description*</label>
                    <textarea class="form-control" id="faculty_description" name ="faculty_description" rows="3" required="" data-parsley-required-message="Please Enter Description">{{ (( isset($FacultyDirectorate-> faculty_description) ) ? $FacultyDirectorate-> faculty_description: '')}}</textarea>
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
        
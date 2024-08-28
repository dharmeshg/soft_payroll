@extends('layouts.app')

@section('content')



<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Designation</h4>
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
              <h4 class="card-title">Add Designation</h4>
              <form id="" action="{{ route('changePasswordPost')}}" method="POST" class="mt-3" data-parsley-validate="">
                {{ csrf_field() }}

                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                   <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <label for="title">Title*</label>
                    <input
                      id="title"
                      name="title"
                      type="text"
                      class="required form-control"
                      required
                      data-parsley-required-message="Please Enter Title"
                    />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <label for="description">Description*</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required="" data-parsley-required-message="Please Enter Description"></textarea>
                    </div>
                     <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 department-image">
                    <label for="imageupload">Image Upload*</label>
                    <label for="inputTag" class="imageupload">Choose image</label>
                    <input type="file" name="app_cvupload" required="" class="fullwidth input rqd" id="inputTag">
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
     
       
        
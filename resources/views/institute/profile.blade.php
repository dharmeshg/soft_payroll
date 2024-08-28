@extends('layouts.employee')

@section('content')

<style>


</style>

<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Edit Profile</h4>
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
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="card">
            <div class="card-body wizard-content">
              <form id="example-form" action="{{ route('institute.profile.update')}}" method="POST" class="mt-3" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                      <!--<div class="steps clearfix">
                          <a href="{{ route('index')}}">Account</a>
                          <a href="{{ route('changepasswordget')}}">Change Password</a>
                      </div>-->
                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                    
                      <div class="content clearfix">
                      
                      <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                      <div class="row">
                      <div class="col-sm-9">
                      <div class="form-group">
                            <label for="email"> Email*</label>
                            <input  id="email" name="email" type="email" class="required form-control" required value="{{Auth::user()->email}}" />
                        </div>

                        <div class="form-group">
                        <label for="moblie">Moblie *</label>
                            <input id="moblie" name="moblie" type="text" class="required form-control" required value="{{Auth::user()->mobile}}" />
                        </div>
                        <div class="form-group">
                            <label for="number">Contact_no *</label>
                            <input id="contact_no" name="contact_no" type="text" class="required form-control" required value="{{Auth::user()->contact_no}}"/>
                        </div>
                        <div class="form-group">
                        <label for="Address">Address*</label>
                            <input id="address" name="address" type="text" class="required form-control" value="{{Auth::user()->address}}"/> 
                        </div>
                        <div class="col-md-4 upload-image">
                            <div class="form-group">
                            <input type="file" name="image" placeholder="Choose image" id="imgInp">
                            @error('image')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                  <label>&nbsp;</label>
                    @if(isset(Auth::user()->image) && Auth::user()->image != '' && Auth::user()->image != NULL)
                        <img id="image_preview" src="{{asset('public/images')}}/{{Auth::user()->image}}" alt="User" class="img-fluid"/>
                    @else
                        <img id="image_preview" src="assets/images/users/6.jpg" alt="Image Icon" class="img-fluid"/>
                    @endif
                  </div>
                  </div>
                      </section>
                      </div>
                      <div class="row">
                        <div class="col-12 change-btn">
                          <button type="submit" class="btn btn-primary">Submit</button>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });

    $("#next").click(function {
          $("#newpost").hide();
          $("#newpost1").show();
      });
      $("#back").click(function {
          $("#newpost").show();
          $("#newpost1").hide();
      });
    </script>
@endsection
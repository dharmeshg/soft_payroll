@extends('layouts.app')

@section('content')


<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">School</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                <!--   <ol class="breadcrumb">
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
              @if( isset( $school ) )
              <h4 class="card-title">Edit School</h4>
              @else
              <h4 class="card-title">Add School</h4>
              @endif

             
              @if( isset( $school ) )
              <form id="" enctype="multipart/form-data" action="{{route('school.update',[$school->id])}}" method="POST" autocomplete="off" data-parsley-validate="">
              {{ csrf_field() }}
              @else
              <form id="example-form" enctype="multipart/form-data" action="{{ route('school.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
              @endif
          
              
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                    <div class="row">
                      <div class="col-3">
                         <label for="schoolname">School Name*</label>
                          <input
                            id="institutionname"
                            name="institutionname"
                            type="text"
                            class=" required form-control"
                            required=""
                            data-parsley-required-message="Please Enter Name"
                            value="{{ (( isset($school->institutionname) ) ? $school->institutionname: '')}}"
                          />
                      </div>
                      <div class="col-3">
                         <label for="contact_person">Contact Person*</label>
                          <input
                            id="contact_person"
                            name="contact_person"
                            type="text"
                            class="required form-control"
                            required=""
                            data-parsley-required-message="Please Enter contact Person"
                            value="{{ (( isset($school->contact_person) ) ? $school->contact_person: '')}}"
                          />
                      </div>
                      <div class="col-3">
                         <label for="contact_no">Contact No*</label>
                          <input
                            id="phoneno-inputmask"
                            name="contact_no"
                            type="text"
                            class="required form-control phoneno-inputmask"
                            required=""
                            data-parsley-required-message="Please Enter contact number"
                            value="{{ (( isset($school->contact_no) ) ? $school->contact_no: '')}}"
                          />
                      </div>
                      <div class="col-3">
                         <label for="website">Website Address*</label>
                          <input
                            id="website"
                            name="websiteaddress"
                            type="text"
                            class="required form-control website"
                            required=""
                            data-parsley-required-message="Please Enter Website Address"
                            value="{{ (( isset($school->websiteaddress) ) ? $school->websiteaddress: '')}}"
                          />
                      </div>
                    </div>

                    <div class="row mt-20">
                      <div class="col-3">
                        <label for="mobile">Mobile *</label>
                        <input
                          id="phoneno-inputmask"
                          name="mobile"
                          type="text"
                          class="required form-control phoneno-inputmask"
                          required=""
                          data-parsley-required-message="Please Enter Mobile number"
                          value="{{ (( isset($school->mobile) ) ? $school->mobile: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="email">Email *</label>
                        <input
                          id="email"
                          name="email"
                          type="email"
                          class="required form-control"
                          required=""
                          data-parsley-type="email"
                          value="{{ (( isset($school->email) ) ? $school->email: '')}}"
                        />
                      </div>
                      <div class="col-3"> 
                        <label for="password">Password @if(!isset($school))*@endif</label>
                        <input
                          id="anotherfield"
                          name="password"
                          type="password"
                          class="required form-control"                          
                          data-parsley-minlength="8"
                          value=""
                          @if(!isset($school)) required="true" @endif
                        />
                      </div>
                      <div class="col-3">
                        <label for="confirm_password">Confirm Password @if(!isset($school))*@endif</label>
                        <input
                          id="confirm_password"
                          name="confirm_password"
                          type="password"
                          class="required form-control"
                          @if(!isset($school)) required="true" @endif
                          data-parsley-equalto="#anotherfield"
                          value=""
                        />
                      </div>
                    </div>

                    <div class="row mt-20">
                      <div class="col-3">
                        <label for="address">Address *</label>
                        <input
                          id="address"
                          name="address"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter Address"
                          value="{{ (( isset($school->address) ) ? $school->address: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="pin_code">Pin Code *</label>
                        <input
                          id="pin_code"
                          name="pin_code"
                          type="text"
                          class="required form-control pincode-inputmask"
                          required=""
                          data-parsley-minlength="6"
                          value="{{ (( isset($school->pin_code) ) ? $school->pin_code: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="state">State *</label>
                        <input
                          id="state"
                          name="state"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter State"
                          value="{{ (( isset($school->state) ) ? $school->state: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="city">City *</label>
                        <input
                          id="city"
                          name="city"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter city"
                          value="{{ (( isset($school->city) ) ? $school->city: '')}}"
                        />
                      </div>
                    </div>
                    <div class="row mt-20">
                      <div class="col-3">
                        <label for="datecreated">Date Created *</label>
                        <input
                          id="datecreated"
                          name="datecreated"
                          type="text"
                          class="required form-control datepicker"
                          required=""
                          data-parsley-required-message="Please Enter Date Created"
                          value="{{ (( isset($school->datecreated) ) ? $school->datecreated: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="subscriptiondate">Subscription Date *</label>
                        <input
                          id="subscriptiondate"
                          name="subscriptiondate"
                          type="text"
                          class="required form-control datepicker"
                          required=""
                          data-parsley-required-message="Please Enter Subscription Date"
                          value="{{ (( isset($school->subscriptiondate) ) ? $school->subscriptiondate: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="registrationdate">Registration Date *</label>
                        <input
                          id="registrationdate"
                          name="registrationdate"
                          type="text"
                          class="required form-control datepicker"
                          required=""
                          data-parsley-required-message="Please Enter Registration Date"
                          value="{{ (( isset($school->state) ) ? $school->state: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="institutiontype">School Type *</label>
                        <input
                          id="institutiontype"
                          name="institutiontype"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter School Type"
                          value="{{ (( isset($school->institutiontype) ) ? $school->institutiontype: '')}}"
                        />
                      </div>
                    </div>
                    <div class="row mt-20">
                     <div class="col-3">
                        <label for="ownershiptype">Ownership Type *</label>
                        <input
                          id="ownershiptype"
                          name="ownershiptype"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter Registration Date"
                          value="{{ (( isset($school->ownershiptype) ) ? $school->ownershiptype: '')}}"
                        />
                      </div>
                      <div class="col-3">
                        <label for="institutionlocationcountry">School Location Country *</label>
                        <input
                          id="institutionlocationcountry"
                          name="institutionlocationcountry"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter School Location Country"
                          value="{{ (( isset($school->institutionlocationcountry) ) ? $school->institutionlocationcountry: '')}}"
                        />
                      </div>                                        
                      <div class="col-3">
                        <label for="instiimage">Upload School Logo</label>
                        <input type="file" name=" instiimage" required="" data-parsley-required-message="Please Upload Instution Logo" class="fullwidth inputTag" id="inputTag">
                      </div>
                      <div class="col-3">
                        <label for="institutionmotto">Create School Motto</label>
                        <input
                          id="institutionmotto"
                          name="institutionmotto"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Create Institution Motto"
                          value="{{ (( isset($school->institutionmotto) ) ? $school->institutionmotto: '')}}"
                        />                        
                      </div>                      
                    </div>
                    <!-- <br>
                    <hr>
                    <br>
                    <div class="row mt-20">                      
                      <div class="col-3">
                        <label for="dbname">Database *</label>
                        <input
                          id="dbname"
                          name="dbname"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter Database"
                          value="dbnbewg0eaiydn"
                          disabled
                        />
                      </div>
                      <div class="col-3">
                        <label for="dbuser">Database User *</label>
                        <input
                          id="dbuser"
                          name="dbuser"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter Database User"
                          value="uezuc79zggkbc"
                          disabled
                        />
                      </div>
                      <div class="col-3">
                        <label for="dbpassword">Database Password *</label>
                        <input
                          id="dbpassword"
                          name="dbpassword"
                          type="text"
                          class="required form-control"
                          required=""
                          data-parsley-required-message="Please Enter Database Password"
                          value="18cCe#2411`w"
                          disabled
                        />
                      </div>
                    </div> -->
                    
                  </section>
                  </div>
                  <div class="row">
                    <div class="col-12 change-btn">
                      <button type="submit" class="btn btn-primary">Save</button>
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
        <script type="text/javascript">
  $(document).ready(function() {
    $('.datepicker').datepicker({
      todayHighlight: true,
    });
  });
  
</script>
            @endsection
    
        
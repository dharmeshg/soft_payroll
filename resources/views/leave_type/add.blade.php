<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')


<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Leave Type</h4>
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
              <h4 class="card-title">Add LeaveType</h4>
             
              <form id="example-form" action="{{ route('leavetype.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_name">Leave Name*</label>
                      <input
                        id="leave_name"
                        name="leave_name"
                        type="text"
                        class="required form-control"
                        required
                        data-parsley-required-message="Leave Name"
                      />
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_description">Description*</label>
                      <textarea class="form-control" id="leave_description" name="leave_description" rows="3" required="" data-parsley-required-message="Please Enter Description"></textarea>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_cycle">Leave Cycle*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Plese Select Leave Cycle" name="leave_cycle" id="leave_cycle">
                        <option></option>
                        <option value="Fiscal Year">Fiscal Year (April to March)</option>
                        <option value="Anniversary Year">Anniversary Year</option>
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="days">Per Year Total Leave Days*</label>
                      <input
                        id="days"
                        name="days"
                        type="text"
                        class="required form-control"
                        required
                        data-parsley-required-message="Leave Days"
                      />
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group"> 
                      <label for="accrual_method" >Accrual Method :</label>
                      <input type="checkbox" name="accrual_method[]" class="fullwidth inputTag" id="accrual_method" value="Per Month">Per Month
                      <input type="checkbox" name="accrual_method[]" class="fullwidth inputTag" id="accrual_method" value="Per Year">Per Year
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="max_allow_days">Maximum allowed leave days*</label>
                      <input
                        id="max_allow_days"
                        name="max_allow_days"
                        type="text"
                        class="required form-control"
                        required
                        data-parsley-required-message="Please Enter Max Allow Leave Days"
                        onchange="TotalLeave()"
                      />
                      <p id="projectIDSelectError"></p>
                    </div>
                    <div class="row">
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group">
                      <!--  <label for="imageupload">Image Upload*</label> -->
                      <input type="checkbox" name="carryover_policy" class="fullwidth inputTag" id="carryover_policy">CarryOver Policy
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group remaning">
                      <!--  <label for="imageupload">Image Upload*</label> -->
                      <input type="checkbox" name="all_remaning_leaves" class="fullwidth inputTag" id="all_remaning_leaves">All Remaning Leaves
                    </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group carryforword">
                      <label for="max_leave_carry_forword">Max Leaves to Carry Forword *</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Days" name="max_leave_carry_forword" id="max_leave_carry_forword">
                      <option></option>
                      @for($i = 1; $i <= 60; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                      </select>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <!--  <label for="imageupload">Image Upload*</label> -->
                      <label for="rules" >Rules and Regulations*</label>
                      <textarea class="form-control" id="rules" name="rules" rows="3" required="" data-parsley-required-message="Please Enter Rules and Regulations"></textarea>
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
      <script>
            jQuery(document).ready( function () {
              $(".remaning").hide();
              $(".carryforword").hide();
              $("#carryover_policy").click(function(){
                    var showOrHide=$(this).is(':checked'); 
                    $(".remaning").toggle(showOrHide);
                    $(".carryforword").toggle(showOrHide);
                });
                $("#all_remaning_leaves").click(function(){
                    var showOrHide=$(this).is(':checked'); 
                    $(".carryforword").hide(showOrHide);
                    $("#max_leave_carry_forword").prop('required',false);
                });
                $("#all_remaning_leaves").click(function(){
                    var showOrHide=$(this).is(':unchecked'); 
                    $(".carryforword").toggle(showOrHide);
                });
            });
        </script>
        <script>
          function TotalLeave(){
            var total = $('#days').val();
            var max = $('#max_allow_days').val();
            // alert(total);
            // alert(max);
            if(total < max){
              $("#projectIDSelectError").html("Max Allow Days Less Than Total Number of Days").addClass("error-msg").css('color', '#ff0000');
            }else{
              $("#projectIDSelectError").html("");
            }
          }
        </script>

@endsection
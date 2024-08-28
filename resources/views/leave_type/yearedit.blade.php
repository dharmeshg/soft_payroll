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
              <h4 class="card-title">Edit LeaveType Year</h4>
             
              <form id="example-form" action="{{ route('leavetype.Yearupdate')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="name">Leave Name*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Plese Select Leave Type" name="name" id="name">
                        <option></option>
                        @foreach($leavetypes as $leavetype)
                        <option value="{{$leavetype -> id}}">{{$leavetype -> name}}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_cycle">Leave Cycle*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Plese Select Leave Cycle" name="leave_cycle" id="leave_cycle" onchange="myFunction()">
                        <option></option>
                        <option value="Fiscal Year">Fiscal Year (April to March)</option>
                        <option value="Anniversary Year">Anniversary Year</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                <div class="row" style="display: none;" id="oth">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group" >
                      <label for="from_date">Start Date*</label>
                      <input type="text" name="from_date" id="from_date" class="required form-control datepicker"  data-parsley-required-message="Please Enter Start Date">
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="to_date">End Date*</label>
                      <input type="text" name="to_date" id="to_date" class="required form-control datepicker"  data-parsley-required-message="Please Enter End Date" onchange="Days()">
                      <span id="error"></span>
                    </div>
                </div>
                  </section>
                  </div>
                  <div class="row">
                    <div class="col-12 change-btn">
                      <button type="submit" class="btn btn-primary"  id="save_btn">save</button>
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
                var Picker = $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'dd-mm-yyyy'
                });
            });
        </script>
        <script>
            function myFunction(){
                var leave_cycle = $('#leave_cycle :selected').val();
                var txtfrom = document.getElementById("from_date");
                var txtto = document.getElementById("to_date");
                var txtOther = document.getElementById("oth");
                if(leave_cycle == "Other"){
                    txtOther.style.display='flex';
                    txtfrom.required=true;
                    txtto.required=true;
                }else{
                    txtOther.style.display='none';
                    txtfrom.required=false;
                    txtto.required=false;
                } 
            }


            function Days(){
                var error = document.getElementById("error")
                var from = $("#from_date").val();
                var to = $("#to_date").val();
                if(Date.parse(from) > Date.parse(to)){
                    error.textContent = "Please enter a valid date"
                    error.style.color = "red"
                    $('#save_btn').prop('disabled',true);
                }else{
                    error.textContent = ""
                    $('#save_btn').prop('disabled',false);
                }
            }

            // function errorMessage(){
            //     var error = document.getElementById("error")
            //     var from = $("#from_date").val();
            //     var to = $("#to_date").val();
            //     if(Date.parse(from) > Date.parse(to)){
            //         error.textContent = "Please enter a valid date"
            //         error.style.color = "red"
            //     }else{
            //         error.textContent = ""
            //     }

            // }
        </script>

@endsection
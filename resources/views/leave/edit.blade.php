<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')

<style type="text/css">
  #outer{
    width:100%;
    text-align: left;
}
.inner
{
    display: inline-block;
}
</style>
<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Leave Request</h4>
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
              <h4 class="card-title">Edit Leave Request</h4>
             
              <form id="example-form" action="{{ route('leave.update',[$leave->id])}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                    
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leave_name">Employee Name*</label>
                      
                      <input
                        id="employee_id"
                        name="employee_id"
                        type="text"
                        class="required form-control"
                        value=""
                        placeholder="{{$data->fname}}{{$data->mname}}{{$data->lname}}"
                        disabled
                      />
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="leavetype_id">Leave Type Select*</label>
                      
                      <input
                        id="leavetype_id"
                        name="leavetype_id"
                        type="text"
                        class="required form-control"
                        value=""
                        placeholder="{{$type->name}}"
                        disabled
                      />
                    </div>
                    <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="start_date">Start Date*</label>
                      <input type="text" name="start_date" id="start_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter Start Date" value="{{ (( isset($leave->start_date) ) ? $leave->start_date : '')}}"disabled>
                    </div>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-group">
                      <label for="end_date">End Date*</label>
                      <input type="text" name="end_date" id="end_date" class="required form-control datepicker" required="" data-parsley-required-message="Please Enter End Date"value="{{ (( isset($leave->end_date) ) ? $leave->end_date : '')}}"disabled>
                    </div>
                    </div>

                    <!-- <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="reason">Reason For Leave*</label>
                      <textarea class="form-control" id="reason" name="reason" rows="3" required="" data-parsley-required-message="Please Enter Reason"disabled></textarea>
                    </div> -->
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="reason">Reason For Leave*</label>
                      <input
                        id="reason"
                        name="reason"
                        type="text"
                        class="required form-control"
                        value=""
                        placeholder="{{$leave->reason}}"
                        disabled
                      />
                    </div>
                  <div id="outer">
                    <div class="inner">
                      <button type="submit" class="btn btn-primary" name="Approve">Approve</button>
                      <button type="submit" class="btn btn-danger" name="Reject">Reject</button>
                    </div>
                  </div>
                    </div>
                  </section>
                  </div>
                </div>
              </form>
            </div>
          </div>
        
        </div>
      </div>
        <script>
            jQuery(document).ready( function () {
                $('.datepicker').datepicker({ 
                        todayHighlight: true,
                        format: 'yyyy/mm/dd'
                });
            });
        </script>

@endsection

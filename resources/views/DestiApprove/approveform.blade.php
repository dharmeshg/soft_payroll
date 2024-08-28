@extends('layouts.employee')

@section('content')

<style>
	.fa-edit{
	    padding: 6px 5px;
	    background-color: #2255a4;
	    color: #fff;
	    font-size: 16px;
	    margin: 0 6px;
  }
  .fa-trash{
	    padding: 6px 5px;
	    color: #fff;
	    background-color: #da542e;
	    font-size: 16px;
  }
</style>

      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Transfer Request Form</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                </nav>
              </div>
            </div>
          </div>
        </div>
      
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Authorize Transfer List</h5>
                  <form id=""  method="POST"
                    autocomplete="off" data-parsley-validate="">
                  {{ csrf_field() }}
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Full Name:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->fname}}{{$employee->mname}}{{$employee->lname}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Staff ID:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->official_information->staff_id}}">
                    
                    </div>
                    <div class="col-3 form-group">
                      <label>Age:</label>
                      @if(isset($age) && $age != '')
                      <input type="text" class="form-control" name="" value="{{$age}}">
                      @endif
                    </div>
                    <div class="col-3 form-group">
                    <label>Sex:</label>
                    <label type="text" class="form-control" name="" value="">{{$employee->sex}}</label>
                    
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Date Of Birth:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->dateofbirth}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>LAG Of Origin:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->localgovermentoforigin}}">
                     
                    </div>
                    <div class="col-3 form-group">
                       <input type="text" class="form-control" name="" value="{{$employee->hometown}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>State:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->state}}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Grade Level:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->official_information->gradelevel}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Designation:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->official_information->designations->title}}">
                    </div>
                    <!-- <div class="col-3 form-group">
                      <label>Date Of Assumption in Office:</label>
                    </div> -->
                  </div>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Year in Service:</label>
                      @if(isset($year) && $year != '')
                      <input type="text" class="form-control" name="" value="{{$year}}">
                      @endif
                    </div>
                    <div class="col-3 form-group">
                      <label>Expected Retirement Date:</label>
                      <input type="text" class="form-control" name="" value="{{$employee->official_information->expectedretirementdate}}">
                    </div>
                  </div>
                  <h3>From Details</h3>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Institution Name:</label>
                      @if(isset($instiname) && $instiname != '')
                      <input type="text" class="form-control" name="" value="{{$instiname}}">
                      @endif
                    </div>
                    <div class="col-3 form-group">
                      <label>Faculty:</label>
                      <input type="text" class="form-control" name="" value="{{$transfer->faculty_trf_dt->facultyname}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Department:</label>
                      <input type="text" class="form-control" name="" value="{{$transfer->departments_trf_dt->departmentname}}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Transfer Date:</label>
                      @if(isset($created) && $created != '')
                      <input type="text" class="form-control" name="" value="{{$created}}">
                      @endif
                    </div>
                    <div class="col-3 form-group">
                      <label>Transfer Initisted By:</label>
                      @if(isset($initiateby) && $initiateby != '')
                      <input type="text" class="form-control" name="" value="{{$initiateby}}">
                      @endif
                    </div>
                  </div>
                  <h3>To Details</h3>
                  <div class="row">
                    <div class="col-3 form-group">
                      <label>Institution Name:</label>
                      <input type="text" class="form-control" name="" value="{{$transfer->insti_trf_detail->institutionname}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Faculty:</label>
                      <input type="text" class="form-control" name="" value="{{$fac->facultyname}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Department:</label>
                      <input type="text" class="form-control" name="" value="{{$dep->departmentname}}">
                    </div>
                    <div class="col-3 form-group">
                      <label>Unit:</label>
                      <input type="text" class="form-control" name="" value="{{$u->name}}">
                    </div>
                  </div>
                  <div class="row">
                        <div class="col-12 change-btn form-group form-group">
                        <a href="{{route('destination.finalapproveform',[$transfer->id])}}" class="btn btn-primary submit-btn">Approve</a>
                        <a href="#" class="btn btn-primary cancle-btn submit-btn">Cancel</a>
                        </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
       @endsection
     
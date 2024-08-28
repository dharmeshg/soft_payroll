<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')


<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Assign Leave</h4>
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
              <h4 class="card-title">Assign Leave To {{$data->fname}} {{$data->mname}} {{$data->lname}}</h4>
             
              <form id="example-form" action="{{ route('assign.leaveemployee',[$data->id]) }}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group"> 
                    <?php
                    $ar = [];
                    if(isset($data->leavetype_id)){
                        if(!empty($data->leavetype_id)) {
                            $ar = explode(',',$data->leavetype_id);
                        }
                    }
                    ?>
                  @foreach($leavetype as $leavetypes)
                      <input type="checkbox" name="leavetype_id[]" required="" data-parsley-required-message="Please Select Leaves" class="fullwidth inputTag" id="leavetype_id" value="{{$leavetypes->id}}" {{ ( isset($data->leavetype_id) && (in_array($leavetypes->id,$ar)) ? 'checked' : '' )}}>{{$leavetypes->name}} <br>
                      @endforeach
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
        

<!-- Employee Permission assign -->
          <div class="card">
            <div class="card-body wizard-content">
              <h4 class="card-title">Assign Permission To {{$data->fname}} {{$data->mname}} {{$data->lname}}</h4>
             
              <form id="example-form" action="{{route('assign.permissionemployee',[$data->id])}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                  <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group" style="white-space: nowrap;">
                  <?php
                    $ac = [];
                    if(isset($data->permission_id)){
                        if(!empty($data->permission_id)) {
                            $ac = explode(',',$data->permission_id);
                        }
                    }
                    ?>
                  @foreach($permission as $permissions)
                      <input type="checkbox" name="permission_id[]" required="" data-parsley-required-message="Please Select Permission" class="fullwidth inputTag" style="margin-bottom: 10px;" id="permission_id" value="{{$permissions->id}}" {{ ( isset($data->permission_id) && (in_array($permissions->id,$ac)) ? 'checked' : '' )}}>{{$permissions->permissions}}<br>
                  @endforeach
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
white-space: nowrap;
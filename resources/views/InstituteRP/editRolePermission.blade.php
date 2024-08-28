<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')


<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Roles & Permissions</h4>
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
              <h4 class="card-title">Edit Roles & Permissions</h4>
             
              <form id="example-form" action="{{route('rolespermissions.update',[$IRP->id])}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="role_id">Role*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Role" name="role_id" id="role_id">
                        <option></option>
                       @foreach($roles as $role)
                        <option value="{{ $role->id }}"{{ (isset($role->id) || old('id'))? "selected":"" }}>{{ $role->roles}}</option>
                       @endforeach
                      </select>
                    </div>
                    <?php
                    $ar = [];
                    if(isset($IRP->permission_id)){
                        if(!empty($IRP->permission_id)) {
                            $ar = explode(',',$IRP->permission_id);
                        }
                    }
                    ?>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group"> 
                      <label for="permission_id" >Permissions:</label>
                      @foreach($permissions as $permission)
                      <input type="checkbox" name="permission_id[]" required="" data-parsley-required-message="Please Select Permission" class="fullwidth inputTag" id="permission_id" value="{{$permission->id}}"{{ ( isset($IRP->permission_id) && (in_array($permission->id,$ar)) ? 'checked' : '' )}}>
                      <label class="form-check-label" style="position: relative; top: -18px; left: 23px; font-size: 16px;">{{$permission->permissions}}</label>
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
      </div>

@endsection
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
              <h4 class="card-title">Assign Roles & Permissions</h4>
             
              @foreach($leave as $like)
              @if($like->institute_id == Auth::user()->id)
              <form id="example-form" action="{{route('rolespermissions.update',[$like->id])}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data"></form>
              {{ csrf_field() }}
              @else
              <form id="example-form" action="{{route('rolespermissions.store')}}" method="POST" class="mt-3" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                {{ csrf_field() }}
                @endif
                @endforeach
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                      <label for="role_id">Role*</label>
                      <select class="js-directorate" required="" data-parsley-required-message="Please Select Role" name="role_id" id="role_id">
                        <option></option>
                       @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->roles}}</option>
                       @endforeach
                      </select>
                    </div>

                    <div id="permission_id_id" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12  form-group"> 
                      <label for="permission_id" >Permissions:</label>
                      @foreach($permissions as $permission)
                      <input type="checkbox" name="permission_id[]" required="" data-parsley-required-message="Please Select Permission" class="fullwidth inputTag check" id="permission_id" value="{{$permission->id}}">
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
                  <!-- Edit Assign Roles and Permissions -->
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Roles & Permission List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Role</th>
                          <th>Permissions</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($IRP as $data=>$row)
                          <tr>
                            <th>{{$data+1}}</th>
                            <td>{{$row->roles}}</td>
                            <td>{{$row->permission_id}}</td>
                            <td> <a href="{{route('rolespermissions.edit',[$row->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('rolespermissions.delete',[$row->id])}}" class="fas fa-trash delete" id="delete" data-title="" data-original-title="delete Institution" data-title="{{$row->roles}}"></a></td>
                          </tr>
                         @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<script>
  jQuery(document).ready( function () {
    $('#role_id').on('change', function () {
      var nive = $("#permission_id").val();
      // alert(nive);
      $("#permission_id_id").html('');
                var role = this.value;
                $.ajax({
                    url: "{{url('fetch-Permission')}}",
                    type: "POST",
                    data: {
                      role_id: role,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                      // console.log(res);
                        $.each(res.Permission_Role, function (key, value) {
                            $("#permission_id_id").append('<input type="checkbox" name="permission_id[]" required="" data-parsley-required-message="Please Select Permission" class="fullwidth inputTag check" id="permission_id" value="'+ value.id +'") > <label class="form-check-label" style="position: relative; top: -18px; left: 23px; font-size: 16px;">'+ value.permissions +'</label>');
                            $(".check").prop('checked',true);
                        });
                        
                    }
                });
            });
  });
</script>
@endsection
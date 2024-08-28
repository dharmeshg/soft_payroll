@extends('layouts.app')

@section('content')

<style>
  .button-column { min-width: 150px; }
  input[type=checkbox].toggle:checked + label, input[type=checkbox].toggle1:checked + label{
    text-align: left;
  }
  input[type=checkbox].toggle +label, input[type=checkbox].toggle1 +label{
    display: inline-block;
    height: 29px;
    width: 64px;
    position: relative;
    font-size: 20px;
    padding: 0;
    margin: 0;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: green;
  }
  .rounded, .rounded1{
    border-radius: 30px !important;
  }
  input[type=checkbox].toggle:checked + label::after, input[type=checkbox].toggle1:checked + label::after{
    content: attr(data-checked);
    left: 8px;
    right: auto;
    opacity: 1;
    color: white;
    font-size: 12px;
  }
  input[type=checkbox].toggle + label::after, input[type=checkbox].toggle1 + label::after{
    text-align: center;
    z-index: 2;
    text-transform: uppercase;
    position: absolute;
    top: 51%;
    transform: translateY(-50%);
    text-overflow: ellipsis;
    overflow: hidden;
  }
  input[type=checkbox].toggle:checked + label::before, input[type=checkbox].toggle1:checked + label::before{
    left: 33px;
    background-color: white;
    border-radius: 50%;
  }
  input[type=checkbox].toggle + label::before, input[type=checkbox].toggle1 + label::before{
    position: absolute;
    top: 3px;
    height: 23px;
    width: 26px;
    content: "";
    transition: all 0.3s ease;
    z-index: 3;
  }
  input[type=checkbox].toggle:not(:checked) +label, input[type=checkbox].toggle1:not(:checked) +label{
    background-color: red;
    text-align: right;
  }
  input[type=checkbox].toggle:not(:checked) +label:after, input[type=checkbox].toggle1:not(:checked) +label:after{
    content: attr(data-unchecked);
    right: 9px;
    left: auto;
    opacity: 1;
    color: white;
    font-size: 12px;
  }
  input[type=checkbox].toggle:not(:checked) +label:before, input[type=checkbox].toggle1:not(:checked) +label:before{
    left: 1px;
    background-color: white;
    border-radius: 50%;
  }
  input[type=checkbox].toggle, input[type=checkbox].toggle1{
    display: none;
  }
  .fa-edit{
    padding: 6px 5px;
    background-color: #2255a4;
    color: #fff;
    font-size: 16px;
  }
  .fa-trash{
    padding: 6px 5px;
    color: #fff;
    background-color: #da542e;
    font-size: 16px;
  }
  .page-item.active .page-link{
    background-color: #7460ee;
    border-color: #7460ee;
    
  }
  .on-off-btn{
    vertical-align: bottom;
  }
</style>

<div class="page-wrapper">
     
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Institution</h4>
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
         
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Institution List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Institution Name</th>
                          <th>Contact Person</th>
                          <th>Contact No</th>
                          <th>Email</th>
                         <!--  <th>Password</th> -->
                          <th>Address</th>
                          <th class="button-column"></th>
                        </tr>
                      </thead>
                      <tbody>                   
                         @foreach($data as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>
                            <td>{{$item['institutionname']}}</td>
                            <td>{{$item['contact_person']}}</td>
                            <td>{{$item['contact_no']}}</td>
                            <td>{{$item['email']}}</td>
                            <!-- <td>{{$item['password']}}</td> -->
                            <td>{{$item['address']}}</td>
                            <td> @if($item->id != 1)
                            <input type="checkbox" class="toggle" id="rounded{{ $item->id }}" data-itemid="{{ $item->id }}" {{ ( ( $item->status == 1 ) ? 'checked' : '' ) }}>
                            <label for="rounded{{ $item->id }}" data-checked="ON" data-unchecked="off" class="rounded on-off-btn"></label>
                            @else
                            -
                            @endif                             
                            <a href="{{route('institution.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('institution.delete',[$item->id])}}" class="fas fa-trash delete" id="delete" data-title="{{$item->name}}" data-original-title="delete Institution"></a></td>
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
       @endsection
     @section('script')
      <script>
        $(document).on('change','input.toggle', function(){
        var data_institutionid = $(this).attr( 'data-itemid' );
        var data_status = ( ( $(this).prop("checked") == true ) ? '1' : '0' );
        //$("body").addClass('is-user-status-loader');
        // alert(data_status);
        // alert(data_institutionid);
        $.ajax({
            type: "POST",
            url: '{{ route("statusupdate") }}',
            data: {
                data_institutionid: data_institutionid,
                data_status: data_status,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $("body").removeClass('is-user-status-loader');
               const obj = JSON.parse( response );
               if( obj.status == 'success' ) {
                toastr.success("Status Update Successfully.", {timeOut: 5000});
               } else {
                toastr.error("Try Again", {timeOut: 5000});
               }
           }
       });
    });

      </script>
       @endsection
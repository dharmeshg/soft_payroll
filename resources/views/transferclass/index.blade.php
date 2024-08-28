@extends('layouts.employee')

@section('content')

<style>
  .thumbnail-image img {
    width: 60%;
}
.thumbnail-column {
  max-width:80px;
}
  
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
    margin: 0 6px;
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
  .next-page{
    display: inline-block;
    color: #fff;
    border-radius: 0.25rem;
    background-color: #2255a4;
    padding: 4px 10px;
    text-align: center;
    margin: 2px 0 0 0;
  }
</style>

<div class="page-wrapper">
     
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Transfer Class</h4>
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
                  <h5 class="card-title">Transfer Class List</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Transfer Class Name</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $key=>$transferclass)
                          <tr>
                            <th>{{$key+1}}</th>                            
                            <td>{{$transferclass->classname}}</td>
                            <td>{{$transferclass->description}}</td> 
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
        var data_transferclassid = $(this).attr( 'data-itemid' );
        var data_status = ( ( $(this).prop("checked") == true ) ? '1' : '0' );
        $.ajax({
            type: "POST",
            url: '{{ route("transferclass.statusupdate") }}',
            data: {
                data_transferclassid: data_transferclassid,
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
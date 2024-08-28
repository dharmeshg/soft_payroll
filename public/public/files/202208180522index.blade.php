@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;
@endphp
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style type="text/css">
    .add-product-btn, .export-btn, .download{
        z-index: 999;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 10px;
    }
    span.select2.select2-container.select2-container--default {
        border: 1px solid #C4C4C4;
        padding: 5px 15px;
        height: 40px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        font-size:12px;
    }
    .col-lg-8 span.select2.select2-container.select2-container--default {
        padding:0px;
    } 
    .select2-container--default .select2-selection--multiple{
        border-width:0px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple{
        border-width: 0px;
    }   
    .content-wrapper-product-list.Add-Product.reports-list-page .export-btn {
        top: 420PX;
    }
    .right-side{
        margin-top:-10px;
    }
    .card-body-sales,.card-body-items {
        padding: 35px 27px 35px 30px
    }
    .search-button{
        margin-top:23px;
    }
</style>
<div class="content-wrapper-product-list reports-list-page">
    <div class="row product-list-row">
        <h1>Reports</h1>
    </div>
    <div class="filter-type-wrap">
        <form method="POST">
		{{ csrf_field() }}
            <div class="row">
                
            	<div class="col-sm-12 col-lg-12">
                    @if(Auth::user()->role == 'CMD' || Auth::user()->role == 'CEO' || Auth::user()->role == 'Administrator')
                    <div class="row">
                        <div class="col-sm-12 col-md-5 col-lg-3">
                            <div class="form-group">
                                <label for="fromdate">From Date</label>
                                <input type="text" name="from_date" id="fromdate" value="{{ ( isset( $_GET['from_date'] ) ? $_GET['from_date'] : date('d/m/Y', strtotime( str_replace('/', '-',$from_date ))) ) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-3">
                            <div class="form-group">
                                <label for="enddate">End Date</label>
                                <input type="text" name="end_date" id="enddate" value="{{ ( isset( $_GET['end_date'] ) ? $_GET['end_date'] : date('d/m/Y', strtotime( str_replace('/', '-',$end_date ))) ) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
            				<div class="form-group">
	            				<label for="type">Select Users</label>
	            				<select class="form-control" id="user_id" name="user_id">
	        						<option value="">-Select User-</option>
                                    @if($users->count() > 0)
                                        @foreach($users as $ust)
                                            <option value="{{$ust->id}}" {{ ( isset( $users_id ) && $users_id == $ust->id ? 'selected' : '' ) }}>{{$ust->name}}</option>
                                        @endforeach
                                    @endif
	        					</select>
            				</div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
            				<div class="form-group">
	            				<label for="type">Select Customer</label>
	            				<select class="form-control" id="customer_id" name="customer_id">
	        						<option value="">-Select Customer-</option>
                                    @if($customers->count() > 0)
                                        @foreach($customers as $cst)
                                            <option value="{{$cst->id}}" {{ ( isset( $customer_id ) && $customer_id == $cst->id ? 'selected' : '' ) }}>{{$cst->company}}</option>
                                        @endforeach
                                    @endif
	        					</select>
            				</div>
            			</div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-sm-12 col-md-5 col-lg-4">
                            <div class="form-group">
                                <label for="fromdate">From Date</label>
                                <input type="text" name="from_date" id="fromdate" value="{{ ( isset( $_GET['from_date'] ) ? $_GET['from_date'] : date('d/m/Y', strtotime( str_replace('/', '-',$from_date ))) ) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-4">
                            <div class="form-group">
                                <label for="enddate">End Date</label>
                                <input type="text" name="end_date" id="enddate" value="{{ ( isset( $_GET['end_date'] ) ? $_GET['end_date'] : date('d/m/Y', strtotime( str_replace('/', '-',$end_date ))) ) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
            				<div class="form-group">
	            				<label for="type">Select Customer</label>
	            				<select class="form-control" id="customer_id" name="customer_id">
	        						<option value="">-Select Customer-</option>
                                    @if($customers->count() > 0)
                                        @foreach($customers as $cst)
                                            <option value="{{$cst->id}}" {{ ( isset( $customer_id ) && $customer_id == $cst->id ? 'selected' : '' ) }}>{{$cst->company}}</option>
                                        @endforeach
                                    @endif
	        					</select>
            				</div>
            			</div>
                    </div>
                    @endif
            		<div class="row">
            			<div class="col-sm-12 col-md-6 col-lg-8">
            				<div class="form-group">
	            				<label for="type">Select Product</label>
	            				<select class="form-control" id="product_id" name="product_id[]" multiple="multiple">
	        						<option value="">-Select Product-</option>
                                    @if($products->count() > 0)
                                        @foreach($products as $prdct)
                                            <option value="{{$prdct->id}}" {{ ( isset( $product_id ) && in_array($prdct->id,$product_id) ? 'selected' : '' ) }}>{{$prdct->name}}({{$prdct->product_code}})</option>
                                        @endforeach
                                    @endif
	        					</select>
            				</div>
            			</div>
                        <div class="col-sm-12 col-md-2 col-lg-4">
                    <div class="form-group search-button">
                        <label for="enddate">Search</label>
                        <button type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            		</div>
                    <div class="row">
      <div class="col-md-12 col-xxl-3 col-xl-3 col-lg-6 col-sm-12 col-xs-12 pdding">
            <div class="card ">
                <div class="card-body card-body-sales ">
                    <div class="d-flex align-items-center text-sales justify-content-between">
                        <h4>{{ $volume }} <span>Kg</span> </h4>
                        <img src="{{ asset('/') }}imgs/green-wait.svg">
                    </div>
                   <div class=" right-side">
                 
                    <h5>Sales In Volume</h5>
                   </div>
                 
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xxl-3 col-xl-3 col-lg-6 col-sm-12 col-xs-12 pdding">
            <div class="card  ">
                <div class="card-body card-body-items ">
                    <div class="d-flex align-items-center text-sales justify-content-between">
                        <h4>₹ {{$prices}}</h4>
                        <img src="{{ asset('/') }}imgs/green-rup.svg">
                        
                    </div>
                   <div class=" right-side ">
                    <h5>Sales Value</h5>
                   </div>
                 
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-md-12  col-lg-6 col-sm-12 col-xs-12 paddings">
            <div class="card ">
                <div class="card-body card-body-items ">
                    <div class=" text-sales  d-flex align-items-center justify-content-between">
                        <h4>₹ {{ $outstanding_pay }}</h4>
                        <img src="{{ asset('/') }}imgs/red-rup.svg">
                        
                    </div>
                   <div class="  right-side">
                    <h5>Total Outstanding</h5>
                   </div>
                 
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3 col-xxl-3 col-xs-12 xol-sm-12 paddings">
            <div class="card ">
                <div class="card-body card-body-items">
                    <div class=" text-sales d-flex align-items-center justify-content-between">
                        <h4>₹ {{ $total_overdue }} </h4>
                        <img src="{{ asset('/') }}imgs/red-rup.svg">
                        
                    </div>
                   <div class=" right-side">
                    <h5>Total Overdue</h5>
                   </div>
                 
                </div>
            </div>
        </div>
    </div>
            	</div>
            </div>
        </form>
    </div>
    <div class="row product-list-summary">
        <div class=" col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 data-table table-responsive">
            <a href="" class="export-btn is-data-export-button" > <h5><img src="{{asset('/')}}imgs/export-icon.svg">Export</h5> </a>
            
            <table class="table" id="myTable">
                <thead>
                    <tr class="headings">
                        <th class="no-filter-img" ></th>
                        <th>Sr. No</th>
                        <th>Invoice No.</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th class="no-filter-img"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($invoices->count()>0)
                        @foreach($invoices as $key=>$inv)
                            <tr>
                                <td></td>
                                <td>{{$key+1}}</td>
                                <td>{{$inv->invoice_no}}</td>
                                <td>{{$inv->customer_name}}</td>
                                <td>{{$inv->product_name}}</td>
                                <td>{{$inv->qty}} KG</td>
                                <td>₹ {{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$inv->net_amount)}}</td>
                                <td>{{Carbon::parse($inv->created_at)->format('d-m-Y');}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    
    
</div>
<div id="dvjson"></div>  
@endsection

@section('script')
<script>

    $('select').select2();
  $('#fromdate, #enddate').datepicker({ format: 'dd/mm/yyyy'}).on('changeDate', function(e){
      $(this).datepicker('hide');
      });
   </script>
   
   <script>
    $('#myTable').dataTable({
    //your normal options

    "oLanguage": { "sSearch": "" } 

    });
toastr.options.closeButton = true;

@if(Session::has('success'))
	toastr.success("{{ Session::get('success') }}", {timeOut: 5000});
@endif

@if(Session::has('error'))
	toastr.error("{{ Session::get('error') }}", {timeOut: 5000});
@endif

/* delete brand */
        $(document).on('click', '.delete', function(e) {
            
            e.preventDefault();
            var that = $(this);
            var name = that.data('title');
            swal({
                    title: "Are you sure you want to delete " + name + " Product?",
                    buttons: true,
                    dangerMode: true,
                    buttons: ['NO', 'YES']
                })
                .then((willChange) => {
                    if (willChange) {
                        window.location.href = that.data('href');
                    }
                });
        });

        // For Export Button
    $(document).on('click','.is-data-export-button', function(e){
        e.preventDefault();
        var from_date = $("#fromdate").val();
        var to_date = $("#enddate").val();
        var product_id = $('#product_id').val();
        var customer_id = $('#customer_id').val();
        @if(Auth::user()->role == 'CMD' || Auth::user()->role == 'CEO' || Auth::user()->role == 'Administrator')
            var user_id = $('#user_id').val();
        @endif
        $.ajax({
            type: "POST",
            url: '{{ route("product.export") }}',
            data: {
                _token: "{{ csrf_token() }}",
                'customer_id' : customer_id,
                'product_id' : product_id,
                'from_date' : from_date,
                @if(Auth::user()->role == 'CMD' || Auth::user()->role == 'CEO' || Auth::user()->role == 'Administrator')
                    'user_id' : user_id,
                @endif
                'to_date' : to_date,
            },
            success: function(response) {
                const data = JSON.parse( response );
                console.log(data);
                $("#dvjson").excelexportjs({
                  containerid: "dvjson", 
                  datatype: 'json', 
                  worksheetName:"user-data",
                  dataset: data, 
                  columns: getColumns(data)     
                });
           }
       });
    });
</script>
@endsection
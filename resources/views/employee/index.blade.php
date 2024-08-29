<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://softwiaamcl.com/public/assets/buttons.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')
<style>
.dtr-details{
  padding:0;
  list-style:none;
}
.dtr-details li{
  padding : 5px 0;
  border-bottom:1px solid #e3e3e3;
}
.dtr-details .dtr-title{
  font-weight:bold;
}
div.dt-button-collection{
  left:45px !important;
}
.odd td:first-child, .even td:first-child{
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
}
.odd td:first-child:before, .even td:first-child:before {
    content: "\f055";
}
.parent td:first-child:before {
    content: "\f056";
}
.thumbnail-image img {
    width: 45%;
}
.thumbnail-column {
  max-width:50px;
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
  .fa-edit, .fa-id-card{
    padding: 6px 5px;
    background-color: #2255a4;
    color: #fff;
    font-size: 16px;
    /*margin: 0 6px;*/
  }
  .fa-trash{
    padding: 6px 5px;
    color: #fff;
    background-color: #da542e;
    font-size: 16px;
  }
  .fa-plus{
    padding: 6px 5px;
    color: #fff;
    background-color: #2255a4;
    font-size: 16px;
  }
  .page-item.active .page-link{
    background-color: #7460ee;
    border-color: #7460ee;

  }

  .on-off-btn{
    vertical-align: bottom;
  }
  .search-btn{
    margin-top: 25px;

  }
  /*employee count*/
  .card-body h6{
    font-size: 15px;
    line-height: 25px;
    padding-bottom: 10px;
    margin: 0;
    text-align: right;
    padding-right: 23px;
  }

  .dt-buttons {
        top: 20px;
        right: 50px;
        position: absolute !important;
        border-radius: unset !important;
        
    }
    button.dt-button, div.dt-button, a.dt-button {
        line-height: 30px;
        height: 28px;
        padding: 1px 6px;
    }
    div.dt-buttons {
        padding: 0px;
        display: flex;
    }
    #employee_data ul{
      list-style: none;
    padding: 0px;
    }
    #employee_data ul li{
      padding: 5px 0;
    border-bottom: 1px solid #e3e3e3;
    }
    #employee_data .dtr-title{
      font-weight: bold;
    }
   
  
</style>



<div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Employee</h4>              
            </div>
          </div>
        </div>
        <div class="container-fluid">
             <!-- <div class="card">
                <div class="card-body wizard-content employee-content">
                    <div class="employee-page">
                      <section>
                          <form action="{{ route('daily_report') }}" method="post">
                             {{ csrf_field() }}
                          <div class="row">
                          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                               <label for="fromdate">Start Date Of Employment</label>
                               <input type="text" name="from_date" @if(isset($from_date_val)) value="{{$from_date_val}}" @endif class="form-control datepicker">
                          </div>
                          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                <label for="enddate">End Date Of Employment</label>
                                <input type="text" name="end_date" @if(isset($end_date_val)) value="{{$end_date_val}}" @endif class="form-control datepicker">
                          </div>
                          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                              <label for="age">Age</label>
                              <input type="number" name="age" @if(isset($age_val)) value="{{$age_val}}" @endif class="form-control">                              
                          </div>
                          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                              <label for="qualification">Qualification</label>
                              <input type="text" name="qualification" @if(isset($qua_val)) value="{{$qua_val}}" @endif class="form-control">
                          </div>
                          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 form-group search-button">
                               <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        </div>
                         </form>
                      </section>
                    </div>
                </div>
            </div> -->

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-8 col-lg-8"><h5 class="card-title">Employee List</h5></div>
                  <!-- <div class="col-sm-2 col-lg-2"><h6 class="">Employee ({{ $employeecount }})</h6></div> -->
                  <!-- <div class="col-sm-2 col-lg-2"><button class="btn btn-primary is-data-export-button" style="float:right">Export</button></div> -->
                </div>
                  
                  
                  <div class="table-responsive">
                    <table border="0" cellspacing="5" cellpadding="5" align="left" >
                        <tbody>
                            <tr>
                                <td>Minimum age:</td>
                                <td><input type="text" id="min" name="min" class="form-control form-control-sm"></td>
                                <td>Maximum age:</td>
                                <td><input type="text" id="max" name="max" class="form-control form-control-sm"></td>
                                <td>Select Gender: <label><input type="radio" name="gen_search" class="" value="male"> Male</label>&nbsp;&nbsp;<label><input type="radio" name="gen_search" value="female"> Female</label></td>
                            </tr>                            
                        </tbody>
                    </table>
                    <table
                      id="employee_data"
                      class="table table-striped table-bordered"
                      style="width:100%">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Date Of Birth</th>
                          <th>Age</th>
                          <th>Marital Status</th>
                          <th>Gender</th>
                          <th>Genotype</th>
                          <th>Service Years</th>
                          <th>Blood Group</th>
                          <th>Staff ID</th>
                          <th>Department (Academic)</th>  
                          <th>Department (Non-Academic)</th>                          
                          <th>Date of Employment</th>
                          <th>Email</th>
                          <th>Designation (Academic)</th>  
                          <th>Designation (Non-Academic)</th>                          
                          <th>Contact No</th>
                          <th>Roll</th>
                          <th>Category</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         @if($data)
                         @foreach($data as $key=>$Employee)

                         <?php
                         // echo "<pre>" ;
                         // echo $Employee;
                         ?>
                          <tr>
                            <td></td>
                            <td>{{$Employee->title}} {{$Employee->fname}} {{$Employee->mname}} {{$Employee->lname}}</td>
                            <td>{{$Employee->employeeemail}}</td>
                            <td>{{$Employee->dateofbirth->format('d/m/Y')}}</td>
                            <td>{{$Employee->age}}</td>
                            <td>{{$Employee->maritalstatus}}</td>
                            <td id="search">{{$Employee->sex}}</td>
                            <td>{{$Employee->genotype}}</td>
                            <?php 
                                $dateofemployment = $Employee->official_information->dateofemployment;
                                $today = date('Y/m/d');
                                $diff = date_diff(date_create($dateofemployment), date_create($today));
                            ?>
                            <td><?php echo $diff->format('%y'); ?></td>
                            <td>{{$Employee->bloodgroup}}</td>
                            <td>@if(isset($Employee->official_information)){{$Employee->official_information->staff_id}}@endif</td>
                            <td>@if(isset($Employee->official_information) && $Employee->official_information->department != null){{$Employee->official_information->departments_dt->departmentname}}@else - @endif</td>
                            <td>@if(isset($Employee->official_information) && $Employee->official_information->non_Academic_department != null){{$Employee->official_information->non_academic_departments_dt->departmentname}}@else - @endif</td>

                            <td>@if(isset($Employee->official_information)){{$Employee->official_information->dateofemployment->format('d/m/Y'), ''}}@endif</td>
                            <td>@if(isset($Employee->employeeemail)){{$Employee->employeeemail}}@endif</td>
                           
                            <td>@if(isset($Employee->official_information) && $Employee->official_information->designation != null){{$Employee->official_information->designations->title}} @else - @endif</td>
                            <td>@if(isset($Employee->official_information) && $Employee->official_information->non_Academic_designation != null){{$Employee->official_information->non_academic_designations->title}} @else - @endif</td>

                            <td>{{$Employee->phoneno}}</td>
                            <td>{{ isset($Employee->official_information->role) ? $Employee->official_information->role : $Employee->official_information->non_Academic_role  }}</td>
                            <td>{{$Employee->official_information->category}}</td>

                            
                            <td>
                            <input type="checkbox" class="toggle" id="rounded{{ $Employee->id }}" data-employeeid="{{ $Employee->id }}" {{ ( ( $Employee->status == 1 ) ? 'checked' : '' ) }}>
                            <label for="rounded{{ $Employee->id }}" data-checked="ON" data-unchecked="off" class="rounded on-off-btn"></label>
                            <a href="{{route('employee.pdf',[$Employee->id])}}" class="fas fa-id-card" target="_blank"></a>
                            <a href="{{route('employee.edit',[$Employee->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('employee.assign',[$Employee->id])}}" class="fas fa-plus"></a>
                            <a href="{{route('employee.delete',[$Employee->id])}}" class="fas fa-trash delete" id="delete" data-title="{{$Employee->name}}" data-original-title="delete Employee"></a>
                            </td>
                          </tr>
                           @endforeach
                           @else
                           <h3>No data found</h3>
                           @endif
                          
                      </tbody>
                    </table>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style>
      .ti-search{
          display:none;
      }
      </style>

       @endsection

     @section('script')
     
     <script src="https://softwiaamcl.com/public/assets/buttons.colVis.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.print.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.html5.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/dataTables.buttons.min.js"></script>
    <script data-require="datatables-responsive@*" data-semver="2.1.0" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
     <script>

/* Custom filtering function which will search data in column four between two values */
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = parseInt($('#min').val(), 10);
    var max = parseInt($('#max').val(), 10);
    var age = parseFloat(data[4]) || 0; // use data for the age column
    
    if (
        (isNaN(min) && isNaN(max)) ||
        (isNaN(min) && age <= max) ||
        (min <= age && isNaN(max)) ||
        (min <= age && age <= max)
    ) {
        return true;
    }
    return false;
});
 

$(document).ready(function () {
    var table = $('#employee_data').DataTable();
 
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup(function () {
        table.draw();
       
    });

    // $('#employee_data_filter input').keyup(function(){
    //   alert("123");
    //   table.column(5)
    //     .search("^" + $(this).val() + "$", true, false, true)
    //     .draw();
    // });

    
});



      $(document).on('click','.is-data-export-button', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route("employee.export") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const data = JSON.parse( response );
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
      $(document).on('change','input.toggle', function(){
        var data_employeeid = $(this).attr( 'data-employeeid' );
        var data_status = ( ( $(this).prop("checked") == true ) ? '1' : '0' );
        $.ajax({
            type: "POST",
            url: '{{ route("employee.statusupdate") }}',
            data: {
                data_employeeid: data_employeeid,
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

       $(document).ready(function() { 
          $('.datepicker').datepicker({ 
              todayHighlight: true,
          });

        

        
        //var table = $('#employee_data').DataTable();

        var table = $("#employee_data").DataTable({
          
            bLengthChange: false,
            bDestroy: true,
            language: {
                search: "<i class='ti-search' id='searchemployee'></i>",
                searchPlaceholder: "Quick Search",
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>",   
                },
                
               
            },
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "copyHtml5",
                    text: '<i class="fa fa-copy"></i>',
                    /*titleAttr: "Copy",*/
                    title: $("#logo_title").val(),
                    exportOptions: {
                        /*columns: ":visible",
                        columns: ":not(:first-child)",*/
                        columns: [ 0, ':visible' ]
                    },
                },
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel-o"></i>',
                    /*titleAttr: "Excel",*/
                    title: $("#logo_title").val(),
                    exportOptions: {
                        /*columns: ":visible",
                        columns: ":not(:first-child)",*/
                        columns: [ 0, ':visible' ],
                        order: "applied",
                    },
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fas fa-file-csv"></i>',
                    /*titleAttr: "CSV",*/
                    title: $("#logo_title").val(),
                    exportOptions: {
                        /*columns: ":visible",
                        columns: ":not(:first-child)",*/
                        columns: [ 0, ':visible' ]
                    },
                },
                {
                    extend: "pdfHtml5",
                    pageSize: 'LEGAL',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    /*titleAttr: "PDF",*/
                    exportOptions: {
                        page: 'current',
                        columns: [ 0, ':visible' ],
                        /*columns: ":visible",
                        columns: ":not(:first-child)",*/
                        order: "applied",
                        columnGap: 20,
                    },
                    orientation: "landscape",
                    pageSize: "A4",
                    /*messageTop: function() {
                        var t = [
                            "Class: " + $("#cls").val(),
                            "         ",
                            "Section: " + $("#sec").val(),
                        ];

                        return t;
                    },*/
                    alignment: "center",
                    header: true,
                    margin: 20,                    
                    //title: $("#logo_title").val(),
                },
                {
                    extend: "print",
                    text: '<i class="fa fa-print"></i>',
                    /*titleAttr: "Print",*/
                    //title: $("#logo_title").val(),
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ["colvisRestore"],
                    columns: ':not(.noVis)'
                },
                ],
            /*dom: "Bfrtip",
            buttons: [
              {
                    extend: "copyHtml5",
                    text: '<i class="fa fa-copy"></i>',
                    titleAttr: "Copy",
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ":visible",
                        columns: ":not(:last-child)",
                    },
                },
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: "Excel",
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ":visible",
                        columns: ":not(:last-child)",
                        order: "applied",
                    },
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-excel"></i>',
                    titleAttr: "CSV",
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ":visible",
                        columns: ":not(:last-child)",
                    },
                },
              //   {
              //       extend: "pdfHtml5",
              //       text: '<i class="fa fa-file-pdf-o"></i>',
              //       titleAttr: "PDF",
              //       exportOptions: {
              //           columns: ":visible",
              //           columns: ":not(:last-child)",
              //           order: "applied",
              //           columnGap: 20,
              //       },
              //       orientation: "landscape",
              //       pageSize: "A4",
              //       messageTop: function() {
              //           var t = [
              //               "Class: " + $("#cls").val(),
              //               "         ",
              //               "Section: " + $("#sec").val(),
              //           ];

              //           return t;
              //       },
              //       alignment: "center",
              //       header: true,
              //       margin: 20,
              //       customize: function(doc) {
              //           doc.content.splice(1, 0, {
              //               margin: [0, 0, 0, 12],
              //               alignment: "center",
              //               image: "data:image/png;base64," + $("#logo_img").val(),
              //           });
              //           doc.pageMargins = [70, 20, 10, 20];
              //           doc.defaultStyle.fontSize = 10;
              //           doc.styles.tableHeader.fontSize = 11;
              //       },
              //       title: $("#logo_title").val(),
              //   },
                {
                    extend: "print",
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: "Print",
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ":visible",
                        columns: ":not(:last-child)",
                    },
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ["colvisRestore"],
                },
            ],*/
            columnDefs: [
            { responsivePriority: 1, targets: -1 },
            {
                visible: false,
            }, 
            

            {
                targets: [0,16],
                className: 'noVis',
               
            },
            

            ],
            autoWidth: false,
            responsive: true,
            
        });
        
        //$('#employee_data').prepend('<label>Version :<input type="search" id="versionSearch" class="form-control input-sm" placeholder="" aria-controls="customerTable"></label>');
        $('input[type=radio][name=gen_search]').change(function() {
            table.column(6)
            .search("^" + this.value + "$", true, false, true)
            .draw();
        });
        // $('input#versionSearch').on('keyup', function() {
        // table.column(6)
        // .search("^" + $(this).val() + "$", true, false, true)
        // .draw();
        // });
        
        // $('input#versionSearch').on('keyup', function() {
         
        //   var val = $(this).val();
        //   var id = "";
        
        //   // Find indexes of rows which have `val` in the 1 column
        //   var indexes = table.rows().eq(6).filter(function(rowIdx) {
        
        //     return table.cell(rowIdx, 1).data().split(',').includes(val);
        //   });
        
        //   // Get the id of the field from the rows
        //   if (indexes && val) {
        
        //     // when data is in arrays
        //     //id = table.rows(indexes).data()[0][0];
        //     // when data is in object
        //     id = table.rows(indexes).data()[0].id;
        
        //   }
        
        //   if (val) {
        //     table.column(0).search('^' + id + "$", true, false).draw();
        //   } else {
        //     table.column(0).search("").draw();
        //   }
        // });


      

        $('a.toggle-vis').on('click', function (e) {
        	$(document).on('click','.is-data-export-button', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route("employee.export") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const data = JSON.parse( response );
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

        e.preventDefault();
 
        // Get the column API object
        var column = table.column($(this).attr('data-column'));
        
 
        // Toggle the visibility
        column.visible(!column.visible());
      });
    });
  </script>
  @endsection
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://softwiaamcl.com/public/assets/buttons.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>   
@section('content')

<style>
  
  .fa-edit{
    padding: 6px 5px;
    background-color: #2255a4;
    color: #fff;
    font-size: 16px;
    margin-right: 7px;
  }
  .fa-trash{
    padding: 6px 5px;
    color: #fff;
    background-color: #da542e;
    font-size: 16px;
  }
  .dt-buttons{
    padding-right:45px !important;
    padding: 0 !important;
    border-radius: unset !important;
    
  }
  .table-responsive{
        margin-top: 20px !important;
  }
  .two_div{
    display: flex;
    justify-content: space-between;
  }
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
    .collapsed .odd td:first-child, .even td:first-child{
      font-family: 'Font Awesome 5 Free';
      font-weight: 900;
    }
    .collapsed .odd td:first-child:before, .even td:first-child:before {
        content: "\f055";
    }
    .parent td:first-child:before {
        content: "\f056";
    }
    .select2-container {
        display: block;
        width: 100% !important;
    }

    .search-btn {
        margin-top: 31px;
    }
    table#employee_data th {
        font-weight: bold;
    }
    table#employee_data td {
        background: none;
    }
    .download-btn{
    color: #fff;
    font-size: 16px;
    line-height: 30px;
    border-radius: 2px;
    padding: 2px 24px!important;
    }
    a:hover{
        color: #fff;
    }
    .employee_history{
        background-color: #d1d5da;
    }
    li.parsley-required{
        float: left;
    position: absolute;
    bottom: 12px;
    }
    .btn{
        padding: 10px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered{
        overflow-y: scroll;
        height: 100%;
    }
    .table td, .table th{
        padding: 1em 0.5em;
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
              <h4 class="page-title">View Leave Request</h4>
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
                  <div class="two_div">
                  <h5 class="card-title">Leave Request List</h5>
                  
                </div>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Employee Name</th>
                          <th>Leave Type</th>
                          <th>Leave Days</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Reason For Leave</th>
                          <th>Head of Unit Status</th>
                          <th>Head of Department Status</th>
                          <th>Head of School/Directorate Status</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                          @foreach($leaves as $key=>$item)
                          <tr>
                            <?php 
                            
                              $offcial = App\Models\OfficialInfo::where('employee_id',$item->employee_id)->first();
                            
                            ?>
                            <th>{{$key+1}}</th>
                            <td>{{$item->fname}}{{$item->mname}}{{$item->lname}}</td>
                            <td>{{$item->name}}</td>
                            @if($item->leave_days == "half")
                            <td>{{$item->leave_days}} Leave in {{$item->half_leave}}</td>
                            @elseif($item->leave_days == "hourly")
                            <td>{{$item->leave_days}} Leave For {{$item->hourly_hours}} Hour</td>
                            @else
                            <td>{{$item->leave_days}}</td>
                            @endif
                            <td>{{$item->start_date}}</td>
                            <td>{{$item->end_date}}</td>
                            @if($item->reason == "Other")
                            <td>{{$item->other_reason}}</td>
                            @else
                            <td>{{$item->reason}}</td>
                            @endif
                            <td>@if($item->hou_status != null && $item->hou_status != 0){{$item->hou_status}}@elseif($item->hou_status == null && $offcial->role != "HOU") I Am Not Authorized to Accept this Leave Request @elseif($item->hou_status == null && $offcial->role == "HOU") I Can't Accept this Leave Request Because It's Mine @else Head Of Unit Does Not Exists @endif</td>
                            <td>@if($item->hod_status != null){{$item->hod_status}} @elseif($item->hod_status == null && $offcial->role == "HOD") I Can't Accept this Leave Request Because It's Mine @else I Am Not Authorized to Accept this Leave Request @endif</td>
                            <td>@if($item->hof_status != null){{$item->hof_status}} @elseif($item->hof_status == null && $offcial->role == "HOF") I Can't Accept this Leave Request Because It's Mine @else I Am Not Authorized to Accept this Leave Request @endif</td>
                            <td>{{$item->status}}</td>
                            <td> <a href="{{route('leave.edit',[$item->id])}}" class="fas fa-edit"></a></td>
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
     <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
     <script src="https://softwiaamcl.com/public/assets/buttons.colVis.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.print.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/buttons.html5.min.js"></script>
    <script src="https://softwiaamcl.com/public/assets/dataTables.buttons.min.js"></script>
    <script data-require="datatables-responsive@*" data-semver="2.1.0" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
     <script>

// function ExportToExcel(type, fn, dl) {
//   var elt = document.getElementById('zero_config');
//   var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

  
//   var ws = wb.Sheets["sheet1"];

  
//   var columnWidths = [
//     { wch: 5 },   
//     { wch: 15 },  
//     { wch: 15 },
//     { wch: 10 },
//     { wch: 10 },
//     { wch: 10 },
//     { wch: 15 },
//     { wch: 45 },
//     { wch: 23 },
//     { wch: 20 },
//     { wch: 10 }   
   
//   ];

  
//   columnWidths.forEach(function(column, index) {
//     var colRef = XLSX.utils.encode_col(index);  
//     ws["!cols"] = ws["!cols"] || [];
//     ws["!cols"].push({ wch: column.wch });
//   });

  
//   var headingText = "Excel File Heading";
//   var mergeCellStart = { c: 0, r: 0 }; 
//   var mergeCellEnd = { c: columnWidths.length - 1, r: 0 }; 
//   var headingCellStyle = {
//     v: headingText,
//     s: {
//       alignment: { horizontal: "center" },
//       font: { bold: true }
//     }
//   };
//   var headingMergeRange = XLSX.utils.encode_cell(mergeCellStart) + ":" + XLSX.utils.encode_cell(mergeCellEnd);
//   ws[headingMergeRange] = headingCellStyle;

//   return dl ?
//     XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
//     XLSX.writeFile(wb, fn || ('Leavedetails.' + (type || 'xlsx')));
// }
    
</script>
<!-- <script type="text/javascript" src="https://demo.rajodiya.com/hrmgo/js/html2pdf.bundle.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script> -->



<script>
// $("#export_pdf").click(function(){
// setTimeout(function(){
        
//       HidePdfView();
//     },3000); 
//       $.ajax({
//               type: 'post',
//               url: "{{ url('Leave/export-pdf') }}",
//               // data: {id:id},
//               headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//               },
//               success: function (response)
//               {
//                 console.log(response);
//                 // $("#printableArea").html(response);
//                 var opt = {
//                 margin: 0.3,
//                 filename: 'Employeelist.pdf',
//                 image: {
//                     type: 'jpeg',
//                     quality: 1
//                 },
//                 html2canvas: {
//                     scale: 4,
//                     dpi: 72,
//                     letterRendering: true
//                 },
//                 jsPDF: {
//                   orientation: 'landscape',
//                     unit: 'in',
//                     format: 'A4'
//                 }
//             };
//             html2pdf().set(opt).from(response).save();
//               }

//             });  
//       });
    
        
//         function HidePdfView() {
//   $("#printableArea").hide();
//   }
      </script>

      <script>
// function convertDataTableToCSV(dataTable) {
//   var csv = '';
//   var headers = [];
//   var srNo = 1;

//   $(dataTable).find('th:not(:first-child)').each(function() {
//     headers.push($(this).text());
//   });

//   headers.unshift('Sr.No');

//   csv += headers.join(',') + '\n';

//   $(dataTable).find('tbody tr').each(function() {
//     var row = [];

//     row.push(srNo++);

//     $(this).find('td:not(:first-child)').each(function() {
//       row.push($(this).text());
//     });

//     csv += row.join(',') + '\n';
//   });

//   return csv;
// }



  // function downloadCSV(csvData, fileName) {
  //   var link = document.createElement('a');
  //   link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvData);
  //   link.download = fileName;
  //   link.style.display = 'none';
  //   document.body.appendChild(link);
  //   link.click();
  //   document.body.removeChild(link);
  // }

  // $(document).ready(function() {
  //   var csvData = convertDataTableToCSV('#zero_config');
  //   $('#export_csv').click(function() {
  //     downloadCSV(csvData, 'Leaveslist.csv');
  //   });
  // });
</script>
<script>
// $('#print_data').click(function() {
//   var newTab = window.open('', '_blank');

//   // HTML content of the new tab
//   var htmlContent = '<html><head><title>Employee Leaves List</title>';
  
//   // Add CSS styles for table formatting
//   htmlContent += '<style>table { width: 100%; border-collapse: collapse; } th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; } th { background-color: #f2f2f2; }</style>';
  
//   htmlContent += '</head><body><h1>Employee Leaves List</h1><br>';

//   // Get the HTML content of the data table
//   var tableHtml = $('#zero_config').prop('outerHTML');

//   // Add the data table HTML to the new tab
//   htmlContent += tableHtml;

//   // Add a print button to the HTML content

//   // Close the HTML content and open the new tab
//   htmlContent += '</body></html>';
//   newTab.document.open();
//   newTab.document.write(htmlContent);
//   newTab.document.close();
//   newTab.onload = function() {
//     newTab.print();
//   };
//   newTab.onafterprint = function() {
//     newTab.close();
//   };
// });
var exportColumns = [1, 2, 3, 6, 7, 8, 9, 10];
var table = $("#zero_config").DataTable({
    bLengthChange: false,
    bDestroy: true,
    dom: "Bfrtip",
    buttons: [
        
        {
            extend: "excelHtml5",
            text: '<i class="fa fa-file-excel-o"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ":visible",
                columns: ":not(:first-child)",
                order: "applied",
            },
        },
        {
            extend: "csvHtml5",
            text: '<i class="fas fa-file-csv"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ":visible",
                columns: ":not(:first-child)",
            },
        },
        {
            extend: "pdfHtml5",
            pageSize: 'LEGAL',
            text: '<i class="fa fa-file-pdf-o"></i>',
            exportOptions: {
                page: 'current',
                columns: ":visible",
                columns: ":not(:first-child)",
                order: "applied",
                columnGap: 5,
                columns: function (idx, data, node) {
            return exportColumns.includes(idx);
        },
        order: 'applied',
            },
            customize: function (doc) {
                doc.header = function () {
            return {
                text: "Employee Details",
                fontSize: 18,
                alignment: "center"
            };
        };
        
        doc.filename = "CustomFileName";
        },
            orientation: "landscape",
            pageSize: "A4",
            alignment: "center",
            header: true,
            margin: 5,                    
        },
        {
            extend: "print",
            text: '<i class="fa fa-print"></i>',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ":visible",
                columns: ":not(:first-child)",
            },
        },
        ],
    columnDefs: [{
        visible: false,
    }, ],
    responsive: true,
});
</script>

       @endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://softwiaamcl.com/public/assets/buttons.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>   
@extends('layouts.employee')

@section('content')

<style>
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
    /*background-color: #2255a4;*/
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
    .data{
    	text-align: center;
	    font-size: 18px;
    }
    .dt-buttons{
    padding-right:45px !important;
    padding: 0 !important;
    border-radius: unset !important;
  }
  .one a{
        color:#3e5569;
    }
    .one a:hover{
        color: blue;
    }
</style>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Transfer Audit Log Details</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content employee-content employee_history">
                <div class="employee-page">
                    <section>
                        <form action="{{ route('transfer.audit_details') }}" method="post" data-parsley-validate="">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="trfClass">Transfer Class </label>
                                    <select id="trfClass" name="trfClass[]"
                                        class="trfClass required form-control">
                                        <option value="">--Select Transfer Class--</option>
                                        <option value="incoming" {{ isset($trfClass) && in_array('incoming', $trfClass) ? 'selected' : '' }}>Incoming Transfer</option>
                                        <option value="outgoing" {{ isset($trfClass) &&  in_array('outgoing', $trfClass) ? 'selected' : '' }}>Outgoing Transfer</option>
                                    </select>
                                </div>

                                <div
                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 form-group search-button">
                                    <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search"
                                            aria-hidden="true"></i></button>
                                </div>
                           

                            </div>
                        </form>
                            <div class="dt-buttons">               
                                <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="trf_data" type="button" id="export_excel"><span><i class="fa fa-file-excel-o"></i></span></button> 
                                <button class="dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="trf_data" type="button" id="export_csv"><span><i class="fas fa-file-csv"></i></span></button> 
                                <button class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="trf_data" type="button" id="export_pdf"><span><i class="fa fa-file-pdf-o"></i></span></button>
                                <button class="dt-button buttons-print" tabindex="0" aria-controls="trf_data" type="button" id="print_data"><span><i class="fa fa-print"></i></span></button>
                            </div>
                    </section>
                </div>
            </div>
        </div>
        @if(isset($transfer_out))
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Transfer Outgoing Audit Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="trf_data1" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th>Sr.No</th>
                                        <th>Full Name</th>
                                        <th>Staff ID No</th>
                                        <th>Processed By</th>
                                        <th>Authorized By HOU</th>
                                        <th>Authorized By HOD</th>
                                        <th>Authorized By HOS</th>
                                        <th>Source Institution Final Approval</th>
                                        <th>Destination Institution Final Approval</th>
                                        <th>Request Initiate Time</th>
                                        <th>Time Processed</th>  
                                        <th>Authorized By HOU Time</th> 
                                        <th>Authorized By HOD Time</th>
                                        <th>Authorized By HOS Time</th>
                                        <th>Source Institution Final Approval Time</th>
                                        <th>Destination Institution Final Approval Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($transfer_out) > 0 )
                                        @foreach($transfer_out as $key => $Trf_detail)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>@if(isset($Trf_detail['nameofstaff']))<?php $out_name= App\Models\Employee::where('id',$Trf_detail['nameofstaff'])->first(); ?>{{isset($out_name->fname) ? $out_name->fname : ''}}{{isset($out_name->mname) ? $out_name->mname : ''}}{{isset($out_name->lname) ? $out_name->lname : ''}} @else -- @endif
                                            </td>
                                            <td class="one">@if(isset($Trf_detail['staffid'])){{$Trf_detail['staffid']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail['process_by'])){{$Trf_detail['process_by']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['authorize_by_hou'])){{$Trf_detail['authorize_by_hou']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['authorize_by_hod'])){{$Trf_detail['authorize_by_hod']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['authorize_by_hof'])){{$Trf_detail['authorize_by_hof']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['approve_by'])){{$Trf_detail['approve_by']}} @else -- @endif</td>
                                            <td>@if(isset($Trf_detail['approve_by_insti'])){{$Trf_detail['approve_by_insti']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['created_at']))<?php $createdDate = $Trf_detail['created_at'];  $timestamp = strtotime($createdDate);  $formattedDate = date('Y-m-d h:i A', $timestamp);?>{{$formattedDate}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['process_datetime'])){{$Trf_detail['process_datetime']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['hou_datetime'])){{$Trf_detail['hou_datetime']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['hod_datetime'])){{$Trf_detail['hod_datetime']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['hof_datetime'])){{$Trf_detail['hof_datetime']}} @else -- @endif</td>
                                            <td>@if(isset($Trf_detail['insti_datetime'])){{$Trf_detail['insti_datetime']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail['final_insti_datetime'])){{$Trf_detail['final_insti_datetime']}} @else -- @endif</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="16" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($transfer_in))
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-8 col-lg-8">
                                <h5 class="card-title">Transfer Incoming Audit Details</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="trf_data2" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                          <th>Sr.No</th>
                                          <th>Full Name</th>
                                          <th>Staff ID No</th>
                                          <th>Final Approval</th>
                                          <th>Final Approval Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($transfer_in) > 0 )
                                        @foreach($transfer_in as $key => $Trf_detail_in)
                                        <tr>
                                            <td>{{$key+1}}
                                            </td>
                                            <td>@if(isset($Trf_detail_in['nameofstaff']))<?php $in_name= App\Models\Employee::where('id',$Trf_detail_in['nameofstaff'])->first(); ?>{{isset($in_name->fname) ? $in_name->fname : ''}}{{isset($in_name->mname) ? $in_name->mname : ''}}{{isset($in_name->lname) ? $in_name->lname : ''}} @else -- @endif
                                            </td>

                                            <td class="one">@if(isset($Trf_detail_in['staffid'])){{$Trf_detail_in['staffid']}}@endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['approve_by_insti'])){{$Trf_detail_in['approve_by_insti']}} @else -- @endif
                                            </td>
                                            <td>@if(isset($Trf_detail_in['final_insti_datetime'])){{$Trf_detail_in['final_insti_datetime']}} @else -- @endif</td>
                                        </tr>

                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5" class="data">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(isset($records))
          <p>No Records Founds</p>
        @endif
    </div>
</div>

@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
    jQuery(document).ready(function () {
        jQuery('.trfClass').select2({
          placeholder: "--Select Transfer Class--",
          allowClear: true
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/excel-export-js@1.0.1/dist/jquery.techbytarun.excelexportjs.min.js"></script>
<!-- <script type="text/javascript" src="https://demo.rajodiya.com/hrmgo/js/html2pdf.bundle.min.js"></script> -->
<script type="text/javascript" src="{{ asset('assets/libs/jquery-validation/dist/html2pdf.bundle.min.js') }}"></script>


<script src="https://softwiaamcl.com/public/assets/buttons.colVis.min.js"></script>
<script src="https://softwiaamcl.com/public/assets/buttons.print.min.js"></script>
<script src="https://softwiaamcl.com/public/assets/buttons.html5.min.js"></script>
<script src="https://softwiaamcl.com/public/assets/dataTables.buttons.min.js"></script>
<script data-require="datatables-responsive@*" data-semver="2.1.0" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>
<script>
    var dataTable1 = $('#trf_data1').DataTable({});
    var dataTable2 = $('#trf_data2').DataTable({});
    var filename = 'TransferAudit.xlsx';
    function exportToExcel() {
        var excelExport = new ExcelJS.Workbook();
        var filename = 'TransferAudit.xlsx';

        var dataTable1 = $('#trf_data1').DataTable();
        var dataTable2 = $('#trf_data2').DataTable();

        if (dataTable1 && dataTable1.rows().count() > 0) {
            var table1Data = dataTable1.rows({ search: 'applied' }).data().toArray();
            if (table1Data.length > 0) {
            var worksheet1 = excelExport.addWorksheet('Outgoing Transfer');
            var table1Headers = dataTable1.columns().header().toArray().map(function (th, columnIndex) {
                if (columnIndex !== dataTable1.columns().header().length - 1) {
                return th.textContent;
                }
            }).filter(Boolean);

            worksheet1.mergeCells('A1:' + String.fromCharCode(64 + table1Headers.length) + '1'); 
            worksheet1.getCell('A1').value = 'Outgoing Transfer'; 
            worksheet1.getCell('A1').alignment = { horizontal: 'center' }; 

            worksheet1.addRow(table1Headers); 
            table1Data.forEach(function (row) {
                var rowData = row.filter(function (_, columnIndex) {
                return columnIndex !== dataTable1.columns().header().length - 1;
                });
                worksheet1.addRow(rowData);
            });
            var columnWidths1 = [100, 120, 80, 80, 200,  120, 120, 80, 200];
            worksheet1.columns.forEach(function (column, index) {
                column.width = columnWidths1[index] / 6; 
            });
            }
        }

        if (dataTable2 && dataTable2.rows().count() > 0) {
            var table2Data = dataTable2.rows({ search: 'applied' }).data().toArray();
            if (table2Data.length > 0) {
            var worksheet2 = excelExport.addWorksheet('Incoming Transfer');
            var table2Headers = dataTable2.columns().header().toArray().map(function (th) {
                return th.textContent;
            });

            worksheet2.mergeCells('A1:' + String.fromCharCode(64 + table2Headers.length) + '1'); 
            worksheet2.getCell('A1').value = 'Incoming Transfer'; 
            worksheet2.getCell('A1').alignment = { horizontal: 'center' }; 

            worksheet2.addRow(table2Headers); 
            table2Data.forEach(function (row) {
                worksheet2.addRow(row);
            });
            }
        }

        excelExport.xlsx.writeBuffer().then(function (buffer) {
            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), filename);
        });
    }

    $('#export_excel').on('click', function() {
        exportToExcel();
    });


</script>

<script>
    $(document).ready(function () {
        // Initialize DataTables for table1 and table2
        var dataTable1 = $('#trf_data1').DataTable();
        var dataTable2 = $('#trf_data2').DataTable();

        // Custom function to export both DataTables to PDF
        function exportToPDF() {
    var tablesData = [
        {
            tableName: 'Transfer Outgoing Audit Details',
            dataTable: $('#trf_data1').DataTable()
        },
        {
            tableName: 'Transfer Incoming Audit Details',
            dataTable: $('#trf_data2').DataTable()
        }
    ];

    var docDefinition = {
        pageSize: 'A1',
        pageOrientation: 'landscape',
        content: [],
        styles: {
            header: {
                fontSize: 16,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 10]
            },
            tableHeader: {
                bold: true,
                fontSize: 13,
                color: 'black'
            }
        }
    };
    var hasDataTable1Data = tablesData[0].dataTable.rows().data().length > 0;
    var hasDataTable2Data = tablesData[1].dataTable.rows().data().length > 0;

    if (hasDataTable2Data && hasDataTable1Data) {
        docDefinition.pageSize = 'A1';
        // docDefinition.content.push({ text: '', pageBreak: 'after' });
    }else if(hasDataTable2Data){
        docDefinition.pageSize = 'A5';
    }

    var tablesWithData = tablesData.filter(function (tableInfo) {
      var dataTable = tableInfo.dataTable;
      var data = [];

      if ($(dataTable.table().node()).is(':visible')) {
        dataTable.rows().data().each(function (row) {
          var rowData = [];
          row.forEach(function (cellData) {
            rowData.push(cellData === null || cellData === undefined ? '' : cellData);
          });
          data.push(rowData);
        });
      }
      
      return data.length > 0;
    });
    tablesWithData.forEach(function (tableInfo) {
        var dataTable = tableInfo.dataTable;
        var columns = [];
        var data = [];

        function getTableHeaders(dataTable) {
            $(dataTable.table().header()).find('th').each(function () {
                columns.push({ text: $(this).text(), style: 'tableHeader' });
            });
        }

        function getTableData(dataTable) {
            if ($(dataTable.table().node()).is(':visible')) {
                dataTable.rows().data().each(function (row) {
                    var rowData = [];
                    row.forEach(function (cellData) {
                        rowData.push(cellData === null || cellData === undefined ? '' : cellData);
                    });
                    data.push(rowData);
                });
            }
        }

        getTableHeaders(dataTable);
        getTableData(dataTable);

        if (data.length > 0) {
            docDefinition.content.push(
                { text: tableInfo.tableName, style: 'header' },
                {
                    table: {
                        headerRows: 1,
                        widths: 'auto',
                        body: [
                            columns,
                            ...data
                        ]
                    },
                    layout: 'lightHorizontalLines'
                }
            );
        } else {
            docDefinition.content.push(
                { text: tableInfo.tableName, style: 'header' },
                { text: 'No data available.', margin: [0, 10, 0, 0] }
            );
        }
    });

    if (docDefinition.content.length > 0) {
        pdfMake.createPdf(docDefinition).download('Transfer_Audit_Log.pdf');
    } else {
        alert('No data to export to PDF.');
    }
}

$('#export_pdf').on('click', function() {
    exportToPDF();
    });
});
</script>


<!-- Make sure to include the papaparse library in your HTML -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<script>
function exportToCSV() {
    var dataTable1 = $('#trf_data1').DataTable();
    var dataTable2 = $('#trf_data2').DataTable();

    var filename = 'TransferAudit.csv';

    var csvContent = '';

    // Function to convert a row to CSV format
    function convertRowToCSV(row) {
        return row.join(',') + '\n';
    }

    if (dataTable1 && dataTable1.rows().count() > 0) {
        var table1Headers = dataTable1.columns().header().toArray().map(function (th, columnIndex) {
            if (columnIndex !== dataTable1.columns().header().length - 1) {
                return th.textContent;
            }
        }).filter(Boolean);

        var table1Data = dataTable1.rows({ search: 'applied' }).data().toArray();
        csvContent += convertRowToCSV(['Outgoing Transfer']);
        csvContent += convertRowToCSV(table1Headers);
        table1Data.forEach(function (row) {
            var rowData = row.filter(function (_, columnIndex) {
                return columnIndex !== dataTable1.columns().header().length - 1;
            });
            csvContent += convertRowToCSV(rowData);
        });
    }

    if (dataTable2 && dataTable2.rows().count() > 0) {
        var table2Headers = dataTable2.columns().header().toArray().map(function (th) {
            return th.textContent;
        });

        var table2Data = dataTable2.rows({ search: 'applied' }).data().toArray();
        csvContent += convertRowToCSV(['Incoming Transfer']);
        csvContent += convertRowToCSV(table2Headers);
        table2Data.forEach(function (row) {
            csvContent += convertRowToCSV(row);
        });
    }

    // Create and trigger the file download
    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) {
        // For IE and Edge
        navigator.msSaveBlob(blob, filename);
    } else {
        // For other browsers
        var link = document.createElement('a');
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

$('#export_csv').on('click', function () {
    exportToCSV();
});
</script>

<script>
    // Function to gather and format table data for printing
    function formatTablesForPrint() {
        // Initialize an empty string to store the combined table data
        var combinedTableData = '';

        // Check which tables exist and add their data to the combinedTableData string
        if ($('#trf_data1').length > 0) {
            var table1Data = $('#trf_data1').html();
            combinedTableData += '<div style="margin-bottom: 30px;"><h2>Transfer Outgoing Audit Details</h2><table class="printable-table">' + table1Data + '</table></div>';
        }

        if ($('#trf_data2').length > 0) {
            var table2Data = $('#trf_data2').html();
            combinedTableData += '<div style="margin-bottom: 30px;"><h2>Transfer Incoming Audit Details</h2><table class="printable-table">' + table2Data + '</table></div>';
        }

        // Create a new window and append the combined table data
        var printWindow = window.open('', 'Print Window');
        printWindow.document.write('<html><head><title>Print DataTables</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">');
        printWindow.document.write('<style>body {font-size: 14px;} .printable-table {width: 100%;} .dataTables_paginate, .dataTables_filter {display: none;} @media print { @page { size: landscape; }}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(combinedTableData);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Wait for the new window to load and print it
        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
    }

    // Click event for the print button
    $('#print_data').on('click', function () {
        // Gather and format the table data for printing
        formatTablesForPrint();
    });
</script>

@endsection
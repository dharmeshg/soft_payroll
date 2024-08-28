<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link
      href="https://softwiaamcl.com/public/assets/buttons.dataTables.min.css"
      rel="stylesheet"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.employee')
{{-- @extends('layouts.institute') --}}

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
  .next-page{
    display: inline-block;
    color: #fff;
    border-radius: 0.25rem;
    background-color: #2255a4;
    padding: 4px 10px;
    text-align: center;
    margin: 2px 0 0 0;
  }
  .dt-buttons{
    padding: 0 !important;
    border-radius: unset !important;
    text-align: right;
    margin-bottom: 20px;
  }
  .main_heading_div{
    display: flex;
    justify-content: space-between;
  }
  .add_button{
    margin-bottom: 20px;
  }
</style>

      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Transfer</h4>
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
                  <div class="main_heading_div">
                    <div>
                  <h5 class="card-title">Transfer List</h5>
                    </div>
                    <div>
                  <div class="add_button">
                    <a href="{{ route('add.transfer')}}" class="next-page">Add Transfer Initiation Form</a>
                  </div>
                  <div class="dt-buttons">               
                    <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="employee_data" type="button" id="export_excel" onclick="ExportToExcel('xlsx')"><span><i class="fa fa-file-excel-o"></i></span></button> 
                    <button class="dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="employee_data" type="button" id="export_csv"><span><i class="fas fa-file-csv"></i></span></button> 
                    <button class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="employee_data" type="button" id="export_pdf"><span><i class="fa fa-file-pdf-o"></i></span></button>
                    <button class="dt-button buttons-print" tabindex="0" aria-controls="employee_data" type="button" id="print_data"><span><i class="fa fa-print"></i></span></button>
                  </div>
                  </div>
                </div>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Staff ID No</th>
                          <th>Staff Name</th>
                          <th>Department</th>
                          <th>Application Type</th>
                          <th>Transfer Class</th>
                          <th>Action</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $key=>$item)
                          <tr>
                            <th>{{$key+1}}</th>                            
                            <td>{{$item->staffid}}</td>
                            <td>{{isset($item->employee_trf_detail->fname) ? $item->employee_trf_detail->fname : ''}}{{isset($item->employee_trf_detail->mname) ? $item->employee_trf_detail->mname : ''}}{{isset($item->employee_trf_detail->lname) ? $item->employee_trf_detail->lname : ''}}</td>
                            <td>{{$item->departments_trf_dt->departmentname}}</td>
                            <td>{{$item->transfertype}}</td>
                            <td>{{$item->transferclass}}</td>
                            <td>@if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' ||  Auth::user()->role == 'Employee')
                              <a href="{{route('processtransfer.edit',[$item->id])}}" class="next-page">Process Transfer Application</a>
                              @else
                              <a href="" class="next-page">Initiate</a>
                              @endif
                            </td> 
                            <td>@if(Auth::user()->role == 'HOD' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' || Auth::user()->role == 'Employee')
                            <a href="{{route('transfer.edit',[$item->id])}}" class="fas fa-edit"></a>
                            <a href="{{route('transfer.delete',[$item->id])}}" class="fas fa-trash delete"></a>
                            @else
                            <a href="">-</a>
                            @endif
                          </td>
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
      
       @endsection
       @section('script')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
function ExportToExcel(type, fn, dl) {
  var elt = document.getElementById('zero_config');
  var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

  
  var ws = wb.Sheets["sheet1"];

  
  var columnWidths = [
    { wch: 5 },   
    { wch: 20 },  
    { wch: 15 },
    { wch: 15 },
    { wch: 15 },
    { wch: 15 },
    { wch: 15 }   
   
  ];

  
  columnWidths.forEach(function(column, index) {
    var colRef = XLSX.utils.encode_col(index);  
    ws["!cols"] = ws["!cols"] || [];
    ws["!cols"].push({ wch: column.wch });
  });

  
  var headingText = "Excel File Heading";
  var mergeCellStart = { c: 0, r: 0 }; 
  var mergeCellEnd = { c: columnWidths.length - 1, r: 0 }; 
  var headingCellStyle = {
    v: headingText,
    s: {
      alignment: { horizontal: "center" },
      font: { bold: true }
    }
  };
  var headingMergeRange = XLSX.utils.encode_cell(mergeCellStart) + ":" + XLSX.utils.encode_cell(mergeCellEnd);
  ws[headingMergeRange] = headingCellStyle;

  return dl ?
    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
    XLSX.writeFile(wb, fn || ('Transferlist.' + (type || 'xlsx')));
}

</script>
<script>
function convertDataTableToCSV(dataTable) {
  var csv = '';
  var headers = [];
  var srNo = 1;

  $(dataTable).find('th:not(:first-child)').each(function() {
    headers.push($(this).text().trim()); // Trim whitespace from header cells
  });

  headers.unshift('Sr.No');

  csv += headers.join(',') + '\r\n'; // Use '\r\n' instead of '\n'

  $(dataTable).find('tbody tr').each(function() {
    var row = [];

    row.push(srNo++);

    $(this).find('td:not(:first-child)').each(function() {
      row.push($(this).text().trim()); // Trim whitespace from data cells
    });

    csv += row.join(',') + '\r\n'; // Use '\r\n' instead of '\n'
  });

  return csv;
}



  function downloadCSV(csvData, fileName) {
    var link = document.createElement('a');
    link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvData);
    link.download = fileName;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  $(document).ready(function() {
    var csvData = convertDataTableToCSV('#zero_config');
    $('#export_csv').click(function() {
      downloadCSV(csvData, 'Transferlist.csv');
    });
  });

</script>
<!-- <script type="text/javascript" src="https://demo.rajodiya.com/hrmgo/js/html2pdf.bundle.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script> -->
<script type="text/javascript" src="{{ asset('assets/libs/jquery-validation/dist/html2pdf.bundle.min.js') }}"></script>

<script>
  $("#export_pdf").click(function(){
    $.ajax({
              type: 'post',
              url: "{{ url('transfer/export-pdf') }}",
              // data: {id:id},
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function (response)
              {
                console.log(response);
                // $("#printableArea").html(response);
                var opt = {
                margin: 0.3,
                filename: 'Transferlist.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                  orientation: 'landscape',
                    unit: 'in',
                    format: 'A4'
                }
            };
            html2pdf().set(opt).from(response).save();
              }

            }); 
  });
  </script>
<script>
$('#print_data').click(function() {
  var newTab = window.open('', '_blank');

  // HTML content of the new tab
  var htmlContent = '<html><head><title>Transfer List</title>';
  
  // Add CSS styles for table formatting
  htmlContent += '<style>table { width: 100%; border-collapse: collapse; } th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; } th { background-color: #f2f2f2; }</style>';
  
  htmlContent += '</head><body><h1>Transfer List</h1><br>';

  // Get the HTML content of the data table
  var tableHtml = $('#zero_config').prop('outerHTML');

  // Add the data table HTML to the new tab
  htmlContent += tableHtml;

  // Add a print button to the HTML content

  // Close the HTML content and open the new tab
  htmlContent += '</body></html>';
  newTab.document.open();
  newTab.document.write(htmlContent);
  newTab.document.close();
  newTab.onload = function() {
    newTab.print();
  };
  newTab.onafterprint = function() {
    newTab.close();
  };
});
</script>

@endsection
     
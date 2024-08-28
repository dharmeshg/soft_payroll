<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    
{{--@extends('layouts.institute')--}}
@extends('layouts.employee')

@section('content')

<style>
    .search-btn {
        margin-top: 31px;
    }
    .btn{
        padding: 10px;
    }
    
</style>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Graphical Report</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content employee-content">
                <div class="employee-page">
                    <section>
                        <form method="post" data-parsley-validate="">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="faculty">School</label>
                                    <select id="faculty" name="faculty" class="faculty form-control" >
                                        <option value="">--Select School--</option>                                        
                                        @if(isset($facultyfilter))
                                            @foreach($facultyfilter as $facultyfilters)
                                                <option <?php echo isset( $faculty_data) && $faculty_data == $facultyfilters['id']
                                            ? 'selected' : '' ?> value="{{ $facultyfilters->id }}">{{ isset($facultyfilters->facultyname) ? $facultyfilters->facultyname : '' }}
                                                </option>
                                            @endforeach
                                        @endif                                       
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="department">Department </label>
                                    <select id="department" name="department" class="department required form-control">
                                        <option value="">--Select Department--</option>
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 form-group">
                                    <label for="unit">Unit </label>
                                    <select id="unit" name="unit" class="unit required form-control">
                                        <option value="">--Select Unit--</option>
                                    </select>
                                </div>                                                               
                                <div
                                    class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 form-group search-button">
                                    <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search"
                                            aria-hidden="true"></i></button>
                                </div>

                                <!-- <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 form-group">
                                	<a href="" class="is-data-export-button"><img src="{{ asset('assets/images/export-icon.svg') }}"></a>
                                </div> -->

                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>   
        @if(isset($data) && !empty($data) && count($data) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- column -->
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Marital Status V/S Gender</h4>
                                    </div>
                                </div>
                                <canvas id="myChart" style="width:100%;max-width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Religion V/S Gender</h4>
                                    </div>
                                </div>
                                <canvas id="myChart1" style="width:100%;max-width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- column -->
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Designation V/S Gender</h4>
                                    </div>
                                </div>
                                <canvas id="myChart2" style="width:100%;max-width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Designation V/S Religion</h4>
                                    </div>
                                </div>
                                <canvas id="myChart3" style="width:100%;max-width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- column -->
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Certificate Obtained V/S Gender</h4>
                                    </div>
                                </div>
                                <canvas id="myChart4" style="width:100%;max-width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Employee Count V/S Grade Level V/S Gender</h4>
                                    </div>
                                </div>
                                <canvas id="myChart5" style="width:100%;max-width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @endif
    </div>
</div>

@endsection
<?php //dd($malecount); ?>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
jQuery(document).ready(function () {
    $('#faculty').on('change', function() {
      var directorate_id = this.value;
      $("#department").html('');
      $.ajax({
        url: "{{url('employee/department')}}",
        type: "POST",
        data: {
          directorate_id: directorate_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#department').html('<option value="">Select Department</option>');          
          $.each(result.departmentname, function(key, value) {
            $("#department").append('<option value="' + value.id + '">' + value.departmentname + '</option>');
          });
          $('#unit').html('<option value="">Select Department First</option>');
          $('#employee').html('<option value="">Select Unit First</option>');
        }
      });
    });
    @if(isset($faculty_data) && $faculty_data != NULL)
        var directorate_id = '{{$faculty_data}}';
        $("#department").html('');
        $.ajax({
          url: "{{url('employee/department')}}",
          type: "POST",
          data: {
            directorate_id: directorate_id,
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(result) {
            $('#department').html('<option value="">Select Department</option>');
            var department_data = '{{$department_data}}';
            $.each(result.departmentname, function(key, value) {
              var selected = '';
              if (department_data == value.id) {
                var isselected = 'selected';
              }
              $("#department").append('<option value="' + value.id + '" ' + isselected + '>' + value.departmentname + '</option>');
            });
          }
        });
    @endif
    $('#department').on('change', function() {
      var department_id = this.value;  
      $("#unit").html('');
      $.ajax({
        url: "{{url('employee/unit')}}",
        type: "POST",
        data: {
          department_id: department_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#unit').html('<option value="">Select Unit</option>');          
          $.each(result.unit, function(key, value) {
            $("#unit").append('<option value="' + value.id + '">' + value.name + '</option>');
          });          
          $('#employee').html('<option value="">Select Unit First</option>');
        }
      });
    });
    @if(isset($department_data) && $department_data != NULL)
        var department_id = '{{$department_data}}';
        $("#unit").html('');
        $.ajax({
          url: "{{url('employee/unit')}}",
          type: "POST",
          data: {
            department_id: department_id,
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(result) {
            $('#unit').html('<option value="">Select Unit</option>');
            var unit_data = '{{$unit_data}}';
            $.each(result.unit, function(key, value) {
              var selected = '';
              if (unit_data == value.id) {
                var isselected = 'selected';
              }
              $("#unit").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
            });
          }
        });
    @endif
});
    jQuery(document).ready(function () {
        jQuery('.faculty').select2();
        // jQuery('.historytype').select2();
    });
    jQuery(document).ready(function () {
        jQuery('.department').select2();
        // jQuery('.historytype').select2();
    });
    jQuery(document).ready(function () {
        jQuery('.unit').select2();
        // jQuery('.historytype').select2();
    });
    jQuery(document).ready(function () {
        jQuery('.employee').select2();
        // jQuery('.historytype').select2();
    });
    jQuery(document).ready(function () {
        jQuery('.filtecontnet').select2();
        // jQuery('.historytype').select2();
    });
    
</script>
<!-- <script src="{{ asset('dist/js/excelexportjs.js') }}"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
@if(isset($data) && !empty($data) && count($data) > 0)
var xValues = ['Single', 'Married', 'Unmarried', 'Other'];
var yValuesmale = @json($malecount);
var yValuesfemale = @json($femalecount);
var yValuesother = @json($othercount);

new Chart("myChart", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: [{
         label: 'Male',
         data: yValuesmale,
         backgroundColor: '#28b779'
      }, {
         label: 'Female',
         data: yValuesfemale,
         backgroundColor: '#da542e'
      }, {
         label: 'Other',
         data: yValuesother,
         backgroundColor: '#2255a4'
      }]
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});

var xValues = @json($religion);
var yValuesmale = @json($malereligioncount);
var yValuesfemale = @json($femalereligioncount);
var yValuesother = @json($otherreligioncount);

new Chart("myChart1", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: [{
         label: 'Male',
         data: yValuesmale,
         backgroundColor: '#28b779'
      }, {
         label: 'Female',
         data: yValuesfemale,
         backgroundColor: '#da542e'
      }, {
         label: 'Other',
         data: yValuesother,
         backgroundColor: '#2255a4'
      }]
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});

var xValues = @json($designationname);
var yValuesmale = @json($maledesignationcount);
var yValuesfemale = @json($femaledesignationcount);
var yValuesother = @json($otherdesignationcount);

new Chart("myChart2", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: [{
         label: 'Male',
         data: yValuesmale,
         backgroundColor: '#28b779'
      }, {
         label: 'Female',
         data: yValuesfemale,
         backgroundColor: '#da542e'
      }, {
         label: 'Other',
         data: yValuesother,
         backgroundColor: '#2255a4'
      }]
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});

var xValues = @json($designationname);
<?php
$i = 0;
foreach($religdesignationcount as $key => $religdesignationcnt) {    
   $baccolor = array('#28b779','#da542e','#2255a4','#7460ee');
   if(isset($baccolor[$i])) {
        $baccolor = $baccolor[$i];
   }
   else {
        $baccolor = '#28b779';
   }
   $abc[] = ['label'=>$key,'data'=>$religdesignationcnt,'backgroundColor'=>$baccolor];
   $i++;
}
?>
var yValueschristianity = @json($religdesignationcount);
var cde = @json($abc);
console.log(cde);
var yValuesshinto = [2,2,2]
new Chart("myChart3", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: cde      
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});

//var xValues = ['BSC', 'BEd', 'MA','MSC', 'MEd','Phd'];
var xValues = @json($certiobtained);

var yValuesmale = @json($malecertiobtaincount);
var yValuesfemale = @json($femalecertiobtaincount);
var yValuesother = @json($othercertiobtaincount);

new Chart("myChart4", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: [{
         label: 'Male',
         data: yValuesmale,
         backgroundColor: '#28b779'
      }, {
         label: 'Female',
         data: yValuesfemale,
         backgroundColor: '#da542e'
      }, {
         label: 'Other',
         data: yValuesother,
         backgroundColor: '#2255a4'
      }]
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});

var xValues = @json($gradelevel);
//var xValues = @json($certiobtained);


var yValuesmale = @json($malegradelevelcount);

var yValuesfemale = @json($femalegradelevelcount);

var yValuesother = @json($othergradelevelcount);

new Chart("myChart5", {
   type: 'bar',
   data: {
      labels: xValues,
      datasets: [{
         label: 'Male',
         data: yValuesmale,
         backgroundColor: '#28b779'
      }, {
         label: 'Female',
         data: yValuesfemale,
         backgroundColor: '#da542e'
      }, {
         label: 'Other',
         data: yValuesother,
         backgroundColor: '#2255a4'
      }]
   },
   options: {      
      scales: {
         xAxes: [{
            stacked: true // this should be set to make the bars stacked
         }],
         yAxes: [{
            stacked: true // this also..
         }]
      }
   }
});
@endif
</script>
@endsection
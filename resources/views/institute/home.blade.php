<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')

@section('content')

<style>
  .select2-container {
      display: block;
      width: 100% !important;
  }
  h6.nobirthday-icon {
    color: #27a9e3;  
    font-size: 100px;
    text-align: center;
  }
  .no-birthday h4 {
    text-align: center;
  }
  .todolist-section h4 {
    display: inline-block;
  }
  .todolist-section a {
      display: inline-block;
      float: right;
  }
  .todolist-section span.ti-plus:before {
      margin-right: 5px;
      font-size: 10px;
  }
  .todolist-section button.btn.btn-outline-light {
    padding: 5px 10px 7px 10px;
  }
  .todolist-section button.btn.btn-outline-light:hover {
    background: #ffffff !important;
    color: #ffa962;
  }
  .todolist-section .card-header {
    background: #ffa962;
    color: #ffffff;
  }
  .notactivebtn {
    background: transparent;
    color: #705de6;
  }
  .todolist-section .btn-check:focus+.btn-primary,.todolist-section .btn-primary:focus {
    box-shadow: unset !important;
  }
  button#toDoListsCompleted {
    float: right;
  }
  .to-do-list {
    margin-bottom: 20px;
  }
  .common-checkbox {
    margin-top: 3px;
    margin-right: 20px;
  }
  .todolist-section .toDoList div {
    display: flex;
    align-items: flex-start;
  }
</style>
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Dashboard</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                <!--   <ol class="breadcrumb">
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
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Sales Cards  -->
          <!-- ============================================================== -->
          <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('facultydirectorate.list')}}">
                <div class="box bg-cyan text-center">
                  <h1 class="font-light text-white">
                    <i class="mdi mdi-account-multiple"></i>
                  </h1>
                  <h6 class="text-white">School/Directorate</h6>
                </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('employee.list')}}">
                  <div class="box bg-success text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-account"></i>
                    </h1>
                    <h6 class="text-white">Employee</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">                
                <a href="{{ route('department.list')}}">
                  <div class="box bg-warning text-center">
                    <h1 class="font-light text-white">
                      <i class="fas fa-building"></i>
                    </h1>
                    <h6 class="text-white">Departments</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('unit.list')}}">
                  <div class="box bg-danger text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-format-list-numbers"></i>
                    </h1>
                    <h6 class="text-white">Unit</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('designation.list')}}">
                  <div class="box bg-info text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi fas fa-building"></i>
                    </h1>
                    <h6 class="text-white">Designation</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('employee.graph')}}">
                  <div class="box bg-danger text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-chart-bar"></i>
                    </h1>
                    <h6 class="text-white">Graphical Report</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->            
            <div class="col-md-6 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('employee.history')}}">
                  <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-history"></i>
                    </h1>
                    <h6 class="text-white">Reports History and Counts</h6>
                  </div>
                </a>
              </div>
            </div>            
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('employee.history')}}">
                  <div class="box bg-info text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-filter-outline"></i>
                    </h1>
                    <h6 class="text-white">Employee Filter</h6>
                  </div>
                </a>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('transfer.list')}}">
                  <div class="box bg-warning text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-transit-transfer"></i>
                    </h1>
                    <h6 class="text-white">Transfer Management</h6>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <a href="{{ route('leave.index')}}">
                  <div class="box bg-success text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-calendar-clock"></i>
                    </h1>
                    <h6 class="text-white">Leave Management</h6>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- Sales chart -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <!-- column -->
                    <div class="col-md-6">
                      <div class="d-md-flex align-items-center">
                        <div>
                          <h4 class="card-title">Department V/S Grade</h4>
                        </div>
                      </div>
                      <canvas id="myChart" style="width:100%;max-width:100%;"></canvas>
                    </div>
                    <div class="col-md-6">
                      <div class="d-md-flex align-items-center">
                        <div>
                          <h4 class="card-title">Month v/s Recruitment</h4>
                        </div>
                      </div>
                      <canvas id="myChart3" style="width:100%;max-width:100%;"></canvas>
                    </div>
                    <!-- column -->

                    <div
                  class="comment-widgets scrollable"
                  style="max-height: 130px"
                >
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
                    <div class="col-md-12">
                      <div class="d-md-flex align-items-center">
                        <div>
                          <h4 class="card-title">Department V/S Gender</h4>
                        </div>
                      </div>
                      <div class="row">
                      <?php $i=1;?>
                      @foreach($keys as $ke)
                      <?php if(($i % 4) == 1 ) { echo "</div><div class='row'>"; } ?>
                      <div class="col-lg-3 col-md-3">
                      <canvas id="myChart{{$ke}}" style="width:100%;max-width:100%;"></canvas>
                      </div>
                      @php
                        $i++
                      @endphp
                      @endforeach
                      </div>
                    </div>
                    <div
                  class="comment-widgets scrollable"
                  style="max-height: 130px"
                >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Today Birthday Start -->
        <?php if (isset($todaybirthday) && !empty($todaybirthday) && (count($todaybirthday) == 1 )) { $flex = ''; } else{ $flex = ''; } ?>
        <div class="row" style=" <?php echo $flex; ?>">
          <?php if (isset($todaybirthday) && !empty($todaybirthday) && (count($todaybirthday) > 1 )) { ?>
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Today's Birthdays</h4>
              </div>
              
              <div class="comment-widgets scrollable" style="height: 100%; max-height:170px;"> 
                <div class="container">
                <div class="row"> 
                @foreach($todaybirthday as $todaybirthdayvalue)              
                  <div class="col-lg-4">
                    <div class="d-flex flex-row birth-today mt-0 align-items-center" style="background: rgba(0,0,0,0.05);padding: 15px 30px;">                      
                      <div class="w-100">
                        <h6 class="font-medium fw-bold" style="text-align: left;">{{$todaybirthdayvalue->fname}} {{$todaybirthdayvalue->lname}}</h6>  
                        <h6 class="font-medium" style="text-align: left;">{{ date('M d, Y', strtotime($todaybirthdayvalue->dateofbirth) )}}</h6>
                        <h6 class="font-medium " style="text-align: left;">{{ $todaybirthdayvalue->department }}</h6>
                        <span class="font-medium fw-bold" style="text-align: left; color: #ffa962 !important;">{{ date_diff(date_create($todaybirthdayvalue->dateofbirth), date_create('today'))->y }} years</span>                        
                      </div>  
                      <div class="p-2">
                        <?php 
                          $pro_image2 = isset($todaybirthdayvalue->profile_image) ? '../public/employee/'.$todaybirthdayvalue->profile_image : '../assets/images/users/1.jpg';
                         ?>
                        <img
                          src="{{$pro_image2}}"
                          alt="user"
                          width="50"
                          height="50"
                          class="rounded-circle"
                        />
                      </div>              
                    </div>  
                  </div>
                @endforeach
                </div>
              </div>
              </div>              
            </div>

            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                    <label for="graphtype">Graph Type</label>
                    <select id="graphtype" name="graphtype" class="graphtype required form-control">
                        <option value="">--Select Graph--</option>
                        <option value="designation-vs-number-of-employee">Designation v/s Number of Employee</option>
                        <option value="designation-vs-gender">Designation v/s Gender</option>   
                        <option value="employee-vs-faculty">School v/s Employee</option>                
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card graph-main">
              <div class="card-body">
                <div class="row">
                  <!-- column -->
                  <div class="col-md-12 graphchart designation-vs-number-of-employee">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">Designation v/s Number of Employee</h4>
                      </div>
                    </div>
                    <canvas id="myChart4" style="width:100%;max-width:100%;"></canvas>
                  </div>  
                  <div class="col-md-12 graphchart designation-vs-gender">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">Designation v/s Gender</h4>
                      </div>
                    </div>
                    <div class="row">                      
                      @foreach($designationkey as $desikey)                        
                        <div class="col-lg-4 col-md-4">
                          <canvas id="myChart{{$desikey}}" style="width:100%;max-width:100%;"></canvas>
                        </div>
                      @endforeach
                    </div>                    
                  </div>   
                  <div class="col-md-12 graphchart employee-vs-faculty">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">School v/s Employee</h4>
                      </div>
                    </div>
                    <canvas id="myChart5" style="width:100%;max-width:100%;"></canvas>
                  </div>                
                  <!-- column -->
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <!-- Today Birthday End -->

        <!-- Start Upcoming Birthdays Code -->
        <?php if ((isset($emp_data) && !empty($emp_data)) || ((isset($todaybirthday) && !empty($todaybirthday))) ) { ?>
        <div class="col-lg-4">
        <?php if (isset($todaybirthday) && !empty($todaybirthday) && (count($todaybirthday) == 1 )) { ?>
          
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Today's Birthdays</h4>
              </div>
              
              <div class="comment-widgets scrollable" style="height: 100%; max-height:170px;"> 
                <div class="container">
                <div class="row"> 
                @foreach($todaybirthday as $todaybirthdayvalue)              
                  <div class="col-lg-12">
                    <div class="d-flex flex-row mt-0 align-items-center">  
                      <div class="p-2">
                        <?php 
                          $pro_image1 = isset($todaybirthdayvalue->profile_image) ? '../public/employee/'.$todaybirthdayvalue->profile_image : '../assets/images/users/1.jpg';
                         ?>
                        <img
                          src="{{$pro_image1}}"
                          alt="user"
                          width="90"
                          height="90"
                          class="rounded-circle"
                        />
                      </div> 
                      <div class="comment-text w-100">
                        <h6 class="font-medium fw-bold">{{$todaybirthdayvalue->fname}} {{$todaybirthdayvalue->lname}}</h6>  
                        <h6 class="font-medium">{{ date('M d, Y', strtotime($todaybirthdayvalue->dateofbirth) )}}</h6>
                        <h6 class="font-medium ">{{ $todaybirthdayvalue->department }}</h6>
                        <span class="font-medium fw-bold">{{ date_diff(date_create($todaybirthdayvalue->dateofbirth), date_create('today'))->y }} years</span>                        
                      </div>              
                    </div>  
                  </div>
                @endforeach
                </div>
              </div>
              </div>              
            </div>
          
        <?php } ?>
        <?php if (isset($emp_data) && !empty($emp_data)) { ?>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Upcoming Birthdays</h4>
            </div>
            <div class="comment-widgets scrollable" style="height: 100%; max-height:300px;">
              <?php //echo "<pre>"; print_r($emp_data);
              $value = []; ?>
              @foreach($emp_data as $value)
              <?php $value = $value;// echo "<pre>"; print_r($value); ?>
              <!-- Comment Row -->
              @foreach($value as $valuea)
              <div class="d-flex flex-row comment-row mt-0 align-items-center">
                <div class="p-2">
                  <?php 
                    $pro_image = isset($valuea->profile_image) ? '../public/employee/'.$valuea->profile_image : '../assets/images/users/1.jpg';
                   ?>
                  <img                    
                    src="{{$pro_image}}"
                    alt="user"
                    width="50"
                    height="50" 
                    class="rounded-circle"
                  />
                </div>
                <div class="comment-text w-100">
                  <h6 class="font-medium fw-bold">{{$valuea->fname}} {{$valuea->lname}}</h6>  
                  <h6 class="font-medium">{{  date('M d, Y', strtotime($valuea->dateofbirth) )}}</h6>
                  <span class="fw-bold">{{ date_diff(date_create($valuea->dateofbirth), date_create('today'))->y }} years</span>   
                </div>
              </div>
                @endforeach
                @endforeach
            </div>
          </div>
        <?php } else { ?>
          <?php if (count($todaybirthday) == 0 ) {   ?>
            <div class="card no-birthday">
              <div class="card-body">
                <h4 class="card-title">No Upcoming Birthdays</h4>
                <h6 class="nobirthday-icon"><i class="mdi mdi-cake-layered"></i></h6>
              </div>
            </div>
            <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <!-- End Upcoming Birthdays Code -->
        <?php if ( (!isset($todaybirthday)) || ( isset($todaybirthday) && count($todaybirthday) <= 1 ) ) { ?>          
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                    <label for="graphtype">Graph Type</label>
                    <select id="graphtype" name="graphtype" class="graphtype required form-control">
                        <option value="">--Select Graph--</option>
                        <option value="designation-vs-number-of-employee">Designation v/s Number of Employee</option>
                        <option value="designation-vs-gender">Designation v/s Gender</option>   
                        <option value="employee-vs-faculty">School v/s Employee</option>                
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card graph-main">
              <div class="card-body">
                <div class="row">
                  <!-- column -->
                  <div class="col-md-12 graphchart designation-vs-number-of-employee">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">Designation v/s Number of Employee</h4>
                      </div>
                    </div>
                    <canvas id="myChart4" style="width:100%;max-width:100%;"></canvas>
                  </div>  
                  <div class="col-md-12 graphchart designation-vs-gender">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">Designation v/s Gender</h4>
                      </div>
                    </div>
                    <div class="row">                      
                      @foreach($designationkey as $desikey)                        
                        <div class="col-lg-4 col-md-4">
                          <canvas id="myChart{{$desikey}}" style="width:100%;max-width:100%;"></canvas>
                        </div>
                      @endforeach
                    </div>                    
                  </div>    
                  <div class="col-md-12 graphchart employee-vs-faculty">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">School v/s Employee</h4>
                      </div>
                    </div>
                    <canvas id="myChart5" style="width:100%;max-width:100%;"></canvas>
                  </div>                 
                  <!-- column -->
                </div>
              </div>
            </div>
          </div>
          
        <?php } ?>
      </div>
      


<div class="row todolist-section">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
          <h4 class="card-title">To Do List</h4>
          <a href="#" data-toggle="modal" class="" data-target="#add_to_do" title="Add To Do" data-modal-size="modal-md">          
            <button type="button" class="btn btn-outline-light" data-dismiss="modal"><span class="ti-plus">Add</span></button>         
          </a>
        </div>
      <div class="card-body">

        <div class="modal fade admin-query" id="add_to_do">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add To Do</h4>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <form id="example-form" action="{{ route('saveToDoData.institute')}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-12 form-group">
                            <label for="todo_title">To Do Title</label>
                            <input id="todo_title" name="todo_title" type="text" class=" required form-control" required="" data-parsley-required-message="Please Enter To Do Title" value="" />
                          </div>
                        </div>
                        <div class="row mt-30">
                          <div class="col-lg-12 form-group">
                            <label for="tododate">Date</label>
                              <input id="tododate" name="tododate" type="text" class="required form-control datepicker" data-parsley-required-message="Please Enter To Do Date" value="" />                            
                          </div>
                        </div>
                        <div class="col-lg-12 text-center">
                          <div class="mt-40 d-flex justify-content-between">                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                            <button type="submit" class="btn btn-primary">save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--to list view start-->

        <div class="row to-do-list mb-20">
          <div class="col-md-6 col-6">
              <button class="btn btn-primary" id="toDoList">Incomplete</button>
          </div>
          <div class="col-md-6 col-6">
              <button class="btn btn-primary notactivebtn" id="toDoListsCompleted">Completed</button>
          </div>
        </div>
        <input type="hidden" id="url" value="{{url('/')}}">
        @if( isset($todoviewpending) )
          @foreach($todoviewpending as $todoviewpendings)
            <div class="toDoList">
              <div class="single-to-do d-flex justify-content-between toDoList" id="to_do_list_div{{@$todoviewpendings->id}}">
                <div>
                  <input type="checkbox" id="midterm{{@$todoviewpendings->id}}" class="common-checkbox complete_task" name="complete_task" value="{{@$todoviewpendings->id}}">
                  <label for="midterm{{@$todoviewpendings->id}}">
                      <input type="hidden" id="id" value="{{@$todoviewpendings->id}}">
                      <input type="hidden" id="url" value="{{url('/')}}">
                      <h5 class="d-inline">{{$todoviewpendings->todo_title}}</h5>
                      <p class="ml-35">{{$todoviewpendings->todo_date->format('jS M, Y')}}</p>
                  </label>
                </div>
              </div>
            </div>
          @endforeach
        @endif
       
            <div class="toDoListsCompleted">
             
            </div>
       
        <!--to do list view end-->
      </div>
    </div>
  </div>
</div> 
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>

jQuery(document).ready(function() {
    $('.datepicker').datepicker({
      todayHighlight: true,
      format: 'd/m/yyyy'
    });
    $(".toDoListsCompleted").hide();
    $("#toDoList").on("click", function(e) {
        e.preventDefault();
        $(".toDoList").show();
        $(".toDoListsCompleted").hide();
        $("#toDoList").removeClass('notactivebtn');
        $("#toDoListsCompleted").addClass('notactivebtn');
    });

    $("#toDoListsCompleted").on("click", function(e) {
      $("#toDoList").addClass('notactivebtn');
      $("#toDoListsCompleted").removeClass('notactivebtn');
      e.preventDefault();
        $(".toDoList").hide();
        $(".toDoListsCompleted").show();

        var formData = {
          id: 0,
        };
        var url = $("#url").val();

        $.ajax({
          type: "GET",
          data: formData,
          dataType: "json",
          url: '{{ route("getToDoList.institute") }}',
          success: function(data) {
            console.log(data);
            $(".toDoListsCompleted").empty();
            $.each(data, function(i, value) {
                var appendRow = "";
                appendRow +=
                    "<div class='single-to-do d-flex justify-content-between'>";
                appendRow += "<div>";
                appendRow += "<h5 class='d-inline'>" + value.title + "</h5>";
                appendRow += "<p>" + value.date + "</p>";
                appendRow += "</div>";
                appendRow += "</div>";
                $(".toDoListsCompleted").append(appendRow);
            });
          },
          error: function(data) {
            console.log("Error:", data);
          },
        });
    });

    $(".complete_task").on("click", function() {
        var url = $("#url").val();
        var id = $(this).val();
        var formData = {
            id: $(this).val(),
        };
        console.log(formData);
        // get section for student
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: '{{ route("removetodo.institute") }}',
            success: function(data) {
                setTimeout(function() {
                    toastr.success(
                        "Operation Success!",
                        "Success Alert", {
                            iconClass: "customer-info",
                        }, {
                            timeOut: 50000,
                        }
                    );
                }, 500);

                $("#to_do_list_div" + id + "").remove();

                $("#toDoListsCompleted").children("div").remove();
            },
            error: function(data) {
                console.log("Error:", data);
            },
        });
    });
  });

$("select").change(function(){
  $(this).find("option:selected").each(function(){
      var optionValue = $(this).attr("value");
      if(optionValue){
          $(".graph-main").show();
          $(".graphchart").not("." + optionValue).hide();
          $("." + optionValue).show();
      } else{
          $(".graph-main").hide();
      }
  });
}).change();

var xValues = @json($keys);
var yValues = @json($values);
var barColors = @json($colors);

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Department v/s Greatest Grade Level"
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }],
    }
  }
});

@foreach($keys as $ke)
var xValues = ['Male','Female','Other'];
var yValues = [{{$genders[$ke]['male']}}, {{$genders[$ke]['female']}}, {{$genders[$ke]['other']}}];
var barColors = [
  "#28b779",
  "#da542e",
  "#2255a4",
];

new Chart("myChart{{$ke}}", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "{{$ke}}"
    }
  }
});
@endforeach

var xValues = @json($months1);
var yValues = @json($monthcountfinal);

new Chart("myChart3", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      data: yValues,
      borderColor: "#2255a4",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});

/* designation v/s no of employee */
var xValues = @json($designationkey);
var yValues = @json($designation_empcount);
var barColors = @json($colors);

new Chart("myChart4", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Designation v/s Number of Employee"
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }],
    }
  }
});

/* Faculty v/s no of employee */
var xValues = @json($facultykey);
var yValues = @json($faculty_empcount);
var barColors = @json($colors);

new Chart("myChart5", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "School v/s Employee"
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }],
    }
  }
});

/* designation v/s Gender */
@foreach($designationkey as $desikey)
var xValues = ['Male','Female','Other'];
var yValues = [{{$desigenders[$desikey]['male']}}, {{$desigenders[$desikey]['female']}}, {{$desigenders[$desikey]['other']}}];
var barColors = [
  "#28b779",
  "#da542e",
  "#2255a4",
];

new Chart("myChart{{$desikey}}", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "{{$desikey}}"
    }
  }
});
@endforeach

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    jQuery(document).ready(function () {
      jQuery('.graphtype').select2();
      // jQuery('.historytype').select2();
  });
  $('.graphtype').select2({
        placeholder: "--Select Graph--",
        allowClear: true
  });
</script>
@endsection

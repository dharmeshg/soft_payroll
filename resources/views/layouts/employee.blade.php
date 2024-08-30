<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex,nofollow" />

    <title>SoftPayroll</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />
    <!-- Custom CSS -->

    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />

    <!--  <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }}" rel="stylesheet" />

    <!-- toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--added for to do list-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--end to do list-->

    <style>
        .notification h5 {
            font-weight: 600;
            line-height: 20px;
            padding-bottom: 7px;
        }
        .left-sidebar{width: 300px !important;}
        #main-wrapper[data-sidebartype="full"] .page-wrapper { margin-left: 300px !important;}

        .notification-date {
            font-weight: 700;
        }

        .notification-bell a i span {
            position: absolute;
            top: 13px;
            left: 41px;
            border-radius: 50%;
            color: #fff;
            background: #da542e;
            height: 20px;
            width: 20px;
            margin-left: -13px;
            font-size: 11px;
            border-color: #8C4297;
            text-decoration: none;
            display: inline-block;
            line-height: 20px;
            padding: 0 5px 0 3px;
        }

        .notification_div {
            overflow: auto;
            max-height: 200px;
        }
    </style>

</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


 
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    @if (Auth::user()->role == null)
                        <a class="navbar-brand" href="{{ route('home.institute') }}">
                        @else
                            <a class="navbar-brand" href="{{ route('employeehome.emp_dashboard') }}">
                    @endif
                    <b class="logo-icon ps-2">
                        @if (Auth::user()->is_school == 3)
                            @if (isset(\App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->instiimage) &&
                                    \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->instiimage != '')
                                <img src="{{ asset('public/images/' . \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->instiimage) }}"
                                    alt="homepage" class="light-logo" height="50" />
                            @endif
                        @else
                            @if (isset(Auth::user()->instiimage) && Auth::user()->instiimage != '')
                                <img src="{{ asset('public/images/' . Auth::user()->instiimage) }}" alt="homepage"
                                    class="light-logo" height="50" />
                            @endif
                        @endif



                    </b>
                    </a>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link dropdown-toggle">
                                <span class="d-none d-md-block right-line">
                                    @if (Auth::user()->is_school == 3)
                                        {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->institutionname }}
                                    @else
                                        @if (isset(Auth::user()->institutionname))
                                            {{ Auth::user()->institutionname }}
                                        @endif
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link dropdown-toggle">
                                <!-- <span class="d-none d-md-block">{{ Auth::user()->address }}</span>   -->
                                <span class="d-none d-md-block right-line">
                                    @if (Auth::user()->is_school == 3)
                                        {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->city }}
                                    @else
                                        @if (isset(Auth::user()->city))
                                            {{ Auth::user()->city }}
                                        @endif
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link dropdown-toggle">
                                <!-- <span class="d-none d-md-block">{{ Auth::user()->address }}</span>   -->
                                <span class="d-none d-md-block right-line">
                                    @if (Auth::user()->is_school == 3)
                                        {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->state }}
                                    @else
                                        @if (isset(Auth::user()->state))
                                            {{ Auth::user()->state }}
                                        @endif
                                    @endif
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-none d-md-block">More Detail<i
                                        class="fa fa-angle-down offset-1"></i></span>
                                <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="tel:{{ Auth::user()->contact_no }}">
                                        <span class="d-none d-md-block">
                                            @if (Auth::user()->is_school == 3)
                                                {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->contact_no }}
                                            @else
                                                @if (isset(Auth::user()->contact_no))
                                                    {{ Auth::user()->contact_no }}
                                                @endif
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="https://{{ Auth::user()->websiteaddress }}">
                                        <span class="d-none d-md-block">
                                            @if (Auth::user()->is_school == 3)
                                                {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->websiteaddress }}
                                            @else
                                                @if (isset(Auth::user()->websiteaddress))
                                                    {{ Auth::user()->websiteaddress }}
                                                @endif
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="mailto:{{ Auth::user()->email }}">
                                        <span class="d-none d-md-block">
                                            @if (Auth::user()->is_school == 3)
                                                {{ \App\Models\User::where('id', Auth::user()->employee->institution_id)->first()->email }}
                                            @else
                                                @if (isset(Auth::user()->email))
                                                    {{ Auth::user()->email }}
                                                @endif
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item notification-bell dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->role == null)
                                    <i
                                        class="mdi mdi-bell font-24"><span>{{ Auth::user()->Notifications->where('is_read', '=', 0)->count() }}</span></i>
                                @else
                                    <i
                                        class="mdi mdi-bell font-24"><span>{{ Auth::user()->Notifications->where('is_read', '=', 0)->count() }}</span></i>
                                @endif
                            </a>
                            <!-- <ul class="dropdown-menu notification_ul" aria-labelledby="navbarDropdown">
                  
              
                </ul> -->
                            <ul class="
                    dropdown-menu dropdown-menu-end
                    mailbox
                    animated
                    bounceInDown
                  "
                                aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="is-notification-list">

                                            <?php
                        
                        if( NotificationDashboard()->isNotEmpty() ) {
                          echo '<div class="notification_div">';
                        	foreach( NotificationDashboard() as $notification ) {
                           if($notification->role == 'Employee' && $notification->notifiable_type == 'process_transfer')
                           {
                             echo '<a href="' . route('authorizetransfer.edit', [$notification->notifiable_id]) . '" class="link border-top">';
                           }
                           elseif($notification->role == 'HOU' && $notification->notifiable_type == 'authorized_transfer'){
                            echo '<a href="' . route('authorizetransfer.edit', [$notification->notifiable_id]) . '" class="link border-top">';
                           }
                           elseif($notification->role == 'HOD' && $notification->notifiable_type == 'authorized_transfer'){
                            echo '<a href="' . route('authorizetransfer.edit', [$notification->notifiable_id]) . '" class="link border-top">';
                           }
                           elseif($notification->role == 'Institute' && $notification->notifiable_type == 'Approved Transfer'){
                            echo '<a href="' . route('approvetransfer.edit', [$notification->notifiable_id]) . '" class="link border-top">';
                           }
                           else{
                        echo '<a href="javascript:void(0)" class="link border-top">';
                      }
                          echo '<div class="d-flex no-block align-items-center p-10 notification_div">';
                            echo '<span class="btn btn-primary btn-circle d-flex align-items-center justify-content-center">';
                           echo ' <i class="mdi mdi-account fs-4"></i></span>';
                            echo '<div class="ms-2 notification">';
                            echo '<h5 data-id="'.$notification['id'].'">'.'</h5>';
                             echo '<h5 class="mb-0">'.$notification['message'].'</h5>';
                             echo '<span class="notification-date">';
                             echo date('d-m-Y');
                             echo'</span>';
                            echo '</div>';
                          echo '</div>';
                        echo '</a>';
                        
                         } 
                         echo '</div>';
                     }else {
                            ?><p class="no-notification">No notification found!</p>
                                            <?php
                          }
                          ?>
                                            @if (NotificationDashboard()->isNotEmpty())
                                                <div class="button view-all-notification">
                                                    @if (Auth::user()->role == null)
                                                        <a href="{{ route('insti-read-all-notification') }}">Read All
                                                            Notifications</a>
                                                    @else
                                                        <a href="{{ route('read-all-notification') }}">Read All
                                                            Notifications</a>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" id="2"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="font-24 mdi mdi-comment-processing"></i>
                            </a>
                            <ul class="
                    dropdown-menu dropdown-menu-end
                    mailbox
                    animated
                    bounceInDown
                  "
                                aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="">
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span
                                                        class="
                                btn btn-success btn-circle
                                d-flex
                                align-items-center
                                justify-content-center
                              "><i
                                                            class="mdi mdi-calendar text-white fs-4"></i></span>
                                                    <div class="ms-2">
                                                        <h5 class="mb-0">Event today</h5>
                                                        <span class="mail-desc">Just a reminder that event</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span
                                                        class=" btn btn-info btn-circle d-flex align-items-center justify-content-center"><i
                                                            class="mdi mdi-settings fs-4"></i></span>
                                                    <div class="ms-2">
                                                        <h5 class="mb-0">Settings</h5>
                                                        <span class="mail-desc">You can customize this template</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- <a href="javascript:void(0)" class="link border-top">
                          <div class="d-flex no-block align-items-center p-10">
                            <span
                              class="
                                btn btn-primary btn-circle
                                d-flex
                                align-items-center
                                justify-content-center
                              "
                              ><i class="mdi mdi-account fs-4"></i
                            ></span>
                            <div class="ms-2">
                              <h5 class="mb-0">Pavan kumar</h5>
                              <span class="mail-desc"
                                >Just see the my admin!</span
                              >
                            </div>
                          </div>
                        </a> -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span
                                                        class="
                                btn btn-danger btn-circle
                                d-flex
                                align-items-center
                                justify-content-center
                              "><i
                                                            class="mdi mdi-link fs-4"></i></span>
                                                    <div class="ms-2">
                                                        <h5 class="mb-0">Luanch Admin</h5>
                                                        <span class="mail-desc">Just see the my new admin!</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  "
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @if (isset(Auth::user()->image))
                                    <img class="image rounded-circle" name="image"
                                        src="{{ asset('public/images/' . Auth::user()->image) }}" alt="profile_image"
                                        style="width: 100%;height: 60px; padding: 10px; margin: 0px; ">
                                @else
                                    <img class="image rounded-circle" name="image"
                                        src="{{ asset('public/images/upload.jpg') }}" alt="profile_image"
                                        style="width: 100%;height: 60px; padding: 10px; margin: 0px; ">
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">

                                <!-- <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#"
                    ><i class="mdi mdi-settings me-1 ms-1"></i> Account
                    Setting</a> -->

                                <!--<div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                        class="fa fa-power-off me-1 ms-1"></i>logout</a>
                                <!--<div class="dropdown-divider"></div>-->
                                <div class="ps-4 p-10">

                                    @if (Auth::user()->role == null || Auth::user()->is_school == 1)
                                        <a href="{{ route('institute.profile') }}"
                                            class="btn btn-sm btn-success btn-rounded text-white profileview">View
                                            Profile</a>
                                    @else
                                        <a href="{{ route('emp_dashboard.profile') }}"
                                            class="btn btn-sm btn-success btn-rounded text-white profileview">View
                                            Profile</a>
                                    @endif
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <p
                        style="color: #fff; padding: 10px 10px 0 10px; font-size: 11px; margin: 0 auto; text-align: center; line-height: 15px;">
                        {{ Auth::user()->institutionmotto }}</p>
                    <ul id="sidebarnav" class="pt-4">

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                <?php 
                    if(Auth::user()->role == 'Employee' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOD'){
                      ?>href="{{ route('employeehome.emp_dashboard') }}"<?php
                    }else{
                      ?>href="{{ route('home.institute') }}"
                                <?php
                    }
                  ?> aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Dashboard</span></a>
                        </li>
                        
                           @if(Auth::user()->category == '')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span
                                        class="hide-menu">School/Directorate </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.facultydirectorate') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Add
                                                School/Directorate </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('facultydirectorate.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu">School/Directorate
                                                List</span></a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            @if(Auth::user()->category == 'Academic' || Auth::user()->category == '')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-building"></i><span
                                        class="hide-menu">Department </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.department') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Add
                                                Department </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('department.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu"> Department List
                                                (Academic)</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('non_academic_department.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu"> Department List
                                                (Non-Academic) </span></a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(Auth::user()->category == 'Non-Academic' || Auth::user()->category == '')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-building"></i><span
                                        class="hide-menu">Division </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.division') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Add
                                                Division </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('division.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu"> Division List @if(Auth::user()->category == '') (Non-Academic) @endif
                                            </span></a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi mdi-format-list-numbers"></i><span
                                        class="hide-menu">Unit </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.unit') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Add
                                                Unit </span></a>
                                    </li>
                                    @if(Auth::user()->category == 'Academic' || Auth::user()->category == '')
                                    <li class="sidebar-item">
                                        <a href="{{ route('unit.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu">Unit
                                                List (Academic)</span></a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->category == 'Non-Academic' || Auth::user()->category == '')
                                    <li class="sidebar-item">
                                        <a href="{{ route('non_academic_unit.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu">Unit
                                                List (Non-Academic)</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi fas fa-building"></i><span
                                        class="hide-menu">Designation </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.designation') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Add
                                                Designation </span></a>
                                    </li>
                                    @if(Auth::user()->category == 'Academic' || Auth::user()->category == '')
                                    <li class="sidebar-item">
                                        <a href="{{ route('designation.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu">Designation
                                                List (Academic)</span></a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->category == 'Non-Academic' || Auth::user()->category == '')
                                    <li class="sidebar-item">
                                        <a href="{{ route('non_academic_designation.list') }}" class="sidebar-link"><i
                                                class="fas fa-list-alt"></i><span class="hide-menu">Designation
                                                List (Non-Academic)</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi mdi-account-circle"></i><span
                                        class="hide-menu">Employee </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.employee') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon"></i><span class="hide-menu">Add Employee
                                            </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('employee.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Employee </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('employee.history') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Reports
                                                History and Counts</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('employee.filter') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Employee
                                                Filter</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('employee.graph') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon"></i><span class="hide-menu">Graphical
                                                Report</span></a>
                                    </li>
                                </ul>
                            </li>

                            <!-- <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-account-multiple"></i
                  ><span class="hide-menu">Roles Management</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">{{-- {{ route('insti.rolespermissions')}} {{ route('insti.roles')}} {{ route('insti.permissions')}} {{ route('insti.rolespermissions')}} --}}
                <li class="sidebar-item">
                    <a href="javascript:void(0)" class="sidebar-link"
                      ><i class="mdi mdi-library-plus"></i
                      ><span class="hide-menu">Add Roles</span></a
                    >
                  </li><li class="sidebar-item">
                    <a href="javascript:void(0)" class="sidebar-link"
                      ><i class="mdi mdi-library-plus"></i
                      ><span class="hide-menu">Add Permissions</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="javascript:void(0)" class="sidebar-link"
                      ><i class="mdi mdi-library-plus"></i
                      ><span class="hide-menu">Roles And Permissions</span></a
                    >
                  </li>
                </ul>
              </li> -->

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi mdi-calendar-clock"></i><span
                                        class="hide-menu">Leave Management</span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('add.leavetype') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Leave Type
                                                Add</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('leavetype.index') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Leave
                                                Type</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('leavetype.Yearedit') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Leave Year
                                                Setting</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('leave.add') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">Leave
                                                Request</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('leave.index') }}" class="sidebar-link"><i
                                                class="mdi mdi-library-plus"></i><span class="hide-menu">View Leave
                                                Request</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="mdi mdi-account-circle"></i><span
                                        class="hide-menu">Transfer Management </span></a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ route('transferclass.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Transfer Class </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transfertype.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Transfer Type </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transfercategory.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Transfer Category </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transferreason.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Transfer Reason</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transfer.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Transfer Initiation Form </span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('authorizetransfer.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List
                                                Authorized Transfer Request</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('approvetransfer.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">List Approve
                                                Transfer Request</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('destination.list') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Destination
                                                Transfer Request</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transfer.audit') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Transfer
                                                Audit Details</span></a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('transfer.PreviousList') }}" class="sidebar-link"><i
                                                class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Previous
                                                Transfer Details</span></a>
                                    </li>
                                </ul>
                            </li>
                    </ul>
                </nav>
                <div class="bottom-logo">
                    <b class="logo-icon ps-2">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!--  <img
                  src="{{ asset('assets/images/logo-icon.png') }}"
                  alt="homepage"
                  class="light-logo"
                  width="25"
                /> -->
                        <a>SoftHR</a>
                    </b>
                </div>
            </div>
        </aside>

        <main class="">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('dist/js/excelexportjs.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>

    <!-- <script src="{{ asset('dist/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('dist/js/popper.min.js') }}"></script> -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!-- this page js -->
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- Charts js Files -->
    <script src="{{ asset('assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/chart/chart-page-init.js') }}"></script>
    <!--  toastr js  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });
    </script>
    <script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $("#zero_config").DataTable();
    </script>
    <!--  for parsly js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- inputmask -->
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/mask/mask.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <script>
        $(document).on('click', '.button.view-all-notification a', function() {
            var is_data = [];
            $(".is-notification-list").each(function(index) {
                is_data.push($(this).attr('data-id'));
            });
            $.ajax({
                type: "POST",
                url: "{{ route('read-all-notification') }}",
                data: {
                    is_data: is_data,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                }
            });
        });
    </script>
    @yield('script')
</body>

</html>

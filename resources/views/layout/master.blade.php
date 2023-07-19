<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ \App\Settings::find(1)->app_name }} | @yield('page-title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ (\App\Settings::find(1)->logo == null) ? url('/admin/assets/images/logo-icon.png') : \App\Settings::find(1)->logo }}"/>
    <!-- Custom CSS -->
    <link href="{{ asset('/admin/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/admin/assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/assets/libs/jquery-steps/steps.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/assets/libs/summer-note/summer-note.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ asset('/admin/assets/libs/tingle-modal/tingle.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/assets/dist/css/style.min.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/libs/toastr/toastr.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="/dashboard">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="{{ (\App\Settings::find(1)->logo == null) ? url('/admin/assets/images/logo-icon.png') : \App\Settings::find(1)->logo }}" class="light-logo" width="25"/>
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <h2 style="margin-top: 14px;color: #dc5324;font-size: 31px;">{{ \App\Settings::find(1)->app_name }}</h2>
              </span>
              <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
              ><i class="ti-menu ti-close"></i
            ></a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5"
          >
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"
                  ><i class="mdi mdi-menu font-24"></i
                ></a>
              </li>
              <!-- ============================================================== -->
              <!-- Search -->
              <!-- ============================================================== -->
              <li class="nav-item search-box">
                <a
                  class="nav-link waves-effect waves-dark"
                  href="javascript:void(0)"
                  ><i class="mdi mdi-magnify fs-4"></i
                ></a>
                <form class="app-search position-absolute">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search &amp; enter"
                  />
                  <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                </form>
              </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
              <ul class="navbar-links">
                <li class="navbar-dropdown d-flex">
                  @if(Auth::user()->user_image == null)
                    <img class="img-wrap aside-profile-image" src="{{ asset('/admin/assets/images/no_image_found.png') }}">
                  @else
                    <img class="img-wrap aside-profile-image" src="{{ asset('/admin/assets/images/user') . '/' . Auth::user()->user_image }}">
                  @endif
                  <a href="#" class="user-name">{{ Auth::user()->name }}</a>
                  <div class="dropdown">
                    @if(Auth::user()->is_admin == 1)
                      <a href="{{ route('settings.index') }}"><i class="fa fa-cog"></i> &nbsp; Settings</a>
                    @endif
                    <a href="{{ route('user.profile', Auth::id()) }}"><i class="fa fa-user"></i> &nbsp; Profile</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> &nbsp; Logout</a>
                  </div>
                </li>
              </ul>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
            @auth
              @if(auth()->user()->is_admin == null || auth()->user()->is_admin == 0)
                <ul id="sidebarnav" class="pt-4">
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link waves-effect waves-dark sidebar-link"
                      href="/dashboard"
                      aria-expanded="false"
                      ><i class="mdi mdi-view-dashboard"></i
                      ><span class="hide-menu" style="padding-left: 10px;">Dashboard</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link waves-effect waves-dark sidebar-link"
                      href="/in-progress-papers"
                      aria-expanded="false"
                      ><i class="far fa-newspaper"></i>
                      <span class="hide-menu" style="padding-left: 10px;">In Progress Papers</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link waves-effect waves-dark sidebar-link"
                      href="/submitted-papers"
                      aria-expanded="false"
                      ><i class="fas fa-check-circle"></i>
                      <span class="hide-menu" style="padding-left: 10px;">Submitted Papers</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link waves-effect waves-dark sidebar-link"
                      href="/games"
                      aria-expanded="false"
                      ><i class="fas fa-gamepad"></i>
                      <span class="hide-menu" style="padding-left: 10px;"> Play Games</span>
                    </a>
                  </li>
                </ul>
              @endif
              @if(auth()->user()->is_admin == 1)
                <ul id="sidebarnav" class="pt-4">
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link waves-effect waves-dark sidebar-link"
                      href="/admin/dashboard"
                      aria-expanded="false"
                      ><i class="mdi mdi-view-dashboard"></i
                      ><span class="hide-menu">Dashboard</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)"
                      aria-expanded="false"
                      ><i class="fas fa-user"></i
                      ><span class="hide-menu"> User </span></a
                    >
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="/admin/user" class="sidebar-link"
                          ><i class="fas fa-eye"></i
                          ><span class="hide-menu"> View Users </span></a
                        >
                      </li>
                      <li class="sidebar-item">
                        <a href="/admin/user/create" class="sidebar-link"><i class="fas fa-user-plus"></i><span class="hide-menu"> Add User </span></a>
                      </li>
                    </ul>
                  </li>

                  <li class="sidebar-item">
                    <a
                      class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)"
                      aria-expanded="false"
                      ><i class="fas fa-users"></i
                      ><span class="hide-menu"> Groups </span></a
                    >
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="/admin/groups" class="sidebar-link"
                          ><i class=" fas fa-pencil-alt"></i
                          ><span class="hide-menu"> Manage Groups </span></a
                        >
                      </li>
                      {{-- <li class="sidebar-item">
                        <a href="/admin/user/create" class="sidebar-link"><i class="fas fa-user-plus"></i><span class="hide-menu"> Add User </span></a>
                      </li> --}}
                    </ul>
                  </li>

                  <li class="sidebar-item">
                    <a
                      class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)"
                      aria-expanded="false"
                      ><i class="fas fa-book"></i
                      ><span class="hide-menu"> Subject </span></a
                    >
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="/admin/subject" class="sidebar-link"
                          ><i class="fas fa-eye"></i
                          ><span class="hide-menu"> View Subjects </span></a
                        >
                      </li>
                      <li class="sidebar-item">
                        <a href="/admin/subject/create" class="sidebar-link"
                          ><i class="fas fa-plus"></i
                          ><span class="hide-menu"> Add Subject </span></a
                        >
                      </li>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)"
                      aria-expanded="false"
                      ><i class="fas fa-newspaper"></i
                      ><span class="hide-menu"> Papers </span></a
                    >
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="/admin/paper" class="sidebar-link"
                          ><i class="fas fa-eye"></i
                          ><span class="hide-menu"> View Papers </span></a
                        >
                      </li>
                      <li class="sidebar-item">
                        <a href="/admin/paper/create" class="sidebar-link"
                          ><i class="fas fa-plus"></i
                          ><span class="hide-menu"> Make a Paper </span></a
                        >
                      </li>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a
                      class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)"
                      aria-expanded="false"
                      ><i class="fas fa-tasks"></i
                      ><span class="hide-menu">Assign Paper </span></a
                    >
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="/admin/assign-paper" class="sidebar-link"
                          ><i class="fas fa-eye"></i
                          ><span class="hide-menu"> View Papers </span></a
                        >
                      </li>
                      <li class="sidebar-item">
                        <a href="/admin/assign-paper/create" class="sidebar-link"
                          ><i class="fas fa-plus"></i
                          ><span class="hide-menu">Create Paper </span></a
                        >
                      </li>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/students-report" aria-expanded="false"><i class="fa fa-file"></i>
                      <span class="hide-menu">Students Report</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/games" aria-expanded="false"><i class="fas fa-gamepad"></i>
                      <span class="hide-menu">&nbsp;Play Games</span>
                    </a>
                  </li>
                </ul>
              @endif
            @endauth
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <input type="hidden" name="base_url" value="{{ url('/') }}">
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        @yield('main-content')
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
          Copyright &copy; {{ date('Y') }} | All rights reserved.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>

      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('/admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('/admin/assets/dist/js/bootstrap-5.min.js') }}" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="{{ asset('/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('/admin/assets/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('/admin/assets/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('/admin/assets/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- <script src="/admin/assets/dist/js/pages/dashboards/dashboard1.js"></script> -->
    <script src="{{ asset('/admin/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('/admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <!-- Toastr -->
    <script type="text/javascript" src="{{ asset('/admin/assets/libs/toastr/toastr.min.js') }}"></script>
    <!-- Tingle Modal Script -->
    <script src="{{ asset('/admin/assets/libs/tingle-modal/tingle.js') }}"></script>
    <script src="{{ asset('/admin/assets/dist/js/highcharts.js') }}"></script>
    <!-- Charts js Files -->
    <script src="{{ asset('/admin/assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/summer-note/summer-note.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/dist/js/pages/chart/chart-page-init.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/sweetalert/all.min.js') }}"></script>
    @yield('scripts')
  </body>
</html>
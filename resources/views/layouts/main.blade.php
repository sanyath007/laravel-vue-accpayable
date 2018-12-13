<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Accounts Payable System</title>

	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
	<!-- Compiled and minified CSS -->
  	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
	<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/> -->
	<link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/daterangepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/fullcalendar/dist/fullcalendar.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/ng-tags-input/ng-tags-input.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/AngularJS-Toaster/toaster.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/angular-xeditable/dist/css/xeditable.css') }}">
	<!-- <link href="{{ asset('/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="{{ asset('/css/theme.css') }}"> -->
	<!-- Ionicons -->
  	<link rel="stylesheet" href="{{ asset('/css/ionicons.min.css') }}">
  	<!-- jvectormap -->
  	<link rel="stylesheet" href="{{ asset('/css/jquery-jvectormap.css') }}">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">
 	<!-- AdminLTE Skins. Choose a skin from the css/skins
       	folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="{{ asset('/css/skins/_all-skins.min.css') }}">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">

	<!-- Fonts -->
	<!-- <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Roboto:400,300' type='text/css'> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.has-error .select2-selection {
		    border-color:#a94442;
		    -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
		    box-shadow:inset 0 1px 1px rgba(0,0,0,.075)
		}
	</style>
	
	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="{{ asset('/bower/angular/angular.min.js') }}"></script>
	<script src="{{ asset('/bower/moment/moment.js') }}"></script>
    <script src="{{ asset('/bower/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('/bower/fullcalendar/dist/locale/th.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
	<script src="{{ asset('/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('/bower/ng-tags-input/ng-tags-input.min.js') }}"></script>
	<script src="{{ asset('/bower/angular-animate/angular-animate.min.js') }}"></script>
	<script src="{{ asset('/bower/AngularJS-Toaster/toaster.min.js') }}"></script>
	<script src="{{ asset('/bower/angular-xeditable/dist/js/xeditable.js') }}"></script>
	<script src="{{ asset('/bower/angular-modal-service/dst/angular-modal-service.min.js') }}"></script>
	<script src="{{ asset('/bower/underscore/underscore-min.js') }}"></script>
	<!-- <script src="{{ asset('/bower/axios/dist/axios.min.js') }}"></script> -->
	<!-- <script src="{{ asset('/js/bootstrap-tagsinput.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-tagsinput-angular.min.js') }}"></script> -->
	<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
	<script src="{{ asset('/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('/js/daterangepicker.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker-custom.js') }}"></script>
	<script src="{{ asset('/js/locales/bootstrap-datepicker.th.js') }}"></script>
	<script src="{{ asset('/js/jquery.knob.min.js') }}"></script>
	<script src="{{ asset('/js/fastclick.js') }}"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-more.js"></script>
	
	<!-- AdminLTE App -->
	<script src="{{ asset('/js/adminlte.min.js') }}"></script>

	<!-- AngularJS Components -->
	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('/js/controllers/mainCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/homeCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/debtCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/creditorCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/debttypeCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/accountCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/reportCtrl.js') }}"></script>
	<!--<script src="{{ asset('/js/directives/highcharts.js') }}"></script>-->
	<script src="{{ asset('/js/services/report.js') }}"></script>
	<script src="{{ asset('/js/services/stringFormat.js') }}"></script>
	<script src="{{ asset('/js/services/pagination.js') }}"></script>

	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!--<script src="{{ asset('/js/services/dashboard.js') }}"></script>-->
	<!-- AdminLTE for demo purposes -->
	<!--<script src="{{ asset('/js/services/demo.js') }}"></script>-->

</head>
<body class="hold-transition skin-blue  sidebar-collapse sidebar-mini" ng-app="app" ng-controller="mainCtrl">
	<div class="wrapper">

		<header class="main-header">

			<!-- Logo -->
			<a href="{{ url('/home') }}" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>A</b>LT</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Admin</b>LTE</span>
			</a>

			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">

				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">

						<!-- Messages: style can be found in dropdown.less-->
						<!-- <li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span class="label label-success">4</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 4 messages</li>
								<li>
									<ul class="menu">
										<li>
											<a href="#">
												<div class="pull-left">
													<img src="{{ asset('/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
												</div>
												<h4>
													Support Team
													<small><i class="fa fa-clock-o"></i> 5 mins</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<img src="{{ asset('/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">
												</div>
												<h4>
													AdminLTE Design Team
													<small><i class="fa fa-clock-o"></i> 2 hours</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<img src="{{ asset('/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
												</div>
												<h4>
													Developers
													<small><i class="fa fa-clock-o"></i> Today</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<img src="{{ asset('/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">
												</div>
												<h4>
													Sales Department
													<small><i class="fa fa-clock-o"></i> Yesterday</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<img src="{{ asset('/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
												</div>
												<h4>
													Reviewers
													<small><i class="fa fa-clock-o"></i> 2 days</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="#">See All Messages</a></li>
							</ul>
						</li> --><!-- End messages menu-->

						<!-- Notifications: style can be found in dropdown.less -->
						<!-- <li class="dropdown notifications-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">10</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 10 notifications</li>
								<li>
									<ul class="menu">
										<li>
											<a href="#">
												<i class="fa fa-users text-aqua"></i> 5 new members joined today
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
												page and may cause design problems
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-users text-red"></i> 5 new members joined
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-shopping-cart text-green"></i> 25 sales made
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-user text-red"></i> You changed your username
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="#">View all</a></li>
							</ul>
						</li> --><!-- End notifications menu -->

						<!-- Tasks: style can be found in dropdown.less -->
						<!-- <li class="dropdown tasks-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-flag-o"></i>
								<span class="label label-danger">9</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 9 tasks</li>
								<li>
									<ul class="menu">
										<li>
											<a href="#">
												<h3>
													Design some buttons
													<small class="pull-right">20%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
													aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">20% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<h3>
													Create a nice theme
													<small class="pull-right">40%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
													aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">40% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<h3>
													Some task I need to do
													<small class="pull-right">60%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
													aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">60% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<h3>
													Make beautiful transitions
													<small class="pull-right">80%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
													aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">80% Complete</span>
													</div>
												</div>
											</a>
										</li>
									</ul>
								</li>
								<li class="footer">
									<a href="#">View all tasks</a>
								</li>
							</ul>
						</li> --><!-- End tasks menu -->

						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">

							@if (Auth::guest())

							@else

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="{{ asset('/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
									<span class="hidden-xs">{{ Auth::user()->person_firstname }} {{ Auth::user()->person_lastname }}</span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

										<p>
											{{ Auth::user()->person_firstname }} {{ Auth::user()->person_lastname }}
											<small>Member since Nov. 2012</small>
										</p>
									</li>
									
									<!-- Menu Body -->
									<!-- <li class="user-body">
										<div class="row">
											<div class="col-xs-4 text-center">
												<a href="#">Followers</a>
											</div>
											<div class="col-xs-4 text-center">
												<a href="#">Sales</a>
											</div>
											<div class="col-xs-4 text-center">
												<a href="#">Friends</a>
											</div>
										</div>
									</li> -->
									
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a 	href="{{ route('logout') }}" 
												onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
												class="btn btn-default btn-flat">
                                    			Sign out
                                			</a>

			                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			                                    {{ csrf_field() }}
			                                </form>
										</div>
									</li>
								</ul>

							@endif

						</li><!-- End user account menu -->

						<!-- Control Sidebar Toggle Button -->
						<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li>
						<!-- Control Sidebar Toggle Button -->

					</ul><!-- /.nav navbar-nav -->
				</div>

			</nav>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="{{ asset('/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>

							@if (!Auth::guest())
 								{{ Auth::user()->person_firstname }} {{ Auth::user()->person_lastname }}
 							@endif

						</p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				<!-- search form -->
				<form action="#" method="get" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
				<!-- /.search form -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATION</li>

					<li class="active">
						<a href="{{ url('/home') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-files-o"></i>
							<span>บันทึกรายการ</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/debt/list') }}"><i class="fa fa-circle-o"></i> รับหนี้</a></li>
							<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> ขออนุมัติเบิก-จ่ายหนี้</a></li>
							<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> ตัดจ่ายหนี้</a></li>
						</ul>
					</li>					
					<li class="treeview">
						<a href="#">
							<i class="fa fa-laptop"></i>
							<span>บัญชี</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/account/ledger/0/0/0') }}"><i class="fa fa-circle-o"></i> ยอดหนี้แยกประเภท</a></li>
							<li><a href="{{ url('/account/arrear') }}"><i class="fa fa-circle-o"></i> ยอดหนี้ค้างจ่าย</a></li>
							<li><a href="{{ url('/account/creditor-paid') }}"><i class="fa fa-circle-o"></i> เจ้าหนี้จ่ายชำระหนี้</a></li>
						</ul>
					</li>
					<!-- <li class="treeview">
						<a href="#">
							<i class="fa fa-edit"></i> <span>Forms</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
							<li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
							<li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
						</ul>
					</li> -->
					<li class="treeview">
						<a href="#">
							<i class="fa fa-pie-chart"></i>
							<span>รายงาน</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="{{ url('/report/debt-creditor/list') }}">
									<i class="fa fa-circle-o"></i> ยอดหนี้รายเจ้าหนี้
								</a>
							</li>
							<li>
								<a href="{{ url('/report/debt-debttype/list') }}">
									<i class="fa fa-circle-o"></i> ยอดหนี้รายประเภทหนี้
								</a>
							</li>
							<li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
							<li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-table"></i> <span>ข้อมูลพื้นฐาน</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="{{ url('/creditor/list') }}"><i class="fa fa-circle-o"></i> เจ้าหนี้</a></li>
							<li><a href="{{ url('/debttype/list') }}"><i class="fa fa-circle-o"></i> ประเภทหนี้</a></li>
						</ul>
					</li>													
				</ul>
			</section><!-- /.sidebar -->

		</aside>

		<!-- Content Wrapper. Contains page content -->
  		<div class="content-wrapper">

				@yield('content')

				<toaster-container></toaster-container>
				
		</div><!-- /.content-wrapper -->

	  	<!-- Footer -->
		@extends('layouts.footer')
		<!-- Footer -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Create the tabs -->
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
				<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div class="tab-pane" id="control-sidebar-home-tab">
					<h3 class="control-sidebar-heading">Recent Activity</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-birthday-cake bg-red"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

									<p>Will be 23 on April 24th</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-user bg-yellow"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

									<p>New phone +1(800)555-1234</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

									<p>nora@example.com</p>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-file-code-o bg-green"></i>

								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

									<p>Execution time 5 seconds</p>
								</div>
							</a>
						</li>
					</ul>
					<!-- /.control-sidebar-menu -->

					<h3 class="control-sidebar-heading">Tasks Progress</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Custom Template Design
									<span class="label label-danger pull-right">70%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Update Resume
									<span class="label label-success pull-right">95%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-success" style="width: 95%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Laravel Integration
									<span class="label label-warning pull-right">50%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<h4 class="control-sidebar-subheading">
									Back End Framework
									<span class="label label-primary pull-right">68%</span>
								</h4>

								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-primary" style="width: 68%"></div>
								</div>
							</a>
						</li>
					</ul>
					<!-- /.control-sidebar-menu -->

				</div>
				<!-- /.tab-pane -->
				<!-- Stats tab content -->
				<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
				<!-- /.tab-pane -->
				<!-- Settings tab content -->
				<div class="tab-pane" id="control-sidebar-settings-tab">
					<form method="post">
						<h3 class="control-sidebar-heading">General Settings</h3>

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Report panel usage
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Some information about this general settings option
							</p>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Allow mail redirect
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Other sets of options are available
							</p>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Expose author name in posts
								<input type="checkbox" class="pull-right" checked>
							</label>

							<p>
								Allow the user to show his name in blog posts
							</p>
						</div>
						<!-- /.form-group -->

						<h3 class="control-sidebar-heading">Chat Settings</h3>

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Show me as online
								<input type="checkbox" class="pull-right" checked>
							</label>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Turn off notifications
								<input type="checkbox" class="pull-right">
							</label>
						</div>
						<!-- /.form-group -->

						<div class="form-group">
							<label class="control-sidebar-subheading">
								Delete chat history
								<a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
							</label>
						</div>
						<!-- /.form-group -->
					</form>
				</div>
				<!-- /.tab-pane -->
			</div>
		</aside><!-- /.control-sidebar -->

		<!-- Add the sidebar's background. This div must be placed
			immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>

	</div>
	<!-- ./wrapper -->
</body>
</html>

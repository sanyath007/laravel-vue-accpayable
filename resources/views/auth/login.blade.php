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

    <!-- Fonts -->
    <!-- <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Roboto:400,300' type='text/css'> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
    <script src="{{ asset('/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('/js/fastclick.js') }}"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/highcharts-more.js"></script>
    
    <!-- AdminLTE App -->
    <script src="{{ asset('/js/adminlte.min.js') }}"></script>

    <!-- AngularJS Components -->
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/controllers/mainCtrl.js') }}"></script>
    <!-- <script src="{{ asset('/js/reserveCtrl.js') }}"></script>
    <script src="{{ asset('/js/assignCtrl.js') }}"></script>
    <script src="{{ asset('/js/maintainedCtrl.js') }}"></script>
    <script src="{{ asset('/js/insuranceCtrl.js') }}"></script>
    <script src="{{ asset('/js/taxCtrl.js') }}"></script>
    <script src="{{ asset('/js/fuelCtrl.js') }}"></script>
    <script src="{{ asset('/js/reportCtrl.js') }}"></script>
    <script src="{{ asset('/js/directives/highcharts.js') }}"></script>
    <script src="{{ asset('/js/services/report.js') }}"></script> -->

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('/js/services/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('/js/services/demo.js') }}"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini" ng-app="app" ng-controller="mainCtrl">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-8 col-md-offset-2" style="padding-top: 80px;">

                    <div class="panel panel-default">
                        <div class="panel-heading">Login</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/signin') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('person_username') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">Username</label>

                                    <div class="col-md-6">
                                        <input id="person_username" type="text" class="form-control" name="person_username" value="{{ old('person_username') }}">

                                        @if ($errors->has('person_username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('person_username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('person_password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="person_password" type="password" class="form-control" name="person_password">

                                        @if ($errors->has('person_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('person_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i> Login
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!--- /.panel -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @extends('layouts.footer')
        <!-- Footer -->

    </div><!-- /.wrapper -->
</body>
</html>
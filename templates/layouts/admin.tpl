<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('page-title') | {{env('APP_TITLE')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/plugins/ionicons/css/ionicons.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/plugins/iCheck/all.css">
    <!-- jquery-confirm -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/plugins/jquery-confirm/jquery-confirm.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url('/')}}/themes/admin/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        // GLOBAL MESSAGES
        var MSG = {
            "YES": "{{ trans('admin::messages.yes') }}",
            "NO": "{{ trans('admin::messages.no') }}",
            "DELETE": "{{ trans('admin::messages.delete') }}",
            "DELETE_CONFIRM" : "{{ trans('admin::messages.delete.confirm') }}"
        };
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{{env('APP_SHORT_TITLE')}}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{env('APP_TITLE')}}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </nav>
    </header>

    @include('admin.layouts.partials._left_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer"></footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{url('/')}}/themes/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url('/')}}/themes/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="{{url('/')}}/themes/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- jquery-confirm 3.0.3 -->
<script src="{{url('/')}}/themes/admin/plugins/jquery-confirm/jquery-confirm.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{url('/')}}/themes/admin/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="{{url('/')}}/themes/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/')}}/themes/admin/dist/js/app.min.js"></script>
<!-- AdminLTE for admin purposes -->
<script src="{{url('/')}}/themes/admin/dist/js/admin.js"></script>
</body>
</html>

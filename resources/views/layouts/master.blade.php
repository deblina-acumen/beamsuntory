<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('assets/img/favicon.ico')}}">

    <title>beamsuntory - All Warehouses</title>
  
	<!-- Bootstrap 4.1-->
	<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-extend.css')}}">	
	
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">

	<!-- SoftPro admin skins -->
	<link rel="stylesheet" href="{{asset('assets/css/skins/_all-skins.css')}}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
@yield('header_styles')
</head>


<body class="hold-transition skin-red sidebar-mini fixed">
<div class="wrapper">

    @include('layouts.header')
	<!-- Left side column. contains the logo and sidebar -->
    <!-- sidebar-->
    @include('layouts.left-menu')
    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  
	@include('layouts.footer')
	<script src="{{asset('assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js')}}"></script>
	
	<!-- fullscreen -->
	<script src="{{asset('assets/assets/vendor_components/screenfull/screenfull.js')}}"></script>
	
	<!-- popper -->
	<script src="{{asset('assets/assets/vendor_components/popper/dist/popper.min.js')}}"></script>
	
	<!-- Bootstrap 4.1-->
	<script src="{{asset('assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	
	<!-- SlimScroll -->
	<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	
	<!-- FastClick -->
	<script src="{{asset('assets/assets/vendor_components/fastclick/lib/fastclick.js')}}"></script>
	<!-- date-range-picker -->
   <script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
   <script src="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  
  <!-- bootstrap datepicker -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  
  <!-- bootstrap color picker -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  
  <!-- bootstrap time picker -->
  <script src="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
  
	<!-- SoftPro admin App -->
	<script src="{{asset('assets/js/template.js')}}"></script>


    @yield('footer_scripts')
	<script>
 $(".slide-left").click(function() {
  event.preventDefault();
  $(".table-responsive").animate(
    {
      scrollLeft: "+=300px"
    },
    "slow"
  );
});

$(".slide-right").click(function() {
  event.preventDefault();
  $(".table-responsive").animate(
    {
      scrollLeft: "-=300px"
    },
    "slow"
  );
});
</script>
</body>
</html>

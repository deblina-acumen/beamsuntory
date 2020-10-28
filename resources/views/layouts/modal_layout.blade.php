<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}">
    <title>Avaada | @if(isset($title)) {{$title}} @endif</title>


	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">


    <link rel="stylesheet" href="{{asset('assets/main/css/custom.css')}}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    @yield('header_styles')
  </head>

<body class="hold-transition skin-purple-light sidebar-mini fixed">


    @yield('content')

 



	<!-- jQuery 3 -->
	<script src="{{asset('assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js')}}"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('assets/assets/vendor_components/jquery-ui/jquery-ui.js')}}"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>

	<!-- popper -->
	<script src="{{asset('assets/assets/vendor_components/popper/dist/popper.min.js')}}"></script>

	<!-- Bootstrap 4.0-->
	<script src="{{asset('assets/assets/vendor_components/bootstrap/dist/js/bootstrap.js')}}"></script>


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

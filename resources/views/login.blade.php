<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('assets/img/favicon.ico')}}">

    <title>beamsuntory - Log in </title>
  
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

</head>
<body class="hold-transition bg-gray-light logoTile">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			
			<div class="col-lg-5 col-md-8 col-12">
				<div class="content-top-agile bg-img" style="background-image:url(assets/img/loginbox.jpg)" data-overlay="4">
					<h2>Login With</h2>
					 
				</div>
				<div class="p-40 mt-10 bg-white content-bottom box-shadowed">
					<form action="{{URL('user-login')}}" method="post" class="login100-form validate-form">
                    @csrf
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text bg-danger border-danger"><i class="ti-user"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Username"  placeholder="Username" name='email'>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text bg-danger border-danger"><i class="ti-lock"></i></span>
								</div>
								<input type="password" class="form-control" placeholder="Password" placeholder="Password" name='password'>
							</div>
						</div>
						  <div class="row">
							
							</div>
							<!-- /.col -->
							
							<!-- /.col -->
							<div class="col-12 text-center">
							  <button type="submit" class="btn btn-danger-outline btn-block mt-10 btn-rounded">SIGN IN</button>
							</div>
							<!-- /.col -->
						  </div>
					</form>	
				
				</div>
			</div>
			
			
		</div>
	</div>


	<!-- jQuery 3 -->
	<script src="{{asset('assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js')}}"></script>
	
	<!-- fullscreen -->
	<script src="{{asset('assets/assets/vendor_components/screenfull/screenfull.js')}}"></script>
	
	<!-- popper -->
	<script src="{{asset('assets/assets/vendor_components/popper/dist/popper.min.js')}}"></script>
	
	<!-- Bootstrap 4.1-->
	<script src="{{asset('assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

</body>
</html>

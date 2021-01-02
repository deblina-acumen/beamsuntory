<!DOCTYPE html>
<html lang="en">
<head>
	<title>Beam suntory</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">

	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-extend.css')}}">	
	
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">

	<!-- SoftPro admin skins -->
	<link rel="stylesheet" href="{{asset('assets/css/skins/_all-skins.css')}}">	

</head>
<body class="hold-transition bg-gray-light logoTile">
	
	<div class="container h-p100">
	@if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
							
							@if (session('danger-msg'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('danger-msg')}}</h6>

                            </div>
                            @endif
		<div class="row align-items-center justify-content-md-center h-p100">
			
			<div class="col-lg-5 col-md-8 col-12">
				<div class="content-top-agile bg-img" style="background-image:url(assets/img/loginbox.jpg)" data-overlay="4">
					<h2>Set New Password</h2>
					 
				</div>
				<div class="p-40 mt-10 bg-white content-bottom box-shadowed">
					<form action="{{route('change-submit-new-set-password')}}" name="form1" method="post" id="add_development_plan" class="login100-form validate-form">
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text bg-danger border-danger"><i class="ti-user"></i></span>
								</div>
								<input type="password" class="form-control" placeholder="New Password" name='pass'>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text bg-danger border-danger"><i class="ti-lock"></i></span>
								</div>
								<input type="password" class="form-control"  placeholder="Confirm Password" name='conpass'>
							</div>
						</div>
						  <div class="row">
							<input type="hidden" name="id" value="{{$id}}">
							<div class="forgot-password">
							<a href="{{URL('/')}}" class="txt1">
								Back To Login
							</a>
						</div>
							</div>
							<!-- /.col -->
							
							<!-- /.col -->
							<div class="col-12 text-center">
							  <button type="submit" class="btn btn-danger-outline btn-block mt-10 btn-rounded">Submit</button>
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
<script>
function allnumericplusminus(inputtxt,conpassval) 
{ 
var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
if(inputtxt.value.match(paswd)) 
{ 
if(inputtxt.value != "" && inputtxt.value == conpassval.value) {
	//alert('Correct, try another...')
//return true;
document.getElementById('add_development_plan').submit();
}
else{
	alert('Wrong confirm password...!')
return false;
}

}
else
{ 
alert('Please Filled correct password...!')
return false;
}
}  
</script>
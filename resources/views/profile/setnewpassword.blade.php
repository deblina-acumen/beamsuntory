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
<body>
	

<div class="limiter">		
        <div class="logo">
		
            <!--<img src="{{asset('assets/assets/img/login/avaada-logo.jpg')}}" alt="">-->
        </div>

        <div class="container-login">
			<div class="wrap-login">
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
				<div class="login100-form-title">
					<span class="login100-form-title-1">
						Change Password
					</span>
                </div>
                <form action="{{route('change-submit-new-set-password')}}" name="form1" method="post" id="add_development_plan" class="login100-form validate-form">
                    @csrf
					
						
						<div class="wrap-input100 validate-input">
						
						<input type="password" class="input100"  placeholder="New Password" name='pass'>
						
						<span class="req-input"></span>
				    	</div>
						
						
						<div class="wrap-input100 validate-input">
						
						<input type="password" class="input100"  placeholder="Confirm Password" name='conpass'>
						
						<span class="req-input"></span>
				    	</div>
						
						
						<input type="hidden" name="id" value="{{$id}}">
						  <div class="row">

							<!-- /.col -->
							<div class="forgot-password">
							<a href="{{URL('/')}}" class="txt1">
								Back To Login
							</a>
						</div>
							<!-- /.col -->
							<div class="container-login100-form-btn">
						<button type="button" onclick="allnumericplusminus(document.form1.pass,document.form1.conpass)" class="login100-form-btn">
							Submit
						</button>
					</div>
							<!-- /.col -->
						  </div>
					</form>
			</div>
		</div>
	</div>	
<!-- /container -->


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
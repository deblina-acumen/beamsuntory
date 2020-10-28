<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/css/pages/login/login.css')}}">

</head>
<body>
	

<div class="limiter">		
        <div class="logo">
		
            <img src="" alt="">
        </div>

        <div class="container-login">
		 
			<div class="wrap-login">
			@if (session('error-msg'))
                            <div class="alert alert-danger alert-dismissible">
                               
                                <h6><i class="icon fa fa-check"></i> {{session('error-msg')}}</h6>

                            </div>
                            @endif
			

				<div class="login100-form-title">
				
					<span class="login100-form-title-1">
						Sign In
					</span>
                </div>
                <form action="{{URL('user-login')}}" method="post" class="login100-form validate-form">
                    @csrf
				 
					<div class="wrap-input100 validate-input">
						<span class="label-input100">Username</span>
						
						<input type="text" class="input100" placeholder="Username" name='email'>
						<span class="req-input"></span>
					</div>

					<div class="wrap-input100 validate-input">
						<span class="label-input100">Password</span>
						
						<input type="password" class="input100" placeholder="Password" name='password'>
						<span class="req-input"></span>
					</div>
				
						<div class="forgot-password">
							<a href="{{URL('forget-password')}}" class="txt1">
								Forgot Password?
							</a>
						</div>		
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
<!-- /container -->


<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</body>
</html>
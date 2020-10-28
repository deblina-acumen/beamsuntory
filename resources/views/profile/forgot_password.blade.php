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
			@if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                              
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
							
							@if (session('danger-msg'))
                            <div class="alert alert-danger alert-dismissible">
                                
                                <h6><i class="icon fa fa-check"></i> {{session('danger-msg')}}</h6>

                            </div>
                            @endif
				<div class="login100-form-title">
					<span class="login100-form-title-1">
						Forgot Password
					</span>
                </div>
               <form action="{{route('forgot-pass-submit')}}" method="post" class="login100-form validate-form">
                    @csrf
				
					<div class="wrap-input100 validate-input">
						
						<input type="email" class="input100" placeholder="Email Address" name='email'>
						
						<span class="req-input"></span>
					</div>
	
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Submit
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
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Facility Management</title>
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
				<div class="login100-form-title">
				@if (session('danger-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('danger-msg')}}</h6>

                            </div>
                            @endif
					<span class="login100-form-title-1">
						Set New Password
					</span>
                </div>
                <form action="{{route('submit-new-set-password')}}" method="post" class="login100-form validate-form">
                    @csrf
				
					<div class="wrap-input100 validate-input">
						
						
						<input type="password"  placeholder="New Password" name='pass' class="input100" >
						<span class="req-input"></span>
					</div>

					<div class="wrap-input100 validate-input">
						
						
						<input type="password" class="input100" placeholder="Confirm Password" name='conpass'>
						<span class="req-input"></span>
					</div>
				
						<div class="forgot-password">
							<a href="{{URL('forget-password')}}" class="txt1">
								Forgot Password?
							</a>
						</div>		
						<input type="hidden" name="encnumber" value="{{$number}}">
						<input type="hidden" name="id" value="{{$id}}">
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
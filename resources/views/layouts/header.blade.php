<header class="main-header">
    <!-- Logo -->
    <a href="{{URL('dashboard')}}" class="logo">
      <!-- mini logo -->
	  <b class="logo-mini">
		  <span class="light-logo"><img src="{{asset('assets/img/logo-mini.png')}}" alt="logo"></span>
		  <span class="dark-logo"><img src="{{asset('assets/img/logo-mini.png')}}" alt="logo"></span>
	  </b>
      <!-- logo-->
      <span class="logo-lg">
		  <img src="{{asset('assets/img/logo-big-dark.png')}}" alt="logo" class="light-logo">
	  	  <img src="{{asset('assets/img/logo-big-light.png')}}" alt="logo" class="dark-logo">
	  </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
	  	
      <!-- Sidebar toggle button-->
		  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		  </a>	
		
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  
		  
		  <!-- full Screen -->
		  @if(Auth::user()->role_id == 1)
	      <li class="full-screen-btn">
			<a href="{{URL('user-list')}}" data-provide="fullscreen" title="Users">
				<i class="mdi mdi-account-multiple-outline"></i>
			</a>
		  </li>	
		  @endif
       <!-- full Screen -->
        <li class="full-screen-btn">
      <a href="#" data-provide="fullscreen" title="Reports">
        <i class="mdi mdi-chart-line"></i>  
      </a>
      </li>  
          <!-- Messages -->
         
		  <!-- User Account-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <!--<img src="{{asset('assets/img/dp.jpg')}}" class="user-image rounded-circle b-2" alt="User Image"> -->
			  
			  <?php if(isset(Auth::user()->profile_pic)&&Auth::user()->profile_pic !=''){ ?>
			<img src="{{asset('public/profile_pic/'.Auth::user()->profile_pic)}}" class="user-image rounded-circle b-2" alt="User Image" >
			<?php } else { ?>
              <img src="{{asset('assets/images/avatar/no_image.jpg')}}" class="user-image rounded-circle b-2" alt="User Image" >
			<?php } ?>
				<span class="font-size-14">{{Auth::user()->name}}<i class="mdi mdi-chevron-down"></i></span>
            </a>
            <ul class="dropdown-menu scale-up">
              <!-- Menu Body -->
              <li class="user-body bt-0">
                <div class="row no-gutters">
                  <div class="col-12 text-left">
                    <a href="{{URL('profile-management/profile/'.base64_encode(Auth::user()->id))}}"><i class="ion ion-person"></i> My Profile</a>
                  </div>
                  
                  
			
				  
				<div role="separator" class="divider col-12"></div>
				  <div class="col-12 text-left">
                    <a href="{{URL('logout')}}"><i class="fa fa-power-off"></i> Logout</a>
                  </div>				
                </div>
                <!-- /.row -->
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>

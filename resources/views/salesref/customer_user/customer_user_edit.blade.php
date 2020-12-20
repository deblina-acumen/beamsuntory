@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">
<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit user
      </h1>
    </section>

    <!-- Main content -->
    <section class="content mob-container">
		
          <!---- List Item ------>
          <div class="box">			
				<div class="box-body p-0">
				<div class="media media-single">
						  <div class="media-body">
						  </div>
 						  <div class="media-right">
							<a class="btn btn-block btn-dark btn-sm" href="{{URL('customer-user-list')}}">Back</a>
						  </div>
						</div>
				<form id="add_development_plan" action="<?= URL('update-customer-user')?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
				@csrf
				@include('salesref/customer_user/customer_user_form')

				</form>
			</div>
      
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')
<!-- jQuery 3 -->
	<script src="assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js"></script>
	
	<!-- fullscreen -->
	<script src="assets/vendor_components/screenfull/screenfull.js"></script>
	
	<!-- popper -->
	<script src="assets/vendor_components/popper/dist/popper.min.js"></script>
	
	<!-- Bootstrap 4.1-->
	<script src="assets/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- SlimScroll -->
	<script src="assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	
	<!-- FastClick -->
	<script src="assets/vendor_components/fastclick/lib/fastclick.js"></script>
	
	<!-- SoftPro admin App -->
	<script src="js/template.js"></script>
	
	<script>

	function get_province(obj)
{
	var country = $(obj).val(); 
	//alert(country);
	
 $.ajax({
		url:'<?php echo URL("get-store-province-by-country-id"); ?>',
		method:"POST",
		dataType: 'json',
		data: {
		"country_id": country,
        "_token": "{{ csrf_token() }}",
        
        },
		success:function(data)
		{
			$('#province_id').html('');
			var html = '<option value="">Select </option>';
			if(data.length > 0)
			{
				for(i =0;i < data.length; i++)
				{
					html = html + '<option value="'+data[i]['id']+'">'+data[i]['name'] +'</option>';
					
				}
			}
			$('#province_id').html(html);
		}
		
	   });
}
</script>

@stop

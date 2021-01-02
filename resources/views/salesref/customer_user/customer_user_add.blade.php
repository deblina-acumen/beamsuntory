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
        Add New User
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
				<form id="add_development_plan" action="<?= URL('submit-customer-user')?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
				@csrf
				@include('salesref/customer_user/customer_user_form')

				</form>
			</div>
      
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')
 <script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
 <!-- date-range-picker -->
  <script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
  <script src="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  
  <!-- bootstrap datepicker -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  
  <!-- bootstrap color picker -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  
  <!-- bootstrap time picker -->
  <script src="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
	
	<script>
	
(function() {
	$('#Attributes').css('display','none');
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

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
<script>
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#dvPreview')
                        .attr('src', e.target.result)
                        .width(110)
                        .height(110);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
		
		function generate_password()
{
 var pass = 'JMB'+<?php echo $rand = rand(100,8588888);?>+'@!#';
 $('#password').val(pass);
}
</script>
@stop

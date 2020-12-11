@extends('layouts.master')
@section('header_styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">

@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Store  &nbsp;<a href="{{URL('store-list')}}" type="button" class="btn btn-dark btn-sm"> Store</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="#">Store</a></li>
        
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
	  <div class="row">
		<div class="col-lg-12 col-12">
			<div class="box box-solid bg-gray">
			
				<div class="box-header with-border">
				  <h4 class="box-title">Edit Store</h4>      
				  <ul class="box-controls pull-right">
					<li><a class="box-btn-fullscreen" href="#"></a></li>
				  </ul>
				</div>
				<!-- /.box-header -->
					  
					<form id="add_development_plan" action="<?= URL('update-store')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('master/store/form')
					</form>
			</div> 
		  </div>
      <!-- /.row -->
	  </div>
    </section>
    <!-- /.content -->
  </div>

@stop
@section('footer_scripts')
<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script>
(function() {
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
</script>
<script>
$('.select2').select2({ width: 'resolve' });
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
			$('#state').html(html);
		}
		
	   });
}
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

</script>
@stop

@extends('layouts.master')
@section('header_styles')
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit User  &nbsp;<a href="{{URL('role-user-list')}}" type="button" class="btn btn-dark btn-sm"> User</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="#">User</a></li>
        
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
	  <div class="row">
		<div class="col-lg-12 col-12">
			<div class="box box-solid bg-gray">
			
				<div class="box-header with-border">
				  <h4 class="box-title">Edit User</h4>      
				  <ul class="box-controls pull-right">
					<li><a class="box-btn-fullscreen" href="#"></a></li>
				  </ul>
				</div>
				<!-- /.box-header -->
					  
					<form id="add_development_plan" action="<?= URL('update-role-user-data')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('master/roleUser/form')
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

<!-- fullscreen -->
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
</script>

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

function generate_password()
{
 var pass = 'JMB'+<?php echo $rand = rand(100,8588888);?>+'@!#';
 $('#password').val(pass);
}

    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                //console.log("Checkbox is checked.");
				$('.store_locator_address_block').css('display','none');
            }
            else if($(this).prop("checked") == false){
                $('.store_locator_address_block').css('display','block');
            }
        });
    });
</script>
<script>
	function get_province(obj)
{
	var country = $(obj).val(); 

 $.ajax({
		url:'<?php echo URL("get-province-by-country-id"); ?>',
		method:"POST",
		dataType: 'json',
		data: {
		"country_id": country,
        "_token": "{{ csrf_token() }}",
        
        },
		success:function(data)
		{
			$('#province_id').html('');
			var html = '<option value="">select </option>';
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
	function get_store_locator_province(obj)
{
	var country = $(obj).val(); 

 $.ajax({
		url:'<?php echo URL("get-province-by-country-id"); ?>',
		method:"POST",
		dataType: 'json',
		data: {
		"country_id": country,
        "_token": "{{ csrf_token() }}",
        
        },
		success:function(data)
		{
			$('#store_locator_province_id').html('');
			var html = '<option value="">select </option>';
			if(data.length > 0)
			{
				for(i =0;i < data.length; i++)
				{
					html = html + '<option value="'+data[i]['id']+'">'+data[i]['name'] +'</option>';
					
				}
			}
			$('#store_locator_province_id').html(html);
		}
		
	   });
}
</script>
@stop

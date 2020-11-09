@extends('layouts.master')
@section('header_styles')
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Delivery Agent  &nbsp;<a href="{{URL('delivery-agent-list')}}" type="button" class="btn btn-dark btn-sm"> Delivery Agent</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="#">Delivery Agent</a></li>
        
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
	  <div class="row">
		<div class="col-lg-12 col-12">
			<div class="box box-solid bg-gray">
			
				<div class="box-header with-border">
				  <h4 class="box-title">Edit Delivery Agent</h4>      
				  <ul class="box-controls pull-right">
					<li><a class="box-btn-fullscreen" href="#"></a></li>
				  </ul>
				</div>
				<!-- /.box-header -->
					  
					<form id="add_development_plan" action="<?= URL('update-delivery-agent-data')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('master/DeliveryAgent/form')
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
$('#add_development_plan').submit(function(e){
	//validate phone
var phone = $('input[name="phone"]').val();
   intRegex =/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
if(phone!='')
{
if((phone.length < 6) || (!intRegex.test(phone)))
{
		$('#phone').removeAttr('style');
   /// $('#phone').parent().css('border-radius','4px');
	$('#phone').attr("style","border-color:#dc3545  !important");
		e.preventDefault()
}
else
{
	$('#phone').removeAttr('style');
}
}


}); 
</script>
@stop

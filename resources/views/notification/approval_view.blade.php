@extends('layouts.master')
@section('header_styles')

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css')}}">

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/iCheck/all.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.css')}}">

<!-- Bootstrap select -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-select/dist/css/bootstrap-select.css')}}">

<!-- Bootstrap tagsinput -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">

<!-- Bootstrap touchspin -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">

<!-- Theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">

<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

<!--alerts CSS -->
<link href="{{asset('assets/assets/vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<style>
	.select2-container--default .select2-selection--multiple .select2-selection__rendered {
		height: 32px !important;
		overflow-y: auto !important;


	}

	.select2 select2-container select2-container--default {
		width: 100% !important;
	}

	.td-heading {
		background-color: #2b679238;
		width: 36%;
	}

	.td-description {
		background-color: #69beef42;
	}

	/* style for data table menu */
	.data-table-tool {
		width: 100%;
		/*border:none;*/
	}



	.user-mangment-data-table .dataTables_filter {
		white-space: nowrap;
		float: none;
	}

	.user-mangment-data-table .dataTables_filter label {
		display: block;
		text-align: right;
	}

	.user-mangment-data-table .dataTables_filter input.form-control {
		display: inline-block;
		width: auto;
		margin-right: 0;
	}

	.menu-dropdown {
		position: relative;
		z-index: 2;
		width: 100px;
	}

	.menu-dropdown .btn {
		background: transparent;
		border: none;
		font-size: 20px;
		padding-left: 0;
	}

	.menu-dropdown button.btn.dropdown-toggle:after {
		display: none;
	}
	td.details-control {
    background: url(http://datatables.net/examples/resources/details_open.png) no-repeat center center;
    cursor: pointer;
}
.modal-content {width: 90% !important;}

	/* style for data table menu */
</style>
@stop
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Approval 
	</h1>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Home</a></li>
		<li class="breadcrumb-item active"><a href="#">Approval</a></li>
		
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<!-- Step wizard -->
	<div class="box box-solid bg-gray">
		<div class="box-header with-border">
			<h3 class="subtitle">Member Details </h3> 
			<ul class="box-controls pull-right">
				<!-- <li><a class="box-btn-close" href="#"></a></li>
              <li><a class="box-btn-slide" href="#"></a></li> -->
				<li><a class="box-btn-fullscreen" href="#"></a></li>
				
					 
			</ul>
		</div>
		<!-- /.box-header -->
		<div class="box-body wizard-content">

			<section class="section_cintent">
				@if (session('error-msg'))
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h6><i class="icon fa fa-ban"></i> {{session('error-msg')}}</h6>

				</div>
				@endif
				@if (session('success-msg'))
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h6><i class="icon fa fa-ban"></i> {{session('success-msg')}}</h6>
				</div>
				@endif
				
				
				<div class="row">
				<div class="col-md-12">
				
				</div>
					<div class="col-md-12">
					<!---- ////// -->
					 <div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <a class="avatar avatar-lg" href="#">
						<img src="{{$profile_pic}}" alt="...">
					  </a>
					  <div class="media-body">
						<p class="font-size-16">
						  <a class="hover-primary" href="#"><strong>{{$name}}</strong></a>
						</p>{{$current_date}}
						 
						<p>{{$description}}</p>
						</div>
					  <div class="media-right">
					  <?php if($active!='Y'){ ?>
					  
				<span class="badge badge-success">Active</span>
			<?php }else{ ?>
				<span class="badge badge-danger">Inactive</span>
			
					  <?php }?>
					  
					  </div>
					  
					</div>					
					
				  </div>
				 
				   <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-striped mb-0">
					  
					  <tbody>
						<tr>
						  <th scope="row"> User ID:</th>
						  <td>{{$userid}}</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row"> Email:</th>
						  <td>{{$email}}</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Phone Number:</th>
						  <td>{{$phone_number}}</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Address:</th>
						  <td>{{$address}}</td>
						   <td></td>
						</tr>
						
						
					  </tbody>
					</table>
				</div>
            </div>
					<!---- /////  --->
					</div>
				
					
					<!-- document section -->
													
				</div>
				

				
				
			</section>
		</div>
		<!-- /.box-body -->
	</div>
		
			<!----- approval section start---------->
			<?php
	$is_approver = is_approver_notification(Auth::user()->id,$memberId); 
	if (count($is_approver)>0) { ?>
	<div class="box box-solid bg-gray">
		<div class="box-header with-border">
			<h3 class="subtitle">Approval Section </h3> 
		</div>
			<div class="box-body wizard-content">
			
			<section class="section_cintent">
				<div class="col-md-12">
							<form action="{{URL('notification/save-member-approval')}}" method="post" class="needs-validation" novalidate enctype="multipart/form-data" autocomplete="off">
								@csrf
								
								<div class="col-md-12">
									<section class="section_cintent">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Date<span class="text-danger">*</span></label>
													<div class="controls">
														<input type="text" readonly name="date" class="form-control pull-right" id="next_action_date" value="<?= date('d/m/Y');?>">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Comment<span class="text-danger">*</span></label>
													<div class="controls">
														<textarea name="comment" class="form-control pull-right" style="margin-top: 0px; margin-bottom: 0px; height: 36px;"></textarea>
													</div>
												</div>
											</div>
											
											<div class="col-md-12 ">
												<div class="form-group ">
													
													<input type="hidden" class="btn btn-primary" name="memberId" value="<?= $memberId  ?>">	
													<input type="hidden" class="btn btn-primary" name="notification_id" value="<?= $facilityId ?>">
													<input type="hidden" class="btn btn-primary" name="facility_id" value="<?= $facilityId ?>">
													<div class="controls" style="text-align: center;margin:12px;">
														<input type="submit" name="approve" value="Approve" class="btn btn-sm btn-success" >
														<input type="submit" name="reject" value="Reject" class="btn btn-sm btn-danger" >
														<!--<input type="submit" name="resend"  value="Request For Change" class="btn btn-sm btn-warning" >-->
													</div>
												</div>

											</div>
										</div>
									</section>
								</div>
							
						</div>
						</section>
						
				</div>
		</div>
		<?php  } ?>
	</form>
			<!----- approval section end ----------->

			
					
					
					
					
					
	
</div> 
	
</section>


@stop

@section('footer_scripts')

<!-- fullscreen -->
<script src="{{asset('assets/assets/vendor_components/screenfull/screenfull.js')}}"></script>
<!-- Bootstrap 4.1-->
<script src="{{asset('assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
<!-- Bootstrap tagsinput -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>
<!-- Bootstrap touchspin -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}">
</script>
<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}">
</script>
<!-- bootstrap color picker -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}">
</script>
<!-- bootstrap time picker -->
<script src="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('assets/assets/vendor_plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('assets/assets/vendor_components/fastclick/lib/fastclick.js')}}"></script>
<!-- SoftPro admin App -->
<script src="{{asset('assets/main/js/template.js')}}"></script>
<!-- SoftPro admin for advanced form element -->
<script src="{{asset('assets/main/js/pages/advanced-form-element.js')}}"></script>
<!-- Form validator JavaScript -->
<script src="{{asset('assets/main/js/pages/validation.js')}}"></script>
<!-- steps  -->
<script src="{{asset('assets/assets/vendor_components/jquery-steps-master/build/jquery.steps.js')}}"></script>
<!-- validate  -->
<script src="{{asset('assets/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}">
</script>
<!-- Sweet-Alert  -->
<script src="{{asset('assets/assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>


<!-- fullscreen -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<script src="{{asset('assets/main/js/pages/widget-blog.js')}}"></script>
<script src="{{asset('assets/main/js/pages/list.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/main/js/pages/data-table.js')}}"></script>
<script src="{{asset('assets/main/js/pages/project-table.js')}}"></script>

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
@stop
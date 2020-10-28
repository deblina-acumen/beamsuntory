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
    /* Dynamic field add and remove */
    .add_more {
        width: 100%;
    }

    .add_more .col-md-6:nth-child(2n+1) {
        float: left;
    }

    .add_more .col-md-6:nth-child(2n) {
        float: right;
    }

    .add_field_button {}

    .remove_field {
        margin-top: 3px;
    }

    .add_delete_section {
        display: table;
        width: 100%;
    }

    .add_delete_section_left,
    .add_delete_section_right {
        display: table-cell;
        vertical-align: middle;
    }

    .add_delete_section_right {
        text-align: right;
    }

    .add_delete_section .btn-danger {
        padding: 2px 12px;
    }


    /*  validation color change */
    .custom-select.is-invalid,
    .form-control.is-invalid,
    .was-validated .custom-select:invalid,
    .was-validated .form-control:invalid {
        border-color: #dc3545 !important;
    }

    .custom-select.is-valid,
    .form-control.is-valid,
    .was-validated .custom-select:valid,
    .was-validated .form-control:valid {
        border-color: #d2d6de !important;
    }

    .was-validated .form-control:valid,
    .form-control.is-valid,
    .was-validated .custom-select:valid,
    .custom-select.is-valid {
        border-color: #d2d6de !important;
    }

    .subtitle {
        display: block;
        margin-top: 0px;
        margin: 0;
    }

    .section_cintent .col-md-6 {
        min-height: 90px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        height: 32px !important;
        overflow-y: auto !important;

    }

    .input_fields_wrap .dynamo-block:nth-child(2n+1) {
        background-color: #f1f1f1;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap .dynamo-block:nth-child(2n) {
        background-color: #fbfbfb;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_1 .dynamo-block:nth-child(2n+1) {
        background-color: #f1f1f1;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_1 .dynamo-block:nth-child(2n) {
        background-color: #fbfbfb;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_2 .dynamo-block:nth-child(2n+1) {
        background-color: #f1f1f1;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_2 .dynamo-block:nth-child(2n) {
        background-color: #fbfbfb;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_3 .dynamo-block:nth-child(2n+1) {
        background-color: #f1f1f1;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_3 .dynamo-block:nth-child(2n) {
        background-color: #fbfbfb;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_4 .dynamo-block:nth-child(2n+1) {
        background-color: #f1f1f1;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }

    .input_fields_wrap_4 .dynamo-block:nth-child(2n) {
        background-color: #fbfbfb;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
    }
			.image-upload>input {
  display: none;
}
</style>

@stop
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile Management
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Home</a></li>
        <li class="breadcrumb-item active">My Profile</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Step wizard -->
    <div class="box box-solid bg-gray">
        <div class="box-header with-border">
            <h3 class="subtitle">Profile </h3>
        </div>
	
        <!-- /.box-header -->
        <div class="box-body wizard-content">
			@if (session('success-msg'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>
</div>
@endif
@if (session('error-msg'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>
</div>
@endif
            <!-- Step 1 -->
            <form id="add_development_plan" action="<?= URL('profile-management/profile-update') ?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data" autocomplete="off">
                @csrf
                <section class="section_cintent">
                   
                    <div class="row">

                        <div class="col-md-4">
                            <div class="image-upload" >
								  <label for="file-input">
									<img src="{{$profile_pic}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
								  </label>

								  <input id="file-input" type="file" name="profile_pic" onchange="readURL(this);"/>
								</div>
                        </div>
						
				


						
						

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <div class="controls">
                                            <div class="add_delete_section">
                                                <div class="add_delete_section_left">
                                                    <input type="text" name="info[name]" id="name" class="form-control" value="{{isset($info[0]->name)?$info[0]->name:''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							 <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <div class="controls">
                                            <div class="add_delete_section">
                                                <div class="add_delete_section_left">
                                                    <input type="text" name="info[lastname]" id="name" class="form-control" value="{{isset($info[0]->lastname)?$info[0]->lastname:''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
							

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="controls">
                                            <div class="add_delete_section">
                                                <div class="add_delete_section_left">
                                                    <input type="text" name="info[email]" id="email" class="form-control" value="{{isset($info[0]->email)?$info[0]->email:''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <div class="controls">
                                            <div class="add_delete_section">
                                                <div class="add_delete_section_left">
                                                    <input type="text" name="info[userId]"  id="email" class="form-control" value="{{isset($info[0]->useId)?$info[0]->useId:''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           
							 
							
							
                        </div>

                    </div>

                    <div class="gap-items gap-y">
                        <div class="bg-secondary p-10">
                            <h3 class="subtitle" style="color: #f5f0f0;">Update Password</h3>
                        </div>
                    </div></br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="controls">
                                    <div class="add_delete_section">
                                        <div class="add_delete_section_left">
                                            <input type="password" name="password" id="password" class="form-control" value="" onkeyup="check_password()" >
                                           <div id="error1" style="color:red"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Re-enter Password</label>
                                <div class="controls">
                                    <div class="add_delete_section">
                                        <div class="add_delete_section_left">
                                            <input type="password" name="password" id="confirm_password" class="form-control" value="" onkeyup="re_check_password()" >
											<div id="error" style="color:red"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="">
                    <div class="text-center">
                        <input type="hidden" name="id" id="id" value="{{isset($info[0]->id)?$info[0]->id:''}}">
                        <button type="button" id="submit_development_plan" class="btn btn-info" onclick="check_data()">Update</button>
                    </div>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
</section>
</div>
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

<!-- CK Editor -->
<script src="{{asset('assets/assets/vendor_components/ckeditor/ckeditor.js')}}"></script>

<!-- SoftPro admin for editor -->
<script src="{{asset('assets/main/js/pages/editor.js')}}"></script>

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

    function check_password()
	{
		$('#error1').text(" ");
		$('#password').attr('required','false');
		$('#password').css('border-color','#d2d6de');
		$('#submit_development_plan').prop("disabled",false);
		$('#confirm_password').val('');
	}

    // checking passwords are same or not
    function re_check_password()
    {
		$('#error').text(" ");
		$('#confirm_password').attr('required','false');
		$('#confirm_password').css('border-color','#d2d6de');
		
		$('#submit_development_plan').prop("disabled",false);
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
		if(password != '' && confirm_password != '')
		{
			if(password != confirm_password)
			{
				$('#confirm_password').attr('required','true');
	            $('#confirm_password').css('border-color','#c51e2e');
				$('#error').text("Both the passwords must be same");
				$('#submit_development_plan').prop("disabled",true);
				return false;
			}
			else
			{
				$('#error').text(" ");
				$('#confirm_password').attr('required','false');
	            $('#confirm_password').css('border-color','#d2d6de');
				
				$('#submit_development_plan').prop("disabled",false);
				return true;
			} 
		}
    }

    // on clicking submit button it checks password is same or not
    $('#submit_development_plan').click(function(){
       var password = $('#password').val();
	   var con_pass = $('#confirm_password').val();
	   if(password!='' && con_pass!='')
	   {
		   document.getElementById('add_development_plan').submit();
	   }
	   else{
		   if(password!='' && con_pass =='')
	   {
		  $('#confirm_password').attr('required','true');
	            $('#confirm_password').css('border-color','#c51e2e');
				$('#error').text("Please Insert Confirm Password");
				$('#submit_development_plan').prop("disabled",true);
	   }
	    if(password =='' && con_pass !='')
	   {
		  $('#password').attr('required','true');
	            $('#password').css('border-color','#c51e2e');
				$('#error1').text("Please Insert Password");
				$('#submit_development_plan').prop("disabled",true);
	   }
	    if(password =='' && con_pass =='')
	   {
		  document.getElementById('add_development_plan').submit(); 
	   }
		   
	   }
    });
	
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
		
		function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#dvPreview2')
                        .attr('src', e.target.result)
                        .width(110)
                        .height(110);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
 
</script>
@stop
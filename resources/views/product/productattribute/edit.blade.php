@extends('layouts.master')
@section('header_styles')
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
  <link rel="stylesheet" href=" {{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">
 
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">  
   
   <link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css')}}">
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product-Attribute   &nbsp;<a href="{{URL('Produt-attribute-list')}}" type="button" class="btn btn-dark btn-sm"> Product-Attribute </a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="#">Product-Category </a></li>
        
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
	  <div class="row">
		<div class="col-lg-12 col-12">
			<div class="box box-solid bg-gray">
			
				<div class="box-header with-border">
				  <h4 class="box-title">Edit Product-Attribute </h4>      
				  <ul class="box-controls pull-right">
					<li><a class="box-btn-fullscreen" href="#"></a></li>
				  </ul>
				</div>
				<!-- /.box-header -->
					  
					<form id="add_development_plan" action="<?= URL('update-Produt-attribute-value')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('product/productattribute/form')
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
<!-- Bootstrap Select -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
  
  <!-- Bootstrap tagsinput -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>
  
  <!-- Bootstrap touchspin -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
  
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
  <script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  
  <!-- bootstrap color picker -->
  <script src=" {{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
 
  <!-- bootstrap time picker -->
  <script src="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
  
 
  
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('assets/assets/vendor_plugins/iCheck/icheck.min.js')}}"></script>
  

  

  
  <!-- SoftPro admin for advanced form element -->
  <script src="{{asset('assets/js/pages/advanced-form-element.js')}}"></script>
	
    <!-- Bootstrap WYSIHTML5 -->
  <script src="{{asset('assets/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js')}}"></script>
  
  
  
<script>
$(document).ready(function() {
	var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button1"); //Add button ID
    var option_value = '<?php //echo $option_string; ?>';
    var x = 1; //initlal text box count
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; 
			
			     $(wrapper).append('<div class="row" id="div_'+x+'"><div class="col-md-12"><div class="form-group"><label> Values</label><input type="text" class="form-control" placeholder="Attribute values" name="attr_val[]"></div><div class="pull-right"><button type="button" class="btn btn-danger btn-sm" onclick="remove_div(\'div_'+x+'\')">Remove</button></div></div></div>');//add input box
			
          
        }

    });
	});
	
	function remove_div(div)
	{
		$('#'+div).remove();
	}
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

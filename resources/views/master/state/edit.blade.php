@extends('layouts.master')
@section('header_styles')

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- daterange picker -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css')}}">

<!-- bootstrap datepicker -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/iCheck/all.css')}}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.css')}}">

<!-- Bootstrap select -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-select/dist/css/bootstrap-select.css')}}">

<!-- Bootstrap tagsinput -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">

<!-- Bootstrap touchspin -->
<link rel="stylesheet"
    href="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">

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

.add_field_button {

}

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
.section_cintent .col-md-6{
min-height:90px;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered{
    height: 32px !important;
    overflow-y: auto !important;

}
.input_fields_wrap .dynamo-block:nth-child(2n+1){
    background-color:#f1f1f1;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap .dynamo-block:nth-child(2n){
    background-color:#fbfbfb;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_1 .dynamo-block:nth-child(2n+1){
    background-color:#f1f1f1;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_1 .dynamo-block:nth-child(2n){
    background-color:#fbfbfb;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_2 .dynamo-block:nth-child(2n+1){
    background-color:#f1f1f1;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_2 .dynamo-block:nth-child(2n){
    background-color:#fbfbfb;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_3 .dynamo-block:nth-child(2n+1){
    background-color:#f1f1f1;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_3 .dynamo-block:nth-child(2n){
    background-color:#fbfbfb;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_4 .dynamo-block:nth-child(2n+1){
    background-color:#f1f1f1;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
.input_fields_wrap_4 .dynamo-block:nth-child(2n){
    background-color:#fbfbfb;
    display:inline-block;width:100%;
    margin-bottom:10px;
    margin-bottom:10px;
    padding-top:20px;
}
</style>
@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit State  &nbsp;<button type="button" class="btn btn-dark btn-sm">States</button>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">State</a></li>
        <li class="breadcrumb-item active">Edit State</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		
	  <div class="row">

    <div class="col-lg-9 col-12">
        <div class="box box-solid bg-gray">
        <div class="box-header with-border">
          <h4 class="box-title">State Details</h4>      
          <ul class="box-controls pull-right">
            <li><a class="box-btn-fullscreen" href="#"></a></li>
          </ul>
        </div>
        <!-- /.box-header -->
      
		@if (session('error-msg'))
			  <div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h6><i class="icon fa fa-ban"></i> {{session('error-msg')}}</h6>
				
			  </div>
			  @endif
            <form id="add_development_plan" action="{{URL('update-state')}}"
                method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                <!-- Step 1 -->
                @csrf
                @include('master/state/form')


            </form>

         </div> 





      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
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
//Date picker
$('#meeting_datepicker').datepicker({
    autoclose: true
});
$('#tentative_datepicker').datepicker({
    autoclose: true
});
$('#endorsement_datepicker').datepicker({
    autoclose: true
});
$('#relinquishment_datepicker').datepicker({
    autoclose: true
});
$('#work_order_datepicker').datepicker({
    autoclose: true
});
$('#approved_datepicker1').datepicker({
    autoclose: true
});




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

$('#add_development_plan').submit(function(e){
	//validate phone
var phone = $('input[name="phone"]').val(),
    intRegex = /[0-9 -()+]+$/;
if(phone!='')
{
if((phone.length < 6) || (!intRegex.test(phone)))
{
	
    $('#phone').parent().css('border-radius','4px');
	$('#phone').parent().css('border','.4px solid #dc3545');
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

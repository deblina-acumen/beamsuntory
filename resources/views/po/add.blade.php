@extends('layouts.master')
@section('header_styles')
 <!-- Bootstrap select -->
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-select/dist/css/bootstrap-select.css')}}">
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">
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
 <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">  
@stop
@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New PO  &nbsp;<a type="button" href="{{URL('purchase-order-list')}}" class="btn btn-dark btn-sm">All PO</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
       
        <li class="breadcrumb-item active"> PO</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">	
	  <div class="row">
    <div class="col-lg-12 col-12">
        <div class="box box-solid bg-gray">
        <div class="box-header with-border">
          <h4 class="box-title">Add PO </h4>      
          <ul class="box-controls pull-right">
            <li><a class="box-btn-fullscreen" href="#"></a></li>
          </ul>
        </div>
					<form id="add_development_plan" action="<?= URL('save-po-steop1')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('po/form')
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

</script>
<script>

$('#datepicker').daterangepicker({
singleDatePicker: true,
autoUpdateInput: true,
defaultDate: new Date(),

});
 $('#datetimepicker3').daterangepicker({
	 singleDatePicker: true,
        timePicker: true,
        
        locale: {
            format: 'hh:mm A'
        }
    }, function (start, end, label) { //callback
        start_time = start.format('hh:mm A');
        end_time = end.format('hh:mm A');
        console.log(start_time, end_time);
    }).on('show.daterangepicker', function (ev, picker) {
        picker.container.find(".calendar-table").hide(); //Hide calendar
 });
/* //$( "#datepicker" ).datepicker();
 $("#datetimepicker3" ).daterangepicker({
      timePicker: true,
	 startDate: "07/01/2015",
    endDate: "07/15/2015",
  }, function (start_date) {
    $('#datetimepicker3').val(start_date.format('H:i:s'));
}); */
 $('#datetimepicker3').timepicker({
    showInputs: false
  });
  <?php 
  $option ='<option value="">Select</option>';
  foreach($product as $products){
				$option .='<option value="'. $products->id.'"  >'.$products->name.'</option>';
  }
  ?>
  function add_item(obj)
  {
	  var item_html ='<div class="row"><div class="col-md-4"><label>Item Type</label><div class="input-group"><select name="itemtype[]" aria-controls="project-table" class="form-control form-control-sm" required onchange="get_item(this)"><option value="">Select</option><option value="simple_product">Simple Product</option><option value="variable_product">Variable Product</option></select></div></div><div class="col-md-4"><label>Select Item</label><div class="input-group"><select name="item[]" required aria-controls="project-table" class="form-control form-control-sm" ><?=$option?></select></div></div> <div class="col-md-2"><div class="form-group"><label>Select Qty</label><input type="text" value="" name="quantity[]"  class="form-control form-control-sm"data-bts-button-up-class="btn btn-secondary" required> </div></div><div class="col-md-2"> <div class="pull-right"><label>Action</label><div class="input-group"><button type="button" class="btn btn-danger btn-sm mb-5" onclick="remove_item(this)"><i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp;Remove</button></div></div></div> </div>';
	  $('#new_item').append(item_html);
  }
  function remove_item(obj)
  {
	  $(obj).parent().parent().parent().prev().prev().parent().remove();
  }
  function get_item(obj)
  {
	  $(obj).parent().parent().next().children().children().html('<option value="">Select</option>');
	  var type = $(obj).val();
	  $.ajax({
            url: '<?php echo URL("get-item-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "type": type,
				 "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                
               $(obj).parent().parent().next().children().children().html(data);
               
            }

        });
  }
</script>
@stop

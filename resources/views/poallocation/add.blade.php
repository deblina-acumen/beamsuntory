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
  

  
  <!-- Bootstrap tagsinput -->
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
  
  <!-- Bootstrap touchspin -->
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">
  

    <link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css')}}">
 <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">  
@stop
@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New PO  &nbsp;<a type="button" href="{{URL('po-list')}}" class="btn btn-dark btn-sm">All PO</a>
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
          <h4 class="box-title">{{$poinfo[0]->order_no}} </h4>      
          <ul class="box-controls pull-right">
            <li><a class="box-btn-fullscreen" href="#"></a></li>
          </ul>
        </div>
					
						<!-- Step 1 -->
						
						@include('poallocation/form')
					
			</div> 
		  </div>
      <!-- /.row -->
	  </div>
    </section>
    <!-- /.content -->
  </div>
                 <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Allocate Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
            
			  </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
@stop

@section('footer_scripts')

 <script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
 <!-- date-range-picker -->
  <script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
 
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('assets/assets/vendor_plugins/iCheck/icheck.min.js')}}"></script>
  
  <!-- SoftPro admin for advanced form element -->
  <script src="{{asset('assets/js/pages/advanced-form-element.js')}}"></script>
  
  <!-- Bootstrap Select -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
  
  
  <!-- Bootstrap tagsinput -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>
  
  <!-- Bootstrap touchspin -->
  <script src="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
  
  
  
  
  
  <!-- InputMask -->
  <script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

  <script src="{{asset('assets/assets/vendor_components/datatable/datatables.js')}}"></script>
<script src="{{asset('assets/js/pages/project-table.js')}}"></script>

		<!-- This is data table -->
    <script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
	
	<!-- SoftPro admin for Data Table -->
	
	<script src="{{asset('assets/js/pages/data-table.js')}}"></script>
  
    <!-- Bootstrap WYSIHTML5 -->
  <script src="{{asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js')}}"></script>

 <?php

 $htmloption = '<option value="">Select</option>';
       foreach($userRole as $userRole){
          $htmloption .= '<option value="'.$userRole->id.'">'.$userRole->name.'</option>';
           }

 ?>

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
  
  function open_modal(obj,varienceId,itemId,poDetailsId,po_id)
    {
      /*alert(varienceId);
		alert(itemId);
		alert(poDetailsId);
		alert(po_id); */
        $('.modal-body').empty();
       // $(obj).attr('data-target','#modal-'+id);
      //  $("#myModal").modal("show");
        
        $.ajax({
            url: '<?php echo URL("get-allocation-window"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
				"itemId":itemId,
				"poDetailsId":poDetailsId,
				"po_id":po_id,
                "varienceId": varienceId,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
                console.log(data);
                $('.modal-body').append(data);
                $("#myModal").modal("show");

               
            }

        });
	
    }
	
	function get_role2(obj,incid,pid)
	{
		//console.log($(obj).val()) ;
		if($(obj).val() == 11)
		{
			$("#hide_locker_"+incid+'_'+pid).show() ;
		}
		else{
			$("#hide_locker_"+incid+'_'+pid).hide() ;
		}
		
		$.ajax({
            url: '<?php echo URL("get-role2"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
				"value":$(obj).val(),
				"incid":incid,
				"pod_id":pid,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
                 console.log(data);
				
				/* $("#role2_"+incid+'_'+pid).html('');
				 var newData = JSON.parse(data) ;
				console.log(JSON.parse(data).length); 
			var html = '<option value="">select </option>';
			if(newData.length > 0)
			{
				
				for(i =0;i < newData.length; i++)
				{
					var provinveId = newData[i]['province_id'] ;
					var brandId = newData[i]['brand_id'] ;
					console.log(provinveId);
					console.log(brandId);
					if(provinveId != null)
					{
					var provincename = '<?php echo ger_province_name('+provinveId+'); ?>'
					}
					else
					{
						var provincename = '';
					}
					if(brandId != null)
					{
						var brandname =  '<?php echo get_brand_name('+brandId+'); ?>'
					}
					else{
						var brandname = '' ;
					}
					
					console.log(provincename);
					console.log(brandname);
					html = html + '<option value="'+newData[i]['id']+'">'+newData[i]['name'] +'</option>';
					
				}
			}
			console.log(html); */
			$("#role2_"+incid+'_'+pid).html(data); 
				
				
				
               
            }

        });
		
	}
	
	function get_role3(obj,incid,pid)
	{
		$.ajax({
            url: '<?php echo URL("get-role3"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
				"value":$(obj).val(),
				"incid":incid,
				"pod_id":pid,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
                 console.log(data);
				
			$("#role3_"+incid+'_'+pid).html(data); 
				
				
				
               
            }

        });
	}
	 var count = 1;
	function addmorerow(pid)
	{
		//alert(pid);
		var max_fields_1 = 10; //maximum input boxes allowed
        var wrapper_1 = $(".input_fields_wrap_1"); //Fields wrapper
        //var add_button_1 = $("#add_field_button_1_"+pid); //Add button ID
        var option_value_1 = '';
        //initlal text box count
        var extct = 0;
         //on add input button click
           // e.preventDefault();
            if (count < max_fields_1) { //max input box allowed
                count++; //text box increment
                console.log(count);
                $(wrapper_1).append('<div class="row add_1_' + count + '"><div class="col-md-3 add_1_' + count + '"><div class="input-group"><select  aria-controls="project-table" name="userrole1_'+count+'" id="role_'+count+'_'+pid+'" onchange=get_role2(this,'+count + ','+pid+') class="form-control form-control-sm">'+'<?=$htmloption?>'+'</select></div></div><div class="col-md-3 add_1_' + count + '"><div class="input-group"><select name="userrole2_'+count+'" id="role2_'+count+'_'+pid+'" onchange=get_role3(this,'+count + ','+pid+') class="form-control select2" multiple="multiple" aria-controls="project-table" class="form-control form-control-sm" ></select></div></div><div class="col-md-3 add_1_' + count + '"><div class="input-group"><select name="userrole3_'+count+'"  id="role3_'+count+'_'+pid+'" class="form-control select2" multiple="multiple" aria-controls="project-table" class="form-control form-control-sm"></select></div><div class="input-group" style="margin-top: 20px;"><div class="checkbox checkbox-success" id="hide_locker_0_'+count+'_'+pid+'"><input id="checkbox3_'+count+'_'+pid+'" name="storelocator_'+count+'" type="checkbox"><label for="checkbox3_'+count+'_'+pid+'"> Locker </label></div><div class="checkbox checkbox-success" style="margin-left: 30px;"><input id="checkbox4_'+count+'_'+pid+'" type="checkbox" name="eachselectbox_'+count+'"><label for="checkbox4_'+count+'_'+pid+'"> Each </label></div></div></div><div class="col-md-2 add_1_' + count + '"><div class="form-group"><input type="number"  onblur="calculate_amount()" name="quantity_'+count+'" id="quantity_'+count+'_'+pid+'"  class="form-control quantity" placeholder="100"></div></div><div class="col-md-1 add_1_' + count + '"><div class="pull-right"><div class="input-group"><button type="button" onClick="remove_field_1('+count+')" class="btn btn-dark btn-sm mb-5"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div></div></div></div>');
              
            }

     
	}
	
	function remove_field_1(remove_class) {
		console.log(remove_class);
       new_remove_class = 'add_1_' + remove_class;
	   console.log(new_remove_class);
       $("." + new_remove_class).remove();
   }
   
   function calculate_amount()
{
	var total_qty = $(".total_quantity").val() ;
var sum = 0 ;
	$(".quantity").each(function( index ) {
		
	
		 sum += Number($(this).val());
 // alert( "test:"+index + ": " + $(this).attr('area'));
 
});
	// alert(sum);
	 if(sum>total_qty)
	 {
		 $('.submit_btn').prop('disabled',true);
		 alert('allocation quantity overflow');
	 }
	 else{
		 $('.submit_btn').prop('disabled',false);
}
	 
	
	
}
 
</script>
@stop

@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Verify Packaging Boxes for ::<?= isset($po_details[0]->name)?$po_details[0]->name.'[#SKU:'.$po_details[0]->item_sku.']':''?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content mob-container">
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
          <!---- List Item ------>
		  <form id="add_development_plan" action="<?= URL('accept-box-details')?>" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			@csrf
          <div class="box">					
			<div class="box-body p-0">
			<div class="media-list media-list-hover media-list-divided">
            
			<?php $packing_count = count($packing_info)?>
			@if(isset($packing_info ) && count($packing_info)>0)
				@foreach($packing_info as $k=>$packingInfo)
            <div class="media media-single">
			
              <div class="media-body" <?php if($k+1==$packing_count){ ?> id="box_info" <?php } ?>>
				  
              <ul class="flexbox flex-justified my-10">
			  <li>
			  <div class="form-group">
					<label>Box Type</label>
					<select class="form-control" name="box_type[]" disabled>
					<option value="">Select</option>
					<?php foreach($BoxType as $boxType){ ?>
					<option value="{{$boxType->id}}" <?php if(isset($packingInfo->box_type) && $packingInfo->box_type==$boxType->id){echo"selected";} ?>>{{$boxType->type}}</option>
					<?php } ?>
					</select>
				  </div>
			  </li>
                  <li>
                    <div class="form-group">
                    <label ># Boxes</label>
                    <input type="text" class="form-control" name="box[]" value="<?= isset($packingInfo->box_recceived_by_wh)&& $packingInfo->box_recceived_by_wh>0?$packingInfo->box_recceived_by_wh:$packingInfo->box?>">
                  </div>
                  </li>
                  
                  <!--<li>
                    <div class="form-group">
                    <label >Qty per SKID</label>
                    <input type="text" class="form-control">
                  </div>
                  </li>-->
                </ul>
                <!--<ul class="flexbox flex-justified my-10">
                  <li>
                  <div class="checkbox checkbox-success">
                  <input id="checkbox1" type="checkbox">
                  <label for="checkbox1"> Half SKID </label>
                  </div>
                  </li>
                  <li>
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2" type="checkbox">
                  <label for="checkbox2"> Full SKID </label>
                  </div>
                  </li>
                </ul>-->
              </div>
			  
            </div>
			<input type="hidden" name="box_packing_id[]"  value="<?= isset($packingInfo->id)?$packingInfo->id:''?>">
			@endforeach
			@endif
            </div>
			</div>
			</div>
			<div style="text-align:center"><button type="submit" class="btn btn-success btn-lg mt-1" >Accept Goods</button>
			</div>
			<input type="hidden" name="po_item_id" value="<?=$po_details[0]->po_item_id?>">
			<input type="hidden" name="item_sku" value="<?=$po_details[0]->item_sku?>">
			<input type="hidden" name="po_id" value="<?=$po_details[0]->po_id?>">
			
		   </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  


@stop

@section('footer_scripts')
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/js/pages/data-table.js')}}"></script>
<!-- SoftP-->
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
var html_option ='<option value="">Select</option>';
<?php foreach($BoxType as $boxType){ ?>
 html_option +="<option value='<?=$boxType->id?>'><?=$boxType->type?></option>";
<?php } ?>
function add_box_info()
{
	$html='<div class="media-body" id="box_info"><hr><br/><div class="form-group"><label>Box Type</label><select class="form-control" name="box_type[]">'+html_option+'</select></div><ul class="flexbox flex-justified my-10"><li><div class="form-group"><label ># Boxes</label><input type="text" class="form-control" name="box[]"></div></li><li><div class="form-group"><label >Qty per Box</label><input type="text" class="form-control" name="qtn_per_box[]"><input type="hidden" name="box_packing_id[]"  value=""> </div></li><!--<li> <div class="form-group">  <label >Qty per SKID</label><input type="text" class="form-control"></div></li>--></ul><!--<ul class="flexbox flex-justified my-10"> <li><div class="checkbox checkbox-success"><input id="checkbox1" type="checkbox"> <label for="checkbox1"> Half SKID </label></div></li><li><div class="checkbox checkbox-success"><input id="checkbox2" type="checkbox"><label for="checkbox2"> Full SKID </label></div></li></ul>--><div style="text-align:center"><a href="javascript::void(0)" class="btn btn-danger btn-lg mt-10" onclick="remove_pcking_info(this)">Remove</a></div></div>';
	$('#box_info').append($html);
}
function remove_pcking_info(obj)
{
	$(obj).parent().parent().remove();
}
</script>
@stop

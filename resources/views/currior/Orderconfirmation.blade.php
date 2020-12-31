@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Stock Received
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
          <div class="box">
		  <div class="box-header no-border bg-dark">
             <h6 class="pull-left">Stock receive</h6>
             
            </div>	
             	<form id="add_development_plan" action="<?= URL('save-packing-info')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
				@csrf						
				<div class="box-body p-0">
					<div class="media-list media-list-hover media-list-divided">
					<?php $total_quantity=0; ?>
					@foreach($po_details as $poDetails)
					<?php 
						$allocation_qtn = get_po_allocation_quantity($poDetails->id,$poDetails->item_sku);
						$po_qtn = $poDetails->quantity;
						$total_quantity = $total_quantity+$allocation_qtn;
					?>
					
					 <div class="media media-single">
              <div class="media-body">
              <div class="pull-left"><img src="{{URL('public/product/'.$poDetails->image)}}" class="rounded-circle m-td-pic"></div>
              <h6><?= $poDetails->name?></h6>
              <small>SKU : <?=$poDetails->item_sku?></small>
			  
              <p>Qty. Ordered: <span class="text-bold"><?=$allocation_qtn?></span></p>
                <ul class="flexbox flex-justified my-10">
                  <li>
                    <div class="form-group">
                    <label >Qty. Recieved</label>
                    <input name="quantity[]" type="number"  class="form-control form-control-sm" min="1" placeholder="Quantity" aria-controls="project-table" required value="<?= isset($poDetails->quantity_received) && $poDetails->quantity_received>0?$poDetails->quantity_received:''?>">
								<input type="hidden" name="item_sku[]" value="<?=$poDetails->item_sku?>" >
								<input type="hidden" name="po_item_id[]" value="<?=$poDetails->po_item_id?>" >
								<input type="hidden" name="item_id[]" value="<?=$poDetails->item_id?>" >
								<input type="hidden" name="item_orderd[]" value="<?=$allocation_qtn?>" >
								<input type="hidden" name="po_qtn[]" value="<?=$po_qtn?>" >
                  </div>
                  </li>
                  <li>
                    <div class="form-group">
                    <label >Shelf Life</label>
                    <input name="self_life[]" type="number"  class="form-control form-control-sm" min="1" placeholder="Self Life" aria-controls="project-table" value="<?=$poDetails->self_life?>" required>
                  </div>
                  </li>
                </ul>
                <ul class="flexbox flex-justified my-5">
                  <li>
                    <div class="form-group">
                    <label >Retail Price</label>
                    <input name="retail_price[]" type="number" min="1" class="form-control form-control-sm" placeholder="Retail price" aria-controls="project-table" value="<?=$poDetails->retail_price?>" required>
								
                  </div>
                  </li>
                  <li>
                    <div class="form-group">
                    <label >Regular Price</label>
                    <input name="regular_price[]" type="number" min="1" class="form-control form-control-sm" placeholder="Regular price" aria-controls="project-table" value="<?=$poDetails->regular_price?>" required>
                  </div>
                  </li>
                </ul>
                </div>
            </div>
				<div style="text-align:center"><a href="{{URL('packing-box-info/'.base64_encode($poDetails->po_item_id))}}" class="btn btn-success btn-lg mt-10">packaging Information</a></div>
					@endforeach
            <input type="hidden" name="prev_total_count" value="<?=$total_quantity?>" >
			<input type="hidden" name="po_id" value="<?= isset($po_details[0]->id)?$po_details[0]->id:''?>" >
			<input type="hidden" name="po_warehouse_id" value="<?= isset($po_details[0]->warehouse_id)?$po_details[0]->warehouse_id:''?>" >

			
            <div class="media media-single bg-light text-center">
              <div class="media-body">
                <h6>Batch No: <?=$po_details[0]->batch_no?></h6>
                
                <div class="flexbox flex-justified ">
                <button type="submit" class="btn btn-success btn-lg mt-10">Pickup Goods</button>
                
                </div>
            </div>
					</div>
				</div>
			</div>
      </form>
    
    <!-- /.content -->
  </div>
  
  </section>
 </div>

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
function open_modal(obj,id)
    {
        //alert(obj);
		//alert(id);
        $('.modal-body').empty();
       // $(obj).attr('data-target','#modal-'+id);
      //  $("#myModal").modal("show");
        
        $.ajax({
            url: '<?php echo URL("product-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "item_id": id,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
                console.log(data);
               
               

                $('.modal-body').append(data);
                $("#myModal").modal("show");

               
            }

        });
	
    }
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
@stop

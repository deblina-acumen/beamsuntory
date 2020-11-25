@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <!-- Action Elements -->
		
	  <div class="row">
        <div class="col-12">         
         <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h3 class="box-title">PO Details</h3>
			  
            </div>
			<div class="box-body wizard-content">
			<section class="section_cintent">
			<div class="row">
								<div class="col-md-6">
						<table class="table">
							<tbody><tr>
								<td class="td-heading">Active Date :</td>
								<td class="td-description">{{isset($poinfo[0]->active_date)&& $poinfo[0]->active_date!=''?date('d/m/Y',strtotime($poinfo[0]->active_date)):''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Active Time :</td>
								<td class="td-description">{{isset($poinfo[0]->	active_time)&& $poinfo[0]->	active_time!=''?date('g:i a',strtotime($poinfo[0]->	active_time)):''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Wirehouse :</td>
								<td class="td-description">{{isset($warehouse[0]->name) ?$warehouse[0]->name:0}}</td>
							</tr>
							<tr>
								<td class="td-heading">Status :</td>
								<td class="td-description">{{isset($poinfo[0]->status)?$poinfo[0]->status:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Ownership Type :</td>
								<td class="td-description">{{isset($poinfo[0]->ownership_type)?$poinfo[0]->ownership_type:''}}</td>
							</tr>
							
						</tbody></table>
					</div>
										<div class="col-md-6">
						<table class="table">
							
							
							<tbody><tr>
								<td class="td-heading">Supplier:</td>
								<td class="td-description">{{isset($supplier[0]->supplier_name)?$supplier[0]->supplier_name:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Supplier Details :</td>
								<td class="td-description">Address: {{isset($supplier[0]->address)?$supplier[0]->address:''}} <br/>Ph: {{isset($supplier[0]->supplier_phone)?$supplier[0]->supplier_phone:''}} <br/>Email: {{isset($supplier[0]->supplier_email)?$supplier[0]->supplier_email:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Item Kitting :</td>
								<td class="td-description">#Item (50) <br/>Oversized Item (5)								</td>
							</tr>
							<tr>
								<td class="td-heading">Ownership Details :</td>
								<td class="td-description">Not Available</td>
							</tr>
							
							
						</tbody></table>
					</div>
					<div class="col-md-12">
					<h3 class="bg-pale-dark (#c8c8c8)"><b>Product Details</b></h3>
					<div class="table-responsive">
				  <table id="khata_table" class="table table-bordered table-separated">
					<thead>
						<tr>
						  <th>Item</th>
						  <th>Batch No.</th>
						  <th>Expiry Date</th>
						  <th>Retail Price</th>
						  <th>Regular Price</th>
						  <th>Qty</th>
						  <th>Total</th>
						  <th></th>
						</tr>
					</thead>
					  <tbody>
					  <?php foreach($po_details as $po_details_val) { ?>
						<tr>
						
						  <td><div class="pull-left"><img src="{{isset($po_details_val->image) && $po_details_val->image!=''?URL('public/product/'.$po_details_val->image):asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/></div>&nbsp;&nbsp; <span class="td-pic-text">{{isset($po_details_val->name)?$po_details_val->name:''}}-{{isset($po_details_val->item_sku)?$po_details_val->item_sku:''}}</span></td>
						  <td>{{isset($po_details_val->batch_no)?$po_details_val->batch_no:''}}</td>
						  <td>{{isset($po_details_val->expire_date)&& $po_details_val->expire_date!=''?date('d/m/Y',strtotime($po_details_val->expire_date)):''}}</td>
						  <td>$ {{isset($po_details_val->retail_price)?$po_details_val->retail_price:''}}</td>
						  <td>$ {{isset($po_details_val->regular_price)?$po_details_val->regular_price:''}}</td>
						  <td>{{isset($po_details_val->quantity)?$po_details_val->quantity:''}}</td>
						  <td>$<?php echo $po_details_val->quantity * $po_details_val->regular_price ; ?></td>
						  <td class="details-control khata_no" khata_no="{{$po_details_val->po_id}}-{{$po_details_val->itemid}}-{{$po_details_val->po_details_id}}">
						  </td>
						</tr>
					   
					  <?php } ?>
					</tbody>
				  </table>
				</div>
					</div>
					</div>
					</div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <!-- Control Sidebar -->

  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
var table = $('#khata_table').DataTable();
 table.buttons().container()
        .appendTo( '#khata_table_wrapper .col-md-6:eq(0)' );
		 $('#khata_table tbody').on('click', 'td.details-control', function () {
		var khata_no = $(this).attr("khata_no");
		   var tr = $(this).closest('tr');
       	   $.ajax({
			url: '<?php echo URL("get-allocation-details-per-po-details"); ?>',
			method: "POST",
			dataType: 'html',
            data: {				
				"khata_no":khata_no,
				"_token": "{{ csrf_token() }}",
             },
            success: function(data) {	
				 var row = table.row( tr );				
				 if ( row.child.isShown() ) {
					row.child.hide();
					tr.removeClass('shown');
				}
				else {
				   row.child(data).show(); 
					tr.addClass('shown');
				}
            }
        });
    });
</script>  
@stop

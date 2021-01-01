@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PO  &nbsp;<a type="button" href="{{URL('add-po-step1')}}" class="btn btn-dark btn-sm">Add New</a>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">PO</a></li>
        <li class="breadcrumb-item active">All PO</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Action Elements -->
		@if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
          <div class="row mb-10">
           
            <div class="col-sm-12 col-md-9">
              <div class="dataTables_length" id="project-table_length">
			  <form id="project_list" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf
                <div class="input-group">
				<input type="text" name="purchase_order_no_val" value="{{isset($purchase_order_no_val)?$purchase_order_no_val:''}}" class="form-control form-control-sm" placeholder="Order No" >
				<input type="text" name="purchase_order_status_val" value="{{isset($purchase_order_status_val)?$purchase_order_status_val:''}}" class="form-control form-control-sm" placeholder="Order Status" >
				<select  name="po_supplier_val" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Supplier</option>
				 @if(!empty($supplier) && count($supplier)>0)
					  @foreach($supplier as $suppliers)
						<option value="{{$suppliers->id}}" <?php if(isset($po_supplier_val)&& $po_supplier_val == $suppliers->id){ echo "selected" ;} ?>>{{$suppliers->supplier_name}}</option>
					  @endforeach
				  @endif
                </select>
                <select  name="po_warehouse_val" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Warehouse</option>
				 @if(!empty($warehouse) && count($warehouse)>0)
					  @foreach($warehouse as $warehouses)
						<option value="{{$warehouses->id}}" <?php if(isset($po_warehouse_val)&& $po_warehouse_val == $warehouses->id){ echo "selected" ;} ?>>{{$warehouses->name}}</option>
					  @endforeach
				  @endif
                </select>
                &nbsp;<button type="submit" class="btn btn-default btn-sm">Filter</button>
              </div>
			  </form>
              </div>
            </div>
          </div>
		
	  <div class="row">
        <div class="col-12">         
         <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h3 class="box-title">All PO</h3>
			  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-bordered table-separated">
					<thead>
						<tr>
							<th>SL No</th>
							
							<th>Order ID.</th>
							<th>Order Title</th>
							<th>Date</th>
							<th>Status</th>
							<th>Boxes</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@if(!empty($purchase_order) && count($purchase_order)>0)
					  @foreach($purchase_order as $k=>$list)
						<tr>
							<td><?=$k+1?></td>
							
							<td>{{$list->order_no}}</td>
							<td>{{$list->order_title}}</td>
							<td>{{isset($list->created_at)&& $list->created_at!=''?date('d-m-Y',strtotime($list->created_at)):''}}</td>
							<td>
							<?php 
											
											
											if(isset($list->status)&&$list->status=='assigned_for_pickup'){ ?><small class="badge bg-warning">{{str_replace('_',' ',ucfirst($list->status))}}</small><?php } else if(isset($list->status)&&$list->status=='in-transit') { ?> <small class="badge bg-success">{{str_replace('_',' ',ucfirst($list->status))}}</small>
											<?php } else if(isset($list->status)&&$list->status=='draft') { ?> <small class="badge bg-dark">{{str_replace('_',' ',ucfirst($list->status))}}</small>
											<?php }
											elseif(isset($list->status)&&$list->status=='delivered') { ?> <small class="badge bg-success">{{str_replace('_',' ',ucfirst($list->status))}}</small>
											<?php }else { } ?>
																						
											
							
							
							</td>
							
							<td><?php echo $po = get_po_box_count($list->id);?></td>    
							<td><?php 
							echo $item_cost = po_item_cost($list->id);
							
							
							?></td>    
							<!--<td>
						  	<?php 
							if($list->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
							href="{{URL('purchase-active/'.base64_encode($list->id).'/No')}}" class="label label-success">Active</a> 
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
							href="{{URL('purchase-active/'.base64_encode($list->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
											
											
						  </td>-->
							<td><div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
										<?php if($list->status =='draft' || $list->status =='assigned_for_pickup'){ ?>
										<a class="dropdown-item" href="{{URL('add-po-step1/'.base64_encode($list->id))}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-purchase/'.base64_encode($list->id))}}">Delete</a>
										<?php } ?>
										<a class="dropdown-item" 
										href="{{URL('purchase-order-details-example/'.base64_encode($list->id))}}">View
										</a>
										
									</div>
								</div></td>
						</tr>
						 @endforeach
					@endif
					</tbody>
				  </table>
				</div>
            </div>
            <!-- /.box-body -->
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
<div class="box-body">
              <!-- sample modal content -->
				<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myLargeModalLabel">Purchase Order Details</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								
							</div>
							<div class="modal-footer">
								<!--<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>-->
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
              <!-- <img src="../../images/model2.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid" /> -->
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
            url: '<?php echo URL("purchase-order-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "po_id": id,
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

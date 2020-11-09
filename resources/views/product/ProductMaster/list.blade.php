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
        Products  &nbsp;<a type="button" href="{{URL('add-product')}}" class="btn btn-dark btn-sm">Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Products</a></li>
        <li class="breadcrumb-item active">All Products</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Action Elements -->
          <div class="row mb-10">
           
            <div class="col-sm-12 col-md-9">
              <div class="dataTables_length" id="project-table_length">
			  <form id="project_list" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf
                <div class="input-group">
                <select  name="product_category_val" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Category </option>
                  @if(!empty($product_category) && count($product_category)>0)
					  @foreach($product_category as $productCategory)
						<option value="{{$productCategory->id}}" <?php if(isset($product_category_val)&&$product_category_val == $productCategory->id){ echo "selected" ; } ?> >{{$productCategory->name}}</option>
					  @endforeach
				  @endif
                </select>
                <select  name="product_type" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Product Type</option>
                  <option value="simple_product" <?php if(isset($product_type)&& $product_type== 'simple_product'){ echo "selected" ;} ?>>Simple</option>
                  <option value="variable_product" <?php if(isset($product_type)&& $product_type== 'variable_product'){ echo "selected" ;} ?>>variable</option>
                </select>
                <select  name="product_brand" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Brand</option>
				 @if(!empty($brand) && count($brand)>0)
					  @foreach($brand as $brands)
						<option value="{{$brands->id}}" <?php if(isset($product_brand)&& $product_brand == $brands->id){ echo "selected" ;} ?>>{{$brands->name}}</option>
					  @endforeach
				  @endif
                </select>
				<input type="text" name="product_sku" value="{{isset($product_sku)?$product_sku:''}}" class="form-control form-control-sm" placeholder="SKU" >
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
              <h3 class="box-title">All Products</h3>
			  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-bordered table-separated">
					<thead>
						<tr>
							<th>SL No</th>
							<th>Name</th>
							
							<th>Batch No.</th>
							<th>SKU</th>
							<th>Brand</th>
							<th>Categories</th>
							<th>Regular Price</th>
							<th>Retail Price</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@if(!empty($product_list) && count($product_list)>0)
					  @foreach($product_list as $k=>$list)
						<tr>
							<td><?=$k+1?></td>
							<td><div class="pull-left"><img src="{{isset($list->image) && $list->image!=''?URL('public/product/'.$list->image):asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/></div> &nbsp;&nbsp; <span class="td-pic-text">{{ $list->name }}</span></td>
							
							<td>{{$list->batch_no}}</td>
							<td>{{$list->sku}}</td>
							<td>{{$list->brand_name}}</td>
							<td>{{$list->cat_name}}</td>
							<td>{{$list->regular_price}}</td>
							<td>{{$list->retail_price}}</td>
							<td>
						  	<?php 
							if($list->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
							href="{{URL('product-active/'.base64_encode($list->id).'/No')}}" class="label label-success">Active</a> 
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
							href="{{URL('product-active/'.base64_encode($list->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
											
											
						  </td>
							<td><div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
										
										<a class="dropdown-item" href="{{URL('edit-product/'.base64_encode($list->id))}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-product/'.base64_encode($list->id))}}">Delete</a>
										<a class="dropdown-item" data-toggle="modal" 
                                                            href="javascript::void(0)" onclick="open_modal(this,'{{$list->id}}')">View</a>
										
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
								<h4 class="modal-title" id="myLargeModalLabel">Product Details</h4>
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
            url: '<?php echo URL("product-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "facility_id": id,
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

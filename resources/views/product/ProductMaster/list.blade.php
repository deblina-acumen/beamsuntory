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
        Products  &nbsp;<button type="button" class="btn btn-dark btn-sm">Add New</button>
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
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Category</option>
                  @if(!empty($product_category) && count($product_category)>0)
					  @foreach($product_category as $productCategory)
						<option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
					  @endforeach
				  @endif
                </select>
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Product Type</option>
                  <option value="simple_product">Simple</option>
                  <option value="variable_product">variable</option>
                </select>
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select Brand</option>
				 @if(!empty($brand) && count($brand)>0)
					  @foreach($brand as $brands)
						<option value="{{$brands->id}}">{{$brands->name}}</option>
					  @endforeach
				  @endif
                </select>
				<input type="" class="form-control form-control-sm" placeholder="SKU" >
                &nbsp;<button type="button" class="btn btn-default btn-sm">Filter</button>
              </div>
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
							<td>
						  	<?php 
							if($list->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
							href="{{URL('brand-active/'.base64_encode($list->id).'/No')}}" class="label label-success">Active</a> 
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
							href="{{URL('brand-active/'.base64_encode($list->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
											
											
						  </td>
							<td><div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
										
										<a class="dropdown-item" href="{{URL('edit-product/'.base64_encode($list->id))}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-product/'.base64_encode($list->id))}}">Delete</a>
										
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
  
   <footer class="main-footer">
	  &copy; 2020 <a href="#">JimBeam</a>. All Rights Reserved.
  </footer>
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
<!-- SoftP
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
@stop

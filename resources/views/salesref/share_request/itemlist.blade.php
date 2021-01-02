@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">
<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item List
      </h1>
    </section>

    <!-- Main content -->
     <section class="content mob-container">
		
          <!---- List Item ------>
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
          <div class="box">
             <div class="box-header no-border bg-dark">
             <h6 class="pull-left">Item List</h6>
             <div class="pull-right">
              <a href="#"><i class="fa fa-filter font-size-20 text-secondary" aria-hidden="true"></i></a>
             </div>
			 <form id="project_list" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf
             <div class="input-group">
                <input type="search" name="search_category" value="{{$search_category}}" class="form-control form-control-sm" placeholder="Name, SKU or Category" aria-controls="project-table">
               &nbsp;<button type="submit" class="btn btn-blue btn-sm">Search</button>
            </div>
			</form>
            </div>				
				<div class="box-body p-0">
	<form id="item_list" method="post" action="<?= URL('item-send-request')?>" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf	
		<div class="media-list media-list-hover media-list-divided">
			<?php $sum = 0 ; ?>
			@if(!empty($product_list)&& count($product_list)>0)	
			<input type="hidden" name="row_count" value="{{count($product_list)}}">
			@foreach($product_list as $k=>$product_list_val)
			
            <div class="media media-single m-media">
              <div class="media-body">
              <div class="pull-left">
                  <img src="{{isset($product_list_val->image) && $product_list_val->image!=''?URL('public/product/'.$product_list_val->image):asset('assets/images/150x100.png')}}" class="rounded-circle m-td-pic">
              </div>
			  
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2_{{$k}}" name="sku_code_{{$k}}" value="{{$product_list_val->sku_code}}" type="checkbox">
                  <label for="checkbox2_{{$k}}"></label>
                  </div>
				  <input type="hidden" name="item_id_{{$k}}" value="{{$product_list_val->stock_item_id}}">
				  <input type="hidden" name="stock_id_{{$k}}" value="{{$product_list_val->stock_id}}">
				  <input type="hidden" name="avl_quantity_{{$k}}" value="{{get_quantity_by_stock_id($product_list_val->stock_id)}}">
				   <input type="hidden" name="user_id_{{$k}}" value="{{$product_list_val->user_id}}">
				  <div class="form-group">
						 <input type="number" name="quantity_{{$k}}" required id="quantity_{{$k}}" class="form-control quantity" placeholder="" onblur="calculate_amount(this,'{{get_quantity_by_stock_id($product_list_val->stock_id)}}','{{$k}}')" min="0" >
					</div>
				  
              </div>
			  
              <h6>{{(isset($product_list_val->itemname) && $product_list_val->itemname!='')?$product_list_val->itemname:''}}</h6>
              <small>SKU : {{(isset($product_list_val->sku_code) && $product_list_val->sku_code!='')?$product_list_val->sku_code:''}}</small>
              <p>Available Qty: <span class="text-bold">{{get_quantity_by_stock_id($product_list_val->stock_id)}}</span></p>
			  
			  <p>Batch No: <span class="text-bold">{{(isset($product_list_val->batch_no) && $product_list_val->batch_no!='')?$product_list_val->batch_no:''}}</span></p>
             
              </div>
			  
            </div>
			<?php
			$sum = $sum + get_quantity_by_stock_id($product_list_val->stock_id) ;
			
			?>
			@endforeach
			@endif
			
			



            <div class="media media-single bg-light text-center">
              <div class="media-body">
               
                <ul class="flexbox flex-justified my-10">
                  <li class="br-1 px-10">
                  <small>Total Items</small>
                  <h6 class="mb-0 text-bold">{{$sum}}</h6>
                  </li>
                 
                </ul>
				
                <div class="flexbox flex-justified ">
				 <input type="hidden" name="type" value="{{$type}}">
				<input type="hidden" name="role_id" value="{{$role_id}}">
				
				
                <button type="submit" value="submit" name="submit" class="btn btn-success btn-lg mt-10">Request Send</button>
                
                </div>
				 
            </div>
			
					</div>
				</div>
				</form>
				
			</div>
      
    </section>
    <!-- /.content -->
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
<script type="text/javascript">
function calculate_amount (obj,avl_qty,id)
{
   
   if($(obj).val()>avl_qty)
   {
	   $('#quantity_'+id).val('');
	   return false ;
   }
   else
   {
   }
   
}
</script>
@stop

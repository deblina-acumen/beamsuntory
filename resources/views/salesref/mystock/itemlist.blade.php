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
	<form id="item_list" method="post" action="<?= URL('item-list-change-privacystatus')?>" class="needs-validation" novalidate enctype="multipart/form-data">
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
			  <?php if($type!= 'not-own-by-me') {?>
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2_{{$k}}" name="sku_code_{{$k}}" value="{{$product_list_val->sku_code}}" type="checkbox">
                  <label for="checkbox2_{{$k}}"></label>
                  </div>
				  <input type="hidden" name="item_id_{{$k}}" value="{{$product_list_val->stock_item_id}}">
				  <input type="hidden" name="stock_id_{{$k}}" value="{{$product_list_val->stock_id}}">
				  <input type="hidden" name="quantity_{{$k}}" value="{{get_item_quantity_by_id_sku($type,Auth::user()->id,$product_list_val->stock_item_id,$product_list_val->sku_code)}}">
				  
				  <small class="badge bg-warning">{{get_product_privacy(Auth::user()->id,$product_list_val->stock_item_id,$product_list_val->sku_code)}}</small>
				  
              </div>
			  <?php } ?>
              <h6>{{(isset($product_list_val->itemname) && $product_list_val->itemname!='')?$product_list_val->itemname:''}}</h6>
              <small>SKU : {{(isset($product_list_val->sku_code) && $product_list_val->sku_code!='')?$product_list_val->sku_code:''}}</small>
              <p>Qty: <span class="text-bold">{{get_item_quantity_by_id_sku($type,Auth::user()->id,$product_list_val->stock_item_id,$product_list_val->sku_code)}}</span></p>
			  
			  <p>Batch No: <span class="text-bold">{{(isset($product_list_val->batch_no) && $product_list_val->batch_no!='')?$product_list_val->batch_no:''}}</span></p>
             
              </div>
			  
            </div>
			<?php
			$sum = $sum + get_item_quantity_by_id_sku($type,Auth::user()->id,$product_list_val->stock_item_id,$product_list_val->sku_code) ;
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
                  <li class="px-10">
                  <small>Total Boxes</small>
                  <h6 class="mb-0 text-bold">10</h6>
                  </li>
                </ul>
				 <?php if($type!= 'not-own-by-me') {?>
                <div class="flexbox flex-justified ">
				 <input type="hidden" name="type" value="{{$type}}">
				<input type="hidden" name="role_id" value="{{$role_id}}">
				<input type="hidden" name="cate_id" value="{{$cate_id}}">
				
                <button type="submit" value="public" name="submit" class="btn btn-success btn-lg mt-10">Make As Public</button>
                <button type="submit" value="private" name="submit" class="btn btn-dark btn-lg mt-10">Make As Private</button>
                </div>
				 <?php } ?>
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


@stop

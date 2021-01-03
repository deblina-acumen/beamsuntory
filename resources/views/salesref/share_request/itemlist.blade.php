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
		@if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
							@if (session('error-msg'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('error-msg')}}</h6>

                            </div>
                            @endif
          <!---- List Item ------>
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
			<form id="add_request" method="post" action="{{URL('item-send-request')}}" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf			
				<div class="box-body p-0">
					<div class="media-list media-list-hover media-list-divided">
			<?php $sum = 0 ; ?>
			@if(!empty($product_list)&& count($product_list)>0)	
			<input type="hidden" name="row_count" value="{{count($product_list)}}">
			@foreach($product_list as $k=>$product_list_val)
            <div class="media media-single m-media">
              <div class="media-body">
              <div class="pull-left">
                  <img src="{{isset($product_list_val->image) && $product_list_val->image!=''?URL('public/product/'.$product_list_val->image):asset('assets/images/150x100.png')}}" class="rounded-circle m-td-pic" height="200px">
              </div>
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2_{{$k}}" type="checkbox" name="sku_code[]" value="{{isset($product_list_val->sku_code )?$product_list_val->sku_code :''}}">
                  <label for="checkbox2_{{$k}}"></label>
                  </div>
              </div>
			  <div>
              <h6>{{(isset($product_list_val->itemname) && $product_list_val->itemname!='')?$product_list_val->itemname:''}}</h6>
              <small>SKU : {{(isset($product_list_val->sku_code) && $product_list_val->sku_code!='')?$product_list_val->sku_code:''}}</small>
              <p>Available Qty: 
			  <span class="text-bold">{{$available_qtn = get_quantity_by_stock_id($product_list_val->stock_id)}}
			  </span>
			  </p>
			  
			  <p>Batch No: <span class="text-bold">{{(isset($product_list_val->batch_no) && $product_list_val->batch_no!='')?$product_list_val->batch_no:''}}</span></p>
              </div>
			  <div class="input-group my-10">
                <input type="text" class="form-control form-control-sm qtn" placeholder="Quantity" aria-controls="project-table" name="quantity_{{$k}}" id="request_quantity" required>
				
				<input type="hidden" name="avl_quantity_{{$k}}" value="{{isset($available_qtn )?$available_qtn :0}}" >
             
			   <input type="hidden" name="item_id_{{$k}}" value="{{$product_list_val->stock_item_id}}">
				<input type="hidden" name="stock_id_{{$k}}" value="{{$product_list_val->stock_id}}">
				<input type="hidden" name="item_sku_code_{{$k}}" value="{{isset($product_list_val->sku_code )?$product_list_val->sku_code :''}}">
				 
				<input type="hidden" name="user_id_{{$k}}" value="{{$product_list_val->user_id}}">
			  
            </div>
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
                  <li class="br-1 px-20">
                  <small>Total Available Items</small>
                  <h6 class="mb-0 text-bold">{{$sum}}</h6>
                  </li>
                  
                </ul>
                <div class="flexbox flex-justified ">
				
				  <button type="button" class="btn btn-dark btn-lg mt-10" onclick="add_request()">Request Send</button>
				
               
               
                </div>
            </div>
					</div>
				</div>
			</div>
			
			</form>
    </section>
    <!-- /.content -->
</div>
@stop
@section('footer_scripts')
<script>
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#dvPreview')
                        .attr('src', e.target.result)
                        .width(110)
                        .height(110);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
<script>
  function add_request()
  {
	  var err = false;
	  
	  $("input:checkbox[name='sku_code[]']:checked").each(function(){
		 request_qtn = $(this).parent().parent().next().next().children().val();
		 avaiable_qtn = $(this).parent().parent().next().next().children().next().val();
		 if(request_qtn =='')
		 {
			 $(this).parent().parent().next().next().children().css('border','1px solid #d80808a1');
			 err=true;
		 }
		 else if(parseInt(request_qtn) > parseInt(avaiable_qtn))
		 {
			 err=true;
			 $(this).parent().parent().next().next().children().css('border','1px solid #d80808a1');
			 alert("Plase provide valid quantity");
		 }
		 else
		 {
			 err=false;
			 $(this).parent().parent().next().next().children().removeAttr('style');
		 }
		});
		if(err==false)
		{
	  $('#add_request').submit();
		}
  }
  </script>
@stop

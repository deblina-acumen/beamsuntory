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
         Add Ship Request <a href="{{URL('ship-request-list')}}" type="button" class="btn btn-dark btn-sm"> Ship Request List</a>
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
                <input type="text" name="item_search" class="form-control form-control-sm" placeholder="Name, SKU or Category" aria-controls="project-table" value="<?= isset($item_search)?$item_search:''?>">
               &nbsp;<button type="submit" class="btn btn-blue btn-sm">Search</button>
            </div>
			</form>
            </div>	
			<form id="add_request" method="post" action="{{URL('update-store-request')}}" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf			
				<div class="box-body p-0">
					<div class="media-list media-list-hover media-list-divided">
			<?php $sum = 0 ; ?>
			@if(!empty($product_list)&& count($product_list)>0)	
			@foreach($product_list as $k=>$product_list_val)
            <div class="media media-single m-media">
              <div class="media-body">
              <div class="pull-left">
                  <img src="{{isset($product_list_val->image) && $product_list_val->image!=''?URL('public/product/'.$product_list_val->image):asset('assets/images/150x100.png')}}" class="rounded-circle m-td-pic" height="200px">
              </div>
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2_{{$k}}" type="checkbox" name="sku_code[]" value="{{isset($product_list_val->sku_code )?$product_list_val->sku_code :''}}" <?php if($product_list_val->do_iem_sku==$product_list_val->sku_code){echo"checked";}?>>
                  <label for="checkbox2_{{$k}}"></label>
                  </div>
              </div>
			  <div>
              <h6>{{(isset($product_list_val->itemname) && $product_list_val->itemname!='')?$product_list_val->itemname:''}}</h6>
              <small>SKU : {{(isset($product_list_val->sku_code) && $product_list_val->sku_code!='')?$product_list_val->sku_code:''}}</small>
              <p>Qty: 
			  <span class="text-bold">{{$available_qtn =get_item_quantity_by_id_sku($type,Auth::user()->id,$product_list_val->stock_item_id,$product_list_val->sku_code)}}
			  </span>
			  </p>
			  
			  <p>Batch No: <span class="text-bold">{{(isset($product_list_val->batch_no) && $product_list_val->batch_no!='')?$product_list_val->batch_no:''}}</span></p>
              </div>
			  <div class="input-group my-10">
                <input type="text" class="form-control form-control-sm qtn" placeholder="Quantity" aria-controls="project-table" name="request_quantity[<?=$product_list_val->sku_code?>]" id="request_quantity" required value="{{isset($product_list_val->do_quantity)?$product_list_val->do_quantity:''}}">
				<input type="hidden" name="available_quantity[<?=$product_list_val->sku_code?>]" value="{{isset($available_qtn )?$available_qtn :0}}" >
              <input type="hidden" name="item_id[<?=$product_list_val->sku_code?>]" value="{{isset($product_list_val->stock_item_id )?$product_list_val->stock_item_id :''}}" >
			  <input type="hidden" name="do_item_id[<?=$product_list_val->sku_code?>]" value="{{isset($product_list_val->do_item_id )?$product_list_val->do_item_id :''}}" >
            </div>
              </div>
			  
            </div>
			<?php
			$sum = $sum + ($product_list_val->do_quantity) ;
			?>
			@endforeach
			@endif
            <div class="media media-single bg-light text-center">
              <div class="media-body">
               
                <ul class="flexbox flex-justified my-10">
                  <li class="br-1 px-20">
                  <small>Total Requested Items</small>
                  <h6 class="mb-0 text-bold">{{$sum}}</h6>
                  </li>
                  
                </ul>
                <div class="flexbox flex-justified ">
				<button type="button" class="btn btn-success btn-lg mt-10" onclick="add_request('ship_to_store')">Update Quantity</button>
                </div>
            </div>
					</div>
				</div>
			</div>
			<input type="hidden" name="request_type" id="request_type">
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
  function add_request(type)
  {
	  var err = false;
	  $('#request_type').val(type);
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
			 alert("Please provide valid quantity");
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

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
        View delivery Order
      </h1>
    </section>

    <!-- Main content -->
     <section class="content mob-container">

          <!---- List Item ------>
          <div class="box">	
			<div class="box-body p-0">
			<div class="row">
											<div class="col-md-6">
						<table class="table">
							<tbody>
							<tr>
								<td class="td-heading">Order No :</td>
								<td class="td-description">{{isset($doinfo[0]->oder_no)?$doinfo[0]->oder_no:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Created Date :</td>
								<td class="td-description">{{isset($doinfo[0]->created_at)&& $doinfo[0]->created_at!=''?date('d-m-Y',strtotime($doinfo[0]->created_at)):''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Status :</td>
								<td class="td-description">{{isset($doinfo[0]->status)?ucwords(str_replace('_',' ',$doinfo[0]->status)):''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Type :</td>
								<td class="td-description">{{$doinfo[0]->suppler_id ==''? 'Store Delivery':'Ship To Locker'}}</td>
							</tr>
							<tr>
								<td class="td-heading">Store :</td>
								<td class="td-description">{{isset($store[0]->store_name)?ucwords($store[0]->store_name):''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Store Details :</td>
								<td class="td-description">Address: {{isset($store[0]->address)?$store[0]->address:''}} <br/>Ph: {{isset($store[0]->phone)?$store[0]->phone:''}} <br/>Country: {{isset($country[0]->country_name)?$country[0]->country_name:''}}<br/>Province: {{isset($province[0]->name)?$province[0]->name:''}}<br/>City: {{isset($store[0]->city)?$store[0]->city:''}}<br/>Zip Code: {{isset($store[0]->zipcode)?$store[0]->zipcode:''}}</td>
							</tr>

							
						</tbody></table>
					</div>
															<div class="col-md-6">
						<table class="table">
							
							
							<tbody>
							<tr>
								<td class="td-heading">Supplier:</td>
								<td class="td-description">{{isset($supplier[0]->supplier_name)?$supplier[0]->supplier_name:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Supplier Details :</td>
								<td class="td-description">Address: {{isset($supplier[0]->address)?$supplier[0]->address:''}} <br/>Ph: {{isset($supplier[0]->supplier_phone)?$supplier[0]->supplier_phone:''}} <br/>Email: {{isset($supplier[0]->supplier_email)?$supplier[0]->supplier_email:''}}</td>
							</tr>
							<tr>
								<td class="td-heading">Delivery Agent:</td>
								<td class="td-description">{{isset($delivery_agent[0]->name)?$delivery_agent[0]->name:''}} 
								{{isset($delivery_agent[0]->lastname) ?$delivery_agent[0]->lastname:0}}</td>
							</tr>
							<tr>
								<td class="td-heading">Delivery Details:</td>
								<td class="td-description">Address: {{isset($delivery_agent[0]->address)?$delivery_agent[0]->address:''}} <br/>Ph: {{isset($delivery_agent[0]->phone)?$delivery_agent[0]->phone:''}} <br/>Email: {{isset($delivery_agent[0]->email)?$delivery_agent[0]->email:''}} 
								</td>
							</tr>
							

						</tbody></table>
					</div>
					</div>
			<div class="media-list media-list-hover media-list-divided">

		
            <div class="media media-single m-media">
              <div class="media-body">
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
						</tr>
					</thead>
					<tbody>
					@if(!empty($do_list)&& count($do_list)>0)	
					@foreach($do_list as $k=>$doinfo)
						<tr>
						  <td><div class="pull-left"><img src="{{isset($doinfo->image) && $doinfo->image!=''?URL('public/product/'.$doinfo->image):asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/></div>&nbsp;&nbsp; <span class="td-pic-text">{{isset($doinfo->item_name)?$doinfo->item_name:''}}-{{isset($doinfo->item_sku)?$doinfo->item_sku:''}}</span></td>
						  <td>{{isset($doinfo->batch_no)?$doinfo->batch_no:''}}</td>
						  <td>{{isset($doinfo->expire_date)&& $doinfo->expire_date!=''?date('d-m-Y',strtotime($doinfo->expire_date)):''}}</td>
						  <td>$ {{isset($doinfo->retail_price)?$doinfo->retail_price:''}}</td>
						  <td>$ {{isset($doinfo->regular_price)?$doinfo->regular_price:''}}</td>
						  <td>{{isset($doinfo->quantity)?$doinfo->quantity:''}}</td>
						  <td>$<?php echo $doinfo->quantity * $doinfo->regular_price ; ?></td>
							</tr>
							@endforeach
							@endif
					
					</tbody>
				  </table>
	
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

@stop

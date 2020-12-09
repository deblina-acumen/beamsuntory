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
								<td class="td-heading">Order Id:</td>
								<td class="td-description"><?= isset($do_details[0]->oder_no)?$do_details[0]->oder_no:''?></td>
							</tr>
							<tr>
								<td class="td-heading">Requested By:</td>
								<td class="td-description"><?= isset($do_details[0]->created_by)?get_delivery_agent($do_details[0]->created_by):''?></td>
							</tr>
							<tr>
								<td class="td-heading">Dated:</td>
								<td class="td-description"><?= isset($do_details[0]->created_at)?date('d-m-Y',strtotime($do_details[0]->created_at)):''?></td>
							</tr>
							
						</tbody></table>
					</div>
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td class="td-heading">Delivery Address:</td>
								<td class="td-description"><?php
								 $details = get_user_details($do_details[0]->created_id);
								 if($do_details[0]->type == "locker"){
									
										echo isset($do_details[0]->address)?$do_details[0]->address:'';
									 }
								 else
								 {
									echo isset($store[0]->address)?$store[0]->address:'';
								 }				 
								  ?>
								</td>
							</tr>
							<tr>
								<td class="td-heading">Phone:</td>
								<td class="td-description">
								<?php echo isset($do_details[0]->phone)?$do_details[0]->phone:''; ?>
								</td>
							</tr>						
							<tbody>
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
							<th>SKU</th>
							<th>Qty</th>
						</tr>
					</thead>
					<tbody>
					@if(!empty($do_details)&& count($do_details)>0)	
					@foreach($do_details as $do_dtls)
						<tr>
						  <td><?=get_product_name_by_id($do_dtls->item_id)?></td>
						   <td><?=$do_dtls->item_sku?></td>
						  <td><?=$do_dtls->quantity?></td>
						</tr>
					@endforeach
					@endif
					
					</tbody>
				  </table>
	
              </div>
			 </div>
    
				</div>

			</div>
			
			<!--</form>-->
    </section>
    <!-- /.content -->
</div>
@stop
@section('footer_scripts')

@stop

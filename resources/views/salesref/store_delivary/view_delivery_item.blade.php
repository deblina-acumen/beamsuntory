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
			<div class="media-list media-list-hover media-list-divided">
			@if(!empty($do_list)&& count($do_list)>0)	
			@foreach($do_list as $k=>$doinfo)
		
            <div class="media media-single m-media">
              <div class="media-body">
			  <div>
              <h6><?=isset($doinfo->oder_no)?$doinfo->oder_no:'';?></h6>
              <span><b>Created Date : </b><?=isset($doinfo->created_at) && $doinfo->created_at!='' ? date('d-m-Y',strtotime($doinfo->created_at)):''?></span>
              <p>
			  <span><b>Item: </b>
			  <?= isset($doinfo->store_category)?$doinfo->store_category:''?>
			  </span>
			  <br><span><b>SKU:</b> <?= isset($doinfo->store_name)?$doinfo->store_name:''?></span>
			  <br><span><b>Quantity:</b>&nbsp;</span>
			  </p>
			  <span><b>Store Category: </b>
			  <?= isset($doinfo->store_category)?$doinfo->store_category:''?>
			  </span>
			  <br><span><b>Store:</b> <?= isset($doinfo->store_name)?$doinfo->store_name:''?></span>
			  <br><span><b>Store Information:</b></span>
			  <br><span>&nbsp;&nbsp;&nbsp; <b>Zip:</b> <?= isset($doinfo->store_zipcode)?$doinfo->store_zipcode:''?></span>
			  <br><span>&nbsp;&nbsp;&nbsp; <b>Address:</b><?= isset($doinfo->store_address)?$doinfo->store_address:''?></span>
			   <br><span>&nbsp;&nbsp;&nbsp; <b>Country:</b><?= isset($doinfo->country_name)?$doinfo->country_name:''?></span>
			    <br><span>&nbsp;&nbsp;&nbsp; <b>Provinces:</b><?= isset($doinfo->provinces_name)?$doinfo->provinces_name:''?></span>
				 <br><span>&nbsp;&nbsp;&nbsp; <b>City:</b><?= isset($doinfo->store_city)?$doinfo->store_city:''?></span>
			  <br><span><b>Status:</b>&nbsp;<span class="badge bg-success"> <?= isset($doinfo->status)?ucwords(str_replace('_',' ',$doinfo->status)):''?></span></span>
			  </p>
			  <p>

			  </div>
			  <div class="input-group my-10">
               
			   
				</div>
              </div>
			 </div>
			
			@endforeach
			@endif
            
				</div>
			</div>
			
			</form>
    </section>
    <!-- /.content -->
</div>
@stop
@section('footer_scripts')

@stop

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
        Ship To Store Request <a href="{{URL('ship-request')}}" type="button" class="btn btn-dark btn-sm"> Add Ship Request </a>
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
             <h6 class="pull-left">Search</h6>
             <div class="pull-right">
              <a href="#"><i class="fa fa-filter font-size-20 text-secondary" aria-hidden="true"></i></a>
             </div>
			 <form id="project_list" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf
             <div class="input-group">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Order No" aria-controls="project-table" value="<?= isset($search)?$search:''?>">
               &nbsp;<button type="submit" class="btn btn-blue btn-sm">Search</button>
            </div>
			</form>
            </div>	
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
			  <?php if($doinfo->suppler_id==''){ ?>
			  <span><b>Store Category: </b>
			  <?= isset($doinfo->store_category)?$doinfo->store_category:''?>
			  </span>
			
			  </span>
			  <br><span><b>Store:</b> <?= isset($doinfo->store_id)?get_store_name($doinfo->store_id):''?></span>
			  <?php }else{ ?>
			  <span><b>Supplier: </b><?php echo 123;?>
			  <?= isset($doinfo->suppler_id)?get_supplier_name($doinfo->suppler_id):''?>
			  </span>
			
			  </span>
			  <br><span><b>Delivery Agent:</b> <?= isset($doinfo->delivery_agent)?get_delivery_agent($doinfo->delivery_agent):''?></span>
			  <?php } ?>
			  <br><span><b> Type:</b><?php if($doinfo->suppler_id==''){echo"Store Delivery";}else{echo"Ship To Locker";}?></span>
			  <br><span><b>Status:</b>&nbsp;<span class="badge bg-success"> <?= isset($doinfo->status)?ucwords(str_replace('_',' ',$doinfo->status)):''?></span></span>
			  </p>
              
			   
			  </div>
			  <div class="input-group my-10">
               	<a href="{{URL('do-details/'.base64_encode($doinfo->id))}}" class="btn btn-dark btn-lg mt-5">View Details</a>
			  &nbsp;
			  <?php if($doinfo->status =="assign_for_pickup"){ ?>
			  <a href="{{URL('confirm-do-pickup/'.base64_encode($doinfo->id))}}" class="btn btn-warning btn-lg mt-5">Confirm Order</a>
			  <?php } ?>			  
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

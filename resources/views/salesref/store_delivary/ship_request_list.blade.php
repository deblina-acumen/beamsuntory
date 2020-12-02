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
        Ship To Store Request
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
             <h6 class="pull-left">Request List</h6>
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
			  <span><b>Store Category: </b>
			  <?= isset($doinfo->store_category)?$doinfo->store_category:''?>
			  </span>
			  <br><span><b>Store:</b> <?= isset($doinfo->store_name)?$doinfo->store_name:''?></span>
			  <br><span><b>Status:</b>&nbsp;<span class="badge bg-success"> <?= isset($doinfo->status)?ucwords(str_replace('_',' ',$doinfo->status)):''?></span></span>
			  </p>
              <button type="button" class="btn btn-dark btn-lg mt-5">View Item</button>
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

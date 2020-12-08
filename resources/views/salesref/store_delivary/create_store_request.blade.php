@extends('layouts.master')

@section('header_styles')



<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- theme style -->


@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Store Request
      </h1>
    </section>

    <!-- Main content -->
     <section class="content mob-container">
		
          <!---- List Item ------>
          <div class="box">
             <div class="box-header no-border bg-dark">
             <h6 class="pull-left">Store Information</h6>
             <div class="pull-right">
              <a href="#"><i class="fa fa-filter font-size-20 text-secondary" aria-hidden="true"></i></a>
             </div>
			 
            </div>	
			<form id="project_list" method="post" action="{{URL('save-store-request')}}" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf			
				<div class="box-body p-0">
					<div class="media-list media-list-hover media-list-divided">
			<?php $sum = 0 ; ?>
			
            <div class="media media-single m-media">
              <div class="media-body">
              
              
              <div class="input-group my-10">
			  <div class="input-group my-2">
			  <label>Select Category &nbsp;</label>
			  </div>
                <select class="form-control form-control-sm" name="store_category" onchange="get_store(this)"required>
				<option value="">Select</option>
				@foreach($store_category as $category)
				<option value="<?=$category->id?>"><?=$category->name?></option>
				@endforeach
				</select>
              
				</div>
				<div class="input-group my-10">
				<div class="input-group my-2">
			  <label>Select Store  &nbsp;</label>
			  </div>
                <select class="form-control form-control-sm" name="store" id="store" required>
				<option value="">Select</option>
				
				</select>
              
				</div>
				
				<div class="input-group my-10">
				<div class="input-group my-2">
			  <label>Select Deliver  Agent &nbsp;</label>
			  </div>
                <select class="form-control form-control-sm" name="agent" id="store" required>
				@foreach($agent as $agentlst)
				<option value="<?=$agentlst->id?>"><?=$agentlst->name?></option>
				@endforeach
				</select>
              
				</div>
				
				
              </div>
			  
            </div>
			@foreach($sku_code as $sku_cd)
			<input type="hidden" name="sku_code[]" value="<?php echo $sku_cd; ?>" >
			<input type="hidden" name="quantuty[<?=$sku_cd?>]" value="<?php echo $request_quantity[$sku_cd] ?>" >
			<input type="hidden" name="item_id[<?=$sku_cd?>]" value="<?php echo $item_id[$sku_cd] ?>" >
			@endforeach
            <div class="media media-single bg-light text-center">
              <div class="media-body">
               
                <ul class="flexbox flex-justified my-10">
                  <li class="br-1 px-20">
                  <small>Total Requested Items</small>
                  <h6 class="mb-0 text-bold">{{isset($total_requested_qtn)?$total_requested_qtn:0}}</h6>
                  </li>
                  
                </ul>
                <div class="flexbox flex-justified ">
				
				  <button type="submit" class="btn btn-dark btn-lg mt-10">Ship To Store</button>
				
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
function get_store(obj)
{
	var store_cat = $(obj).val();
	$.ajax({
            url: '<?php echo URL("get-store-list"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
				"cat_id":store_cat,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
				$('#store').html(data);
			}
	});
}
</script>

@stop

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
			
		
            <div class="media media-single m-media">
              <div class="media-body">
			  <div>
			  <table style="width:100%;height:150px">
			  <tr>
			  <th>Order Id:</th> 
			  <td><?= isset($do_details[0]->oder_no)?$do_details[0]->oder_no:''?></td>
			  </tr>
			  
			  <tr>
			  <th>Requested By:</th> 
			  <td><?= isset($do_details[0]->created_by)?get_delivery_agent($do_details[0]->created_by):''?></td>
			  </tr>
			  <tr>
			  <th>Dated:</th> 
			  <td><?= isset($do_details[0]->created_at)?date('d-m-Y',strtotime($do_details[0]->created_at)):''?></td>
			  </tr>
			  <tr>
			  <th>Delivery Address:</th> 
			  <td>
			 <?php
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
			  <th>Phone:</th> 
			  <td>
			  <?php echo isset($do_details[0]->phone)?$do_details[0]->phone:''; ?>
			  </td>
			  </tr>
              </table>
			  <table style="width:100%;">
			  <tr>
			  <th>Item Name</th>
			  <th>Sku Code</th>
			  <th>Quantity</th>
			  </tr>
			  @foreach($do_details as $do_dtls)
			  <tr>
			  <td><?=$do_dtls->item_id?></td>
			  <td><?=$do_dtls->item_sku?></td>
			  <td><?=$do_dtls->quantity?></td>
			  </tr>
			  @endforeach
			  </table>
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

@stop

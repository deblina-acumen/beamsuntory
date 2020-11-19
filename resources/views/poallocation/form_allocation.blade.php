<div class="box-body" style="border-radius:0;">
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
            
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
            <h6 class="box-title text-dark">Item: {{$product_name}} - {{$product_sku}}</h6>
            <small class="pull-left">Brand Association : {{$brandName}} </small>
            <small class="pull-right"><span class="text-blue">Order Qty: {{$quantity}}</span></small>
              </div>
            </div>
			<input type="hidden" value="{{$quantity}}" class="total_quantity">
			<input type="hidden" name="itemid" value="{{$itemId}}">
			
			<input type="hidden" name="poid" value="{{$poId}}">
			<input type="hidden" name="itemSkuCode" value="{{$itemSkuCode}}">
			<input type="hidden" name="puchaseOrderDetailsId" value="{{$puchaseOrderDetailsId}}">
			<input type="hidden" name="countrow" id="countrow" value="">

          
            

            <hr class="my-15">
            <!--- ROW 4 ----->
			<!-- edit section -->
			<?php if(isset($count_allocation)&&$count_allocation>0){ 
			if(!empty($info)&&count($info)>0)
			{
				foreach($info as $incid=>$info_val)
				{
			?>
			<div class="row">
              <div class="col-md-2">
						<div class="input-group mb-10">
						<select name="userrole1_{{$incid}}" id="role_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" onchange="get_role2(this,{{$incid}},{{$po_details_val[0]->puchase_order_details_id}})" aria-controls="project-table" class="form-control form-control-sm">
						<option value="">Select </option>
						  <?php foreach($userRole as $userRoleval)
						{ ?>
						<option value="{{$userRoleval->id}}" <?php if(isset($info_val->role_id)&&$info_val->role_id!=''&&$info_val->role_id == $userRoleval->id ){ echo "selected"; } ?> >{{$userRoleval->name}}</option>
						<?php } ?>
						</select>
					  </div>
              </div>
              <div class="col-md-2">
					  <div class="form-group">
					  <?php if($info_val->role_id==2){ 
					  //t(explode(',',json_decode($info[0]->user,true)['roleuser1']));
					  $mixmanager = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="" roleid="" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  <option value="">Select </option>
						  <?php foreach($mixitmanager as $mixitmanagerval)
						{ ?>
						<option value="{{$mixitmanagerval->id}}" <?php if (is_array($mixmanager)) {if (in_array($mixitmanagerval->id, $mixmanager)){echo "selected";}else{}}else{} ?> >{{$mixitmanagerval->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					   <?php if($info_val->role_id==11){ 
					   $province = explode(',',$info_val->region_id) ; 
					   ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="" roleid="" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
					  
					   <option value="">Select </option>
						  <?php foreach($province_list as $province_list_val)
						{ ?>
						<option value="{{$province_list_val->id}}" <?php if (is_array($province)) {if (in_array($province_list_val->id, $province)){echo "selected";}else{}}else{} ?> >{{$province_list_val->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					   <?php if($info_val->role_id==5){ 
					   $brand = explode(',',$info_val->brand_id) ;
					   ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="" roleid="" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  
						  <option value="">Select </option>
						  <?php foreach($brand_list as $brand_list)
						{ ?>
						<option value="{{$brand_list->id}}" <?php if (is_array($brand)) {if (in_array($brand_list->id, $brand)){echo "selected";}else{}}else{} ?>  >{{$brand_list->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==9){ 
					  $country = explode(',',$info_val->country_id) ; 
					  ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="" roleid="" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  
						  <option value="">Select </option>
						  <?php foreach($country_list as $country_list)
						{ ?>
						<option value="{{$country_list->id}}" <?php if (is_array($country)) {if (in_array($country_list->id, $country)){echo "selected";}else{}}else{} ?>  >{{$country_list->country_name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					  </div>
              </div>
              <div class="col-md-2" id="dynamo_dropdown_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}_0">
					  <div class="form-group">
					  <?php if($info_val->role_id==2){ 
					  $mixassistant = explode(',',json_decode($info_val->user,true)['roleuser2']) ;?>
					  <select class="form-control select2" name="userrole3_0[]" usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
					    <option value="">Select </option>
						  <?php foreach($mixitassistant as $mixitassistantval)
						{ ?>
						<option value="{{$mixitassistantval->id}}" <?php if (is_array($mixassistant)) {if (in_array($mixitassistantval->id, $mixassistant)){echo "selected";}else{}}else{} ?> >{{$mixitassistantval->name}}</option>
						<?php } ?>
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==9){ 
					  $province = explode(',',$info_val->region_id) ; 
					  ?>
					  <select class="form-control select2" name="userrole3_0[]" usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
					  
					     <option value="">Select </option>
						  <?php foreach($province_list as $province_val)
						{ ?>
						<option value="{{$province_val->id}}" <?php if (is_array($province)) {if (in_array($province_val->id, $province)){echo "selected";}else{}}else{} ?> >{{$province_val->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==11){ 
					  $salesref = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  $srprovince = explode(',',$info_val->region_id) ;
					  $totalSr = get_salesref_name_by_regionid($srprovince);
					  ?>
					  <select class="form-control select2" name="userrole3_0[]" usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						   <option value="">Select </option>
						  <?php foreach($totalSr as $totalSr_val)
						{ ?>
						<option value="{{$totalSr_val->id}}" <?php if (is_array($salesref)) {if (in_array($totalSr_val->id, $salesref)){echo "selected";}else{}}else{} ?> >{{$totalSr_val->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==5){ 
					  $brandmm = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  $bmbrand = explode(',',$info_val->brand_id) ;
					  $totalBm = get_brandmm_name_by_brandid($bmbrand,5);
					  ?>
					  <select class="form-control select2" name="userrole3_0[]" usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  
						   <option value="">Select </option>
						  <?php foreach($totalBm as $totalBm_val)
						{ ?>
						<option value="{{$totalBm_val->id}}" <?php if (is_array($brandmm)) {if (in_array($totalBm_val->id, $brandmm)){echo "selected";}else{}}else{} ?> >{{$totalBm_val->name}}</option>
						<?php } ?>
					   
					  </select>
					  <?php } ?>
					  </div>
              </div>
			  
			  <div class="col-md-2">
					  <div class="input-group" style="margin-top: 20px;">
					  <div class="checkbox checkbox-success"  id="hide_locker_0_{{$po_details_val[0]->puchase_order_details_id}}">
						<input id="checkbox3_0_{{$po_details_val[0]->puchase_order_details_id}}" value="store" type="checkbox" name="storelocator_0" >
						<label for="checkbox3_0_{{$po_details_val[0]->puchase_order_details_id}}"> Locker </label>
					  </div>
					  <div class="checkbox checkbox-success" >
						<input id="checkbox4_0_{{$po_details_val[0]->puchase_order_details_id}}" value="each" type="checkbox" name="eachselectbox_0">
						<label for="checkbox4_0_{{$po_details_val[0]->puchase_order_details_id}}"> Each </label>
					  </div>
					</div>
              </div>
              <div class="col-md-1">
						<div class="form-group">
						 <input type="number" name="quantity_0" id="quantity_0_{{$po_details_val[0]->puchase_order_details_id}}" class="form-control quantity" placeholder="" onblur="calculate_amount()">
						</div>
						<input type="hidden" name="dynamoselectcount_0" id="dynamoselectcount_0_{{$po_details_val[0]->puchase_order_details_id}}">
              </div>
              <div class="col-md-1">
					  <div class="pull-right">
						<div class="input-group">
						<button type="button" onclick="addmorerow('{{$po_details_val[0]->puchase_order_details_id}}')" id="add_field_button_1_{{$po_details_val[0]->puchase_order_details_id}}" class="btn btn-danger btn-sm mb-5"><i class="fa fa-plus" aria-hidden="true"></i></button>
						</div>
						</div>
              </div>
            </div>
				<?php } } } else {?>
			 <div class="row">
              <div class="col-md-2">
						<div class="input-group mb-10">
						<select name="userrole1_0" id="role_0_{{$po_details_val[0]->puchase_order_details_id}}" onchange="get_role2(this,0,{{$po_details_val[0]->puchase_order_details_id}})" aria-controls="project-table" class="form-control form-control-sm">
						<option value="">Select</option>
						  <?php foreach($userRole as $userRole)
						{ ?>
						<option value="{{$userRole->id}}">{{$userRole->name}}</option>
						<?php } ?>
						</select>
					  </div>
              </div>
              <div class="col-md-2">
					  <div class="form-group">
					  <select name="userrole2_0[]" class="form-control select2" usertype="" roleid="" id="role1_0_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
					   
					  </select>
					  </div>
              </div>
              <div class="col-md-2" id="dynamo_dropdown_0_{{$po_details_val[0]->puchase_order_details_id}}_0">
					  <div class="form-group">
					  <select class="form-control select2" name="userrole3_0[]" usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
					   
					  </select>
					  </div>
              </div>
			  
			  <div class="col-md-2">
					  <div class="input-group" style="margin-top: 20px;">
					  <div class="checkbox checkbox-success"  id="hide_locker_0_{{$po_details_val[0]->puchase_order_details_id}}">
						<input id="checkbox3_0_{{$po_details_val[0]->puchase_order_details_id}}" value="store" type="checkbox" name="storelocator_0" >
						<label for="checkbox3_0_{{$po_details_val[0]->puchase_order_details_id}}"> Locker </label>
					  </div>
					  <div class="checkbox checkbox-success" >
						<input id="checkbox4_0_{{$po_details_val[0]->puchase_order_details_id}}" value="each" type="checkbox" name="eachselectbox_0">
						<label for="checkbox4_0_{{$po_details_val[0]->puchase_order_details_id}}"> Each </label>
					  </div>
					</div>
              </div>
              <div class="col-md-1">
						<div class="form-group">
						 <input type="number" name="quantity_0" id="quantity_0_{{$po_details_val[0]->puchase_order_details_id}}" class="form-control quantity" placeholder="" onblur="calculate_amount()">
						</div>
						<input type="hidden" name="dynamoselectcount_0" id="dynamoselectcount_0_{{$po_details_val[0]->puchase_order_details_id}}">
              </div>
              <div class="col-md-1">
					  <div class="pull-right">
						<div class="input-group">
						<button type="button" onclick="addmorerow('{{$po_details_val[0]->puchase_order_details_id}}')" id="add_field_button_1_{{$po_details_val[0]->puchase_order_details_id}}" class="btn btn-danger btn-sm mb-5"><i class="fa fa-plus" aria-hidden="true"></i></button>
						</div>
						</div>
              </div>
            </div>
			<?php 
			} ?>

			<!--- edit section -->
			<!--- Add section -->
			<!--- Add section -->
             

						<hr class="my-15">
						<div class="input_fields_wrap_1"></div>
              
            </div>
                   
            


          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-default">
              <i class="fa fa-angle-double-left" aria-hidden="true"></i> &nbsp; Previous Step
            </button>
                        <button type="submit" class="btn btn-dark submit_btn">
              Skip & Save
            </button>
                        <button type="submit" class="btn btn-dark submit_btn">
              Save & Finish &nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
          </div> 
               
        </div>
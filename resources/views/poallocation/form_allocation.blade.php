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
			<input type="hidden" value="{{$quantity}}" id="total_quantity" class="total_quantity">
			<input type="hidden" name="itemid" value="{{$itemId}}">
			
			<input type="hidden" name="poid" value="{{$poId}}">
			<input type="hidden" name="itemSkuCode" value="{{$itemSkuCode}}">
			<input type="hidden" name="puchaseOrderDetailsId" value="{{$puchaseOrderDetailsId}}">
			<input type="hidden" name="countrow" id="countrow" value="1">

          
            

            <hr class="my-15">
            <!--- ROW 4 ----->
			<!-- edit section -->
			<?php if(isset($count_allocation)&&$count_allocation>0){ 
			if(!empty($info)&&count($info)>0)
			{
				foreach($info as $incid=>$info_val)
				{
					$add_class = 'add_1_'.$incid ;
			?>
			<div class="row {{$add_class}}">
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
					  <?php if($info_val->role_id==20){ 
					  //t(explode(',',json_decode($info[0]->user,true)['roleuser1']));
					  $mixmanager = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  $count_total_mix_m = count($mixitmanager)  ;
					  $count_mix_m_val = count($mixmanager) ;
					  if($count_mix_m_val == $count_total_mix_m)
					  {
						  $selectedall = true ;
					  }
					  else
					  {
						  $selectedall = false ;
					  }
					  ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="mixit" roleid="{{$info_val->role_id}}" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder=""
						  style="width: 100%;">
						  
						  <?php 
						  $mixt_mangr_array = [] ;
						  $html_mix_manager2 ='';
						  $html_mix_manager = '<option value="">select</option>';
						  foreach($mixitmanager as $mixitmanagerval)
						{
							//if(isset($selectedall)&& $selectedall!=1)
							//{
							if (is_array($mixmanager)) {if (in_array($mixitmanagerval->id, $mixmanager)){ $slecttedmix = "selected";}else{$slecttedmix = '' ;}}else{$slecttedmix = '' ;}
							//}
							//else{
							//	 $slecttedmix = '' ;
						//	}
							$html_mix_manager2 .='<option value="'.$mixitmanagerval->id.'" '.$slecttedmix.'>'.$mixitmanagerval->name.'</option>';
							
							array_push($mixt_mangr_array,$mixitmanagerval->id);
							
						}
						$implode_mixit_manager_array = implode(',',$mixt_mangr_array) ;
						if(isset($selectedall)&& $selectedall ==1)
							{
								$slecttedmixall = "selected";
							}
							else{
								 $slecttedmixall = '' ;
							}
						//$html_mix_manager .='<option value="'.$implode_mixit_manager_array.'" '.$slecttedmixall.'>All ('.count($mixt_mangr_array).')</option>' ;
						echo $html_mix_manager . $html_mix_manager2 ;
						  ?>
						  
					   
					  </select>
					  <?php } ?>
					   <?php if($info_val->role_id==11){ 
					   $province = explode(',',$info_val->region_id) ; 
					   $count_total_province = count($province_list);
					   $count_sal_ref_province_val = count($province);
					    if($count_total_province == $count_sal_ref_province_val)
					  {
						  $selectedallsr = true ;
					  }
					  else
					  {
						  $selectedallsr = false ;
					  }
					   ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="sales_ref" roleid="{{$info_val->role_id}}" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder="" style="width: 100%;">
					  
					  
					  <?php
					  $sales_ref_region_arr = [] ;
					  $html_sale_ref_region = '' ;
					  $html_sale_ref_region2 = '<option value="">select</option>' ;
					  foreach($province_list as $province_list_val)
						{
							//if(isset($selectedallsr)&& $selectedallsr !=1)
							//{
								
								if (is_array($province)) {if (in_array($province_list_val->id, $province)){
									$selectedsr =  "selected";
									}else{$selectedsr = '' ;}}else{ $selectedsr =  "selected"; }
								
							//}
							//else{
							//	$selectedsr = '' ;
							//}
							$html_sale_ref_region .='<option value="'.$province_list_val->id.'" '.$selectedsr.'>'.$province_list_val->name.'</option>';
							array_push($sales_ref_region_arr,$province_list_val->id) ;
						}
						$implode_sales_ref_province = implode(',',$sales_ref_region_arr);
						if(isset($selectedallsr)&& $selectedallsr==1)
							{
								
								$selectedsrall =  "selected";
								
							}
							else{
								$selectedsrall = '' ;
							}
						//$html_sale_ref_region2 .='<option value="'.$implode_sales_ref_province.'" '.$selectedsrall.'>All ('.count($sales_ref_region_arr).')</option>' ;
						echo $html_sale_ref_region2 . $html_sale_ref_region ;
					  ?>
					  
					   
					  </select>
					  <?php } ?>
					   <?php if($info_val->role_id==5){ 
					   $brand = explode(',',$info_val->brand_id) ;
					     $count_total_brand = count($brand_list);
					   $count_bmm_brand_val = count($brand);
					    if($count_total_brand == $count_bmm_brand_val)
					  {
						  $selectedallbmm = true ;
					  }
					  else
					  {
						  $selectedallbmm = false ;
					  }
					   ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="marketing" roleid="{{$info_val->role_id}}" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder=""
						  style="width: 100%;">
						  
						  <?php
					  $bmm_brand_arr = [] ;
					  $html_bmm_brand = '' ;
					  $html_bmm_brand2 = '<option value="">select</option>' ;
					  foreach($brand_list as $brand_list_val)
						{
							//if(isset($selectedallbmm)&& $selectedallbmm !=1)
							//{
								
								if (is_array($brand)) {if (in_array($brand_list_val->id, $brand)){
									$selectedbmm =  "selected";
									}else{$selectedbmm = '' ;}}else{ $selectedbmm = '' ; }
								
							//}
							//else{
							//	$selectedbmm = '' ;
							//}
							$html_bmm_brand .='<option value="'.$brand_list_val->id.'" '.$selectedbmm.'>'.$brand_list_val->name.'</option>';
							array_push($bmm_brand_arr,$brand_list_val->id) ;
						}
						$implode_bmm_brand = implode(',',$bmm_brand_arr);
						if(isset($selectedallbmm)&& $selectedallbmm==1)
							{
								
								$selectedbmmall =  "selected";
								
							}
							else{
								$selectedbmmall = '' ;
							}
						//$html_bmm_brand2 .='<option value="'.$implode_bmm_brand.'" '.$selectedbmmall.'>All ('.count($bmm_brand_arr).')</option>' ;
						echo $html_bmm_brand2 . $html_bmm_brand ;
					  ?>
						
					   
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==15){ 
					  $country = explode(',',$info_val->country_id) ;
					  
					   $count_total_fm_country = count($country_list);
					   $count_fm_country_val = count($country);
					    if($count_total_fm_country == $count_fm_country_val)
					  {
						  $selectedallfm_country = true ;
					  }
					  else
					  {
						  $selectedallfm_country = false ;
					  }
					  ?>
					  <select name="userrole2_{{$incid}}[]" class="form-control select2" usertype="field_marking" roleid="{{$info_val->role_id}}" id="role1_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"  onchange="get_role3(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder=""
						  style="width: 100%;">
						  
						   <?php
					  $fm_country_arr = [] ;
					  $html_fm_country = '' ;
					  $html_fm_country2 = '<option value="">select</option>' ;
					  foreach($country_list as $country_list_val)
						{
							//if(isset($selectedallfm_country)&& $selectedallfm_country !=1)
							//{
								
								if (is_array($country)) {if (in_array($country_list_val->id, $country)){
									$selectedfm_country =  "selected";
									}else{$selectedfm_country = '' ;}}else{$selectedfm_country = '' ; }
								
							//}
							//else{
							//	$selectedfm_country = '' ;
							//}
							$html_fm_country .='<option value="'.$country_list_val->id.'" '.$selectedfm_country.'>'.$country_list_val->country_name.'</option>';
							array_push($fm_country_arr,$country_list_val->id) ;
						}
						$implode_fm_country = implode(',',$fm_country_arr);
						if(isset($selectedallfm_country)&& $selectedallfm_country==1)
							{
								
								$selectedfm_countryall =  "selected";
								
							}
							else{
								$selectedfm_countryall = '' ;
							}
						//$html_fm_country2 .='<option value="'.$implode_fm_country.'" '.$selectedfm_countryall.'>All ('.count($fm_country_arr).')</option>' ;
						echo $html_fm_country2 . $html_fm_country ;
					  ?>
						
					   
					  </select>
					  <?php } ?>
					  </div>
              </div>
              <div class="col-md-2" id="dynamo_dropdown_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}_0">
					  <div class="form-group">
					  <?php if($info_val->role_id==20){
					  $mixassistant = explode(',',json_decode($info_val->user,true)['roleuser2']) ;
					  
					   $count_total_mixi_assistant = count($mixitassistant);
					   $count_mixi_assistant_val = count($mixassistant);
					    if($count_total_mixi_assistant == $count_mixi_assistant_val)
					  {
						  $selectedallmixi_assistant = true ;
					  }
					  else
					  {
						  $selectedallmixi_assistant = false ;
					  }
					  $chield_role = get_previous_role(explode(',',json_decode($info_val->user,true)['roleuser1']));
					  
					  ?>
					  <select class="form-control select2" name="userrole3_{{$incid}}[]" usertype="mixit" roleid="{{ $chield_role}}" id="role2_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
					  
					  <?php
					  $mixi_assistant_arr = [] ;
					  $html_mixi_assistant = '' ;
					  $html_mixi_assistant2 = '<option value="">select</option>' ;
					  foreach($mixitassistant as $mixitassistantval)
						{
							if(isset($selectedallmixi_assistant)&& $selectedallmixi_assistant !=1)
							{
								
								if (is_array($mixassistant)) {if (in_array($mixitassistantval->id, $mixassistant)){
									$selectedmixi_assistant =  "selected";
									}else{$selectedmixi_assistant = '' ;}}else{ }
								
							}
							else{
								$selectedmixi_assistant = '' ;
							}
							$html_mixi_assistant .='<option value="'.$mixitassistantval->id.'" '.$selectedmixi_assistant.'>'.$mixitassistantval->name.'</option>';
							array_push($mixi_assistant_arr,$mixitassistantval->id) ;
						}
						$implode_mixi_assistant = implode(',',$mixi_assistant_arr);
						if(isset($selectedallmixi_assistant)&& $selectedallmixi_assistant ==1)
							{
								
								$selectedmixi_assistantall =  "selected";
								
							}
							else{
								$selectedmixi_assistantall = '' ;
							}
						$html_mixi_assistant2 .='<option value="'.$implode_mixi_assistant.'" '.$selectedmixi_assistantall.'>All ('.count($mixi_assistant_arr).')</option>' ;
						echo $html_mixi_assistant2 . $html_mixi_assistant ;
					  ?>
					  
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==15){ 
					  $province = explode(',',$info_val->region_id) ;
					  $fm_province_list = get_provence_name_by_country(explode(',',$info_val->country_id));
					  
					  $count_total_fm_province = count($fm_province_list);
					   $count_fm_province_val = count($province);
					    if($count_total_fm_province == $count_fm_province_val)
					  {
						  $selectedallfm_province = true ;
					  }
					  else
					  {
						  $selectedallfm_province = false ;
					  }
					  ?>
					  <select class="form-control select2" name="userrole3_{{$incid}}[]" usertype="field_marking" roleid="{{$info_val->role_id}}" id="role2_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder="" style="width: 100%;">
					  
					   <?php
					  $fm_province_arr = [] ;
					  $html_fm_province = '' ;
					  $html_fm_province2 = '<option value="">select</option>' ;
					  foreach($fm_province_list as $fm_province_list_val)
						{
							//if(isset($selectedallfm_province)&& $selectedallfm_province !=1)
							//{
								
								if (is_array($province)) {if (in_array($fm_province_list_val->id, $province)){
									$selectedfm_province =  "selected";
									}else{$selectedfm_province = '' ;}}else{$selectedfm_province = '' ; }
								
							//}
							//else{
								//$selectedfm_province = '' ;
							//}
							$html_fm_province .='<option value="'.$fm_province_list_val->id.'" '.$selectedfm_province.'>'.$fm_province_list_val->name.'</option>';
							array_push($fm_province_arr,$fm_province_list_val->id) ;
						}
						$implode_fm_province = implode(',',$fm_province_arr);
						if(isset($selectedallfm_province)&& $selectedallfm_province==1)
							{
								
								$selectedfm_provinceall =  "selected";
								
							}
							else{
								$selectedfm_provinceall = '' ;
							}
						//$html_fm_province2 .='<option value="'.$implode_fm_province.'" '.$selectedfm_provinceall.'>All ('.count($fm_province_arr).')</option>' ;
						echo $html_fm_province2 . $html_fm_province ;
					  ?>
					  
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==11){ 
					  $salesref = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  $srprovince = explode(',',$info_val->region_id) ;
					  $totalSr = get_salesref_name_by_regionid($srprovince);
					  
					  $count_total_sales_ref = count($totalSr);
					   $count_sales_ref_val = count($salesref);
					    if($count_total_sales_ref == $count_sales_ref_val)
					  {
						  $selectedallsales_ref = true ;
					  }
					  else
					  {
						  $selectedallsales_ref = false ;
					  }
					  ?>
					  <select class="form-control select2" name="userrole3_{{$incid}}[]" usertype="sales_ref" roleid="$info_val->role_id" id="role2_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  
						  <?php
					  $sales_ref_arr = [] ;
					  $html_sales_ref = '' ;
					  $html_sales_ref2 = '<option value="">select</option>' ;
					  foreach($totalSr as $totalSr_val)
						{
							if(isset($selectedallsales_ref)&& $selectedallsales_ref !=1)
							{
								
								if (is_array($salesref)) {if (in_array($totalSr_val->id, $salesref)){
									$selectedsales_ref =  "selected";
									}else{$selectedsales_ref = '' ;}}else{ }
								
							}
							else{
								$selectedsales_ref = '' ;
							}
							$html_sales_ref .='<option value="'.$totalSr_val->id.'" '.$selectedsales_ref.'>'.$totalSr_val->name.'</option>';
							array_push($sales_ref_arr,$totalSr_val->id) ;
						}
						$implode_sales_ref = implode(',',$sales_ref_arr);
						if(isset($selectedallsales_ref)&& $selectedallsales_ref==1)
							{
								
								$selectedsales_refall =  "selected";
								
							}
							else{
								$selectedsales_refall = '' ;
							}
						$html_sales_ref2 .='<option value="'.$implode_sales_ref.'" '.$selectedsales_refall.'>All ('.count($sales_ref_arr).')</option>' ;
						echo $html_sales_ref2 . $html_sales_ref ;
					  ?>
						
					  </select>
					  <?php } ?>
					  <?php if($info_val->role_id==5){ 
					  $brandmm = explode(',',json_decode($info_val->user,true)['roleuser1']) ;
					  $bmbrand = explode(',',$info_val->brand_id) ;
					  $totalBm = get_brandmm_name_by_brandid($bmbrand,$info_val->role_id);
					  
					   $count_total_brand_marketing_m = count($totalBm);
					   $count_brand_marketing_m_val = count($brandmm);
					    if($count_total_brand_marketing_m == $count_brand_marketing_m_val)
					  {
						  $selectedallbrand_marketing_m = true ;
					  }
					  else
					  {
						  $selectedallbrand_marketing_m = false ;
					  }
					  $chiled_role = get_chiled_role_for_fmm($info_val->role_id);
					  ?>
					  <select class="form-control select2" name="userrole3_{{$incid}}[]" usertype="marketing" roleid="{{$chiled_role}}" id="role2_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder=""
						  style="width: 100%;">
						  
						   <?php
					  $brand_marketing_m_arr = [] ;
					  $html_brand_marketing_m = '' ;
					  $html_brand_marketing_m2 = '<option value="">select</option>' ;
					  foreach($totalBm as $totalBm_val)
						{
							if(isset($selectedallbrand_marketing_m)&& $selectedallbrand_marketing_m !=1)
							{
								
								if (is_array($brandmm)) {if (in_array($totalBm_val->id, $brandmm)){
									$selectedbrand_marketing_m =  "selected";
									}else{$selectedbrand_marketing_m = '' ;}}else{ }
								
							}
							else{
								$selectedbrand_marketing_m = '' ;
							}
							$html_brand_marketing_m .='<option value="'.$totalBm_val->id.'" '.$selectedbrand_marketing_m.'>'.$totalBm_val->name.'</option>';
							array_push($brand_marketing_m_arr,$totalBm_val->id) ;
						}
						$implode_brand_marketing_m = implode(',',$brand_marketing_m_arr);
						if(isset($selectedallbrand_marketing_m)&& $selectedallbrand_marketing_m==1)
							{
								
								$selectedbrand_marketing_mall =  "selected";
								
							}
							else{
								$selectedbrand_marketing_mall = '' ;
							}
						$html_brand_marketing_m2 .='<option value="'.$implode_brand_marketing_m.'" '.$selectedbrand_marketing_mall.'>All ('.count($brand_marketing_m_arr).')</option>' ;
						echo $html_brand_marketing_m2 . $html_brand_marketing_m ;
					  ?>
					  </select>
					  <?php } ?>
					  </div>
              </div>
			  <?php if($info_val->role_id==5) 
			  {
				  $user_info = json_decode($info_val->user,true) ;
				 //t($user_info);
				// echo count($user_info);
				 $count_user_role = count($user_info) ; 
				 $next_count_user_role = $count_user_role ;
				 
				 $marketing_brand = explode(',',$info_val->brand_id);
				 
				 for($i=1;$i<$count_user_role;$i++)
				 {
					 $j =$i+1 ;
					$chield_role = get_previous_role(explode(',',json_decode($info_val->user,true)['roleuser'.$i])) ;
					$selected_user = explode(',',json_decode($info_val->user,true)['roleuser'.$j]);
					$total_user = get_chiled_user_brand_marketing($marketing_brand,$chield_role);
					
					$count_total_marketing_brand = count($total_user);
					   $count_marketing_brand_val = count($selected_user);
					    if($count_total_marketing_brand == $count_marketing_brand_val)
						  {
							  $selectedallmarketing_brand = true ;
						  }
					  else
						  {
							  $selectedallmarketing_brand = false ;
						  }
					
				  ?>
				  
				  <div class="col-md-2" id="dynamo_dropdown_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}_{{$i}}">
					  <div class="form-group">
					  <select class="form-control select2" name="userrole4_{{$i}}_{{$incid}}[]" usertype="marketing" roleid="{{$chield_role}}" id="dynamo{{$i}}_$incid_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="{{$i}}" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
						
						 <?php
					  $marketing_brand_arr = [] ;
					  $html_marketing_brand = '' ;
					  $html_marketing_brand2 = '<option value="">select</option>' ;
					  foreach($total_user as $total_user_val)
						{
							if(isset($selectedallmarketing_brand)&& $selectedallmarketing_brand !=1)
							{
								
								if (is_array($selected_user)) {if (in_array($total_user_val->id,$selected_user)){
									$selectedmarketing_brand =  "selected";
									}else{$selectedmarketing_brand = '' ;}}else{ }
								
							}
							else{
								$selectedmarketing_brand = '' ;
							}
							$html_marketing_brand .='<option value="'.$total_user_val->id.'" '.$selectedmarketing_brand.'>'.$total_user_val->name.'</option>';
							array_push($marketing_brand_arr,$total_user_val->id) ;
						}
						$implode_marketing_brand = implode(',',$marketing_brand_arr);
						if(isset($selectedallmarketing_brand)&& $selectedallmarketing_brand==1)
							{
								
								$selectedmarketing_brandall =  "selected";
								
							}
							else{
								$selectedmarketing_brandall = '' ;
							}
						$html_marketing_brand2 .='<option value="'.$implode_marketing_brand.'" '.$selectedmarketing_brandall.'>All ('.count($marketing_brand_arr).')</option>' ;
						echo $html_marketing_brand2 . $html_marketing_brand ;
					  ?>
					  
					  </select>
					  
					  </div>
					  </div>
				 <?php 
				 } ?>
				 <input type="hidden" name="dynamoselectcount_{{$incid}}" value="{{$next_count_user_role}}" id="dynamoselectcount_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}">
				 <?php
				 } ?>
				 
				 <?php if($info_val->role_id==15)
				 {	
				 $user_info = json_decode($info_val->user,true) ;
				 //t($user_info);
				// echo count($user_info);
				 $count_user_role = count($user_info) ; 
				 $next_count_user_role = $count_user_role+1 ;
				 
				 
				 $field_marketing_country = explode(',',$info_val->region_id);
				 
				 for($i=1;$i<=$count_user_role;$i++)
				 {
					 $j =$i-1 ;
				
					$selected_user = explode(',',json_decode($info_val->user,true)['roleuser'.$i]);
					//t($selected_user);
					if($i==1)
					{
						//t($selected_user);
						$chield_role = get_chiled_role_for_fmm($info_val->role_id) ;
						$total_user = get_field_marketing_manager_by_county($field_marketing_country,$info_val->role_id);
					}
					else{
						//t($selected_user);
						$chield_role = get_previous_role( explode(',',json_decode($info_val->user,true)['roleuser'.$j])) ;
						$total_user = get_chiled_user_field_marketing($field_marketing_country,$chield_role);
						//t(get_previous_role(explode(',',json_decode($info_val->user,true)['roleuser'.$i])));
					}
					//t($chield_role);
					$count_total_marketing_field = count($total_user);
					   $count_marketing_field_val = count($selected_user);
					    if($count_total_marketing_field == $count_marketing_field_val)
						  {
							  $selectedallmarketing_field = true ;
						  }
					  else
						  {
							  $selectedallmarketing_field = false ;
						  }
				 ?>
				  <div class="col-md-2" id="dynamo_dropdown_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}_{{$i}}">
					  <div class="form-group">
					  <select class="form-control select2" name="userrole4_{{$i}}_{{$incid}}[]" usertype="field_marking" roleid="{{$chield_role}}" id="dynamo{{$i}}_$incid_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="{{$i}}" onchange="get_role4(this,{{$incid}},'{{$po_details_val[0]->puchase_order_details_id}}')" multiple="multiple" data-placeholder="" style="width: 100%;">
						
						 <?php
					  $marketing_field_arr = [] ;
					  $html_marketing_field = '' ;
					  $html_marketing_field2 = '<option value="">select</option>' ;
					  foreach($total_user as $total_user_val)
						{
							if(isset($selectedallmarketing_field)&& $selectedallmarketing_field !=1)
							{
								
								if (is_array($selected_user)) {if (in_array($total_user_val->id,$selected_user)){
									$selectedmarketing_field =  "selected";
									}else{$selectedmarketing_field = '' ;}}else{ }
								
							}
							else{
								$selectedmarketing_field = '' ;
							}
							$html_marketing_field .='<option value="'.$total_user_val->id.'" '.$selectedmarketing_field.'>'.$total_user_val->name.'</option>';
							array_push($marketing_field_arr,$total_user_val->id) ;
						}
						$implode_marketing_field = implode(',',$marketing_field_arr);
						if(isset($selectedallmarketing_field)&& $selectedallmarketing_field==1)
							{
								
								$selectedmarketing_fieldall =  "selected";
								
							}
							else{
								$selectedmarketing_fieldall = '' ;
							}
						$html_marketing_field2 .='<option value="'.$implode_marketing_field.'" '.$selectedmarketing_fieldall.'>All ('.count($marketing_field_arr).')</option>' ;
						echo $html_marketing_field2 . $html_marketing_field ;
					  ?>
					  
					  </select>
					  
					  </div>
					  </div>
				 <?php } ?>
				 <input type="hidden" name="dynamoselectcount_{{$incid}}" value="{{$next_count_user_role}}" id="dynamoselectcount_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}">
				 <?php
				 } ?>
			  
			  <div class="col-md-2">
					  <div class="input-group" style="margin-top: 20px;">
					   <?php if($info_val->role_id==11)
							{	 ?>
					  <div class="checkbox checkbox-success"  id="hide_locker_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}">
						<input id="checkbox3_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" value="store" <?php if(isset($info_val->store_locker)&& $info_val->store_locker =='store') { echo "checked" ; } ?>  type="checkbox" name="storelocator_{{$incid}}" >
						<label for="checkbox3_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"> Locker </label>
					  </div>
							<?php } ?>
					  <div class="checkbox checkbox-success" >
						<input id="checkbox4_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" <?php if(isset($info_val->each_user)&& $info_val->each_user =='each') { echo "checked" ; } ?> value="each" type="checkbox" name="eachselectbox_0">
						<label for="checkbox4_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}"> Each </label>
					  </div>
					</div>
              </div>
              <div class="col-md-1">
						<div class="form-group">
						 <input type="number" name="quantity_{{$incid}}" value="{{isset($info_val->	quantity)?$info_val->	quantity:''}}" id="quantity_{{$incid}}_{{$po_details_val[0]->puchase_order_details_id}}" class="form-control quantity" placeholder="" onblur="calculate_amount()" min="0">
						</div>
						
              </div>
              <div class="col-md-1">
					  <div class="pull-right">
						<div class="input-group">
						<?php if($incid == 0){ ?>
						<button type="button" onclick="addmorerow('{{$po_details_val[0]->puchase_order_details_id}}')" id="add_field_button_1_{{$po_details_val[0]->puchase_order_details_id}}" class="btn btn-danger btn-sm mb-5"><i class="fa fa-plus" aria-hidden="true"></i></button>
						<?php } else { ?>
						<button type="button" onClick="remove_field_1('{{$incid}}')" class="btn btn-dark btn-sm mb-5"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						<?php } ?>
						
						
						</div>
						</div>
						<input type="hidden" value="{{isset($info_val->id)?$info_val->id:''}}" name="allocation_id_{{$incid}}" >
              </div>
            </div>
				<?php } } } else {?>
			 <div class="row">
              <div class="col-md-2">
						<div class="input-group mb-10">
						<select name="userrole1_0" id="role_0_{{$po_details_val[0]->puchase_order_details_id}}" required onchange="get_role2(this,0,{{$po_details_val[0]->puchase_order_details_id}})" aria-controls="project-table" class="form-control form-control-sm">
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
					  <select name="userrole2_0[]" class="form-control select2" usertype="" roleid="" id="role1_0_{{$po_details_val[0]->puchase_order_details_id}}" required onchange="get_role3(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder=""
						  style="width: 100%;">
					   
					  </select>
					  </div>
              </div>
              <div class="col-md-2" id="dynamo_dropdown_0_{{$po_details_val[0]->puchase_order_details_id}}_0">
					  <div class="form-group">
					  <select class="form-control select2" name="userrole3_0[]" required usertype="" roleid="" id="role2_0_{{$po_details_val[0]->puchase_order_details_id}}" dynamodropdownincid="0" onchange="get_role4(this,0,'{{$po_details_val[0]->puchase_order_details_id}}')"  data-placeholder=""
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
						 <input type="number" name="quantity_0" required id="quantity_0_{{$po_details_val[0]->puchase_order_details_id}}" class="form-control quantity" placeholder="" onblur="calculate_amount()" min="0">
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
            <a href="{{URL('add-po-step2/'.base64_encode($poId))}}" class="btn btn-default">
              <i class="fa fa-angle-double-left" aria-hidden="true"></i> &nbsp; Previous Step
           </a>
                      <button   class="btn btn-dark">
              Save & Finish &nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
          </div> 
               
        </div>
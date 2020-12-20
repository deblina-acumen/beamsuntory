					<div class="media-list media-list-hover media-list-divided">
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
						

            <div class="media media-single m-media">
              <div class="media-body">
                  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="User Name" name="userId" required value="<?=isset($info[0]->useId)?$info[0]->useId:''?>">
                  </div>
					<div class="input-group mb-5">
                   <input type="text" class="form-control" placeholder="Name" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
                  </div>				  
                  <div class="input-group mb-5">
                     <input type="email" class="form-control" placeholder="Email" name="email" required value="<?=isset($info[0]->email)?$info[0]->email:''?>">
                  </div> 
				  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Phone Number" name="phone" required value="<?=isset($info[0]->phone)?$info[0]->phone:''?>">
                  </div> 
				   <div class="input-group mb-5">
                   <input type="text" name="password" class="form-control" value="" placeholder="password" id="password" <?php if(isset($info[0]->id)&& $info[0]->id!=''){ ?> <?php } else { ?>required <?php }?> >
                  </div> 
				  <div class="input-group mb-5">
                   <button type="button"  class="btn btn-warning" onclick="generate_password()">  &nbsp; Generate
                    </button>
                  </div> 
				  <div class="media-body">
				  <div class="form-group mt-20">
					 <select  name="role" class="form-control" value="" id="role" >
								 <option value="">select role</option>
								 <?php if(!empty($roleList) && count($roleList)>0){ 
									foreach($roleList as $role){
								 ?>
								  <option value="{{$role->id}}" <?php if(isset($info[0]->role_id) && $info[0]->role_id==$role->id){echo"selected";}?>>{{$role->name}}</option>
									<?php } } ?>
                                 </select> 
				
				  </div>
				</div>
				
				<div class="input-group mb-5">
                     <input id="file-input" type="file" name="profile_pic" onchange="readURL(this);"/>
			    <label for="file-input">
					<?php if(isset($info[0]->profile_pic) && $info[0]->profile_pic!=''){ ?>
					<img src="{{URL('public/RoleUserPic/'.$info[0]->profile_pic)}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } else { ?>
					<img src="{{asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } ?>
				</label>
                  </div> 
				
				
				
				<div class="media-body">
				  <div class="form-group mt-20">
					<select class="form-control select2" name="brand_id">
                <option  value="">Select brand</option>
                @foreach($brand as $brand_value)
				<option value="<?= $brand_value->id?>" <?php if(isset($info[0]->brand_id)&& $info[0]->brand_id == $brand_value->id){ echo "selected" ;} ?> ><?= $brand_value->name?></option>
				@endforeach
                </select>
				  </div>
				</div>
				
				<div class="media-body">
				  <div class="form-group mt-20">
					<select name="country_id"  class="form-control select2" onchange="get_province(this)" id="country_id">
				<option  value="">Select country</option>
				<?php 
					if(isset($country)&&!empty($country)&&count($country)>0)
					{
					   foreach($country as $k=>$countries)
					   {
				?>
				<option value="{{isset($countries->id)?$countries->id :''}}" <?php if(isset( $info[0]->country_id) && ($countries->id == $info[0]->country_id)){echo "selected";}?>>{{isset($countries->country_name)?$countries->country_name :''}}</option>
				<?php 
					   }
					}
				?>
                </select>
				  </div>
				</div>
				
				
				<div class="media-body">
				  <div class="form-group mt-20">
					<select  class="form-control select2" id="province_id"  name="province_id">
						<option  value="">Select province</option>
						<?php 
						if(isset($province)&&!empty($province)&&count($province)>0)
						{
						   foreach($province as $k=>$provinces)
						   {
						?>
								<option value="{{isset($provinces->id)?$provinces->id :''}}" <?php if(isset( $info[0]->province_id) && ($provinces->id == $info[0]->province_id)){echo "selected";}?>>{{isset($provinces->name)?$provinces->name :''}}</option>
						   <?php 
						   }
						}
						?>
						</select>
				  </div>
				</div>
				<?php
					$user_address_arr = isset($info[0]->user_address)? json_decode($info[0]->user_address,true) : array();
					//t($user_address_arr,1) 
					?>
				<div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="City" name="city" value="{{isset($user_address_arr['city'])?$user_address_arr['city']:''}}" placeholder="Enter City">
                  </div> 
				  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Zip" name="zip" value="{{isset($user_address_arr['zip'])?$user_address_arr['zip']:''}}" placeholder="Enter Zip">
                  </div> 
                  <div class="input-group mb-5">
                    <textarea class="form-control" placeholder="Address" name="address"><?=isset($user_address_arr['street'])?$user_address_arr['street']:''?></textarea>
                  </div> 
				  
				  <div class="input-group mb-5">
                   <input type="checkbox" id="is_check" name="is_same_locator_address" value="true">
			<label for="is_check"> Same As Store Locator Address.</label><br>
                  </div> 
				  <div class="store_locator_address_block">
				  <p><b> Store Locator / Shipping Address : </b></p><br>
				  <?php
				//t($info,1);
					$storelocator_address_arr = isset($info[0]->storelocator_address)? json_decode($info[0]->storelocator_address,true) : array();
				//t($storelocator_address_arr,1) 
					?>
					<div class="media-body">
				  <div class="form-group mt-20">
				  <?php 
				//t($country,1);
				if(isset($country)&&!empty($country)&&count($country)>0)
                   foreach($country as $k=>$countries)
				?>
                <select name="store_locator_country_id"  class="form-control select2" onchange="get_store_locator_province(this)" id="store_locator_country_id">
				<option  value="">Select Country</option>
				<?php 
					if(isset($country)&&!empty($country)&&count($country)>0)
					{
					   foreach($country as $k=>$countries)
					   {
				?>
				<option value="{{isset($countries->id)?$countries->id :''}}" <?php if(isset( $storelocator_address_arr['country']) && ($countries->id == $storelocator_address_arr['country'])){echo "selected";}?>>{{isset($countries->country_name)?$countries->country_name :''}}</option>
				<?php 
					   }
					}
				?>
                </select>
				  </div>
				  </div>
				  <div class="media-body">
				  <div class="form-group mt-20">
				  <select  class="form-control select2" id="store_locator_province_id"  name="store_locator_province_id">
						<option  value="">Select Province</option>
						<?php 
						if(isset($province)&&!empty($province)&&count($province)>0)
						{
						   foreach($province as $k=>$provinces)
						   {
						?>
								<option value="{{isset($provinces->id)?$provinces->id :''}}" <?php if(isset( $storelocator_address_arr['province']) && ($provinces->id == $storelocator_address_arr['province'])){echo "selected";}?>>{{isset($provinces->name)?$provinces->name :''}}</option>
						   <?php 
						   }
						}
						?>
						</select>
				  </div>
				  </div>
					 <div class="input-group mb-5">
					 <input type="text" class="form-control" placeholder="city" name="store_locator_city" value="{{isset($storelocator_address_arr['city'])?$storelocator_address_arr['city']:''}}" placeholder="Enter City">
					  </div>
					 <div class="input-group mb-5">
					 <input type="text" class="form-control" placeholder="zip" name="store_locator_zip" value="{{isset($storelocator_address_arr['zip'])?$storelocator_address_arr['zip']:''}}" placeholder="Enter Zip">
					  </div>
					   <div class="input-group mb-5">
					   <textarea class="form-control" placeholder="Address" name="store_locator_address"><?=isset($storelocator_address_arr['street'])?$storelocator_address_arr['street']:''?></textarea>
					  </div>
					  
				  </div>
				  
              
              </div>
            </div>

            <div class="media media-single bg-light text-center">
              <div class="media-body">
                <div class="flexbox flex-justified ">
				<input type="hidden" id="id" name="id" value="<?=isset($info[0]->id)?$info[0]->id:''?>">
                <button type="submit" class="btn btn-success btn-lg mt-10">Save</button>
                </div>
            </div>
					</div>
				</div>
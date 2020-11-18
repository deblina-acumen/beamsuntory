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
              <div class="row">
			   <div class="col-md-6">
              <div class="form-group">
                <label>user Name *</label>
                <input type="text" class="form-control" placeholder="" name="userId" required value="<?=isset($info[0]->useId)?$info[0]->useId:''?>">
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label> Name *</label>
                <input type="text" class="form-control" placeholder="" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>
			  
               <div class="col-md-6">
              <div class="form-group">
                <label>Email *</label>
                <input type="email" class="form-control" placeholder="" name="email" required value="<?=isset($info[0]->email)?$info[0]->email:''?>">
              </div>
              </div>
              			  
			  
			  <div class="col-md-4">
                            <div class="form-group">
                                <label>Password*</label>
								 <input type="text" name="password" class="form-control" value="" id="password" <?php if(isset($info[0]->id)&& $info[0]->id!=''){ ?> <?php } else { ?>required <?php }?> >
                                        
                            </div>
                        </div> 	
						<div class="col-md-2">
                            <div class="form-group">
                                 <label>&nbsp;</label>
                                 <button type="button"  class="btn btn-warning" onclick="generate_password()">  &nbsp; Generate
                                 </button>
                                        
                            </div>
                        </div> 						
			  <div class="col-md-6">
                            <div class="form-group">
                                <label>Role*</label>
								 <select  name="role" class="form-control" value="" id="role" >
								 <option value="">select</option>
								 <?php if(!empty($roleList) && count($roleList)>0){ 
									foreach($roleList as $role){
								 ?>
								  <option value="{{$role->id}}" <?php if(isset($info[0]->role_id) && $info[0]->role_id==$role->id){echo"selected";}?>>{{$role->name}}</option>
									<?php } } ?>
                                 </select>     
                            </div>
                        </div> 
		  	<div class="col-md-6">
              <div class="form-group">
                <label> Image</label>
               <input id="file-input" type="file" name="profile_pic" onchange="readURL(this);"/>
			    <label for="file-input">
					<?php if(isset($info[0]->profile_pic) && $info[0]->profile_pic!=''){ ?>
					<img src="{{URL('public/RoleUserPic/'.$info[0]->profile_pic)}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } else { ?>
					<img src="{{asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } ?>
				</label>
              </div>
              </div>
			 
            </div>
			<div class="row">
			 <div class="col-md-6">
              <div class="form-group">
                <label>Country *</label>
				<?php 
				//t($country,1);
				if(isset($country)&&!empty($country)&&count($country)>0)
                   foreach($country as $k=>$countries)
				?>
                <select name="country_id"  class="form-control select2" onchange="get_province(this)" id="country_id">
				<option  value="">Select</option>
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
				<div class="col-md-6">
					<div class="form-group">
						<label>Region/Province</label>
						<select  class="form-control select2" id="province_id"  name="province_id">
						<option  value="">Select</option>
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
			</div>
			<div class="row">
			  <div class="col-md-6">
              <div class="form-group">
                <label>Brand</label>
                <select class="form-control select2" name="brand_id">
                <option  value="">Select</option>
                @foreach($brand as $brand_value)
				<option value="<?= $brand_value->id?>" <?php if(isset($info[0]->brand_id)&& $info[0]->brand_id == $brand_value->id){ echo "selected" ;} ?> ><?= $brand_value->name?></option>
				@endforeach
                </select>
              </div>
              </div>
			</div>
			<div class="row">
			    <div class="col-md-6">
					<?php
					$user_address_arr = isset($info[0]->user_address)? json_decode($info[0]->user_address,true) : array();
					//t($user_address_arr,1) 
					?>
					<div class="form-group">
						<label>City</label>
						<input type="text" class="form-control" name="city" value="{{isset($user_address_arr['city'])?$user_address_arr['city']:''}}" placeholder="Enter City">
					</div>
				</div>
			    <div class="col-md-6">
					<div class="form-group">
						<label >Zip Code/Postal Code</label>
						<input type="text" class="form-control" name="zip" value="{{isset($user_address_arr['zip'])?$user_address_arr['zip']:''}}" placeholder="Enter Zip">
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-6">
					<div class="form-group">
						<label> Street Address</label>
						<textarea class="form-control" name="address"><?=isset($user_address_arr['street'])?$user_address_arr['street']:''?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-6">
			<div class="form-group">
			<input type="checkbox" id="is_check" name="is_same_locator_address" value="true">
			<label for="is_check"> Same As Store Locator Address.</label><br>
			</div>
			</div>
			</div>
			<div class="store_locator_address_block">
			<div class="row">
			    <div class="col-md-6">
				<?php
				//t($info,1);
					$storelocator_address_arr = isset($info[0]->storelocator_address)? json_decode($info[0]->storelocator_address,true) : array();
				//t($storelocator_address_arr,1) 
					?>
					<div class="form-group">
						<label>City</label>
						<input type="text" class="form-control" name="store_locator_city" value="{{isset($storelocator_address_arr['city'])?$storelocator_address_arr['city']:''}}" placeholder="Enter City">
					</div>
				</div>
			    <div class="col-md-6">
					<div class="form-group">
						<label >Zip Code/Postal Code</label>
						<input type="text" class="form-control" name="store_locator_zip" value="{{isset($storelocator_address_arr['zip'])?$storelocator_address_arr['zip']:''}}" placeholder="Enter Zip">
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-6">
					<div class="form-group">
						<label>street Address</label>
						<textarea class="form-control" name="store_locator_address"><?=isset($storelocator_address_arr['street'])?$storelocator_address_arr['street']:''?></textarea>
					</div>
				</div>
			</div>
			</div>
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" id="id" name="id" value="<?=isset($info[0]->id)?$info[0]->id:''?>">
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save
            </button>
          </div>  
</div>

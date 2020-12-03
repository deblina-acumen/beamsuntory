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
              
              <div class="form-group mt-20">
                <select class="form-control" name="store_category">
                <option>Select Store Type</option>
                <?php if(isset($store_category)&&!empty($store_category)&&count($store_category)>0){
					foreach($store_category as $store_category)
					{					
					?>
					<option value="{{$store_category->id}}" <?php if(isset($info[0]->store_category)&& $info[0]->store_category !='' &&  $info[0]->store_category == $store_category->id) { echo "selected" ; } ?>>{{$store_category->name}}</option>
				<?php }} ?>
                </select>
              </div>
              </div>
						</div>

            <div class="media media-single m-media">
              <div class="media-body">
                  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Name" name="store_name" required value="<?=isset($info[0]->store_name)?$info[0]->store_name:''?>">
                  </div>
					<div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Contact Person" name="contact_person" required value="<?=isset($info[0]->contact_person)?$info[0]->contact_person:''?>">
                  </div>				  
                  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Email" name="email" required value="<?=isset($info[0]->email)?$info[0]->email:''?>">
                  </div> 
				  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Phone Number" name="phone" required value="<?=isset($info[0]->phone)?$info[0]->phone:''?>">
                  </div> 
				  <div class="media-body">
				  <div class="form-group mt-20">
				<select class="form-control" name="country" onchange="get_province(this)" id="country_id">
                <option>Select Country</option>
                <?php 
						if(isset($country)&&!empty($country)&&count($country)>0)
						{
						   foreach($country as $k=>$countries)
						   {
						?>
							<option value="{{isset($countries->id)?$countries->id :''}}" <?php if(isset( $info[0]->country) && ($countries->id == $info[0]->country)){echo "selected";}?>>{{isset($countries->country_name)?$countries->country_name :''}}</option>
							<?php
						   }
						}
							?>
                </select>
				  </div>
				</div>
				<div class="media-body">
				  <div class="form-group mt-20">
					<select class="form-control" name="state" id="province_id">
                <option>Select Province</option>
                <?php if(isset($Provinces)&&!empty($Provinces)&&count($Provinces)>0){
					foreach($Provinces as $Provinces)
					{					
					?>
					<option value="{{$Provinces->id}}"  <?php if(isset($info[0]->state)&& $info[0]->state !='' &&  $info[0]->state == $Provinces->id) { echo "selected" ; } ?>>{{$Provinces->name}}</option>
				<?php }} ?>
                </select>
				  </div>
				</div>
				<div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="City" name="city" required value="<?=isset($info[0]->city)?$info[0]->city:''?>">
                  </div> 
				  <div class="input-group mb-5">
                    <input type="text" class="form-control" placeholder="Zip Code" name="zipcode" required value="<?=isset($info[0]->zipcode)?$info[0]->zipcode:''?>">
                  </div> 
                  <div class="input-group mb-5">
                    <textarea class="form-control" name="address" placeholder="Address"><?=isset($info[0]->address)?$info[0]->address:''?></textarea>
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
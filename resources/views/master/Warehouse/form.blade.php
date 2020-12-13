		<div class="box-body" style="border-radius:0;">
			<div class="row">
			    <div class="col-md-6">
                  <div class="form-group">
					<label>Name *</label>
					<input type="text" class="form-control" name="name" value="{{isset($info[0]->name)?$info[0]->name:''}}" placeholder="Enter Warehouse name" required>
				  </div>
              </div>
			</div>
			<div class="row">
				 <div class="col-md-6">
					<div class="form-group">
						<label>Manager *</label>
						<?php //t($warehouse_manager,1); ?>
						<select name="manager_id" class="form-control" >
						<option  value="">Select</option>
						<?php 
						if(isset($warehouse_manager)&&!empty($warehouse_manager)&&count($warehouse_manager)>0)
						{
						   foreach($warehouse_manager as $k=>$warehouse_managers)
						   {
						?>
							<option value="{{isset($warehouse_managers->userid)?$warehouse_managers->userid :''}}" <?php if(isset( $info[0]->user_id) && ($warehouse_managers->userid == $info[0]->user_id)){echo "selected";}?>>{{isset($warehouse_managers->first_name)?$warehouse_managers->first_name :''}}</option>
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
						<label>Country *</label>
						<select name="country_id" class="form-control select2" onchange="get_province(this)" id="country_id" >
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
            </div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Region/Province *</label>
						<select name="province_id" class="form-control select2" id="province_id">
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
						<label>City *</label>
						<input type="text" class="form-control" name="city" value="{{isset($info[0]->city)?$info[0]->city:''}}" placeholder="Enter City" required>
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-6">
					<div class="form-group">
						<label >Zip Code/Postal Code *</label>
						<input type="text" class="form-control" name="zip" value="{{isset($info[0]->zip)?$info[0]->zip:''}}" placeholder="Enter Zip" required>
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-6">
					<div class="form-group">
						<label>Address *</label>
						<textarea class="form-control" name="address"><?=isset($info[0]->address)?$info[0]->address:''?></textarea>
					</div>
				</div>
			</div>
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" name="id" value="{{isset($info[0]->id)?$info[0]->id:''}}" >
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save Warehouse
            </button>
          </div>  
		  </div>
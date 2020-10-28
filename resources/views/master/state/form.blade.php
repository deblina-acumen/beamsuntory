<div class="box-body" style="border-radius:0;">
			<div class="row">
			 <div class="col-md-12">
              <div class="form-group">
                <label>Country *</label>
				<?php 
				if(isset($country)&&!empty($country)&&count($country)>0)
                   foreach($country as $k=>$countries)
				?>
                <select name="country_id" class="form-control">
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
			<div class="col-md-12">
              <div class="form-group">
                <label>State *</label>
                <input type="text" class="form-control" name="state" value="{{isset($info[0]->state_name)?$info[0]->state_name:''}}" placeholder="Enter State" required>
              </div>
              </div>
			  </div>
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" name="id" value="{{isset($info[0]->id)?$info[0]->id:''}}" >
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save State
            </button>
          </div>  
               
        </div>
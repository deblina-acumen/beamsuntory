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
              <!-- Date -->
              <div class="form-group">
                <label>Active Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="active date" value="" required>
                </div>
                <!-- /.input group -->
              </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Active Time:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" id="datetimepicker3" name="active_time">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>


            
          <div class="row">
              <div class="col-md-3">
              	<label>Select Supplier</label>
                <div class="input-group">
                <select name="supplier" aria-controls="project-table" class="form-control form-control-sm">
                   <option value="">Select</option>
				@foreach($supplier as $supplier_val)
				<option value="<?= $supplier_val->id?>" <?php if(isset($info[0]->supplier_id)&& $info[0]->supplier_id == $supplier_val->id ){ echo "selected" ;} ?> ><?= $supplier_val->supplier_name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Select Warehouse</label>
                <div class="input-group">
                <select name="warehouse" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="">Select</option>
				@foreach($warehouse as $warehouses)
				<option value="<?= $warehouses->id?>" <?php if(isset($info[0]->id)&& $info[0]->supplier_id == $warehouses->id ){ echo "selected" ;} ?> ><?= $warehouses->name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Status</label>
                <div class="input-group">
                <select name="status" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="draft">Draft</option>
                  <option value="delivered">Delivered</option>
                  <option value="in-transit">In-Transit</option>
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Ownership Type</label>
                <div class="input-group">
                <select name="ownership_type" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="not_defined">Not Defined</option>
                  <option value="owner">Owner</option>
                  <option value="other_role">Other Role</option>
                </select>
              </div>
              </div>
            </div>
            <br/>
           

            <br/>
            <h4 class="box-title text-dark">Add Items </h4>
            <hr class="my-15">
            <div class="row">
			<div class="col-md-4">
              	<label>Item Type</label>
                <div class="input-group">
                <select name="itemtype[]" aria-controls="project-table" class="form-control form-control-sm" onchange="get_item(this)"required>
					<option value="">Select</option>
                    <option value="simple_product">Simple Product</option>
					<option value="variable_product">Variable Product</option>
                </select>
              </div>
              </div>
              <div class="col-md-4">
              	<label>Select Item</label>
                <div class="input-group">
                <select name="item[]" aria-controls="project-table" class="form-control form-control-sm" required>
                    <option value="">Select</option>
				
                </select>
              </div>
              </div>
              <div class="col-md-2">
				<div class="form-group">
								<label>Select Qty</label>
								<input  type="text" value="" name="quantity[]" class="form-control form-control-sm"data-bts-button-up-class="btn btn-secondary" required> </div>
              </div>
              <div class="col-md-2">
              <div class="pull-right">
              	<label>Action</label>
              	<div class="input-group">
                <button type="button" class="btn btn-dark btn-sm mb-5" onclick="add_item(this)"><i class="fa fa-plus"></i> &nbsp;Add Item</button>
                </div>
          	    </div>
              </div>
            </div>
           <div id="new_item"></div>

          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-dark">
              Next Step &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
          </div>  
               
        </div>
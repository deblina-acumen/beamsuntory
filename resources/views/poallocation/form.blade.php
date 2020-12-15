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
			  <div class="col-md-3">
              <!-- Date -->
              <div class="form-group">
                <label>Order Title:</label>

                <div class="input-group date">
                  
                  <input type="text" class="form-control pull-right"  name="order_title" value="<?=isset($poinfo[0]->order_title)&& $poinfo[0]->order_title!=''?$poinfo[0]->order_title:''?>" readonly>
                </div>
                <!-- /.input group -->
              </div>
              </div>
			<div class="col-md-3">
              <!-- Date -->
              <div class="form-group">
                <label>Order Id:</label>

                <div class="input-group date">
                  
                  <input type="text" class="form-control pull-right"  name="order_no" value="<?=isset($poinfo[0]->order_no)&& $poinfo[0]->order_no!=''?$poinfo[0]->order_no:''?>" readonly>
                </div>
                <!-- /.input group -->
              </div>
              </div>
              <div class="col-md-3">
              <!-- Date -->
              <div class="form-group">
                <label>Active Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				  
                  <input type="text" value="{{isset($poinfo[0]->active_date)&& $poinfo[0]->active_date!=''?date('d/m/Y',strtotime($poinfo[0]->active_date)):''}}" class="form-control pull-right" id="" readonly>
                </div>
                <!-- /.input group -->
              </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Active Time:</label>

                  <div class="input-group">
                    <input type="text" value="{{isset($poinfo[0]->	active_time)&& $poinfo[0]->	active_time!=''?date('g:i a',strtotime($poinfo[0]->	active_time)):''}}"  class="form-control timepicker" readonly>

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
                            <div class="col-md-2">
                <label>Wirehouse</label>
                <div class="input-group">
                <select name="" aria-controls="project-table" class="form-control form-control-sm" readonly>
                <option value="">Select</option>
				@foreach($warehouse as $warehouses)
				<option value="<?= $warehouses->id?>" <?php if(isset($poinfo[0]->warehouse_id)&& $poinfo[0]->warehouse_id == $warehouses->id ){ echo "selected" ;} ?> ><?= $warehouses->name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-2">
                <label>Status</label>
                <div class="input-group">
                <select name="" aria-controls="project-table" class="form-control form-control-sm" readonly>
                <option value="draft" <?php if(isset($poinfo[0]->status)&& $poinfo[0]->status == 'draft' ){ echo "selected" ;} ?>>Draft</option>
				 <option value="assigned_for_pickup" <?php if(isset($poinfo[0]->status) && $poinfo[0]->status=="assigned_for_pickup"){echo"selected";} ?>>Assigned for pickup</option>
                  <option value="delivered" <?php if(isset($poinfo[0]->status)&& $poinfo[0]->status == 'delivered'){ echo "selected" ;} ?>>Delivered</option>
                  <option value="in-transit" <?php if(isset($poinfo[0]->status)&& $poinfo[0]->status =='in-transit'){ echo "selected" ;} ?>>In-Transit</option>
                </select>
              </div>
              </div>
              <div class="col-md-2">
                <label>Ownership Type</label>
                <div class="input-group">
                <select name="" aria-controls="project-table" class="form-control form-control-sm" readonly>
                    <option value="not_defined" <?php if(isset($poinfo[0]->ownership_type)&& $poinfo[0]->ownership_type == 'not_defined' ){ echo "selected" ;} ?>>Not Defined</option>
                  <option value="owner" <?php if(isset($poinfo[0]->ownership_type)&& $poinfo[0]->ownership_type == 'owner' ){ echo "selected" ;} ?>>Owner</option>
                  <option value="other_role" <?php if(isset($poinfo[0]->ownership_type)&& $poinfo[0]->ownership_type == 'other_role' ){ echo "selected" ;} ?>>Other Role</option>
                </select>
              </div>
              </div>
            </div>
          
                    <div class="row">
              <div class="col-md-4">
                <label>Supplier</label>
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm" readonly>
                  @foreach($supplier as $supplier_val)
				<option value="<?= $supplier_val->id?>" <?php if(isset($poinfo[0]->supplier_id)&& $poinfo[0]->supplier_id == $supplier_val->id ){ echo "selected" ;} ?> ><?= $supplier_val->supplier_name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
                <label>Supplier Details</label>
                <p class="box-title text-dark">Address: {{isset($supplier[0]->address)?$supplier[0]->address:''}} <br/>Ph: {{isset($supplier[0]->supplier_phone)?$supplier[0]->supplier_phone:''}} <br/>Email: {{isset($supplier[0]->supplier_email)?$supplier[0]->supplier_email:''}} </p>
              </div>
              <div class="col-md-2">
                <label>Item Kitting</label>
                <p class="box-title text-dark">#Item (50) <br/>Oversized Item (5)</p>
              </div>
              <div class="col-md-3">
                <label>Ownership Details</label>
                <p class="box-title text-dark">Not Available</p>
              </div>

            </div>
            
<br/><br/>
<h4 class="box-title text-dark">Allocation</h4>
            <hr class="my-15">

          <div class="table-responsive">
          <table id="example1" class="table table-bordered table-separated">
          <thead>
            <tr>
              <th>Item</th>
              <th>Batch No.</th>
              <th>Expiry Date</th>
              <th>Retail Price</th>
              <th>Regular Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Allocation</th>
            </tr>
          </thead>
          <tbody>
		  <?php foreach($po_details as $po_details_val) { ?>
            <tr>
			
              <td><div class="pull-left"><img src="{{isset($po_details_val->image) && $po_details_val->image!=''?URL('public/product/'.$po_details_val->image):asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/></div>&nbsp;&nbsp; <span class="td-pic-text">{{isset($po_details_val->name)?$po_details_val->name:''}}-{{isset($po_details_val->item_sku)?$po_details_val->item_sku:''}}</span></td>
              <td>{{isset($po_details_val->batch_no)?$po_details_val->batch_no:''}}</td>
              <td>{{isset($po_details_val->expire_date)&& $po_details_val->expire_date!=''?date('d/m/Y',strtotime($po_details_val->expire_date)):''}}</td>
              <td>$ {{isset($po_details_val->retail_price)?$po_details_val->retail_price:''}}</td>
              <td>$ {{isset($po_details_val->regular_price)?$po_details_val->regular_price:''}}</td>
              <td>{{isset($po_details_val->quantity)?$po_details_val->quantity:''}}</td>
              <td>$<?php echo $po_details_val->quantity * $po_details_val->regular_price ; ?></td>
              <td>
			  <?php if(check_allocation_present($po_details_val->itemid,$po_details_val->puchase_order_details_id,$po_details_val->po_id) == true) { ?>
			  <a href="{{URL('edit-po-allocation/'.base64_encode($po_details_val->itemid).'/'.base64_encode($po_details_val->puchase_order_details_id).'/'.base64_encode($po_details_val->po_id))}}" class="btn btn-dark btn-sm"> Edit Allocation </a>
			 
			  <?php } else { ?>
			  <a href="{{URL('add-po-allocation/'.base64_encode($po_details_val->itemid).'/'.base64_encode($po_details_val->puchase_order_details_id).'/'.base64_encode($po_details_val->po_id))}}" class="btn btn-dark btn-sm">Allocate</a>
			  
			  <?php } ?>
			 <br>
              </td>
            </tr>
           
		  <?php } ?>
          </tbody>

          </table>
        </div>
<br/>

          <!-- /.box-body -->
          <div class="box-footer">
            
			<a href="{{URL('add-po-step1/'.base64_encode($po_details_val->po_id))}}" class="btn btn-default">
              <i class="fa fa-angle-double-left" aria-hidden="true"></i> &nbsp; Previous Step
           </a>
             <a href="{{URL('purchase-order-list/')}}" class="btn btn-dark">
               Save & Finish
            </a>
                      <!--  <button type="submit" class="btn btn-dark">
              Save & Finish &nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button> -->
          </div> 
               
        </div>
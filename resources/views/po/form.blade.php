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
                  
                  <input type="text" class="form-control pull-right"  name="order_title" value="<?=isset($po[0]->order_title)&& $po[0]->order_title!=''?$po[0]->order_title:''?>" required>
                </div>
                <!-- /.input group -->
              </div>
              </div>
			<div class="col-md-3">
              <!-- Date -->
              <div class="form-group">
                <label>Order Id:</label>

                <div class="input-group date">
                  
                  <input type="text" class="form-control pull-right"  name="order_no" value="<?=isset($po[0]->order_no)&& $po[0]->order_no!=''?$po[0]->order_no:'PO-BEAM-'.rand(0,1500).'-'.rand(5,500)?>" required>
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
                  <input type="text" class="form-control pull-right" id="datepicker" name="active_date" value="<?=isset($po[0]->active_date)&& $po[0]->active_date!=''?date('m/d/Y',strtotime($po[0]->active_date)):''?>" required>
                </div>
                <!-- /.input group -->
              </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Active Time:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" id="datetimepicker3" name="active_time" value="<?=isset($po[0]->active_time)&& $po[0]->active_time!=''?date('H:i:s',strtotime($po[0]->active_time)):''?>">

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
                <select name="supplier" aria-controls="project-table" class="form-control form-control-sm" required>
                   <option value="">Select</option>
				@foreach($supplier as $supplier_val)
				<option value="<?= $supplier_val->id?>" <?php if(isset($po[0]->supplier_id) && $po[0]->supplier_id == $supplier_val->id ){ echo "selected" ;} ?> ><?= $supplier_val->supplier_name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Select Delivery Agent/Courier</label>
                <div class="input-group">
                <select name="delivery_agent" aria-controls="project-table" class="form-control form-control-sm" required>
                   <option value="">Select</option>
				@foreach($delivery_agent as $agent)
				<option value="<?= $agent->id?>" <?php if(isset($po[0]->delivery_agent_id) && $po[0]->delivery_agent_id  == $agent->id ){ echo "selected" ;} ?> ><?= $agent->name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Select Warehouse</label>
                <div class="input-group">
                <select name="warehouse" aria-controls="project-table" class="form-control form-control-sm" required>
                  <option value="">Select</option>
				@foreach($warehouse as $warehouses)
				<option value="<?= $warehouses->id?>"  <?php if(isset($po[0]->warehouse_id) && $po[0]->warehouse_id==$warehouses->id){echo"selected";} ?>><?= $warehouses->name?></option>
				@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-3">
              	<label>Status</label>
                <div class="input-group">
                <select name="status" aria-controls="project-table" class="form-control form-control-sm" required>
				<option value="">Select</option>
                  <option value="draft" <?php if(isset($po[0]->status) && $po[0]->status=="draft"){echo"selected";} ?>>Draft</option>
				  <option value="assigned_for_pickup" <?php if(isset($po[0]->status) && $po[0]->status=="assigned_for_pickup"){echo"selected";} ?>>Assigned for pickup</option>
                  <option value="delivered" <?php if(isset($po[0]->status) && $po[0]->status=="delivered"){echo"selected";} ?>>Delivered</option>
                  <option value="in-transit" <?php if(isset($po[0]->status) && $po[0]->status=="in-transit"){echo"selected";} ?>>In-Transit</option>
                </select>
              </div>
              </div>
              
            </div><br/>
		
            <br/>
           

            <br/>
            <h4 class="box-title text-dark">Add Items </h4>
            <hr class="my-15">
            
			@if(!empty($po_item) && count($po_item)>0)
			@foreach($po_item as $ik=>$items)
			<div class="row">
			<div class="col-md-4">
              	<label>Item Type</label>
                <div class="input-group">
                <select name="itemtype[]" aria-controls="project-table" class="form-control form-control-sm" onchange="get_item(this)"required>
					<option value="">Select</option>
                    <option value="simple_product" <?php if(isset($items->product_type) && $items->product_type=="simple_product"){echo"selected";} ?>>Simple Product</option>
					<option value="variable_product" <?php if(isset($items->product_type) && $items->product_type=="variable_product"){echo"selected";} ?>>Variable Product</option>
                </select>
              </div>
              </div>
			  <?php 
			  if($items->product_type=='variable_product')
			  $item_sku_code = $items->item_sku.'_'.$items->item_id.'_'.$items->item_variance_id;
			  else
			  $item_sku_code = $items->sku.'_'.$items->item_id;
			  $item = isset($items->product_type)?get_product_list_type_wise($items->product_type):array();?>
              <div class="col-md-4">
              	<label>Select Item</label>
                <div class="input-group">
                <select name="item[]" aria-controls="project-table" class="form-control form-control-sm select2" required>
                    <option value="">Select</option>
					@foreach($item as $k=>$itemss)
					<option value="<?=$k?>" <?php if($item_sku_code == $k){echo"selected";}?>><?=$itemss?></option>
					@endforeach
                </select>
              </div>
              </div>
              <div class="col-md-2">
				<div class="form-group">
				<label>Select Qty..</label>
				<input  type="number"  name="quantity[]" class="form-control form-control-sm" data-bts-button-up-class="btn btn-secondary" value="<?=isset($items->quantity)?$items->quantity:''?>" required> 
				</div>
              </div>
              <div class="col-md-2">
              <div class="pull-right">
              	<label>Action</label>
              	<div class="input-group">
				@if($ik==0)
                <button type="button" class="btn btn-dark btn-sm mb-5" onclick="add_item(this)"><i class="fa fa-plus"></i> &nbsp;Add Item</button>
				@else
					<button type="button" class="btn btn-danger btn-sm mb-5" onclick="remove_item(this)"><i class="fa fa-trash-o"></i> &nbsp;Remove </button>
				@endif
                </div>
          	    </div>
              </div>
            </div>
			<input type="hidden" name="po_item_id[]" value="<?=isset($items->id)?$items->id:''?>">
			
			@endforeach
			@else
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
                <select name="item[]" aria-controls="project-table" class="form-control form-control-sm select2" required>
                    <option value="">Select</option>
				
                </select>
              </div>
              </div>
              <div class="col-md-2">
				<div class="form-group">
								<label>Select Qty</label>
								<input  type="number" value="" name="quantity[]" class="form-control form-control-sm"data-bts-button-up-class="btn btn-secondary" required> </div>
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
			@endif
           <div id="new_item"></div>

          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" name="po_id" value="<?=isset($po[0]->id)?$po[0]->id:''?>">
            <button type="submit" class="btn btn-dark">
              Next Step &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
          </div>  
               
        </div>
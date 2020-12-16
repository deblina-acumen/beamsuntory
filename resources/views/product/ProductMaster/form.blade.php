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
              <div class="col-md-12">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" placeholder="" value= "{{isset($info[0]->name)?$info[0]->name:''}}"  name="product_name" required>
              </div>
              </div>
            </div>
            <div class="row">
			<div class="col-md-4">
              <div class="form-group">
                <label>Product Type</label>
				<select class="form-control select2" name="product_type" onchange="hide_attibute(this)">
				<option  value="">Select</option>
                 <option  value="simple_product" <?php if(isset($info[0]->product_type)&& $info[0]->product_type== 'simple_product'){ echo "selected" ;} ?> >Simple Product</option>
				  <option  value="variable_product" <?php if(isset($info[0]->product_type)&& $info[0]->product_type== 'variable_product'){ echo "selected" ;} ?> >Variable Product</option>
				  </select>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
                <label>Select Brand</label>
                <select class="form-control select2" name="brand" onchange="get_sub_brand(this)" id="brand">
                <option  value="">Select</option>
                @foreach($brand as $brand_value)
				<option value="<?= $brand_value->id?>" <?php if(isset($info[0]->brand_id)&& $info[0]->brand_id == $brand_value->id){ echo "selected" ;} ?> ><?= $brand_value->name?></option>
				@endforeach
                </select>
              </div>
              </div>
			  <div class="col-md-4">
              <div class="form-group">
                <label>Select Sub-brand</label>
                <select class="form-control select2" name="sub_brand" id="sub_brand">
                <option  value="">Select</option>
                @foreach($subbrand as $sub_brand_value)
				<option value="<?= $sub_brand_value->id?>" <?php if(isset($info[0]->sub_brand_id)&& $info[0]->sub_brand_id == $sub_brand_value->id){ echo "selected" ;} ?> ><?= $sub_brand_value->name?></option>
				@endforeach
                </select>
              </div>
              </div>
			  </div>
			   <div class="row">
              <div class="col-md-4">
          <div class="form-group">
          <label>Select Category</label>
          <select class="form-control select2" data-placeholder="Select Category" style="width: 100%;" name="category">
             <option  value="">Select</option>
                @foreach($category as $category_value)
				<option value="<?= $category_value->id?>" <?php if(isset($info[0]->category_id)&& $info[0]->category_id == $category_value->id){ echo "selected" ;} ?> ><?= $category_value->name?></option>
				@endforeach
          </select>
          </div>
              </div>
              <div class="col-md-4">
          <div class="form-group">
          <label>Preferred Vendor</label>
          <select class="form-control select2" data-placeholder="Select Vendor" style="width: 100%;" name="vendor">
			   <option value="">Select</option>
				@foreach($supplier as $supplier_val)
				<option value="<?= $supplier_val->id?>" <?php if(isset($info[0]->supplier_id)&& $info[0]->supplier_id == $supplier_val->id ){ echo "selected" ;} ?> ><?= $supplier_val->supplier_name?></option>
				@endforeach
          </select>
          </div>
              </div>
            </div>
          <div class="row">
		  
		   <div class="col-md-2">
          <div class="form-group">
          <label>Currency</label>
          <select class="form-control select2" data-placeholder="Currency" style="width: 100%;" name="price_currency">
			   <option value="">Select</option>
				<option value="CAD" <?php if(isset($info[0]->price_currency)&& $info[0]->price_currency == 'CAD' ){ echo "selected" ;} ?> >CAD</option>
				<option value="USD" <?php if(isset($info[0]->price_currency)&& $info[0]->price_currency == 'USD' ){ echo "selected" ;} ?> >USD</option>
				
          </select>
          </div>
              </div>
              <div class="col-md-5">
              <div class="form-group">
                <label>Regular Price</label>
                <input type="number" class="form-control" min="0" value= "{{isset($info[0]->regular_price)?$info[0]->regular_price:''}}" step="0.005" placeholder="" name="regular_price">
              </div>
              </div>
			 
              <div class="col-md-5">
              <div class="form-group">
                <label>Retail Price</label>
                <input type="number" class="form-control" min="0" value= "{{isset($info[0]->retail_price)?$info[0]->retail_price:''}}" step="0.005" placeholder="" name="retail_price">
              </div>
              </div>
			  
			  
			 
            </div>
            <div class="row"> 
			 <div class="col-md-4">
              <div class="form-group">
                <label> Image</label>
               <input id="file-input" type="file" name="image" onchange="readURL(this);"/>
			    
					<?php if(isset($info[0]->image) && $info[0]->image!=''){ ?>
					<img src="{{URL('public/product/'.$info[0]->image)}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } else { ?>
					<img src="{{asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } ?>
				
              </div>
              </div>
			</div>
			<div class="row">
			
              <div class="col-md-12">
            <div class="box-body">
              <form>
                <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="product_description">{{isset($info[0]->description)?$info[0]->description:''}}</textarea>
              </form>
            </div>
              </div>
            </div>
            <h4 class="box-title text-dark">General Info</h4>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>SKU</label>
                <input type="text" value= "{{isset($info[0]->sku)?$info[0]->sku:''}}" class="form-control" name="sku" id="primary_sku">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Low Stock Level</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->low_stock_level)?$info[0]->low_stock_level:''}}" name="low_stock_level">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Stock status</label>
				<select class="form-control select2" name="status">
                <option value="in_stock" <?php if(isset($info[0]->status)&& $info[0]->status== 'in_stock'){ echo "selected" ;} ?>>In Stock</option>
				<option value="low_stock" <?php if(isset($info[0]->status)&& $info[0]->status== 'low_stock'){ echo "selected" ;} ?>>Low Stock</option>
				<option value="out_of_stock" <?php if(isset($info[0]->status)&& $info[0]->status== 'out_of_stock'){ echo "selected" ;} ?>>Out Of Stock</option>
				</select>
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Shelf life</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->self_life)?$info[0]->self_life:''}}" name="shelf_life">
              </div>
              </div>
            </div>
            <h4 class="box-title text-dark">Shipping</h4>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>Weight (in gm)</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->weight)?$info[0]->weight:''}}" name="weight">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Length (in cm)</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->length)?$info[0]->length:''}}" name="length">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Width (in cm)</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->width)?$info[0]->width:''}}" name="Width">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Height (in cm)</label>
                <input type="text" class="form-control" value= "{{isset($info[0]->height)?$info[0]->height:''}}"  name="Height">
              </div>
              </div>
            </div>
			<div id="Attributes">
            <h4 class="box-title text-dark">Attributes</h4>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-4">
              <div class="dataTables_length" id="project-table_length">
                <div class="input-group">
               <select class="form-control select2" multiple="multiple" aria-controls="project-table" class="form-control form-control-sm" id="attribute">
                  <option value="Select Product Attributes">Select Product Attributes</option>
				 
                  @foreach($product_attribute as $attribute)
				   <option value="<?= $attribute->id ?>"><?= $attribute->name ?></option>
				  @endforeach
                </select>
                &nbsp;<button type="button" class="btn btn-default btn-sm" onclick="add_attribute()">Add</button>
              </div>
              </div>
              </div>
              <div class="col-md-8">
                &nbsp;
              </div>
            </div>
            <hr class="my-15">                  
            <div class="row">
			<div class="col-md-6"><div class="pull-left"><h4 class="box-title text-dark">Variations</h4></div></div>
         
			</div>
			<br/>
			</div>
			<!------ variation edit --->
			
			<!-------- variation edit -------->
           <div id="variation_div"></div>
			<input type="hidden" value="{{isset($info[0]->id)?$varience_count:0}}" id="variation_count" name="variation_count">
            <br/>
            
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" name="id" value="{{isset($id)?$id:''}}" >
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save Product 
            </button>
          </div>  
		  </div>
         
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
                <label> Name *</label>
                <input type="text" class="form-control" placeholder="Category Name" name="product_category_name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>
			  
			   <div class="col-md-6">
              <div class="form-group">
                <label>Parent Category *</label>
                <select class="form-control" name="parent_id">
                <option value="">Select</option>
                <?php if(isset($product_categoryList)&&!empty($product_categoryList)&&count($product_categoryList)>0){
					foreach($product_categoryList as $product_categoryList)
					{					
					?>
					<option value="{{$product_categoryList->id}}" <?php if(isset($info[0]->parent_id)&& $info[0]->parent_id !='' &&  $info[0]->parent_id == $product_categoryList->id) { echo "selected" ; } ?>>{{$product_categoryList->name}}</option>
				<?php }} ?>
                </select>
              </div>
              </div>
			 
			   <div class="col-md-6">
              <div class="form-group">
                <label>Description *</label>
                <textarea class="form-control" name="description"><?=isset($info[0]->description)?$info[0]->description:''?></textarea>
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
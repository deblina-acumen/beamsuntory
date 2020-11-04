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
                <input type="text" class="form-control" placeholder="Username">
              </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
              <div class="form-group">
                <label>Select Brand</label>
                <select class="form-control select2">
                <option>Select</option>
                <option>Brand A</option>
                <option>Brand B</option>
                </select>
              </div>
              </div>
              <div class="col-md-4">
          <div class="form-group">
          <label>Select Category</label>
          <select class="form-control select2" multiple="multiple" data-placeholder="Select Category"
              style="width: 100%;">
            <option>Tshirt</option>
            <option>Polo T</option>
            <option>Shirts</option>
            <option>Keychains</option>
            <option>Glass</option>
            <option>Watches</option>
            <option>Bags</option>
          </select>
          </div>
              </div>
              <div class="col-md-4">
          <div class="form-group">
          <label>Preferred Vendor</label>
          <select class="form-control select2" multiple="multiple" data-placeholder="Select Vendor"
              style="width: 100%;">
            <option>Vendor A</option>
            <option>Vendor B</option>
            <option>Vendor C</option>
            <option>Vendor D</option>
            <option>Vendor E</option>
            <option>Vendor F</option>
            <option>Vendor G</option>
          </select>
          </div>
              </div>
            </div>
          <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Regular Price</label>
                <input type="text" class="form-control" placeholder="Username">
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>Retail Price</label>
                <input type="text" class="form-control" placeholder="Username">
              </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
            <div class="box-body">
              <form>
                <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Low Stock Level</label>
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Stock status</label>
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Shelf life</label>
                <input type="text" class="form-control">
              </div>
              </div>
            </div>
            <h4 class="box-title text-dark">Shipping</h4>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <label>Weight</label>
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Length</label>
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Width</label>
                <input type="text" class="form-control">
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Height</label>
                <input type="text" class="form-control">
              </div>
              </div>
            </div>
            <h4 class="box-title text-dark">Attributes</h4>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-4">
              <div class="dataTables_length" id="project-table_length">
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Select Product Attributes</option>
                  <option value="25">Size</option>
                  <option value="50">Color</option>
                </select>
                &nbsp;<button type="button" class="btn btn-default btn-sm">Add</button>
              </div>
              </div>
              </div>
              <div class="col-md-8">
                &nbsp;
              </div>
            </div>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-4"><h5>Color</h5></div>
              <div class="col-md-8">
          <div class="form-group">
          <label>Select Values</label>
          <select class="form-control select2" multiple="multiple" data-placeholder="Select Color"
              style="width: 100%;">
            <option>Black</option>
            <option>Red</option>
            <option>Blue</option>
            <option>Green</option>
            <option>Yellow</option>
            <option>Pink</option>
            <option>White</option>
          </select>
          </div>
          <button type="button" class="btn btn-default btn-sm">Select All</button>
          <button type="button" class="btn btn-default btn-sm">Select None</button>
          <button type="button" class="btn btn-default btn-sm">Add New</button>
          <div class="pull-right"><button type="button" class="btn btn-default btn-sm">Remove</button></div>
              </div>
            </div>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-4"><h5>Size</h5></div>
              <div class="col-md-8">
          <div class="form-group">
          <label>Select Values</label>
          <select class="form-control select2" multiple="multiple" data-placeholder="Select Size"
              style="width: 100%;">
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
          </select>
          </div>
          <button type="button" class="btn btn-default btn-sm">Select All</button>
          <button type="button" class="btn btn-default btn-sm">Select None</button>
          <button type="button" class="btn btn-default btn-sm">Add New</button>
          <div class="pull-right"><button type="button" class="btn btn-default btn-sm">Remove</button></div>
              </div>
            </div>
            <br/>
            <button type="button" class="btn btn-default btn-sm">Save Attributes</button>
            <br/>
            <hr class="my-15">
            <div class="row">
          <div class="col-md-6"><div class="pull-left"><h4 class="box-title text-dark">Variations</h4></div></div>
          <div class="col-md-6"><div class="pull-right"><button type="button" class="btn btn-dark btn-sm">Generate All Variations</button></div></div>
        </div>
        <br/>
            <div class="row">
              <div class="col-md-3">
                <label>Select Color</label>
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Black</option>
                  <option value="25">Red</option>
                  <option value="50">Blue</option>
                </select>
                </div> 
              </div>
              <div class="col-md-3">
                <label>Select Size</label>
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">S</option>
                  <option value="25">L</option>
                  <option value="50">XL</option>
                </select>
                </div>
              </div>
              <div class="col-md-3">
                <label>SKU</label>
                <div class="input-group">
                  <input type="text" class="form-control"  placeholder="BST78MXLORG">
                <button type="button" class="btn btn-light btn-sm">Generate SKU</button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="pull-right">
                                    <label>Action</label>
                <div class="input-group">
                  <button type="button" class="btn btn-danger btn-sm">Remove Variation</button>
                </div>
                </div>
              </div>
            </div>
            <hr class="my-15">
            <div class="row">
              <div class="col-md-3">
                <label>Select Color</label>
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Black</option>
                  <option value="25">Red</option>
                  <option value="50">Blue</option>
                </select>
                </div> 
              </div>
              <div class="col-md-3">
                <label>Select Size</label>
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">S</option>
                  <option value="25">L</option>
                  <option value="50">XL</option>
                </select>
                </div>
              </div>
              <div class="col-md-3">
                <label>SKU</label>
                <div class="input-group">
                  <input type="text" class="form-control">
                <button type="button" class="btn btn-dark btn-sm">Generate SKU</button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="pull-right">
                                    <label>Action</label>
                <div class="input-group">
                  <button type="button" class="btn btn-danger btn-sm">Remove Variation</button>
                </div>
                </div>
              </div>
            </div>
            <br/>
            <button type="button" class="btn btn-default btn-sm">Add Variation</button>
            <br/><br/>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save Product
            </button>
          </div>  
		  </div>
         
<div class="box-body" style="border-radius:0;">
@if (session('error-msg'))
					  <div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h6><i class="icon fa fa-ban"></i> {{session('error-msg')}}</h6>
						
					  </div>
					  @endif
              <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Brand Name *</label>
                <input type="text" class="form-control" placeholder="Brand" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>
			   <div class="col-md-6">
              <div class="form-group">
                <label> Image</label>
               <input id="file-input" type="file" name="image" onchange="readURL(this);"/>
			    <label for="file-input">
					<?php if(isset($info[0]->image) && $info[0]->image!=''){ ?>
					<img src="{{URL('public/brandMaster/'.$info[0]->image)}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } else { ?>
					<img src="{{asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
					<?php } ?>
				</label>
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
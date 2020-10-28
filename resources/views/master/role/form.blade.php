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
                <label>Name *</label>
                <input type="text" class="form-control" placeholder="Username" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>Parent Role </label>
                <select  class="form-control" name="parent_id">
				<option value="">Select</option>
				@if(!empty($roleList) && count($roleList)>0)
				@foreach($roleList as $role)
				<option value="<?= $role->id ?>" <?php if(isset($info[0]->parent_id) && $role->id==$info[0]->parent_id){echo"selected";} ?>><?= $role->name ?></option>
				@endforeach
				@endif
				</select>
              </div>
              </div>
			  <div class="col-md-6">
              <div class="form-group">
                <label>Description</label>
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
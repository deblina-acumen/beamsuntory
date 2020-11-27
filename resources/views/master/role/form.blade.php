<div class="box-body" style="border-radius:0;">
@if (session('error-msg'))
					  <div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h6><i class="icon fa fa-ban"></i> {{session('error-msg')}}</h6>
						
					  </div>
					  @endif
              <div class="row">
			  <!-- role -->
              <div class="col-md-6">
              <div class="form-group">
                <label>Role Name *</label>
                <input type="text" class="form-control" placeholder="Role Name" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>  
			   <!-- parent role -->
              <div class="col-md-6">
              <div class="form-group">
                <label>Select Type(Role/Division) </label>
                <select  class="form-control" name="type">
				<option value="">Select</option>
				<option value="master" <?php if(isset($info[0]->type) && $info[0]->type != ''
				&& strtolower($info[0]->type) == "master"){ echo "selected" ; }  ?>>Master</option>
				<option value="division" <?php if(isset($info[0]->type) && $info[0]->type != ''
				&& strtolower($info[0]->type) == "division"){ echo "selected" ; }  ?>>Division</option>
				<option value="user" <?php if(isset($info[0]->type) && $info[0]->type != ''
				&& strtolower($info[0]->type) == "user"){ echo "selected" ; }  ?>>User</option>
				</select>
              </div>
              </div>
			   <!-- parent role -->
              <div class="col-md-6">
              <div class="form-group">
                <label>Parent Role/Division </label>
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
			  
            </div>
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" id="id" name="id" value="<?=isset($info[0]->id)?$info[0]->id:''?>">
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save
            </button>
          </div>  
</div>
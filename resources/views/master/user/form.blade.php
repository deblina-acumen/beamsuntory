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
                <label>user Name *</label>
                <input type="text" class="form-control" placeholder="" name="userId" required value="<?=isset($info[0]->useId)?$info[0]->useId:''?>">
              </div>
              </div>
              
               <div class="col-md-6">
              <div class="form-group">
                <label>Email *</label>
                <input type="email" class="form-control" placeholder="" name="email" required value="<?=isset($info[0]->email)?$info[0]->email:''?>">
              </div>
              </div>
              
			  <div class="col-md-6">
              <div class="form-group">
                <label>First Name *</label>
                <input type="text" class="form-control" placeholder="" name="name" required value="<?=isset($info[0]->name)?$info[0]->name:''?>">
              </div>
              </div>
			  
			  <div class="col-md-6">
              <div class="form-group">
                <label>Last Name *</label>
                <input type="text" class="form-control" placeholder="" name="lastname" required value="<?=isset($info[0]->lastname)?$info[0]->lastname:''?>">
              </div>
              </div>
			  
			  
			  <div class="col-md-6">
                            <div class="form-group">
                                <label>Password*</label>
								 <input type="text" name="password" class="form-control" value="" id="password" <?php if(isset($info[0]->id)&& $info[0]->id!=''){ ?> <?php } else { ?>required <?php }?> >
                                        
                            </div>
                        </div> 						

		  <div class="col-md-6">
                            <div class="form-group">
                                 <label>&nbsp;</label>
                                 <button type="button"  class="btn btn-warning" onclick="generate_password()">  &nbsp; Generate
                                 </button>
                                        
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
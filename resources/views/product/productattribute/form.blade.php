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
                <label>Attribute Name </label>
                <input type="text" class="form-control" name="attr_name" value="{{isset($info[0]->name)?$info[0]->name:''}}" required placeholder="Attribute name">
              </div>
              </div>
            </div>
            
            <h4 class="box-title text-dark">Attributes value</h4>
           
            <hr class="my-15">
			<?php if(isset($id)&& $id!=''){ 
			$attr_val = isset($info[0]->value)?explode(',',$info[0]->value):array() ;
			foreach($attr_val as $k=>$attr_val_val)
			{
			?>
				<div class="row" id="div_{{$k}}_{{$k}}">
              
              <div class="col-md-12">
          <div class="form-group">
          <label> Values</label>
         <input type="text" class="form-control" name="attr_val[]" value="{{$attr_val_val}}" required placeholder="Attribute values">
          </div>
         <?php if($k==0){ ?>
          <div class="pull-right"><button type="button" class="add_field_button1 btn btn-default btn-sm">Add</button></div>
		 <?php } else { ?>
		 <div class="pull-right"><button type="button" onclick="remove_div('div_{{$k}}_{{$k}}')" class="add_field_button1 btn btn-danger btn-sm">Remove</button></div>
		 <?php } ?>
              </div>
            </div>
				
			<?php } }else{ ?>
            <div class="row" id="div_1">
              
              <div class="col-md-12">
          <div class="form-group">
          <label> Values</label>
         <input type="text" class="form-control" name="attr_val[]" required placeholder="Attribute values">
          </div>
         
          <div class="pull-right"><button type="button" class="add_field_button1 btn btn-default btn-sm">Add</button></div>
              </div>
            </div>
			<?php } ?>
			<!-- add row section --->
			
			<!-- add row section -->
			<div class="input_fields_wrap"></div>
			<!--- add row section -->
            <br>
          <!-- /.box-body -->
          <div class="box-footer">
		  <input type="hidden" id="id" name="id" value="<?=isset($info[0]->id)?$info[0]->id:''?>">
            <button type="submit" class="btn btn-dark">
              <i class="ti-save-alt"></i> &nbsp; Save Product
            </button>
          </div> 
</div>
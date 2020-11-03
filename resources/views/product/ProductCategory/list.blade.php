@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- Data Table-->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
	<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-extend.css')}}">
<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">
<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/css/skins/_all-skins.css')}}">

@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Produt-Category List  &nbsp;<a href="{{URL('add-Produt-Category')}}" type="button" class="btn btn-dark btn-sm"> Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        
        <li class="breadcrumb-item active">Produt-Category List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Action Elements -->
         <!--  <div class="row mb-10">
            <div class="col-sm-12 col-md-9">
              <div class="dataTables_length" id="project-table_length">
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Bulk Action</option>
                  <option value="25">Edit</option>
                  <option value="50">Delete</option>
                </select>
                &nbsp;<button type="button" class="btn btn-default btn-sm">Apply</button>
              </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="input-group">
                <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="project-table">
              &nbsp;<button type="button" class="btn btn-default btn-sm">Search</button>
            </div>
            </div>
          </div> -->
		
	  <div class="row">
        <div class="col-12">         
         <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h3 class="box-title">Product Category List</h3>
			  
			  <div class="box-controls pull-right">
                 <!--<button id="row-count" class="btn btn-xs btn-primary">Row count</button>-->
              </div>
            </div>
			
            <!-- /.box-header -->
            <div class="box-body">
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
				<div class="table-responsive">
				  <table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Parent Category</th>
							<th>Description</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					@if(!empty($info) && count($info)>0)
					@foreach($info as $k=>$tlist)
						<tr>
							<td>{{isset($tlist->name)?$tlist->name:''}}</td>
							<td>{{isset($tlist->parent_id)?get_product_category_by_id($tlist->parent_id):''}}</td>
							<td>{{isset($tlist->description)?$tlist->description:''}}</td>
							 <td>
											<?php											
											if($tlist->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
											href="{{URL('Produt-Category-active/'.base64_encode($tlist->id).'/No')}}" class="label label-success">Active</a> 
											<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
											href="{{URL('Produt-Category-active/'.base64_encode($tlist->id).'/Yes')}}" class="label label-danger">Inactive</a>
											<?php } ?>
											
											
						  </td>
                                            <td>
                                                <div class="custom_btn_group btn-group">
                                                    <button class="btn btn-primary dropdown-toggle"
                                                        type="button" data-toggle="dropdown">&nbsp;</button>
                                                    <div class="dropdown-menu dropdown_menu_rightalign"
                                                        style="margin-left: -42px !important;">                                                  
                                                        <a class="dropdown-item" href="{{URL('edit-Produt-Category/'.base64_encode($tlist->id))}}">Edit</a>
                                                        <a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-Produt-Category/'.base64_encode($tlist->id))}}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
						</tr>
					 @endforeach  
					@endif					 
					</tbody>
					<tfoot>
						
					</tfoot>
				  </table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
       </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop

@section('footer_scripts')
<!-- Sparkline -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/pages/widget-blog.js')}}"></script>
<script src="{{asset('assets/js/pages/list.js')}}"></script>
<!-- SlimScroll -->


<!-- This is data table -->

<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.js')}}"></script>
<script src="{{asset('assets/js/pages/project-table.js')}}"></script>

		<!-- This is data table -->
   
	
	<!-- SoftPro admin for Data Table -->
	
	<script src="{{asset('assets/js/pages/data-table.js')}}"></script>
	

<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>



<!-- SoftPro admin for advanced form element -->
<script src="{{asset('assets/js/pages/advanced-form-element.js')}}"></script>

<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
    });
}

</script>

@stop

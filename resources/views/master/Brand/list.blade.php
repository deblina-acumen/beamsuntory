
@extends('layouts.master')

@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>

@stop
@section('content')
<!-- Content Header (Page header) -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Brand  &nbsp;<a type="button" class="btn btn-dark btn-sm" href="{{URL('add-brand')}}">Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
       
        <li class="breadcrumb-item active">All Brand</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Action Elements -->
         
		
	  <div class="row">
		
		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Brand</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
							@if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
							@if (session('error-msg'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('error-msg')}}</h6>

                            </div>
                            @endif
				<div class="table-responsive">
				 <table id="example2" class="table table-bordered table-striped">
					  <thead>
						<tr>
						  
							<th scope="col">Brand Name</th>
							<th scope="col">Image</th>
							
							<th scope="col">Status</th>
							<th scope="col"></th>
							</tr>
					  </thead>
					  <tbody>
					  @if(!empty($info) && count($info)>0)
						  @foreach($info as $infos)
						<tr>
						 
						  <td>{{$infos->name}}</td>
						  <td> <label for="file-input">
								<img src="{{isset($infos->image) && $infos->image!=''?URL('public/brandMaster/'.$infos->image):asset('assets/images/150x100.png')}}" class="user-image rounded-circle b-2" alt="User Image" id="dvPreview" style="height:110px;width:110px"/>
							  </label>&nbsp;&nbsp;&nbsp; {{$infos->name}}</td>
						  <td>
						  	<?php 
							if($infos->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
							href="{{URL('brand-active/'.base64_encode($infos->id).'/No')}}" class="label label-success">Active</a> 
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
							href="{{URL('brand-active/'.base64_encode($infos->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
											
											
						  </td>
							<td>
											 
								<div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
										
										<a class="dropdown-item" href="{{URL('edit-brand/'.base64_encode($infos->id))}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-brand/'.base64_encode($infos->id))}}">Delete</a>
										
									</div>
								</div>
								 
							</td>

						</tr>
						@endforeach
						@endif
					  </tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> 
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
  </div>
@stop

@section('footer_scripts')
<!-- SoftPro admin App -->
<!-- SoftPro admin App -->
<!-- Sparkline -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/js/pages/data-table.js')}}"></script>
<!-- SoftPro admin for advanced form element -->

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

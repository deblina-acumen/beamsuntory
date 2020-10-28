
@extends('layouts.master')

@section('header_styles')
<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">


<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">


<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">
<!-- owlcarousel-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.theme.default.css')}}">



<style>
ul,
#myUL {
    list-style-type: none;
}

#myUL {
    margin: 0;
    padding: 0;
}

.caret {
    cursor: pointer;
    -webkit-user-select: none;
    /* Safari 3.1+ */
    -moz-user-select: none;
    /* Firefox 2+ */
    -ms-user-select: none;
    /* IE 10+ */
    user-select: none;
}

.caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
}

.caret-down::before {
    -ms-transform: rotate(90deg);
    /* IE 9 */
    -webkit-transform: rotate(90deg);
    /* Safari */
    '
transform: rotate(90deg);
}

.nested {
    display: none;
}

.active {
    display: block;
}

.parent_category {
    background: #3ebfea;
    border: 0px;
    color: #ffffff;
    border-radius: 4px;
    display: block;
    padding: 7px 15px;
}

.custom_carret::before {
    color: #fff;
    position: absolute;
}

.textparent {
    padding-left: 15px;
}

.second_child {
    margin-left: -40px;
}

.second_child li {
    display: block;
    border-bottom: 1px solid #ccc;
    padding: 5px;
}

.second_child li:hover {
    background: #f3f3f3;
}

.custom_tree>li {
    line-height: 24px;
    margin-bottom: 5px;
}
.custom_tree{
    margin-top: 10px !important;
}

/* style for data table menu */
.data-table-tool{
            width:100%;
            /*border:none;*/
	}
    
     .user-mangment-data-table .dataTables_filter{
         white-space: nowrap;
         float: none;
     }
     .user-mangment-data-table .dataTables_filter label{
         display:block;
         text-align: right;
     }
     .user-mangment-data-table .dataTables_filter input.form-control{
         display: inline-block;
         width: auto;
        margin-right: 0;
     }
     .menu-dropdown{
        position: relative;
        z-index: 2;
        width: 100px;
     }
     .menu-dropdown .btn{
        background: transparent;
        border: none;
        font-size:20px;
        padding-left: 0;
     }
     .menu-dropdown button.btn.dropdown-toggle:after{
         display: none;
     }
      /* style for data table menu */
</style>
@stop
@section('content')
<!-- Content Header (Page header) -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Role  &nbsp;<a type="button" class="btn btn-dark btn-sm" href="{{URL('add-role')}}">Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Role</a></li>
        <li class="breadcrumb-item active">All Role</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Action Elements -->
         
		
	  <div class="row">
		
		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Roles</h4>
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
				  <table class="table mb-0">
					  <thead>
						<tr>
						  
							<th scope="col">Name</th>
							<th scope="col">Parent Role</th>
							<th scope="col">Status</th>
							</tr>
					  </thead>
					  <tbody>
					  @if(!empty($info) && count($info)>0)
						  @foreach($info as $infos)
						<tr>
						 
						  <td>{{$infos->name}}</td>
						  <td>{{get_role_by_id($infos->parent_id)}}</td>
						  <td>
						  	<?php 
							if($infos->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
							href="{{URL('role-active/'.base64_encode($infos->id).'/No')}}" class="label label-success">Active</a> 
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
							href="{{URL('role-active/'.base64_encode($infos->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
											
											
						  </td>
							<td>
											 
								<div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
										
										<a class="dropdown-item" href="{{URL('edit-role/'.base64_encode($infos->id))}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-role/'.base64_encode($infos->id))}}">Delete</a>
										
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


<!-- Sparkline -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<script src="{{asset('assets/main/js/pages/widget-blog.js')}}"></script>
<script src="{{asset('assets/main/js/pages/list.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/main/js/template.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/main/js/pages/data-table.js')}}"></script>
<script src="{{asset('assets/main/js/pages/project-table.js')}}"></script>


<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>



<!-- SoftPro admin for advanced form element -->
<script src="{{asset('assets/main/js/pages/advanced-form-element.js')}}"></script>

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

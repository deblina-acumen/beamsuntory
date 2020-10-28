@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-extend.css')}}">

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
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
        User List  &nbsp;<a href="{{URL('add-user')}}" type="button" class="btn btn-dark btn-sm"> Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        
        <li class="breadcrumb-item active">User List</li>
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
              <h4 class="box-title">All User</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive user-mangment-data-table">
                                <table id="example"
                                    class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>                                          
                                            
                                            <th>First Name</th>
											<th>Last Name</th>
											<th>User Name</th>
                                            <th>Email</th>
                                            <!--<th>User Id</th>-->
                                            
											<th>Status</th>
											 <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($info as $k=>$tlist)
                                        <tr>
                                            <td>{{$k+1}}</td>
											<td>{{isset($tlist->first_name)?$tlist->first_name:''}}</td>
											<td>{{isset($tlist->last_name)?$tlist->last_name:''}}</td>
											<td>{{isset($tlist->useId)?$tlist->useId:''}}</td>											
                                            
											<td>{{isset($tlist->email)?$tlist->email:''}}</td>
											
											
                                            <td>
											<?php											
											if($tlist->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" 
											href="{{URL('user-active/'.base64_encode($tlist->userid).'/No')}}" class="label label-success">Active</a> 
											<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" 
											href="{{URL('user-active/'.base64_encode($tlist->userid).'/Yes')}}" class="label label-danger">Inactive</a>
											<?php } ?>
											
											
						  </td>
                                            <td>
                                                <div class="custom_btn_group btn-group">
                                                    <button class="btn btn-primary dropdown-toggle"
                                                        type="button" data-toggle="dropdown">&nbsp;</button>
                                                    <div class="dropdown-menu dropdown_menu_rightalign"
                                                        style="margin-left: -42px !important;">                                                  
                                                        <a class="dropdown-item" href="{{URL('user-edit/'.base64_encode($tlist->userid))}}">Edit</a>
                                                        <a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-user/'.base64_encode($tlist->userid))}}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                      @endforeach  

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
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/js/template.js')}}"></script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.js')}}"></script>
<script src="{{asset('assets/js/pages/project-table.js')}}"></script>


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

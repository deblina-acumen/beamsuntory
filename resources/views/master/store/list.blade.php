@extends('layouts.master')

@section('header_styles')
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">
<!-- theme style -->
<!-- owlcarousel-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>

@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Store List  &nbsp;<a href="{{URL('add-store')}}" type="button" class="btn btn-dark btn-sm"> Add New</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>

        <li class="breadcrumb-item active">Store List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


	  <div class="row">

		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Store</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive user-mangment-data-table">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
											<th>Name</th>
                                            <th>Store Category</th>
											<th>Contact Person</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Country</th>
											<th>State/Province</th>
                                            <th>Zipcode</th>
                                            <th>Status</th>
											<th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($info as $k=>$tlist)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{isset($tlist->store_name)?$tlist->store_name:''}}</td>
											<td>{{isset($tlist->category)?$tlist->category:''}}</td>
											<td>{{isset($tlist->contact_person)?$tlist->contact_person:''}}</td>
											<td>{{isset($tlist->email)?$tlist->email:''}}</td>
											<td>{{isset($tlist->phone)?$tlist->phone:''}}</td>
											<td>{{isset($tlist->country_name)?$tlist->country_name:''}}</td>
											<td>{{isset($tlist->province)?$tlist->province:''}}</td>
											<td>{{isset($tlist->zipcode)?$tlist->zipcode:''}}</td>
                                            <td>
											<?php
											if($tlist->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')"
											href="{{URL('store-active/'.base64_encode($tlist->id).'/No')}}" class="label label-success">Active</a>
											<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')"
											href="{{URL('store-active/'.base64_encode($tlist->id).'/Yes')}}" class="label label-danger">Inactive</a>
											<?php } ?>


						  </td>
                                            <td>
                                                <div class="custom_btn_group btn-group">
                                                    <button class="btn btn-dark dropdown-toggle"
                                                        type="button" data-toggle="dropdown"></button>
                                                    <div class="dropdown-menu dropdown_menu_rightalign"
                                                        style="margin-left: -42px !important;">
                                                        <a class="dropdown-item" href="{{URL('edit-store/'.base64_encode($tlist->id))}}">Edit</a>
                                                        <a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-store/'.base64_encode($tlist->id))}}">Delete</a>
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
<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
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

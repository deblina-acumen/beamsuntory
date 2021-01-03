@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap extend-->
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">
<!-- theme style -->
<!-- owlcarousel-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>

@stop
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
         Warehouse  &nbsp;<a type="button" href="{{URL('add-warehouse')}}" class="btn btn-dark btn-sm">Add New</a>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Warehouse</a></li>

      </ol>
    </section>

    <!-- Main content -->
    <section class="content">



	  <div class="row">

		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Warehouse</h4>
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
						  <th scope="col">Warehouse Name</th>
						  <th scope="col">Warehouse Manager Name</th>
						  <th scope="col">Country</th>
						  <th scope="col">Province</th>
						  <th scope="col">City</th>
						  <th scope="col">Address</th>
						  <th scope="col">Zip</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
						</tr>
					  </thead>
					  <tbody>
					<?php
					 if(isset($info)&&!empty($info)&&count($info)>0)
					{
                       foreach($info as $k=>$infos)
					   {
					?>
						<tr>
						  <td>{{isset($infos->name)?$infos->name :''}}</td>
						  <td>{{isset($infos->users_name)?$infos->users_name :''}}</td>
						  <td>{{isset($infos->country_name)?$infos->country_name :''}}</td>
						  <td>{{isset($infos->province_name)?$infos->province_name :''}}</td>
						  <td>{{isset($infos->city)?$infos->city :''}}</td>
						  <td>{{isset($infos->address)?$infos->address :''}}</td>
						  <td>{{isset($infos->zip)?$infos->zip :''}}</td>
						  <td>
							<?php
							if($infos->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')"
							href="{{URL('warehouse-active/'.base64_encode($infos->id).'/No')}}" class="label label-success">Active</a>
							<?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')"
							href="{{URL('warehouse-active/'.base64_encode($infos->id).'/Yes')}}" class="label label-danger">Inactive</a>
							<?php } ?>
						  </td>
						  <td>
							<div class="custom_btn_group btn-group">
								<button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown"></button>
								<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">

									<a class="dropdown-item" href="{{URL('edit-warehouse'.'/'.base64_encode($infos->id))}}">Edit</a>
									<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('delete-warehouse/'.base64_encode($infos->id))}}">Delete</a>

								</div>
							</div>
						</td>

						</tr>
						<?php
					    }
					}
						?>
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
    <div class="box-body">
                <!-- sample modal content -->
  				<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  					<div class="modal-dialog modal-lg">
  						<div class="modal-content">
  							<div class="modal-header">
  								<h4 class="modal-title" id="myLargeModalLabel">Facility Details</h4>
  								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  							</div>
  							<div class="modal-body">

  							</div>
  							<div class="modal-footer">
  								<!--<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>-->
  							</div>
  						</div>
  						<!-- /.modal-content -->
  					</div>
  					<!-- /.modal-dialog -->
  				</div>
  				<!-- /.modal -->
                <!-- <img src="../../images/model2.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid" /> -->
              </div>
        <div class="box-body">
                <!-- sample modal content -->
  				<div id="facilityModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  					<div class="modal-dialog modal-lg">
  						<div class="modal-content">
  							<div class="modal-header">
  								<h4 class="modal-title" id="myLargeModalLabel">Facility Details</h4>
  								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  							</div>
  							<div class="modal-body-facility">

  							</div>
  							<div class="modal-footer">
  								<!--<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>-->
  							</div>
  						</div>
  						<!-- /.modal-content -->
  					</div>
  					<!-- /.modal-dialog -->
  				</div>
              </div>

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

	 function open_modal(obj,id)
    {
        //alert(obj);
		//alert(id);
        $('.modal-body').empty();
       // $(obj).attr('data-target','#modal-'+id);
      //  $("#myModal").modal("show");

        $.ajax({
            url: '<?php echo URL("supplier-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "facility_id": id,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {

                console.log(data);



                $('.modal-body').append(data);
                $("#myModal").modal("show");


            }

        });

    }

		function open_facility_modal(obj,id)
	{
		$("#myLargeModalLabel").html('Member List');
		$('.modal-body-facility').empty();
		  $.ajax({
            url: '<?php echo URL("facility-details-by-member"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "member_id": id,
				"show_facility":'member',
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {

                console.log(data);



                $('.modal-body-facility').append(data);
                $("#facilityModal").modal("show");


            }

        });
	}


</script>


@stop

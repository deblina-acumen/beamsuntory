@extends('layouts.master')

@section('header_styles')
<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">
<!-- theme style -->
<!-- owlcarousel-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.theme.default.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

@stop
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Region  &nbsp;<a href="{{URL('add-facility')}}"><button type="button" class="btn btn-dark btn-sm"><a href="{{URL('add-region')}}">Add New</a></button>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Region</a></li>
     
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Action Elements -->
          
		
	  <div class="row">
		
		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Region</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				 <table id="example2" class="table table-bordered table-striped">
					  <thead>
						<tr>
						  <!--<th scope="col"><input type="checkbox" id="checkbox_a">
                <label for="checkbox_a" class="block"></label></th>-->
						  <th scope="col">Region Name</th>
						  <th scope="col">Country Name</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
						</tr>
					  </thead>
					  <tbody>
					<?php 
					///t($info ,1);
					if(isset($info)&&!empty($info)&&count($info)>0)
					{
                       foreach($info as $k=>$infos)
					   {
					?>
						<tr>
						  <!--<th scope="row"><input type="checkbox" id="checkbox_aa">
              <label for="checkbox_aa" class="block"></label></th>-->
						  <td>{{isset($infos->name)?$infos->name :''}}</td>
						  <td>{{isset($infos->country_name)?$infos->country_name :''}} </td>
						  <!--<td><?php if($infos->is_active!='Yes'){?>Disabled<?php }else{ ?>Enabled<?php } ?></td>-->
						<td>
								<?php if($infos->is_active=='Yes') { ?> <a  onclick="return confirm('Are you sure want to Inactive ?')" href="{{URL('region/active/'.base64_encode($infos->id).'/No')}}" class="label label-success">Active</a> <?php } else {?> <a  onclick="return confirm('Are you sure want to Active ?')" href="{{URL('region/active/'.base64_encode($infos->id).'/Yes')}}" class="label label-danger">Inactive</a> <?php } ?>
						  </td>
						
						  <td>
							<div class="custom_btn_group btn-group">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">&nbsp;</button>
								<div class="dropdown-menu dropdown_menu_rightalign" style="margin-left: -42px !important;">
									
									<a class="dropdown-item" href="{{URL('edit-region'.'/'.base64_encode($infos->id))}}">Edit</a>

									<!--<a class="dropdown-item"
									data-toggle="modal" 
										href="javascript::void(0)" onclick="open_modal(this,'{{$infos->id}}')">View</a>-->
									
									<!--<a class="dropdown-item"
									data-toggle="modal" 
										href="javascript::void(0)" onclick="open_facility_modal(this,'{{$infos->id}}')">Member Details</a>-->
										
									<a class="dropdown-item" onclick="return confirm('Are you sure want to Delete ?')" href="{{URL('region/delete/'.base64_encode($infos->id).'/Yes')}}">Delete</a>
											
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
  </div>
  <!-- /.content-wrapper -->
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
				<!-- /.modal -->
              <!-- <img src="../../images/model2.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid" /> -->
            </div>	
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
<!---fontawesome online link--->
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
            url: '<?php echo URL("region-details"); ?>',
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
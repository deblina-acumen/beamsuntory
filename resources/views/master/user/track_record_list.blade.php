@extends('layouts.master')
@section('header_styles')

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css')}}">

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/iCheck/all.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.css')}}">

<!-- Bootstrap select -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-select/dist/css/bootstrap-select.css')}}">

<!-- Bootstrap tagsinput -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">

<!-- Bootstrap touchspin -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">

<!-- Theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">

<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

<!--alerts CSS -->
<link href="{{asset('assets/assets/vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<style>
	.error-feedback {
	    width: 100%;
	    margin-top: .25rem;
	    font-size: 80%;
	    color: #dc3545;
	}
	.select2-container--default .select2-selection--multiple .select2-selection__rendered {
        /*height: 32px !important;*/
        overflow-x: auto !important;
    }

	.select2 select2-container select2-container--default {
		width: 100% !important;
	}

	.td-heading {
		background-color: #2b679238;
		width: 45%;
	}

	.td-description {
		background-color: #69beef42;
	}

	/* style for data table menu */
	.data-table-tool {
		width: 100%;
		/*border:none;*/
	}

	.user-mangment-data-table {
		margin-top: -50px;
	}

	.user-mangment-data-table .dataTables_filter {
		white-space: nowrap;
		float: none;
	}

	.user-mangment-data-table .dataTables_filter label {
		display: block;
		text-align: right;
	}

	.user-mangment-data-table .dataTables_filter input.form-control {
		display: inline-block;
		width: auto;
		margin-right: 0;
	}

	.menu-dropdown {
		position: relative;
		z-index: 2;
		width: 100px;
	}

	.menu-dropdown .btn {
		background: transparent;
		border: none;
		font-size: 20px;
		padding-left: 0;
	}

	.menu-dropdown button.btn.dropdown-toggle:after {
		display: none;
	}
	h3 {
	    line-height: 44px;
	    font-size: 18px;
	    padding: 4px;
	    padding-left: 7px;
	}


	.table-overflow{
		overflow: auto;
	}

	.add_more.input_fields_wrap.add .row .add_delete_section_right,
	.add_delete_section_right.addmoradd-btn {
	    position: absolute;
	    top: -3px;
	    right: 14px;
	}

@media (min-width: 576px) {
      .modal-xl {
        width: 90%;
       max-width:1200px;
      }
    }
td.details-control {
    background: url(http://datatables.net/examples/resources/details_open.png) no-repeat center center;
    cursor: pointer;
}

	/* style for data table menu */
	
</style>

@stop
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
        User Management
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">User Management</a></li>
        <li class="breadcrumb-item active">User</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

	<!-- Step wizard -->
	<div class="box box-solid bg-gray">
		<div class="box-header with-border">
			<h3 class="subtitle pull-left"> Track Record List </h3>
			<ul class="box-controls court-controls pull-right">
				<!-- <li><a class="box-btn-close" href="#"></a></li>
              <li><a class="box-btn-slide" href="#"></a></li> -->
				
				
				
			</ul>
		</div>
		<!-- /.box-header -->
		<div class="box-body wizard-content">

			<section class="section_cintent">
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
				<!--- Notice Track List -->
				@if(isset($notice_count) && !empty($notice_count))
					<div class="col-md-12">
					<h3 class="bg-pale-dark (#c8c8c8)">Notice Record List</h3>
					<table  class="table table-bordered  table-hover" id="example211" >
								<thead>
						<tr>
							
							<th>Internal Notice No.</th>
							<th>Notice Date</th>
							<th>Responsibility</th>
							<th>Last Date Of Limitation.</th>
							<th>Brief Description</th>
							<th>Notice Source</th>
							
							<th>Status</th>
							<th>Action</th>
						</tr>
								</thead>
								<tbody>
									
										
					@foreach($notice_count as $notice_count_list)
						<tr>
						
							<td>{{$notice_count_list->internal_notice_no}}</td>
							<td>{{(isset($notice_count_list->internal_notice_date)&& $notice_count_list->internal_notice_date!='')?date('d/m/Y', strtotime($notice_count_list->internal_notice_date)):'N/A'}}</td>
							<td><?php 
							$result = [];
							$result = json_decode($notice_count_list->case_responsibility);
							if(!empty($result)){
								$arr = [];
								foreach($result as $key=>$val){
									$arr[$key] =  get_user_by_id($val->reponsible_person);

								}
								 echo implode(",",$arr);
							}

							?></td>
							
							<td>
							{{(isset($notice_count_list->last_date_of_limitation)&& $notice_count_list->last_date_of_limitation!='')?date('d/m/Y', strtotime($notice_count_list->last_date_of_limitation)):'N/A'}}
							</td>
							<td> <?php echo html_entity_decode($notice_count_list->brif_description); ?></td>
							<td>{{$notice_count_list->notice_source}}</td>
							<!--<td>Last Date of Limitation</td>-->
							<!--<td>Next plan of Action</td>
							<td>Next plan of Action Date</td>-->
							<td>
							
							<?php 

							   $litstatus= $notice_count_list->status;
								if($litstatus == ''){
									echo 'N/A';
								} else {
									 $status = ($litstatus!='')?get_module_name_by_id($litstatus):'N/A'; 
									echo ucwords(str_replace("_"," ",$status));

									
								}
								
								?>
						
								</td>
							<td>
							<?php 
							
							$url_village_id = explode(',',$notice_count_list->village_name);
							$survay_id = explode(',',$notice_count_list->sy_number);
							
							
							$totalid = $notice_count_list->id.','.$url_village_id[0].','.$survay_id[0] ; 
							$encodedtotalid = base64_encode($totalid); 
							
							
								
										 ?>
								<div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle"
										type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign"
										style="margin-left: -42px !important;">
										
										<a class="dropdown-item"
											href="{{URL('litigation-management/notice/view-notice-plan/'.$encodedtotalid)}}">View</a>
										
										
										 
									</div>
								</div>
								
							</td>
						</tr>
						
					  @endforeach
									
								</tbody>
							</table>
					</div>
					@else
					@endif
					<!-- notice track list -->
					<!-- Case track list -->
					@if(isset($case_count) && !empty($case_count))
					<div class="col-md-12">
					<h3 class="bg-pale-dark (#c8c8c8)">Case Record List</h3>
					<table  class="table table-bordered  table-hover" id="example2111" >
								<thead>
						<tr>
							
							<th>Case No.</th>
							<th>Case Date</th>
							<th>Responsibility</th>
							<th>Project Name</th>
							
							<th>Litigation Source</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
								</thead>
								<tbody>
									
										
					@foreach($case_count as $case_count_list)
						<tr>
						
							<td>{{$case_count_list->case_no}}</td>
							<td>{{(isset($case_count_list->created_at)&& $case_count_list->created_at!='')?date('d/m/Y', strtotime($case_count_list->created_at)):'N/A'}}</td>
							<td><?php 
							$result = [];
							$result = json_decode($case_count_list->case_responsibility);
							if(!empty($result)){
								$arr = [];
								foreach($result as $key=>$val){
									$arr[$key] =  get_user_by_id($val->case_name);

								}
								 echo implode(",",$arr);
							}

							?></td>
							<td><?php
                                            if($case_count_list->project_id!=''){
                                                 $project = explode(',',$case_count_list->project_id) ;
                                                    foreach($project as $project_val)
                                                    {
                                                         echo get_project_name_by_ids_string($project_val)."," ;
                                                    }

                                                }

                                            ?>
                                            </td>
							
							
							<td>{{$case_count_list->case_source}}</td>
							
							<td>
							
							<?php 

							   $litstatus= $case_count_list->status;
								if($litstatus == ''){
									echo 'N/A';
								} else {
									 $status = ($litstatus!='')?get_module_name_by_id($litstatus):'N/A'; 
									echo ucwords(str_replace("_"," ",$status));

									
								}
								
								?>
						
								</td>
							<td>
							<?php 
							
							$url_village_id = explode(',',$case_count_list->village_name);
							$survay_id = explode(',',$case_count_list->survey_no);
							 ?>
								<div class="custom_btn_group btn-group">
									<button class="btn btn-primary dropdown-toggle"
										type="button" data-toggle="dropdown">&nbsp;</button>
									<div class="dropdown-menu dropdown_menu_rightalign"
										style="margin-left: -42px !important;">
										<a class="dropdown-item"  href="{{url('litigation-management/court-case/view-court-case-plan?case_id='.base64_encode($case_count_list->id).'&villageid='.base64_encode($url_village_id[0]).'&surveyid='.base64_encode($survay_id[0]))}}">View</a>
											 
									</div>
								</div>
								
							</td>
						</tr>
						
					  @endforeach
									
								</tbody>
							</table>
					</div>
					@else
					@endif
				<!-- action plan list -->
				@if(isset($action_pan) && !empty($action_pan))
					<div class="col-md-12">
					<h3 class="bg-pale-dark (#c8c8c8)">Action Plan Record List</h3>
					<div class="table-overflow">
					<table  class="table table-bordered  table-hover live__scroll" id="exampleacp2111" >
								<thead>
						<tr>
							
							 <th class="live__scroll--box">No.</th>
							<th class="live__scroll--box">Survey No</th>
							<th class="live__scroll--box">Taluk</th>
							<th class="live__scroll--box">Village</th>
							<th class="live__scroll--box">Issue No</th>
							<th class="live__scroll--box">Date Of Action Plan Raised</th>
							<th class="live__scroll--box">Section</th>
							<th class="live__scroll--box">Type</th>
							<th class="live__scroll--box">Description</th>
							<th class="live__scroll--box">Action Required</th>
							<th class="live__scroll--box">Responsibility</th>
							<th class="live__scroll--box">Tentative Completion Date</th>
							<th class="live__scroll--box">Actual Completion Date</th>
							
							<th class="live__scroll--box">Status</th>
							<th class="live__scroll--box">Action</th>
						</tr>
								</thead>
								<tbody>
								<?php if(!empty($action_pan) &&count($action_pan)>0){ 
											foreach($action_pan as $k=>$issuelist){
											if($issuelist->survey_id == -200)
												{
													$issuelistvillage_id = -100 ;
												}else{
													$issuelistvillage_id = get_village_id_bysId($issuelist->survey_id) ;
													
												}
												
												
												$encodecoded_id = base64_encode($issuelist->survey_id.','.$issuelistvillage_id.','.$issuelist->id);
											//status color class
											$span_class='';
											if($issuelist->status == "close")
											{
												$span_class = "label-success";
											}
											else if($issuelist->status == "critical")
											{
												$span_class = "label-danger";
											}
											else if($issuelist->status == "open")
											{
												$span_class = "label-info";
											}
											else if($issuelist->status == "urgent")
											{
												$span_class = "label-warning";
											}	
											//status color class	
												
									?>
                                        <tr>
											<td>{{$k+1}}</td>
											<td>
											
											{{(isset($issuelist->survey_id)&&($issuelist->survey_id!='' && $issuelist->survey_id !=-200))?get_survey_by_id_string($issuelist->survey_id):'N/A'}}</td>
                                            <td>
											{{(isset($issuelist->survey_id)&&($issuelist->survey_id!='' && $issuelist->survey_id !=-200))?get_taluk_by_village_ids_string(get_village_id_bysId($issuelist->survey_id)):'N/A'}}
											
											</td>
											<td>
											{{(isset($issuelist->survey_id)&&($issuelist->survey_id!='' && $issuelist->survey_id !=-200))?get_village_by_id_string(get_village_id_bysId($issuelist->survey_id)):'N/A'}}
											
											</td>
											<td>{{$issuelist->issue_no}}</td>
                                            <td>{{date('d/m/Y',strtotime($issuelist->action_plan_date))}}</td>
                                            <td>{{ucwords(str_replace('-',' ',$issuelist->case_type))}}</td> 
											<td>{{ucwords(str_replace('-',' ',$issuelist->case_sub_type))}}</td>
                                            <td>{{$issuelist->issue_desc}}</td>
											<td>{{$issuelist->action_required}}</td>
											<td>{{get_user_by_id($issuelist->responsibility)}}</td>
                                            <td>{{date('d/m/Y',strtotime($issuelist->tentative_completetion_date))}}</td>
                                            <td>{{date('d/m/Y',strtotime($issuelist->actual_completetion_date))}}</td>
                                            <td><span class="label <?=$span_class?>">{{$issuelist->status}}</span></td>
                                            <td>
                                                <div class="custom_btn_group btn-group">
                                                    <button class="btn btn-primary dropdown-toggle"
                                                        type="button" data-toggle="dropdown">&nbsp;</button>
                                                    <div class="dropdown-menu dropdown_menu_rightalign"
                                                        style="margin-left: -42px !important;">
														<?php if($issuelist->case_type == 'litigation'){ ?>
                                                        <a class="dropdown-item"
                                                            href="{{URL('litigation-management/0/view-action-plan/'.base64_encode($issuelist->id).'/'.$encodecoded_id)}}">View</a>
														<?php } elseif($issuelist->case_type == 'project-approval'){ ?>
															<a class="dropdown-item"
                                                            href="{{URL('project/project-approval/view-action-plan/'.base64_encode($issuelist->id).'/'.$issuelist->case_sub_type.'/trueee')}}">View</a>
														<?php } elseif($issuelist->case_type == 'land-management') { ?>
															<a class="dropdown-item"
                                                            href="{{URL('land-management/view-action-plan/'.base64_encode($issuelist->id).'/'.$issuelist->case_sub_type.'/truee')}}">View</a>
														<?php } else { ?>
														<?php } ?>
                                                      
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
										<?php } } ?>
									
					
									
								</tbody>
							</table>
							</div>
					</div>
					@else
					@endif
				<!-- action plan list -->
				</div>
			</section>
		</div>
		<!-- /.box-body -->
	</div>
	
	
	   
	  
	  </div>
</section>





@stop

@section('footer_scripts')

<!-- Sparkline -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<script src="{{asset('assets/main/js/pages/widget-blog.js')}}"></script>
<script src="{{asset('assets/main/js/pages/list.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
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


<!-- This is data table -->

<script>
var tabl = $('#example211').DataTable();
var tabl1 = $('#example2111').DataTable();
var exampleacp2111 = $('#exampleacp2111').DataTable();

$('#tentative_date').datepicker({
    autoclose: true
});
$('#completion_date').datepicker({
    autoclose: true
});
$('#next_action_date').datepicker({
    autoclose: true
});

$('.to_tentative_datepicker').datepicker({
    autoclose: true
});
$('.from_tentative_datepicker').datepicker({
    autoclose: true
});
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();

	
//Date picker
$('#tentative_datepicker').datepicker({
    autoclose: true
});
$('.next_action_date').datepicker({
    autoclose: true
});
$('#limitation_date').datepicker({
    autoclose: true
});



// Case Responsible //


</script>
@stop
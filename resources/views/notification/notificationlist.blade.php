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

    .custom_tree {
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

      .notification-collaps .card .card-header{
          background: #ddd;
          padding:0;
      }
      .notification-collaps .card .card-header h5{
          display: block;
          width: 100%;
      }
      .notification-collaps .card .card-header button.btn{
            padding:10px 7px;
            font-size: 16px;
            color: #000;
            width: 100%;
            text-align: left;
            border: none;
            box-shadow: none;
            border-left:4px solid #aeaeae;
      }
      .notification-collaps .card .card-header button.btn i{
          margin-right: 3px;
      }
      .notification-collaps .card .card-body{
          background:#f2f2f2;
      }
	  .card {  margin-bottom: 0.143rem !important; }
</style>
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Notification
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Notification List</a></li>
        
    </ol>
</section>

<section class="content">

    <div class="row">

        <div class="col-12">
            <div class="tab-content">
                <div>
                    <div class="box box-solid bg-gray">
                          <div class="box-header with-border">
                            <h3 class="box-title">Notification</h3>
                            <!-- <h6 class="subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                          </div>
                        <!-- /.box-header -->
                        <div class="box-body">                            
                            <div class="notification-collaps">
                               <div id="accordion">
							   <!-- accodian one -->
							   @if(!empty($notification_details) && count($notification_details)>0)
								  <?php $k = 1 ; ?>
							   
                                    <div class="card">
                                        <div class="card-header" id="headingOne<?=$k?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?=$k?>" aria-expanded="true" aria-controls="collapseOne<?=$k?>">
                                             <span class="badge badge-pill badge-primary">{{$count_noti}}</span>New Registration
											  
											 
												<i class="mdi mdi-chevron-right" style="float:right"></i>
                                                </button>
                                            </h5>
                                        </div>
										<!-- all noti list -->
										<div id="collapseOne<?=$k?>" class="collapse" aria-labelledby="headingOne<?=$k?>" data-parent="#accordion">
															<div class="card-body">
															  <div class="media-list media-list-hover">
															   
															   <ul>
															   <?php 
																	foreach($notification_details as $notiky=>$notification_details){
																?>
																<li><i class="mdi mdi-arrow-right-bold"></i><a  href="javascript:void(0)"  onclick="opendetails('{{URL($notification_details->notification_url)}}','{{$notification_details->notification_type}}',{{$notification_details->id}})">{{$notification_details->notification_text}}</a></li>
																<?php }  ?>
																</ul>
																</div>
															</div>
														</div>
                                       
										<!-- all noti list -->
                                    </div>
									
								@endif
																		
                                </div>
                            </div>                      
						 </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="tab-pane pad" id="profile4" role="tabpanel">2</div>
                <div class="tab-pane pad" id="messages4" role="tabpanel">3</div>
            </div>

        </div>

    </div>
</section>
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
function opendetails(url,type,notiId)
{
	//alert(url);
	//alert(type);
	//alert(notiId);
	
	window.open(url,'_blank');
	
 	
	
	
}
</script>

@stop
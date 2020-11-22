@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <!-- Action Elements -->
		
	  <div class="row">
        <div class="col-12">         
         <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h3 class="box-title">PO Details</h3>
			  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="khata_table" class="table table-bordered table-separated">
					<thead>
						<tr>
							<th>Order No.</th>
							<th>Purchase order Status</th>
							<th>Supplier Name</th>
							<th>Warehose Name</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					
						<tr>
							
							<td>test</td>
							<td>test</td>
							<td>test</td>
							<td>test</td>
							<td class="details-control khata_no" khata_no="1"></td>
							</tr>
							<tr>
							<td>test</td>
							<td>test</td>
							<td>test</td>
							<td>test</td>
							<td class="details-control khata_no" khata_no="2"></td>
						</tr>
					
					</tbody>
				  </table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <!-- Control Sidebar -->

  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>



@stop

@section('footer_scripts')
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
<!-- SoftP-->
<script>
var table = $('#khata_table').DataTable();
 table.buttons().container()
        .appendTo( '#khata_table_wrapper .col-md-6:eq(0)' );
		 $('#khata_table tbody').on('click', 'td.details-control', function () {
		var khata_no = $(this).attr("khata_no");
		   var tr = $(this).closest('tr');
       	   $.ajax({
			url: '<?php echo URL("get-allocation-details-per-po-details"); ?>',
			method: "POST",
			dataType: 'html',
            data: {				
				"khata_no":khata_no,
				"_token": "{{ csrf_token() }}",
             },
            success: function(data) {	
				 var row = table.row( tr );				
				 if ( row.child.isShown() ) {
					row.child.hide();
					tr.removeClass('shown');
				}
				else {
				   row.child(data).show(); 
					tr.addClass('shown');
				}
            }
        });
    });
</script>
@stop

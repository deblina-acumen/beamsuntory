@extends('layouts.master')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets/vendor_components/datatable/datatables.min.css')}}"/>
@stop
@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Accept Orders
      </h1>
    </section>

    <!-- Main content -->
    <section class="content mob-container">
		
          <!---- List Item ------>
          <div class="box">
             <div class="box-header no-border bg-dark">
             <h6 class="pull-left">Incoming Stock (#101)</h6>
             <div class="pull-right">
              <a href="#"><i class="fa fa-filter font-size-20 text-secondary" aria-hidden="true"></i></a>
             </div>
             <div class="input-group">
                <input type="search" class="form-control form-control-sm" placeholder="Name, SKU or Category" aria-controls="project-table">
              &nbsp;<button type="button" class="btn btn-blue btn-sm">Search</button>
            </div>
            </div>				
				<div class="box-body p-0">
					<div class="media-list media-list-hover media-list-divided">
						<div class="media media-single m-media">
						  <div class="media-body">
              <div class="pull-left">
                  <img src="img/t.jpg" class="rounded-circle m-td-pic">
              </div>
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2" type="checkbox">
                  <label for="checkbox2"></label>
                  </div>
              </div>
              <h6>Beam Diwali 2020 Orange Polo T-Shirt</h6>
              <small>SKU : JEAM1478747</small>
              <p>Qty: <span class="text-bold">100</span></p>
             <div class="input-group my-10">
                <input type="text" class="form-control form-control-sm" placeholder="Quantity" aria-controls="project-table">
              &nbsp;<button type="button" class="btn btn-dark btn-sm">Allocate</button>
            </div>
              </div>
						</div>

            <div class="media media-single m-media">
              <div class="media-body">
              <div class="pull-left">
                  <img src="img/t.jpg" class="rounded-circle m-td-pic">
              </div>
              <div class="pull-right ml-10">
                  <div class="checkbox checkbox-success">
                  <input id="checkbox2" type="checkbox">
                  <label for="checkbox2"></label>
                  </div>
              </div>
              <h6>Beam Diwali 2020 Orange Polo T-Shirt</h6>
              <small>SKU : JEAM1478747</small>
              <p>Qty: <span class="text-bold">100</span></p>
             <div class="input-group my-10">
                <input type="text" class="form-control form-control-sm" placeholder="Quantity" aria-controls="project-table">
              &nbsp;<button type="button" class="btn btn-dark btn-sm">Allocate</button>
            </div>
              </div>
            </div>



            <div class="media media-single bg-light text-center">
              <div class="media-body">
                <h6>Batch No: B662822</h6>
                <ul class="flexbox flex-justified my-10">
                  <li class="br-1 px-10">
                  <small>Total Items</small>
                  <h6 class="mb-0 text-bold">200</h6>
                  </li>
                  <li class="px-10">
                  <small>Total Boxes</small>
                  <h6 class="mb-0 text-bold">10</h6>
                  </li>
                </ul>
                <div class="flexbox flex-justified ">
                <button type="button" class="btn btn-success btn-lg mt-10">Action A</button>
                <button type="button" class="btn btn-dark btn-lg mt-10">Action B</button>
                </div>
            </div>
					</div>
				</div>
			</div>
      
    
    <!-- /.content -->
  </div>
  </section>
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
function open_modal(obj,id)
    {
        //alert(obj);
		//alert(id);
        $('.modal-body').empty();
       // $(obj).attr('data-target','#modal-'+id);
      //  $("#myModal").modal("show");
        
        $.ajax({
            url: '<?php echo URL("product-details"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "item_id": id,
                "_token": "{{ csrf_token() }}",

            },
            success: function(data) {
                console.log(data);
               
               

                $('.modal-body').append(data);
                $("#myModal").modal("show");

               
            }

        });
	
    }
$('.select2').select2({ width: 'resolve' });
(function() {
	$('#Attributes').css('display','none');
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

</script>
@stop

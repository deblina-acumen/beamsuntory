@extends('layouts.master')
@section('header_styles')
 <!-- Bootstrap select -->
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-select/dist/css/bootstrap-select.css')}}">
  <link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}"> 
 <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/css/master_style.css')}}">  
@stop
@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product  &nbsp;<a type="button" href="{{URL('product-list')}}" class="btn btn-dark btn-sm">All products</a>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{URL('product-list')}}">Products</a></li>
        <li class="breadcrumb-item active">Edit Product</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">	
	  <div class="row">
    <div class="col-lg-12 col-12">
        <div class="box box-solid bg-gray">
        <div class="box-header with-border">
          <h4 class="box-title">Edit Product Info</h4>      
          <ul class="box-controls pull-right">
            <li><a class="box-btn-fullscreen" href="#"></a></li>
          </ul>
        </div>
					<form id="add_development_plan" action="<?= URL('update-product')?>"
						method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<!-- Step 1 -->
						@csrf
						@include('product/ProductMaster/form')
					</form>
			</div> 
		  </div>
      <!-- /.row -->
	  </div>
    </section>
    <!-- /.content -->
  </div>

@stop

@section('footer_scripts')
 <script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script>
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

$(document).ready(function(e)
{
	var product_type = '<?php echo $info[0]->product_type ; ?>';
	if(product_type=='simple_product')
	{
		$('#Attributes').css('display','none');
	}else{
		$('#Attributes').css('display','block');
	}
	
	var attribute  = '';
	var product_id  = '<?php echo $id ; ?>';
	var variation_count  = 0;
	
	$.ajax({
            url: '<?php echo URL("get-attribute-detsils"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "attribute": attribute,"variation_count":variation_count,"product_id":product_id,
				 "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                
                $('#variation_div').append(data);
                //var count = parseInt(variation_count)+parseInt(1);
				//$('#variation_count').val(count);
               
            }

        });
	
	
	
	
})

function add_attribute()
{
	var attribute  = $('#attribute').val();
	var variation_count  = $('#variation_count').val();
	
	$.ajax({
            url: '<?php echo URL("get-attribute-detsils"); ?>',
            method: "POST",
            dataType: 'html',
            data: {
                "attribute": attribute,"variation_count":variation_count,
				 "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                
                $('#variation_div').append(data);
                var count = parseInt(variation_count)+parseInt(1);
				$('#variation_count').val(count);
               
            }

        });
}
function remove_variation(obj)
{
	var variation_count  = $('#variation_count').val();
	$(obj).parent().parent().parent().parent().remove();
	 var count = parseInt(variation_count)-parseInt(1);
	$('#variation_count').val(count);
}
function hide_attibute(obj)
{
	var type= $(obj).val();
	if(type == 'simple_product')
	{
		$('#Attributes').css('display','none');
		$('#Attributes').hide();
	}
	else
	{
		$('#Attributes').css('display','block');
		$('#Attributes').show();
	}
}

function genarate_sku(obj)
{
	var type= $(obj).val();
	var primary_sku = $('#primary_sku').val();
	if(primary_sku !='')
	{
	var newSKU_code =primary_sku;
	$(obj).parent().parent().parent().children().each(function(e){
		var classtxt =($(this).children().children().attr('class'));
		if(classtxt=='form-control form-control-sm')
		{
			var attribute_value = ($(this).children().children().val());
			var attribute_value_substr = attribute_value.substring(0, 3);
			newSKU_code = newSKU_code + '-'+ attribute_value_substr;
		}
	});
	$(obj).prev().val(newSKU_code);
	}
	else
	{
		alert("Please provide product SKU code first");
	}
}
function remove_sku(id)
{
	$('#sku'+id).val('');
}
</script>
<script>
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#dvPreview')
                        .attr('src', e.target.result)
                        .width(110)
                        .height(110);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
function get_sub_brand(obj)
{
	var brand_id = $(obj).val(); 

 $.ajax({
		url:'<?php echo URL("get-sub-brand-by-brand-id"); ?>',
		method:"POST",
		dataType: 'json',
		data: {
		"brand_id": brand_id,
        "_token": "{{ csrf_token() }}",
        
        },
		success:function(data)
		{
			$('#sub_brand').html('');
			var html = '<option value="">select </option>';
			if(data.length > 0)
			{
				for(i =0;i < data.length; i++)
				{
					html = html + '<option value="'+data[i]['id']+'">'+data[i]['name'] +'</option>';
					
				}
			}
			$('#sub_brand').html(html);
		}
		
	   });
}
</script>
@stop

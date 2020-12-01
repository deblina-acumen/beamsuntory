@extends('layouts.master')

@section('header_styles')

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">

<!-- Bootstrap 4.1-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">
<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">

@stop
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>

    <!-- Main content -->
     <section class="content mob-container">
<form id="project_list" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
			   @csrf
            <div class="input-group mb-20">
                <input type="search" name="search_category" class="form-control form-control-sm" placeholder="Name, SKU or Category" aria-controls="project-table">
              &nbsp;<button type="submit" class="btn btn-blue btn-sm">Search</button>
            </div>
			</form>

		<div class="row">
		@if(!empty($category)&&count($category)>0)
		@foreach($category as $category_val)

      <div class="col-6">
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xl bg-purple opacity-60 mx-auto">
		  
		  <a href="{{URL('item-list/'.$type.'/'.base64_encode(Auth::user()->role_id).'/'.base64_encode($category_val->id))}}" class="text-center"> 
          <i class="align-sub ti-crown font-size-30"></i>
          </a>
		  
          </span>
          <div class="mt-20">
            <h6 class="text-uppercase fw-500">
			
			{{isset($category_val->name)?$category_val->name:''}}</h6>
            <p>{{get_allocated_product_count_per_user($category_val->id,Auth::user()->id,Auth::user()->role_id,$type)}} items </p>
          </div>
      </div>
      </div>
         @endforeach
		@endif		 


    </div>
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')


@stop

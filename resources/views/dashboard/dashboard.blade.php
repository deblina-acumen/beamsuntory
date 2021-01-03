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
		
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
		
		 <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
		  <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">{{$total_user}}
          <i class="align-sub fa fa-truck font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">Total User</h4>
          </div>
		  
        </div>

        <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">{{$total_product}}
		  
          <i class="align-sub fa fa-truck font-size-40" aria-hidden="true"></i>
         </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">Total Item</h4>
          </div>
        </div>
		
		<div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">{{$total_po}}
		  
          <i class="align-sub fa fa-truck font-size-40" aria-hidden="true"></i>
         </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">Total Po</h4>
          </div>
        </div>
		
		
      
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')


@stop

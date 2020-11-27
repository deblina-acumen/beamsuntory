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

            

		<div class="row">

      <div class="col-6">
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xl bg-purple opacity-60 mx-auto">
          <i class="align-sub ti-crown font-size-30"></i>
          </span>
          <div class="mt-20">
            <h6 class="text-uppercase fw-500">Inventory</h6>
            <p>110 items</p>
          </div>
      </div>
      </div>
      <div class="col-6">
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <a href="{{URL('wh-incomming-stock')}}">
		  <span class="avatar avatar-xl bg-purple opacity-60 mx-auto">
          <i class="align-sub ti-crown font-size-30"></i>
          </span>
          <div class="mt-20">
            <h6 class="text-uppercase fw-500">Incomming Stock</h6>
            <p>110 items</p>
          </div>
		  </a>
      </div>
      </div>
      <div class="col-6">
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xl bg-purple opacity-60 mx-auto">
          <i class="align-sub ti-crown font-size-30"></i>
          </span>
          <div class="mt-20">
            <h6 class="text-uppercase fw-500">Outgoing Stock</h6>
            <p>110 items</p>
          </div>
      </div>
      </div>
        
    </div>
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')


@stop

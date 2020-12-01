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
		<?php if(Auth::user()->role_id==11){ ?>
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
		
		 <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
		 <a href="{{URL('my-stock')}}" class="text-center"> <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </a></span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">MY STOCK </h4>
          </div>
		  
        </div>
		<?php } else { ?>
		  <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
		
		 <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
		 <a href="{{URL('my-stock')}}" class="text-center"> <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </a></span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">View Stock </h4>
          </div>
		  
        </div>
		<?php } ?>
		<?php  if(Auth::user()->role_id==11){ ?>
        <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
		 
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
		  <a href="{{URL('ship-request')}}" class="text-center">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i></a>
          </span>
		  
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">SHIP REQUEST</h4>
          </div>
        </div>
		<?php } else { ?>
		 <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
		 
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto"> <a href="{{URL('store-delivery')}}" class="text-center">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i></a>
          </span>
		  
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">STORE DELIVERY</h4>
          </div>
        </div>
		<?php } ?>
		<?php  if(Auth::user()->role_id==11){ ?>
		 <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">ASSIGN STOCK</h4>
          </div>
        </div>
		<?php } else {?>
		 <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">ASSIGN OWNERSHIP</h4>
          </div>
        </div>
		<?php } ?>
		<?php  if(Auth::user()->role_id==11){ ?><div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">CREATE CUSTOMERS</h4>
          </div>
        </div>
		<?php } else {?>
		<div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">CREATE UESRS</h4>
          </div>
        </div>
		<?php } ?>
		
		<div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">SHARE REQUEST</h4>
          </div>
        </div>
		<div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">RECEIVE REQUEST</h4>
          </div>
        </div>
		
		<?php  if(Auth::user()->role_id==11){ ?>
		
		 <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">
          <i class="align-sub fa fa-file-archive-o font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <h4 class="text-uppercase fw-500">DISPLAY ITEMS</h4>
          </div>
        </div>
		
		<?php } ?>
		
		
		
		
		
		 
		
		
		
		 
      
    </section>
    <!-- /.content -->
  </div>
  
@stop

@section('footer_scripts')


@stop

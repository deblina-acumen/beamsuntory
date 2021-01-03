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
    <section class="content">
      <div class="row">
        <div class="col-md-4">
      <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">

		 <span class="avatar avatar-xxl bg-success opacity-60 mx-auto">
          <i class="fa fa-users align-sub font-size-40" aria-hidden="true"></i>
          </span>
          <div class="mt-20">
            <p class="text-uppercase fw-500">Total User</p>
            <h4 class="text-uppercase fw-500">{{$total_user}}</h4>

          </div>

        </div>
      </div>
<div class="col-md-4">
        <div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-orange opacity-60 mx-auto">

          <i class="align-sub mdi mdi-package font-size-40" aria-hidden="true"></i>
         </span>
          <div class="mt-20">
            <p class="text-uppercase fw-500">Total Item</p>
            <h4 class="text-uppercase fw-500">{{$total_product}}</h4>
          </div>
        </div>
      </div>
<div class="col-md-4">
		<div class="media flex-column text-center p-40 bg-white mb-30 pull-up">
          <span class="avatar avatar-xxl bg-blue opacity-60 mx-auto">

          <i class="align-sub mdi mdi-file-document font-size-40" aria-hidden="true"></i>
         </span>
          <div class="mt-20">
            <p class="text-uppercase fw-500">Total PO</p>
            <h4 class="text-uppercase fw-500">{{$total_po}}</h4>
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

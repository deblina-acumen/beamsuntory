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
        Manage Warehouse  &nbsp;<button type="button" class="btn btn-dark btn-sm">Add New</button>
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Warehouse</a></li>
        <li class="breadcrumb-item active">All Warehouses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Action Elements -->
          <div class="row mb-10">
            <div class="col-sm-12 col-md-9">
              <div class="dataTables_length" id="project-table_length">
                <div class="input-group">
                <select name="project-table_length" aria-controls="project-table" class="form-control form-control-sm">
                  <option value="10">Bulk Action</option>
                  <option value="25">Edit</option>
                  <option value="50">Delete</option>
                </select>
                &nbsp;<button type="button" class="btn btn-default btn-sm">Apply</button>
              </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="input-group">
                <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="project-table">
              &nbsp;<button type="button" class="btn btn-default btn-sm">Search</button>
            </div>
            </div>
          </div>
		
	  <div class="row">
		
		<div class="col-12">
          <div class="box box-solid bg-gray">
            <div class="box-header with-border">
              <h4 class="box-title">All Warehouses</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table class="table mb-0">
					  <thead>
						<tr>
						  <th scope="col"><input type="checkbox" id="checkbox_a">
                <label for="checkbox_a" class="block"></label></th>
						  <th scope="col">Warehouse Name</th>
						  <th scope="col">Warehouse Manager</th>
						  <th scope="col">Creation Date</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
						</tr>
					  </thead>
					  <tbody>
						<tr>
						  <th scope="row"><input type="checkbox" id="checkbox_aa">
              <label for="checkbox_aa" class="block"></label></th>
						  <td>NYC Warehouse</td>
						  <td>Mark Muller</td>
						  <td>Nov 12, 2019 4:38 am</td>
              <td>Enabled</td>
              <td><button type="button" class="btn btn-dark btn-sm">Manage</button></td>

						</tr>
						<tr>
						  <th scope="row"><input type="checkbox" id="checkbox_aaa">
                <label for="checkbox_aaa" class="block"></label></th>
						  <td>California</td>
              <td>Tim Todd</td>
              <td>Nov 12, 2019 4:38 am</td>
              <td>Enabled</td>
              <td><button type="button" class="btn btn-dark btn-sm">Manage</button></td>
						</tr>
						<tr>
						  <th scope="row"><input type="checkbox" id="checkbox_aaaa">
                <label for="checkbox_aaaa" class="block"></label></th>
						  <td>New Delhi</td>
              <td>Rakesh Kumar</td>
              <td>Nov 12, 2019 4:38 am</td>
              <td>Disabled</td>
              <td><button type="button" class="btn btn-secondary btn-sm">Manage</button></td>
						</tr>
					  </tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> 
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop

@section('footer_scripts')


@stop

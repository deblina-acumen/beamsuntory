<!-- Left side column. contains the logo and sidebar -->
  <?php $menue = Request::segment(1);?>
  <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
      
      <!-- sidebar menu-->
	 <?php if(Auth::user()->role_id == 1) { ?>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header nav-small-cap">JIMBEAM WHMS</li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-city"></i> <span>WareHouse</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('manager-list')}}"><i class="fa fa-circle-thin"></i>All Managers</a></li>
            <li><a href="{{URL('add-warehouse-manager')}}"><i class="fa fa-circle-thin"></i>Add Manager</a></li>
            <li><a href="{{URL('warehouse-list')}}"><i class="fa fa-circle-thin"></i>All Warehouses</a></li>
            <li><a href="{{URL('add-warehouse')}}"><i class="fa fa-circle-thin"></i>Add Warehouse</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-file-document"></i> <span>Purchase Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('purchase-order-list')}}"><i class="fa fa-circle-thin"></i>All orders</a></li>
            <li><a href="{{URL('add-po-step1')}}"><i class="fa fa-circle-thin"></i>Add New Order</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-package"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('product-list')}}"><i class="fa fa-circle-thin"></i>All Products</a></li>
            <li><a href="{{URL('add-product')}}"><i class="fa fa-circle-thin"></i>Add New</a></li>
            <li><a href="{{URL('product-category-list')}}"><i class="fa fa-circle-thin"></i>Product Categories</a></li>
            <li><a href="{{URL('Produt-attribute-list')}}"><i class="fa fa-circle-thin"></i>Attributes</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-store"></i> <span>Stores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('store-list')}}"><i class="fa fa-circle-thin"></i>All Stores</a></li>
            <li><a href="{{URL('add-store')}}"><i class="fa fa-circle-thin"></i>Add New</a></li>
            <li><a href="{{URL('store-category-list')}}"><i class="fa fa-circle-thin"></i>Store Categories</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-trophy"></i> <span>Brands</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('brand-list')}}"><i class="fa fa-circle-thin"></i>All Brands</a></li>
            <li><a href="{{URL('add-brand')}}"><i class="fa fa-circle-thin"></i>Add New Brand</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-google-maps"></i> <span>Regions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('region-master-list')}}"><i class="fa fa-circle-thin"></i>All Regions</a></li>
            <li><a href="{{URL('add-region')}}"><i class="fa fa-circle-thin"></i>Add New Region</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Supplier</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('supplier-master-list')}}"><i class="fa fa-circle-thin"></i>All Suppliers</a></li>
            <li><a href="{{URL('add-supplier')}}"><i class="fa fa-circle-thin"></i>Add New Supplier</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="mdi mdi-account-settings"></i> <span>Roles/Division</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('role-list')}}"><i class="fa fa-circle-thin"></i>All Roles/Division</a></li>
            <li><a href="{{URL('add-role')}}"><i class="fa fa-circle-thin"></i>Add Roles/Division</a></li>
			<li><a href="{{URL('role-user-list')}}"><i class="fa fa-circle-thin"></i>All Users</a></li>
            <li><a href="{{URL('add-role-user')}}"><i class="fa fa-circle-thin"></i>Add New User</a></li>
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Delivery Agent</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('delivery-agent-list')}}"><i class="fa fa-circle-thin"></i>All Delivery Agents</a></li>
            <li><a href="{{URL('add-delivery-agent')}}"><i class="fa fa-circle-thin"></i>Add New Delivery Agent</a></li>
          </ul>
        </li>	
		
		<li class="treeview">
         
         
            <li><a href="{{URL('view-stock')}}"><i class="fa fa-circle-thin"></i>Jim Beam Stock</a></li>
            
         
        </li>
	  


		
      </ul>
	    
	 <?php } elseif(Auth::user()->role_id == 10) { ?>
	  
		<ul class="sidebar-menu" data-widget="tree">
        <li class="header nav-small-cap">JIMBEAM Delivery Agent</li>
		
		 <li><a href="{{URL('pickup-order-list')}}"><i class="align-sub fa fa-truck"></i>Pickup Order</a></li>
            <li><a href="<?=URL('delivery-order-list')?>"><i class="align-sub fa fa-truck"></i>Delivery Order</a></li>
		
		</ul>
	 <?php } elseif(Auth::user()->role_id == 11) { ?>
		
		<ul class="sidebar-menu" data-widget="tree">
        <li class="header nav-small-cap">Sales Refs</li>
		
		 <li><a href="{{URL('my-stock')}}"><i class="align-sub fa fa-truck"></i>MY STOCK</a></li>
            <li><a href="<?=URL('ship-request')?>"><i class="align-sub fa fa-truck"></i>SHIP REQUEST</a></li>
		
		
       
		
		 <li><a href="{{URL('assign-ownership/item-list')}}"><i class="align-sub fa fa-truck"></i>ASSIGN STOCK</a></li>
            <li><a href="<?=URL('customer-store-list')?>"><i class="align-sub fa fa-truck"></i>CREATE CUSTOMERS</a></li>
		
       
		
		 <li><a href="{{URL('share-request/item-list')}}"><i class="align-sub fa fa-truck"></i>SHARE REQUEST</a></li>
            <li><a href="<?=URL('receive-request')?>"><i class="align-sub fa fa-truck"></i>RECEIVE REQUEST</a></li>
		
		
		 <li><a href="#"><i class="align-sub fa fa-truck"></i>DISPLAY ITEMS</a></li>
            
		
		</ul>
	 <?php } else { ?>
	 <ul class="sidebar-menu" data-widget="tree">
        <li class="header nav-small-cap">{{get_role_by_id(Auth::user()->role_id)}}</li>
		
		 <li><a href="{{URL('my-stock')}}"><i class="align-sub fa fa-truck"></i>View Stock</a></li>
            <li><a href="<?=URL('store-delivery')?>"><i class="align-sub fa fa-truck"></i>STORE DELIVERY</a></li>
		
		
       
		
		 <li><a href="{{URL('assign-ownership/item-list')}}"><i class="align-sub fa fa-truck"></i>ASSIGN OWNERSHIP</a></li>
            <li><a href="<?=URL('customer-user-list')?>"><i class="align-sub fa fa-truck"></i>CREATE UESRS</a></li>
		
       
		
		<li><a href="{{URL('share-request/item-list')}}"><i class="align-sub fa fa-truck"></i>SHARE REQUEST</a></li>
            <li><a href="<?=URL('receive-request')?>"><i class="align-sub fa fa-truck"></i>RECEIVE REQUEST</a></li>
		
		</ul>
	 <?php } ?>
    </section>
  </aside>
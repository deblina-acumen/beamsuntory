<?php

namespace App\Http\Controllers\po;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Warehouse;
use App\Model\Supplier;
use App\Model\PO;
use App\Model\User;
use App\Model\POItem;
use App\Model\ProductVariations;
use App\Model\Brand;
use App\Model\Region;
use App\Model\Role;
use  App\Model\Country;
use  App\Model\POAllocation;
use Auth;
use DB;
class PoMasterController extends Controller
{
	
	 public function add($id='')
    {
        $data['title']="Purchase Order";
		
		$data['category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();$data['delivery_agent']=$list = User::where('is_deleted','No')->where('is_active','Yes')->where('role_id','10')->orderBy('id','asc')->get();
		$data['product']=$list = Product::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
		//t($data,1);
		if($id=='')
		{
        return view('po.add',$data);
		}
		else
		{
			$id = base64_decode($id);
			$data['po'] = $po = PO::where('id',$id)->get();
			$data['po_item'] = $po_item = POItem::select('purchase_order_details.*','item.name','item.sku','item.product_type')->join('item','item.id','=','purchase_order_details.item_id','left')->where('po_id',$id)->get();
			//t($po);t($po_item);exit;
			return view('po.edit',$data);
		}
    }
	
	
	public function save_po_step1(Request $request)
    {
        $data=$request->all(); //t($data,1);
		
        $insert_data['order_no']=$data['order_no'];
		$insert_data['ownership_type']=$data['ownership_type'];
		$insert_data['status']=$data['status'];
		$insert_data['active_date']=isset($data['active_date']) && $data['active_date']!=''?date('Y-m-d',strtotime($data['active_date'])):'';   
		$insert_data['active_time']=isset($data['active_time']) && $data['active_time']!=''?date('H:i:s',strtotime($data['active_time'])):'';
		$insert_data['supplier_id']=isset($data['supplier'])?$data['supplier']:'';
		$insert_data['delivery_agent_id']=isset($data['delivery_agent'])?$data['delivery_agent']:'';
		$insert_data['warehouse_id']=isset($data['warehouse'])?$data['warehouse']:'';
		$insert_data['remarks']='';
        $insert_data['created_by'] = Auth::user()->id;
        $id=PO::insertGetId($insert_data);
		$variation=array();
		for($i=0;$i<count($data['item']);$i++)
		{
			//t($data['item'][$i]);echo"fffffffffff";
			$item_variance_id = explode('_', $data['item'][$i]); 
			$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
			$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
			$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
			$insert_item['po_id'] = $id;
			$insert_item['quantity'] = $data['quantity'][$i];
			$insert_item['created_by'] = Auth::user()->id;
			POItem::insertGetId($insert_item);
		}
		
        if($id!='')
        {
			
            return redirect('add-po-step2/'.base64_encode($id))->with('success-msg', 'Purchase order successfully added..');
        }
        else			
        {
            return redirect('add-po-step1')->with('error-msg', 'Please try after some time');
        }
    }
	
	public function update_po_steop1(Request $request)
	{
		$data = $request->all();
		//t($data,1);
		$update_data['order_no']=$data['order_no'];
		$update_data['ownership_type']=$data['ownership_type'];
		$update_data['status']=$data['status'];
		$update_data['active_date']=isset($data['active_date']) && $data['active_date']!=''?date('Y-m-d',strtotime($data['active_date'])):'';
		$update_data['active_time']=isset($data['active_time']) && $data['active_time']!=''?date('H:i:s',strtotime($data['active_time'])):'';
		//t($update_data['active_time'],1);
		$update_data['supplier_id']=isset($data['supplier'])?$data['supplier']:'';
		$update_data['delivery_agent_id']=isset($data['delivery_agent'])?$data['delivery_agent']:'';
		$update_data['warehouse_id']=isset($data['warehouse'])?$data['warehouse']:'';
		$update_data['remarks']='';
        $update_data['created_by'] = Auth::user()->id;
        $id=PO::where('id',$data['po_id'])->update($update_data);
		$variation=array();
		$po_item_id = implode(',',array_filter($data['po_item_id']));
		POItem::whereRaw("id not in ($po_item_id)")->delete();
		for($i=0;$i<count($data['item']);$i++)
		{
			if($data['po_item_id'][$i] =="")
			{
			$item_variance_id = explode('_', $data['item'][$i]); 
			$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
			$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
			$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
			$insert_item['po_id'] = $data['po_id'];
			$insert_item['quantity'] = $data['quantity'][$i];
			$insert_item['created_by'] = Auth::user()->id;
			POItem::insertGetId($insert_item);
			}
			else
			{
				$item_variance_id = explode('_', $data['item'][$i]); 
				$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
				$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
				$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
				$insert_item['po_id'] = $data['po_id'];
				$insert_item['quantity'] = $data['quantity'][$i];
				$insert_item['updated_by'] = Auth::user()->id;
				$insert_item['updated_at'] = date('Y-m-d h:i:s');
				POItem::where('id',$data['po_item_id'][$i])->update($insert_item);
			}
		}
		return redirect('add-po-step2/'.base64_encode($data['po_id']))->with('success-msg', 'Purchase order successfully updated..');
	}
	public function get_item_details(Request $request)
	{
		$html = '<option value="">Select</option>';
		$posteddata = $request->all();
		$type = $posteddata['type'];
		$product_list = Product::where('is_deleted','No')->where('is_active','Yes')->where('product_type',$type)->orderBy('name','asc')->get();
		foreach($product_list as $k=>$product)
		{
			$variance = array();
			if($product->product_type == 'variable_product')
			{
				$variance = ProductVariations::where('item_id',$product->id)->where('is_deleted','No')->get();
				foreach($variance as $variancedt)
				{
					$sku = json_decode($variancedt->variation);
					$sku = isset($sku->sku)?$sku->sku:'';
					$html .= '<option value="'.$sku.'_'.$product->id.'_'.$variancedt->id.'">'.$product->name.'-'.$sku.'</option>';
				}
			}
			else
			{
				$html .= '<option value="'.$product->sku.'_'.$product->id.'">'.$product->name.'-'.$product->sku.'</option>';
			}
		}
		echo $html;
	}
	
    public function product_list(Request $request)
    {
		DB::enableQueryLog();
		$posteddata = $request->all();
		//t($posteddata);
		//exit();
        $data['title']="Product category";
		
		$data['product_category_val'] = $product_category_val = isset($posteddata['product_category_val']) ? $posteddata['product_category_val'] : '';
		$data['product_brand'] = $product_brand = isset($posteddata['product_brand']) ? $posteddata['product_brand'] : '';
		$data['product_type'] = $product_type = isset($posteddata['product_type']) ? $posteddata['product_type'] : '';
		$data['product_sku'] = $product_sku = isset($posteddata['product_sku']) ? $posteddata['product_sku'] : '';
		
		$where = '1=1';
		if ($posteddata) {
			
			if ($product_category_val != '') {
				
				$where .= ' and item.category_id='.$product_category_val;
				
							
			}
			if ($product_brand != '') {
				$where .= ' and item.brand_id=' . $product_brand;				
				
			}
			if ($product_type != '') {
				$where .= " and item.product_type='$product_type'";				
								
			}

			if ($product_sku != '') {
				
				$where .= " and lower(item.sku) LIKE '%$product_sku%'";
			}
			
		}
		
        $data['product_list']=$list = Product::select('item.*','brand.name as brand_name','product_category.name as cat_name','supplier_name')->join('product_category','product_category.id','=','item.category_id','left')->join('brand','brand.id','=','item.brand_id','left')->join('supplier','supplier.id','=','item.supplier_id','left')->whereRaw($where)->where('item.is_deleted','No')->orderBy('item.name','asc')->get();
		$data['product_category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//$query = DB::getQueryLog();
		//t($query);
		///exit();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('product.ProductMaster.list',$data);
    }

    
    
    

    


	 public function purchase_order_list(Request $request)
    {

		DB::enableQueryLog();
		$posteddata = $request->all();
		//t($posteddata);
		//exit();
        $data['title']="Purchase Order List";
		
		$data['purchase_order_no_val'] = $purchase_order_no_val = isset($posteddata['purchase_order_no_val']) ? $posteddata['purchase_order_no_val'] : '';
		$data['purchase_order_status_val'] = $purchase_order_status_val = isset($posteddata['purchase_order_status_val']) ? $posteddata['purchase_order_status_val'] : '';
		$data['po_supplier_val'] = $po_supplier_val = isset($posteddata['po_supplier_val']) ? $posteddata['po_supplier_val'] : '';
		$data['po_warehouse_val'] = $po_warehouse_val = isset($posteddata['po_warehouse_val']) ? $posteddata['po_warehouse_val'] : '';
		
		$where = '1=1';
		if ($posteddata) {
			
			if ($purchase_order_no_val != '') {
				
				$where .= " and purchase_order.order_no LIKE '%$purchase_order_no_val%'";	
							
			}
			if ($purchase_order_status_val != '') {
				
				$where .= " and lower(purchase_order.status) LIKE '%$purchase_order_status_val%'";
			}
			if ($po_supplier_val != '') {
				$where .= " and purchase_order.supplier_id='$po_supplier_val'";				
								
			}
			if ($po_warehouse_val != '') {
				$where .= " and purchase_order.warehouse_id='$po_warehouse_val'";				
				
			}

		}
		
		
		$data['purchase_order'] = $list = PO::select('purchase_order.*','supplier.supplier_name','warehouse.name as warehouse_name')->join('supplier','supplier.id','=','purchase_order.supplier_id','left')->join('warehouse','warehouse.id','=','purchase_order.warehouse_id','left')->whereRaw($where)->where('purchase_order.is_deleted','No')->orderBy('purchase_order.id','desc')->get();
		
		
		//$query = DB::getQueryLog();
		//t($query);
		//exit();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('po.list',$data);
    }
	
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=PO::where('id',$id)->update($update_data);
		if($updated)
            return redirect('purchase-order-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('purchase-order-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function delete_purchase($id)
	{
		$id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=PO::where('id',$id)->update($update_data);
        if($updated)
            return redirect('purchase-order-list')->with('success-msg', 'Purchase Order  successfully deleted');
        else
        {
            return redirect('purchase-order-list')->with('error-msg', 'Please try after some time');    
        }
	}
	    public function view(Request $Request)
	 {
		 $data = $Request->all();
		 //t($data,1);
		$profile_pic = $current_date = $description = $active = $cat_name = 
		$userid = $email = $regular_price = $retail_price = $sku = $low_stock_level = 
		$status = $weight = $length = $width = $height = $expire_date = 
		$phone_number = $address = $member = $logo = $name = '';

		
		$info = $list = PO::select('purchase_order.*','supplier.supplier_name','warehouse.name as warehouse_name')->join('supplier','supplier.id','=','purchase_order.supplier_id','left')->join('warehouse','warehouse.id','=','purchase_order.supplier_id','left')->where('purchase_order.is_deleted','No')->
		where('purchase_order.id','=',$data['po_id'])->
		orderBy('purchase_order.id','desc')->get();

			$order_no = isset($info[0]->order_no) ? $info[0]->order_no : '' ;
			$supplier_name = isset($info[0]->supplier_name) ? $info[0]->supplier_name : '' ;
			$warehouse_name = isset($info[0]->warehouse_name) ? $info[0]->warehouse_name : '' ;
			//t($warehouse_name,1);
	


	$html = '
		   <div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <a class="avatar avatar-lg status-success" href="#">
						<img src="'.$profile_pic.'" alt="...">
					  </a>
					  <div class="media-body">
						<p class="font-size-16">
						  <a class="hover-primary" href="#"><strong>'. $name .'</strong></a>
						</p>'.$current_date.'
						 
						<p>'.$description.'</p>
						</div>
					  <div class="media-right">'.$active.'</div>
					  
					</div>					
					
				  </div>
				 
				   <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-striped mb-0">
					  
					  <tbody>
						<tr>
						  <th scope="row"> Order No:</th>
						  <td>'.$order_no.'</td>
						</tr>
						<tr>
						  <th scope="row">  Supplier Name:</th>
						  <td>'.$supplier_name.'</td>
						</tr>
						<tr>
						  <th scope="row"> Warehouse Name:</th>
						  <td>'.$warehouse_name.'</td>
						</tr>
						<tr>
						  <th scope="row">  category Name:</th>
						  <td>'.$cat_name.'</td>
						</tr>
						<tr>
						  <th scope="row">  Price:</th>
						   <td>'.$regular_price.'</td>
						</tr>
						<tr>
						  <th scope="row">  Retail Price:</th>
						   <td>'.$retail_price.'</td>
						</tr>
						<tr>
						  <th scope="row">  SKU:</th>
						   <td>'.$sku.'</td>
						</tr>
						<tr>
						  <th scope="row">  Status:</th>
						   <td>'.$status.'</td>
						</tr>
						<tr>
						  <th scope="row">  Low Stock Level:</th>
						   <td>'.$low_stock_level.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Weight:</th>
						   <td>'.$weight.'</td>
						</tr>
						<tr>
						  <th scope="row">  Length:</th>
						   <td>'.$length.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Width:</th>
						   <td>'.$width.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Height:</th>
						   <td>'.$height.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Expiration Date:</th>
						   <td>'.$expire_date.'</td>
						   
						</tr>';

					  $html .='</tbody>
					</table>
					
				</div>
            </div>' ;
			//$html = '<div>HIIII</div>';
				 echo $html;
	 }
	 
	 	public function purchase_order_details($id)
	{
		$data['title']="Purchase Order Details";
		
		$id= base64_decode($id);
		
		$data['purchase_order'] = $list = PO::select('purchase_order.*','supplier.supplier_name','warehouse.name as warehouse_name')->join('supplier','supplier.id','=','purchase_order.supplier_id','left')->join('warehouse','warehouse.id','=','purchase_order.warehouse_id','left')->where('purchase_order.id',$id)->where('purchase_order.is_deleted','No')->orderBy('purchase_order.id','desc')->get();
		
		
		//$query = DB::getQueryLog();
		//t($query);
		//exit();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('po.po_details',$data);
	}
	
	public function po_products_details($id)
	{
		DB::enableQueryLog();
		$poId= base64_decode($id);
		//t($poId);
		//exit();
		$data['poinfo']=$poinfo =PO::where('id',$poId)->get();
		
		$warehouse_id = isset($poinfo[0]->warehouse_id)?$poinfo[0]->warehouse_id:0 ;
		$data['warehouse']=$warehouse_list = Warehouse::where('id',$warehouse_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//$query = DB::getQueryLog();
		//t($query,1);
		$suppler_id = isset($poinfo[0]->supplier_id)?$poinfo[0]->supplier_id:0 ;
		$data['supplier']= Supplier::where('id',$suppler_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$user_id = isset($warehouse_list[0]->user_id)?$warehouse_list[0]->user_id:0 ;
		//t($user_id,1);
		$data['user']= User::where('id',$user_id)->where('is_deleted','No')->where('is_active','Yes')->get();
		
		$delivery_agent_id = isset($poinfo[0]->delivery_agent_id)?$poinfo[0]->delivery_agent_id:0 ;
		$data['delivery_agent']= User::where('id',$delivery_agent_id)->where('role_id',10)->where('is_deleted','No')->where('is_active','Yes')->get();

		$data['po_details'] = $po_details= POItem::select('purchase_order_details.item_sku','purchase_order_details.quantity','item.name','item.product_type','item.regular_price','item.batch_no','item.expire_date','item.retail_price','item.image','item_variation_details.variation','purchase_order_details.id as puchase_order_details_id','item.id as itemid','item_variation_details.id as varienceid','purchase_order_details.po_id as po_id','purchase_order_details.id as po_details_id')->join('item','item.id','=','purchase_order_details.item_id')->leftjoin('item_variation_details','item_variation_details.id','=','purchase_order_details.item_variance_id')->where('purchase_order_details.po_id',$poId)->get() ;
		
		return view('po.po_product_details',$data);
	}
	public function get_allocation_details_per_po_details(Request $request)
	{
		DB::enableQueryLog();
		$data = $request->all();
		//t($data,1);

		$po_item_podetails_id = $data['khata_no'];
		$po_item_podetails_id = explode('-',$po_item_podetails_id);
		
		
		$data['po_allocationinfo'] = $po_allocationinfo= POAllocation::select('purchase_order_allocation.each_user as po_alloc_each_user','purchase_order_allocation.share_user as po_alloc_share_user','purchase_order_allocation.quantity as po_aloc_quantity','purchase_order_allocation.user as po_allocation_user','user_role.name as user_role_name','country.country_name','provinces.name as provinces_name','brand.name as brand_name')->leftjoin('user_role','purchase_order_allocation.role_id','=','user_role.id')->leftjoin('country','purchase_order_allocation.country_id','=','country.id')->leftjoin('provinces','purchase_order_allocation.region_id','=','provinces.id')->leftjoin('brand','purchase_order_allocation.brand_id','=','brand.id')->where('purchase_order_allocation.po_id',$po_item_podetails_id[0])->where('purchase_order_allocation.item_id',$po_item_podetails_id[1])->where('purchase_order_allocation.podetails_id',$po_item_podetails_id[2])->where('purchase_order_allocation.is_deleted','No')->where('purchase_order_allocation.is_active','Yes')->get() ;
		$data['count_allocation'] = count($po_allocationinfo);
		//print_r($po_allocationinfo[0]->user_role_name);exit();
		//$query = DB::getQueryLog();
		//t($query);exit();
		//t($po_allocationinfo[0]->user_role_name,1);

		$output = '	
		<table id="" class="table table-striped table-bordered bulk_action">
			<thead>
			<tr>
				   
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">User Role</th> 				  
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">Country</th> 
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">Region</th> 
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">Brand</th> 
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">User</th> 
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">Quantity</th> 
				  <th style="background: #1eb16d !important;font-size: 13px; color:#FFF">Share Type</th> 
				

			</tr>
			</thead>
			<tbody>';
			
				if($data['count_allocation']>0){
						for($i=0;$i<count($po_allocationinfo);$i++){
							//t($po_allocationinfo[$i]->user_role_name,1);
							$user_role_name =isset($po_allocationinfo[$i]->user_role_name)?$po_allocationinfo[$i]->user_role_name:'';
							$country_name =isset($po_allocationinfo[$i]->country_name)?$po_allocationinfo[$i]->country_name:'';
							$provinces_name =isset($po_allocationinfo[$i]->provinces_name)?$po_allocationinfo[$i]->provinces_name:'';
							$brand_name =isset($po_allocationinfo[$i]->brand_name)?$po_allocationinfo[$i]->brand_name:'';
							$po_aloc_quantity =isset($po_allocationinfo[$i]->po_aloc_quantity)?$po_allocationinfo[$i]->po_aloc_quantity:'';
							$po_allocation_user =isset($po_allocationinfo[$i]->po_allocation_user)?json_decode($po_allocationinfo[$i]->po_allocation_user,true):array();
							$po_alloc_each_user = isset($po_allocationinfo[$i]->po_alloc_each_user)?$po_allocationinfo[$i]->po_alloc_each_user:'';
							$po_alloc_share_user = isset($po_allocationinfo[$i]->po_alloc_share_user)?$po_allocationinfo[$i]->po_alloc_share_user:'';
							$share_type = '';
							if($po_alloc_each_user != '' && strtolower($po_alloc_each_user) == 'each' 
							&& $po_alloc_share_user != '' && strtolower($po_alloc_share_user) == 'shared'){
								$share_type = 'Each , Shared';
							}else if($po_alloc_each_user != '' && $po_alloc_each_user == 'each'){
								$share_type = 'Each';
							}else if($po_alloc_share_user != '' && $po_alloc_share_user == 'shared'){
								$share_type = 'Shared';
							} 
				$output .= '<tr>
				  
				  <td style="font-size: 13px;">'.$user_role_name.'</td>				  
				  <td style="font-size: 13px;">'.$country_name.'</td>
				  <td style="font-size: 13px;">'. $provinces_name.'</td>
				  <td style="font-size: 13px;">'. $brand_name.'</td>';
				  
				  $output .= '<td style="font-size: 13px;">';
				  for($j=0;$j<count($po_allocation_user);$j++){
				  foreach($po_allocation_user as $key=>$value){	
				  if(strpos(',',$value) !== false){
					  $useridarray = explode(',',$value);
					  $user_details = User::whereIn('id',$useridarray)->get() ;
				  }else{
					  $user_details = User::where('id',$value)->get() ;
				  }
							//$output .= $key ." : ".$value." , ";
							//$output .= $user_details." , ";
							foreach($user_details as $k=>$list){
								$output .= $list->name." , ";
							}
				  }
				  break;
				  }
				  $output .= '</td>
				  <td style="font-size: 13px;">'. $po_aloc_quantity.'</td>
				  <td style="font-size: 13px;">'. $share_type.'</td>
				  </tr>';
					}
				}				  
			
			$output .= '</tbody></table>';

		echo $output;	
	}
	
}
?>
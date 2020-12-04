<?php

namespace App\Http\Controllers\salesref;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Warehouse;
use App\Model\Supplier;
use App\Model\PO;
use App\Model\User;
use App\Model\POItem;
use App\Model\BoxType;
use App\Model\ProductVariations;
use App\Model\PoBox;
use Auth;
use DB;

use App\Model\Brand;
use App\Model\Region;

use App\Model\Role;
use  App\Model\Country;
use  App\Model\POAllocation;
use  App\Model\Stock;
use  App\Model\ProductPrivacy;

class assign_ownershipController extends Controller
{
	

	public function item_list(Request $request,$type='',$role_id='',$cate_id='')
	{
		DB::enableQueryLog();
		$data['title'] = 'Stock List';
		
		$data['role_id'] = $role_id =  Auth::user()->role_id ;
		
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();
		$data['search_category'] = $search_category = isset($posteddata['search_category']) ? $posteddata['search_category'] : '';
		$where = '1=1' ;
		
		$cat_id_arr = [] ;
		$product_id_arr = [] ;
		$item_array=[] ;
		if ($posteddata) {
			if($search_category!='')
			{
				$category_name = ProductCategory::where('name', 'LIKE', "%$search_category%")->get();
				if(!empty($category_name)&& count($category_name)>0)
				{
					foreach($category_name as $category_name_val)
					{
						array_push($cat_id_arr,$category_name_val->id);
					}
					$item_details = Product::whereIn('category_id',$cat_id_arr)->get();
								 if(!empty($item_details)&& count($item_details)>0)
								 {
								 foreach($item_details as $item_details_val)
								 {
									 array_push($product_id_arr,$item_details_val->id);
								 }
								 }
								 else{
									  array_push($product_id_arr,0);
								 }
								 $item_id_val = implode(',',$product_id_arr);
				$where .= ' and stock.item_id in('.$item_id_val.')';
				}
				else{
					
					$item_search = strtolower($search_category);
			$where .=" and (lower(item.name) like '%$item_search%' or lower(stock.sku_code) like '%$item_search%')";
					
								 
				}
				
				
			}
		}
		
		if($cate_id!='')
		{
			$where .= ' and item.category_id='.$cate_id;
			
		}
		$where .= " and (stock.type ='each' or stock.type ='shared')" ;
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity','stock.allocation_id','stock.type')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id',$user_id)->where('stock.stock_type','in')->whereRaw($where)->get();
		
		
		
		$query = DB::getQueryLog();
		$data['product_list'] = $product_list ;
		//t($query);
		//t($product_list);
		//exit();
		return view('salesref.assignownership.itemlist',$data);
		
	}
	
	public function add_allocation($itemid,$skucode,$stockid,$allocationid)
	{
		$data['item_id'] = $itemId = base64_decode($itemid);
		$data['sku_id'] = $skuCode = base64_decode($skucode);
		$data['stockid'] = $stockid = base64_decode($stockid);
		$data['allocationid'] = $allocationid = base64_decode($allocationid);
		
	$data['product_name'] = $product_name = isset($itemId)?get_product_name_by_id($itemId):'' ;
		
	
	
		
	$data['itemId'] =	$itemId = isset($itemId)?$itemId:'';
	
	$data['stock_info'] = $stock_info = Stock::where('id',$stockid)->get();
	$data['quantity'] =	$quantity = $stock_info[0]->quantity ;
	$data['itemSkuCode'] =	$itemSkuCode = isset($skuCode)?$skuCode:'';
	$data['puchaseOrderDetailsId'] =	$puchaseOrderDetailsId = isset($po_details_val[0]->puchase_order_details_id)?$po_details_val[0]->puchase_order_details_id:'';
	
	$data['userRole'] =	$userRole = Role::where('type','master')->orWhere('type','division')->orWhere('id',11)->get() ;
	
	
return view('salesref.assignownership.add_allocation',$data);
		
	}
	
	public function submit_assign_allocation(Request $request)
	{
		$data=$request->all(); //t($data);
		 
		 $userrole2=[];
		 $userrole5=[];
		 $userrole9=[];
		 $userrole11=[];
		 $count_row = $data['countrow'];
		 $total_po_quantity = $data['total_quantity'];
		 $total_quantity = 0 ;
		 for($sum_count=0;$sum_count<$count_row;$sum_count++)
		 {
			 if($data['userrole1_'.$sum_count]==20)
			 {
				 if(isset($data['userrole3_'.$sum_count])&&$data['userrole3_'.$sum_count]!='')
				 {
					 $mixit_user = $data['userrole3_'.$sum_count];
				 }else{
					  $mixit_user = $data['userrole2_'.$sum_count];
				 }
				 
				 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
				if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
				 {
					$count_mix_user = count($mixit_user);
					$sum_amount = $count_mix_user * $quantity ;
				 }
				 else{
					 $sum_amount =  $quantity ;
				 }
				 
				$total_quantity = $total_quantity+ $sum_amount ; 
				 
			 }
			 
			 if($data['userrole1_'.$sum_count]==11)
			 {
				 $sales_ref = (isset($data['userrole3_'.$sum_count])&&$data['userrole3_'.$sum_count]!='')?$data['userrole3_'.$sum_count]:array();
				 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
				 
				 
				 if((isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')&&(isset($data['storelocator_'.$sum_count])&&$data['storelocator_'.$sum_count]== 'store'))
				 {
					  $count_sales_ref_user = count($sales_ref);
					$sum_amount_each = $count_sales_ref_user * $quantity ;
					$sum_amount_locker = $count_sales_ref_user * $quantity ; ;
					$sum_amount = 0 ;
					 
				 }
				 
				 if((isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')&&(!isset($data['storelocator_'.$sum_count])))
				 {
					  $count_sales_ref_user = count($sales_ref);
					$sum_amount_each = $count_sales_ref_user * $quantity ;
					$sum_amount_locker = 0 ;
					$sum_amount = 0 ;
					 
				 }
				  if((isset($data['storelocator_'.$sum_count])&&$data['storelocator_'.$sum_count]== 'store')&&(!isset($data['eachselectbox_'.$sum_count])))
				 {
					 $count_sales_ref_user = count($sales_ref);
					$sum_amount_each = 0 ;
					$sum_amount_locker = $count_sales_ref_user * $quantity ;
					$sum_amount = 0 ;
				 }
				 if((isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each') ||(isset($data['storelocator_'.$sum_count])&&$data['storelocator_'.$sum_count]== 'store'))
				 {
				 }
				 else{
					$sum_amount =  $quantity ;
					 $sum_amount_each = 0 ;
					 $sum_amount_locker = 0 ;
				 }
				 
				 
				 $total_quantity = $total_quantity+ $sum_amount +$sum_amount_locker+ $sum_amount_each ; 
			 }
			  if($data['userrole1_'.$sum_count]==15)
			 {
				 
				  for($j=1;$j<=$data['dynamoselectcount_'.$sum_count];$j++)
				 {
					if(isset($data['userrole4_'.$j.'_'.$sum_count])&&$data['userrole4_'.$j.'_'.$sum_count]!='')
					{
				    	$field_market_user[$j]= (isset($data['userrole4_'.$j.'_'.$sum_count])&&$data['userrole4_'.$j.'_'.$sum_count]!='')?$data['userrole4_'.$j.'_'.$sum_count]:array();; 
					}
				 }
				 
				 
				// $field_market_user = (isset($data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count])&&$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]!='')?$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]:array(); 
				 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
				if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
				 {
					$count_field_market_user = count(end($field_market_user));
					$sum_amount = $count_field_market_user * $quantity ;
				 }
				 else{
					 $sum_amount =  $quantity ;
				 }
				 
				$total_quantity = $total_quantity+ $sum_amount ; 
			 }
			 
			  if($data['userrole1_'.$sum_count]==5)
			 {
				 for($j=1;$j<$data['dynamoselectcount_'.$sum_count];$j++)
				 {
					 
					 if(isset($data['userrole4_'.$j.'_'.$sum_count])&&$data['userrole4_'.$j.'_'.$sum_count]!='')
					 {
					$marketing_user[$j]= (isset($data['userrole4_'.$j.'_'.$sum_count])&&$data['userrole4_'.$j.'_'.$sum_count]!='')?$data['userrole4_'.$j.'_'.$sum_count]:array(); 
					 }
				 }
				 
				 //$marketing_user = (isset($data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count])&&$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]!='')?$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]:array(); 
				 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
				if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
				 {
					$count_marketing_user = count(end($marketing_user));
					$sum_amount = $count_marketing_user * $quantity ;
				 }
				 else{
					 $sum_amount =  $quantity ;
				 }
				 
				$total_quantity = $total_quantity+ $sum_amount ; 
			 }
			 
		 }
		
		 if($total_quantity>$total_po_quantity)
		 {
			 //return redirect('add-po-allocation/'.base64_encode($data['itemid']).'/'.base64_encode($data['puchaseOrderDetailsId']).'/'.base64_encode($data['poid']))->with('error-msg', 'Allcation Quantity Not Sufficient');
		 }
		 else{
			 
			 
			  for($i=0;$i<$count_row;$i++)
		 {
			 //t($data['userrole1_'.$i]);
			$insertdata['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			$insertdata['po_id'] = isset($data['poid'])?$data['poid']:0 ;
			$insertdata['podetails_id'] = isset($data['puchaseOrderDetailsId'])?$data['puchaseOrderDetailsId']:0 ;
			$insertdata['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
			
			
			
			  if($data['userrole1_'.$i]==20)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole2['roleuser1']= (isset($data['userrole2_'.$i])&&$data['userrole2_'.$i]!='')?implode(',',$data['userrole2_'.$i]):'';
				 $userrole2['roleuser2']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] = '' ;
					  $insertdata['store_locker'] ='';
				 }
				 else{
					 $insertdata['each_user'] = '';
					 $insertdata['share_user'] = "shared" ;
					  $insertdata['store_locker'] ='';
				 }
				 $insertdata['user'] = json_encode($userrole2); 
			 }
			 if($data['userrole1_'.$i]==5)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['brand_id']= implode(',',$data['userrole2_'.$i]);
				 
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   
				 
				  $userrole5['roleuser1']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 for($j=1;$j<$data['dynamoselectcount_'.$i];$j++)
				 {
					 $j1 = $j+1 ;
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					 {
					$userrole5['roleuser'. $j1]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					 }
				 }
				
				/*  $userrole['roleuser2']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] ='' ;
					  $insertdata['store_locker'] ='';
				 }
				 else{
					  $insertdata['store_locker'] ='';
					 $insertdata['each_user'] = '' ;
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole5); 
			 } 
			  if($data['userrole1_'.$i]==15)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['country_id']= implode(',',$data['userrole2_'.$i]);
				  $insertdata['region_id']= '';
				 
				   $insertdata['brand_id']= '';
				 $insertdata['region_id']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 
				  for($j=1;$j<=$data['dynamoselectcount_'.$i];$j++)
				 {
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					{
					$userrole9['roleuser'.$j]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					}
				 }
				 
				/*  $userrole['roleuser1']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser2']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_5_'.$i])?implode(',',$data['userrole4_5_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] = '' ;
					  $insertdata['store_locker'] ='';
				 }
				 else{
					  $insertdata['store_locker'] ='';
					 $insertdata['share_user'] = "shared" ;
					 $insertdata['each_user'] = '' ;
				 }
				 $insertdata['user'] = json_encode($userrole9); 
			 } 
			  if($data['userrole1_'.$i]==11)
			 {
				 //t($data['userrole3_'.$i]);
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['region_id']= isset($data['userrole2_'.$i])?implode(',',$data['userrole2_'.$i]):'';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole11['roleuser1']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] ='';
				 }
				  if(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store')
				 {
					 $insertdata['store_locker'] = $data['storelocator_'.$i]  ;
					 $insertdata['share_user']='';
				 }
				 if((isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each') ||(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store'))
				 {
				 }
				 else{
					 $insertdata['each_user'] ='';
					 $insertdata['store_locker'] ='';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole11); 
			 }
			// t(json_encode($userrole));
			 
		 //t($insertdata);
			// exit() ;
			 
		 }
			 
			 
		 }
	}
}
	
?>
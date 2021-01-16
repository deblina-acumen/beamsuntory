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
		
		
		
		
		$data['product_list'] = $product_list ;
		
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
	
	$data['userRole'] =	$userRole = Role::where('id',15)->orWhere('id',5)->orWhere('id',11)->orWhere('id',20)->get() ;
	
	
return view('salesref.assignownership.add_allocation',$data);
		
	}
	
	public function submit_assign_allocation(Request $request)
	{
		$data=$request->all(); t($data);
		//exit();
		 
		 $userrole2=[];
		 $userrole5=[];
		 $userrole9=[];
		 $userrole11=[];
		 $count_row = $data['countrow'];
		 $total_po_quantity = $data['total_quantity'];
		 $total_quantity = 0 ;
		 $stock_details = Stock::where('id',$data['stockid'])->get();
		 $warehouse_id = $stock_details[0]->warehouse_id ;
		 $type = $stock_details[0]->type ;
		 for($sum_count=0;$sum_count<$count_row;$sum_count++)
		 {
			 if($data['userrole1_'.$sum_count]==20)
			 {
				 if(isset($data['userrole3_'.$sum_count])&&$data['userrole3_'.$sum_count]!='')
				 {
					 $mixit_user = explode(',',implode(',',$data['userrole3_'.$sum_count]));
				 }else{
					  $mixit_user = explode(',',implode(',',$data['userrole2_'.$sum_count]));
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
				 $sales_ref = (isset($data['userrole3_'.$sum_count])&&$data['userrole3_'.$sum_count]!='')?explode(',',implode(',',$data['userrole3_'.$sum_count])):array();
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
				    	$field_market_user[$j]= (isset($data['userrole4_'.$j.'_'.$sum_count])&&$data['userrole4_'.$j.'_'.$sum_count]!='')?explode(',',implode(',',$data['userrole4_'.$j.'_'.$sum_count])):array();; 
					}
				 }
				// t(end($field_market_user));
				// t(count(end($field_market_user)));
				 
				// $field_market_user = (isset($data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count])&&$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]!='')?$data['userrole4_'.$data['dynamoselectcount_'.$sum_count].'_'.$sum_count]:array(); 
				 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
				// t($quantity);
				if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
				 {
					$count_field_market_user = count(end($field_market_user));
					$sum_amount = $count_field_market_user * $quantity ;
				 }
				 else{
					 $sum_amount =  $quantity ;
				 }
				 
				$total_quantity = $total_quantity + $sum_amount ; 
				//t($sum_amount) ;
			 }
			 
			  if($data['userrole1_'.$sum_count]==5)
			 {
				 for($j=0;$j<$data['dynamoselectcount_'.$sum_count];$j++)
				 {
					 $j1 = $j+1 ;
					 if(isset($data['userrole4_'.$j1.'_'.$sum_count])&&$data['userrole4_'.$j1.'_'.$sum_count]!='')
					 {
					$marketing_user[$j]= (isset($data['userrole4_'.$j1.'_'.$sum_count])&&$data['userrole4_'.$j1.'_'.$sum_count]!='')?explode(',',implode(',',$data['userrole4_'.$j1.'_'.$sum_count])):array(); 
					 }
				 }
				 $brand_m_manager = (isset($data['userrole3_'.$sum_count])&&$data['userrole3_'.$sum_count]!='')?explode(',',implode(',',$data['userrole3_'.$sum_count])):array();
				 //t($brand_m_manager);
				// t($marketing_user);
				 if(isset($marketing_user)&& $marketing_user!='')
				 {
					 
						$quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
						if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
						 {
							$count_marketing_user = count(end($marketing_user));
							$sum_amount = $count_marketing_user * $quantity ;
						 }
						 else{
							 $sum_amount =  $quantity ;
						 }
					 
				 }
				 else{
					 $quantity = isset($data['quantity_'.$sum_count])?$data['quantity_'.$sum_count]:'';
						if(isset($data['eachselectbox_'.$sum_count])&&$data['eachselectbox_'.$sum_count]== 'each')
						 {
							$count_marketing_user = count($brand_m_manager);
							$sum_amount = $count_marketing_user * $quantity ;
						 }
						 else{
							 $sum_amount =  $quantity ;
						 }
				 }
				
				$total_quantity = $total_quantity+ $sum_amount ; 
			 }
			 
		 }
		 //t($total_quantity);
		 
		// exit();
		
		 if($total_quantity>$total_po_quantity)
		 {
			 return redirect('add-assign-allocation/'.base64_encode($data['itemid']).'/'.base64_encode($data['itemSkuCode']).'/'.base64_encode($data['stockid']).'/'.base64_encode($data['allocationid']))->with('error-msg', 'Allcation Quantity Not Sufficient');
		 }
		 else{
			 
			 
			  for($i=0;$i<$count_row;$i++)
		 {
			 //t($data['userrole1_'.$i]);
			
			
			
			
			  if($data['userrole1_'.$i]==20)
			 {
				 $insertdata20['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			
			    $insertdata20['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
				 $insertdata20['role_id'] = $data['userrole1_'.$i];
				  $insertdata20['region_id']= '';
				  $insertdata20['country_id']= '';
				   $insertdata20['brand_id']= '';
				 $userrole2['roleuser1']= (isset($data['userrole2_'.$i])&&$data['userrole2_'.$i]!='')?implode(',',$data['userrole2_'.$i]):'';
				 $userrole2['roleuser2']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata20['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata20['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata20['share_user'] = '' ;
					  $insertdata20['store_locker'] ='';
				 }
				 else{
					 $insertdata20['each_user'] = '';
					 $insertdata20['share_user'] = "shared" ;
					  $insertdata20['store_locker'] ='';
				 }
				 $insertdata20['user'] = json_encode($userrole2); 
				 $id20 =POAllocation::insertGetId($insertdata20);
				// echo $id20 ;
				 
				 /////////// stock table entry //////
				 
				  if(isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')
				 {
					 $mixit_user = explode(',',implode(',',$data['userrole3_'.$i]));
				 }else{
					  $mixit_user = explode(',',implode(',',$data['userrole2_'.$i]));
				 }
				 foreach($mixit_user as $mixit_user_val)
				 {
					 $insMixitStock['warehouse_id']=$warehouse_id ;
					 $insMixitStock['user_id']=$mixit_user_val ;
					 $insMixitStock['item_id']=$data['itemid'] ;
					 $insMixitStock['sku_code']=$data['itemSkuCode'] ;
					 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
					{
					 $insMixitStock['type']='each' ;
					}
					else{
						$insMixitStock['type']='shared' ;
					}
					 $insMixitStock['stock_type']='in' ;
					 $insMixitStock['allocation_id']=$id20 ;
					 $insMixitStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
					Stock::insert($insMixitStock); 
				 }
				 
				/////////// stock table entry ////// 
				 
			 }
			 if($data['userrole1_'.$i]==5)
			 {
				 $insertdata5['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			
			    $insertdata5['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
				 $insertdata5['role_id'] = $data['userrole1_'.$i];
				 $insertdata5['brand_id']= implode(',',$data['userrole2_'.$i]);
				 
				  $insertdata5['region_id']= '';
				  $insertdata5['country_id']= '';
				   
				 
				  $userrole5['roleuser1']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 for($j=1;$j<=$data['dynamoselectcount_'.$i];$j++)
				 {
					 $j1 = $j+1 ;
					 $j2 = $j-1 ;
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					 {
					$userrole5['roleuser'. $j1]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					
					$marketing_user[$j2]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?$data['userrole4_'.$j.'_'.$i]:array();
					
					 }
				 }
				
			
				 $insertdata5['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata5['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata5['share_user'] ='' ;
					  $insertdata5['store_locker'] ='';
				 }
				 else{
					  $insertdata5['store_locker'] ='';
					 $insertdata5['each_user'] = '' ;
					 $insertdata5['share_user'] = "shared" ;
				 }
				 $insertdata5['user'] = json_encode($userrole5); 
				 $id5 = POAllocation::insertGetId($insertdata5);
				 //echo $id5;
				 ////////////////// stock table entry //////////
				// $count_marketing_user = count(end($marketing_user));
				 
				 if(isset($marketing_user)&& $marketing_user!='')
				 {
					 $brand_markting_user = explode(',',implode(',',end($marketing_user))) ;
				 }
				 else{
					 $brand_markting_user = isset($data['userrole3_'.$i])?explode(',',implode(',',$data['userrole3_'.$i])):array();
				 }
				
				 
				 foreach($brand_markting_user as $brand_markting_user_val)
				 {
					  $insmarketingStock['warehouse_id']=$warehouse_id ;
					 $insmarketingStock['user_id']=$brand_markting_user_val ;
					 $insmarketingStock['item_id']=$data['itemid'] ;
					 $insmarketingStock['sku_code']=$data['itemSkuCode'] ;
					 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
					{
					 $insmarketingStock['type']='each' ;
					}
					else{
						$insmarketingStock['type']='shared' ;
					}
					 $insmarketingStock['stock_type']='in' ;
					 $insmarketingStock['allocation_id']=$id5 ;
					 $insmarketingStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
					Stock::insert($insmarketingStock); 
				 }
				 
			 } 
			  if($data['userrole1_'.$i]==15)
			 {
				 $insertdata15['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			
			    $insertdata15['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
				 $insertdata15['role_id'] = $data['userrole1_'.$i];
				 $insertdata15['country_id']= implode(',',$data['userrole2_'.$i]);
				  $insertdata15['region_id']= '';
				 
				   $insertdata15['brand_id']= '';
				 $insertdata15['region_id']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 
				  for($j=1;$j<=$data['dynamoselectcount_'.$i];$j++)
				 {
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					{
					$userrole9['roleuser'.$j]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					
					$field_market_user[$j]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?$data['userrole4_'.$j.'_'.$i]:array(); 
					}
				 }
				 
				
				 $insertdata15['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata15['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata15['share_user'] = '' ;
					  $insertdata15['store_locker'] ='';
				 }
				 else{
					  $insertdata15['store_locker'] ='';
					 $insertdata15['share_user'] = "shared" ;
					 $insertdata15['each_user'] = '' ;
				 }
				 $insertdata15['user'] = json_encode($userrole9);
				 $id15 =POAllocation::insertGetId($insertdata15);
				 //echo $id15;
				 $field_marketing_user = explode(',',implode(',',end($field_market_user))) ;
				 foreach($field_marketing_user as $field_marketing_user_val)
				 {
					  $insfmarketingStock['warehouse_id']=$warehouse_id ;
					 $insfmarketingStock['user_id']=$field_marketing_user_val ;
					 $insfmarketingStock['item_id']=$data['itemid'] ;
					 $insfmarketingStock['sku_code']=$data['itemSkuCode'] ;
					 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
					{
					 $insfmarketingStock['type']='each' ;
					}
					else{
						$insfmarketingStock['type']='shared' ;
					}
					 $insfmarketingStock['stock_type']='in' ;
					 $insfmarketingStock['allocation_id']=$id15 ;
					 $insfmarketingStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
					Stock::insert($insfmarketingStock); 
				 }
				 
			 } 
			  if($data['userrole1_'.$i]==11)
			 {
				 $insertdata11['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			
			    $insertdata11['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
				 //t($data['userrole3_'.$i]);
				 $insertdata11['role_id'] = $data['userrole1_'.$i];
				 $insertdata11['region_id']= isset($data['userrole2_'.$i])?implode(',',$data['userrole2_'.$i]):'';
				  $insertdata11['country_id']= '';
				   $insertdata11['brand_id']= '';
				 $userrole11['roleuser1']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata11['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata11['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata11['share_user'] ='';
				 }
				  if(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store')
				 {
					 $insertdata11['store_locker'] = $data['storelocator_'.$i]  ;
					 $insertdata11['share_user']='';
				 }
				 if((isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each') ||(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store'))
				 {
				 }
				 else{
					 $insertdata11['each_user'] ='';
					 $insertdata11['store_locker'] ='';
					 $insertdata11['share_user'] = "shared" ;
				 }
				 $insertdata11['user'] = json_encode($userrole11);
				$id11 = POAllocation::insertGetId($insertdata11);
				//echo $id11 ;
				////////// store to stock table ///////////
				$sales_ref = (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?explode(',',implode(',',$data['userrole3_'.$i])):array();
				
				if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
						 foreach($sales_ref as $sales_ref_val)
							 {
								  $inssalesrefStock['warehouse_id']=$warehouse_id ;
								 $inssalesrefStock['user_id']=$sales_ref_val ;
								 $inssalesrefStock['item_id']=$data['itemid'] ;
								 $inssalesrefStock['sku_code']=$data['itemSkuCode'] ;
								
								 $inssalesrefStock['type']='each' ;
								
									
								
								 $inssalesrefStock['stock_type']='in' ;
								 $inssalesrefStock['allocation_id']=$id11 ;
								 $inssalesrefStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
								Stock::insert($inssalesrefStock); 
							 }
				 }
				  if(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store')
				 {
					    foreach($sales_ref as $sales_ref_val1)
						 {
							  $inssalesrefStock['warehouse_id']=$warehouse_id ;
							 $inssalesrefStock['user_id']=$sales_ref_val1 ;
							 $inssalesrefStock['item_id']=$data['itemid'] ;
							 $inssalesrefStock['sku_code']=$data['itemSkuCode'] ;
							
							 
							
								$inssalesrefStock['type']='store' ;
							
							 $inssalesrefStock['stock_type']='in' ;
							 $inssalesrefStock['allocation_id']=$id11 ;
							 $inssalesrefStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
							Stock::insert($inssalesrefStock); 
						 }
				 }
				 if((isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each') ||(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store'))
				 {
				 }
				 else{
					  foreach($sales_ref as $sales_ref_val1)
						 {
							  $inssalesrefStock['warehouse_id']=$warehouse_id ;
							 $inssalesrefStock['user_id']=$sales_ref_val1 ;
							 $inssalesrefStock['item_id']=$data['itemid'] ;
							 $inssalesrefStock['sku_code']=$data['itemSkuCode'] ;
							$inssalesrefStock['type']='shared' ;
							 $inssalesrefStock['stock_type']='in' ;
							 $inssalesrefStock['allocation_id']=$id11 ;
							 $inssalesrefStock['quantity']=isset($data['quantity_'.$i])?$data['quantity_'.$i]:0;
							Stock::insert($inssalesrefStock); 
						 }
				 }
				
				
				
				 
			 }
			// t(json_encode($userrole));
			 
		 //t($insertdata);
			// exit() ;
			 
		 }
		 
		//////// update data/////////////
		 if($stock_details[0]->type == 'each')
			{
				$updateStock['warehouse_id']=$warehouse_id ;
				 $updateStock['user_id']=$stock_details[0]->user_id ;
				 $updateStock['item_id']=$data['itemid'] ;
				 $updateStock['sku_code']=$data['itemSkuCode'] ;
				$updateStock['type']='each' ;
				 $updateStock['stock_type']='out' ;
				 $updateStock['allocation_id']=$stock_details[0]->allocation_id ;
				 $updateStock['quantity']= $total_quantity;
				 $updateStock['stock_id']= $stock_details[0]->id;
				 
				Stock::insert($updateStock); 
			}
			else if($stock_details[0]->type == 'shared')
			{
				$stock_user = [] ;
				$share_stock_list = Stock::where('allocation_id',$stock_details[0]->allocation_id)->where('stock_type','in')->get();
				
				foreach($share_stock_list as $share_stock_list_val)
				{
				
					$updateStock['warehouse_id']=$share_stock_list_val->warehouse_id ;
				 $updateStock['user_id']=$share_stock_list_val->user_id ;
				 $updateStock['item_id']=$data['itemid'] ;
				 $updateStock['sku_code']=$data['itemSkuCode'] ;
				$updateStock['type']='shared' ;
				 $updateStock['stock_type']='out' ;
				 $updateStock['allocation_id']=$share_stock_list_val->allocation_id ;
				 $updateStock['quantity']= $total_quantity;
				 $updateStock['stock_id']= $share_stock_list_val->id;
				Stock::insert($updateStock); 
				
				}
				
			}
			else{
			}
		 
		///////	 update data /////////// 
			  return redirect('assign-ownership/item-list')->with('success-msg', 'Allocation Added Successfully');
		 }
	}
}
	
?>
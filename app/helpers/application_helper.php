<?php
use Illuminate\Contracts\Encryption\DecryptException;
use App\Model\Module;
use App\Model\User;
use App\Model\StoreCategory;
use  App\Model\Notification;
use App\Model\ProductCategory;
use App\Model\Role;
use App\Model\Brand;
use App\Model\Region;
use App\Model\Product;
use App\Model\ProductVariations;
use App\Model\POItem;;
use  App\Model\POAllocation;
use  App\Model\Warehouse;
use App\Model\Stock;
use App\Model\ProductPrivacy ;
use App\Model\Supplier;
use App\Model\Store;

function product($item_id)
{
	$item = POItem::where('id',$item_id)->get();
	return isset($item[0])?$item[0]:array();
}
function get_warehouse_id_by_user($user_id)
{
	$ware_house_details = Warehouse::where('user_id',$user_id)->where('is_active','Yes')->where('is_deleted','No')->get();
	return $ware_house_details;
}
function get_total_purchase_item($po_id){
	$total_item = POItem::selectRaw('sum(quantity) as total_item')->where('po_id',$po_id)->get();
	return isset($total_item[0]->total_item)?$total_item[0]->total_item:0;
}

function get_product_name_by_id($id)
{
	$item = Product::where('id',$id)->get();
	return isset($item[0]->name)?$item[0]->name:'';
}
function get_product_list_type_wise($type)
{
	$product_list = Product::where('is_deleted','No')->where('product_type',$type)->where('is_active','Yes')->where('product_type',$type)->orderBy('name','asc')->get();
	$all_item =array();
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
					
					$all_item[$sku.'_'.$product->id.'_'.$variancedt->id] = $product->name.'-'.$sku;
				}
			}
			else
			{
				$all_item[$product->sku.'_'.$product->id] = $product->name.'-'.$product->sku;
				
			}
		}
		return $all_item;
}
function upload_file_single_with_name($file,$type,$file_name,$userId)
{
	//file upload 
		if($file!=''){
		$new_file_name =$userId;			
		 $upload_path =  public_path($file_name);
		// image upload in public/upload folder.
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true);
		}		
		$files = glob(public_path($file_name.'\*'));// get all file names		
		//end unlik file section
		$extention =$file->getClientOriginalExtension();
		$org_name = $file->getClientOriginalName() ;
		$image_name = $new_file_name.'_'.$org_name;
		$upload = $file->move($upload_path, $image_name); 
		
		if(!empty($upload))
		{
			return $image_name;
		}
		else
		{
			$image_name='';
			return $image_name;
		}
	 }
}

function get_facility_name_by_id($id)
{
	$details = User::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}

function get_number_of_member_by_id($id)
{
	$details = FacilityMemberDetails::where('facility_id',$id)->count();
	return isset($details)?$details:'';
}

	///////////////////////////////////////////Notification Section/////////////////////////////////////////////////
	function get_all_notification($user_id,$type='')
	{
		
		$notification_list = Notification::where('user_id',$user_id)->where('is_opened','N')->get();
		
		return $notification_list;
	}
	
	function is_approver_notification($user_id,$memberId)
	{
		
		$notification_list = Notification::where('user_id',$user_id)->where('member_id',$memberId)->where('is_opened','N')->get();
		
		return $notification_list;
	}
	
	function get_role_by_id($id)
{
	$details = Role::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}
function get_category_by_id($id)
{
	$details = StoreCategory::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}	
function get_product_category_by_id($id)
{
	$details = ProductCategory::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}
function get_brand_name($id)
{
	$details = Brand::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
	
}	
function ger_province_name($id)
{
	$details = Region::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}

function check_allocation_present($itemId,$podetailsId,$poId)
{
	$details = POAllocation::where('item_id',$itemId)->where('po_id',$poId)->where('podetails_id',$podetailsId)->get();
	$count = count($details);
	if($count>0)
	{
		return true ;
	}
	else
	{
		return false ;
	}
	
}

function get_salesref_name_by_regionid($idarray)
{
	//t($idarray);
	$details = User::whereIn('province_id',$idarray)->where('role_id',11)->get();
	return isset($details)?$details:'';
}

function get_brandmm_name_by_brandid($idarray,$parentId)
{
	//t($idarray);
	$chiledRole =  Role::where('parent_id',$parentId)->get();
	$details = User::whereIn('brand_id',$idarray)->where('role_id',$chiledRole[0]->id)->get();
	return isset($details)?$details:'';
}
function get_parent_brand_by_id($parent_id)
{
	$details = Brand::where('id',$parent_id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}

function get_provence_name_by_country($idarray)
{
	$details = Region::whereIn('country_id',$idarray)->get() ;
	return isset($details)?$details:'';
}
function get_previous_role($idarray)
{
	
	$user_info = User::whereIn('id',$idarray)->get();
	
	$chiledRole =  Role::where('parent_id',$user_info[0]->role_id)->get();
	return isset($chiledRole[0]->id)?$chiledRole[0]->id:'';
	
}
function get_chiled_user_brand_marketing($brand,$chiledrole)
{
	$details = User::whereIn('brand_id',$brand)->where('role_id',$chiledrole)->get();
	return isset($details)?$details:'';
}

function get_field_marketing_manager_by_county($idaar,$role)
{
	$chiledRole =  Role::where('parent_id',$role)->get();
	$details = User::whereIn('province_id',$idaar)->where('role_id',$chiledRole[0]->id)->get();
	return isset($details)?$details:'';
}
function get_chiled_role_for_fmm($id)
{
	$chiledRole =  Role::where('parent_id',$id)->get();
	return isset($chiledRole[0]->id)?$chiledRole[0]->id:'';
}
function get_chiled_user_field_marketing($country,$chiledrole)
{
	$details = User::whereIn('province_id',$country)->where('role_id',$chiledrole)->get();
	return isset($details)?$details:'';
}

function get_allocated_product_count_per_user($cateid,$userId,$roleId,$type)
{
	DB::enableQueryLog();
	//t($cateid);
	//exit();
	$item_array=[] ;
	 $item_details = Product::where('category_id',$cateid)->get();
	 if(!empty($item_details)&& count($item_details)>0)
	 {
	 foreach($item_details as $item_details_val)
	 {
		 array_push($item_array,$item_details_val->id);
	 }
	 }
	 else{
		  array_push($item_array,0);
	 }
	 $item_id= implode(',',$item_array) ;
	 if($type=='own-by-me')
	 {
		 $count_stock_product =  DB::select(DB::raw("SELECT count(*) as count FROM `stock` where item_id IN ($item_id) and user_id=$userId and (type='each' or type='shared') and stock_type='in' and order_type='po' GROUP BY item_id,sku_code"));
	 }
	 else if($type=='not-own-by-me')
	 {
		 $count_stock_product =  DB::select(DB::raw("SELECT count(*) as count FROM `stock` where item_id  IN ($item_id) and user_id != $userId and (type='each' or type='shared' or type='store') and stock_type='in' and order_type='po' GROUP BY item_id,sku_code"));
	 }
	 else if($type=='my-locker'){
		 $count_stock_product =  DB::select(DB::raw("SELECT count(*) as count FROM `stock` where item_id IN ($item_id) and user_id=$userId and type='store' and stock_type='in' and order_type='po' GROUP BY item_id,sku_code"));
	 }
	 else{
	 }
	
	//$query = DB::getQueryLog();
 //  t($query);
   //exit();
	$sum = 0 ;
	foreach($count_stock_product as $count_stock_product_val)
	{
		$sum = $sum + $count_stock_product_val->count ;
	}
	 
	 

	return count($count_stock_product) ;
	
	
}

function get_item_quantity_by_id_sku($type,$user_id,$item_id,$sku_code)
{
	$date= date('Y-m-d') ;
		if($type =='my-locker')
		{
			$instock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'in' and `type` = 'store'  and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."' and (`stock`.`active_date`<'".$date."' or `stock`.`active_date` IS NULL)"));
			$outstock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'out' and `type` = 'store'  and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."'"));
			$count = $instock_count[0]->sumqty  - $outstock_count[0]->sumqty ; 
		}
		else if($type =='own-by-me')
		{
			$instock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'in' and (`type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."' and (`stock`.`active_date`<'".$date."' or `stock`.`active_date` IS NULL)"));
			
			$outstock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'out' and (`type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."'"));
			
			$count = $instock_count[0]->sumqty  - $outstock_count[0]->sumqty ; 
		}
		else if($type =='not-own-by-me')
		{
			
			$instock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` != $user_id and `stock`.`stock_type` = 'in' and (`type` = 'store' or `type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."' and (`stock`.`active_date`<'".$date."' or `stock`.`active_date` IS NULL)"));
			
			$outstock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` != $user_id and `stock`.`stock_type` = 'out' and (`type` = 'store' or `type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."'"));
			
			$private_product = DB::select(DB::raw("SELECT sum(quantity) as quantity from item_privacy where item_id=$item_id and sku_code= '".$sku_code."' and privacy_type='private'"));



			
			
			$count = $instock_count[0]->sumqty  - $outstock_count[0]->sumqty - $private_product[0]->quantity ; 
		}
		else{
			$instock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'in' and ( `type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."' and (`stock`.`active_date`<'".$date."' or `stock`.`active_date` IS NULL)"));
			$outstock_count =  DB::select(DB::raw("select  sum(`stock`.`quantity`) as sumqty from  `stock` where `stock`.`user_id` = $user_id and `stock`.`stock_type` = 'out' and (`type` = 'each' or `type` = 'shared') and `stock`.`item_id`=$item_id and `stock`.`sku_code`='".$sku_code."' and (`stock`.`active_date`<'".$date."' or `stock`.`active_date` IS NULL)"));
			$count = $instock_count[0]->sumqty  - $outstock_count[0]->sumqty ;
			
		}
		
		return $count ;
	
	
	
	
}

function get_product_privacy($userId,$item_id,$skucode)
{
	$item_privacy = ProductPrivacy::where('user_id',$userId)->where('item_id',$item_id)->where('sku_code',$skucode)->get();
	return isset($item_privacy[0]->privacy_type)?$item_privacy[0]->privacy_type:'';
}


function get_supplier_name($id)
{
	
	$Supplier = Supplier::where('id',$id)->get();
	return isset($Supplier[0]->supplier_name)?$Supplier[0]->supplier_name:'';
}

function get_product_quantity_by_stock_id($stockId,$userid)
{
	$instock = Stock::where('id',$stockId)->where('user_id',$userid)->where('stock_type','in')->get();
	if(!empty($instock)&& count($instock)>0)
	{
	$inquantity = isset($instock[0]->quantity)?$instock[0]->quantity:0 ;
	}
	else{
		$inquantity = 0 ;
	}
	
	$outStock = Stock::where('stock_id',$stockId)->where('user_id',$userid)->where('stock_type','out')->get();
	if(!empty($outStock)&& count($outStock)>0)
	{
	$outquantity = isset($outStock[0]->quantity)?$outStock[0]->quantity:0 ;
	}
	else{
		$outquantity = 0 ;
	}
	
	return $inquantity-$outquantity ;
}

function get_user_details($id)
{
	$agent = User::where('id',$id)->get();
	return isset($agent[0])?$agent[0]:'';
}

function get_delivery_agent($id)
{
	$agent = User::where('id',$id)->get();
	return isset($agent[0]->name)?$agent[0]->name:'';
}
function get_store_name($id)
{
	$agent = Store::where('id',$id)->get();
	return isset($agent[0]->store_name)?$agent[0]->store_name:'';
}
function get_store_details($id)
{
	$store = Store::where('id',$id)->get();
	return isset($store)?$store:'';
}
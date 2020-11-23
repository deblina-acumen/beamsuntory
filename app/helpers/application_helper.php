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

function get_total_purchase_item($po_id){
	$total_item = POItem::selectRaw('sum(quantity) as total_item')->where('po_id',$po_id)->get();
	return isset($total_item[0]->total_item)?$total_item[0]->total_item:0;
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


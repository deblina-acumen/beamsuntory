<?php

namespace App\Http\Controllers\ReceiveRequest;

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
use  App\Model\ItemShareRequest;

class ReceiveRequestController extends Controller
{
	
		public function receive_request(Request $request)
	{
		DB::enableQueryLog();
		
		$data['title'] = 'Receive Request';
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
				$where .= ' and item_share_request.item_id in('.$item_id_val.')';
				}
				else{
					
					$item_search = strtolower($search_category);
			$where .=" and (lower(item.name) like '%$item_search%' or lower(item_share_request.sku_code) like '%$item_search%')";
					
								 
				}
				
				
			}
		}
		
		 $data['product_list']=$list = ItemShareRequest::select('item_share_request.*','item.name as itemname','item.image as item_image','users.name as user_name')->join('item','item.id','=','item_share_request.item_id','left')->join('users','users.id','=','item_share_request.request_from','left')->whereRaw($where)->where('item_share_request.is_deleted','No')->where('item_share_request.request_to',$user_id)->orderBy('item.name','asc')->get(); 
		
		//$query = DB::getQueryLog();
		//t($query);

		return view('ReceiveRequest.receiverequestlist',$data);
		
	}
	public function reject_receive_request($id)
	{
		$id = base64_decode($id);
		$update['status']='Rejected';
		ItemShareRequest::where('id',$id)->update($update);
		return redirect('receive-request/')->with('success-msg', 'Request successfully rejected');
	}
	public function accept_receive_request($id)
	{
		$id = base64_decode($id);
		$request_details_arr =ItemShareRequest::select('item_share_request.*','stock.allocation_id','stock.type','stock.warehouse_id','stock.user_id')->join('stock','stock.id','=','item_share_request.stock_id','left')->where('item_share_request.id',$id)->get();
		$request_details = isset($request_details_arr[0])?$request_details_arr[0]:array();
		if($request_details->type == 'each')
				
			{
				$inset_stock['warehouse_id'] =$request_details->warehouse_id;
				$inset_stock['stock_id'] =$request_details->stock_id;
				$inset_stock['user_id'] = $request_details->user_id;
				$inset_stock['item_id'] = $request_details->item_id;
				$inset_stock['sku_code']=$request_details->sku_code;
				$inset_stock['type']="each";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "share_request";
				$inset_stock['quantity'] = $request_details->quantity;
				Stock::insertGetId($inset_stock);
				
				
			}
		elseif($request_details->type == 'shared')
			{
				$another_stock_othruser = Stock::where('allocation_id',$request_details->allocation_id)->where('type','shared')->get();
			    foreach($another_stock_othruser as $shredstock)
				{
				
				$inset_stock['warehouse_id'] =$shredstock->warehouse_id;
				$inset_stock['stock_id'] =$shredstock->id;
				$inset_stock['user_id'] = $shredstock->user_id;
				$inset_stock['item_id'] = $request_details->item_id;
				$inset_stock['sku_code']=$request_details->sku_code;
				$inset_stock['type']="shared";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "share_request";
				$inset_stock['quantity'] = $request_details->quantity;
				Stock::insertGetId($inset_stock);
				
				}
				
			}
	
		$update_status['status'] = 'accepted';
		ItemShareRequest::where('id',$id)->update($update_status);
		return redirect('receive-request/')->with('success-msg', 'Request successfully accepted');
	}
	}
	
?>
<?php

namespace App\Http\Controllers\Warehouse;

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

class WarehouseStockController extends Controller
{
	
	
	
	
	
	public function item_list(Request $request)
	{
		$posteddata = $request->all();
		//t($posteddata);
		//exit();
		DB::enableQueryLog();
		
		$data['title'] = 'Stock List';
		
		$user_id = Auth::user()->id ;
		$wh_id = array();
		$wh_details = Warehouse::where('user_id',$user_id)->get() ;
		foreach($wh_details as $wh_details_val)
		{
			array_push($wh_id,$wh_details_val->id);
		}
		
		//t($wh_id);
		//exit();
		
		$data['search_category'] = $search_category = isset($posteddata['search_category']) ? $posteddata['search_category'] : '';
		//t($search_category);
		$where = '1=1' ;
		
		$cat_id_arr = [] ;
		$product_id_arr = [] ;
		$item_array=[] ;
		if ($posteddata) {
			if($search_category!='')
			{
				$category_name = ProductCategory::where('name', 'LIKE', "%$search_category%")->get();
				/* if(!empty($category_name)&& count($category_name)>0)
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
				} */
				//else{
					
					$item_search = strtolower($search_category);
			$where .=" and (lower(item.name) like '%$item_search%' or lower(stock.sku_code) like '%$item_search%')";
					
								 
			//	}
				
				
			}
		}
		
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.warehouse_id','stock.quantity')->join('stock','item.id','=',"stock.item_id")->whereIn('stock.warehouse_id',$wh_id)->whereRaw($where)->groupBy('stock.item_id','stock.sku_code')->paginate(10);
		//t($product_list);
		//exit();
		
		$query = DB::getQueryLog();
		$data['product_list'] = $product_list ;
		//t($query);
		//t($product_list);
		//exit();
		return view('Warehouse.itemlist',$data);
		
	}
	
	
	
	
	}
	
?>
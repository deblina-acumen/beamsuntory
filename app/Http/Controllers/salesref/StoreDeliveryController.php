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

class StoreDeliveryController extends Controller
{
	
	public function item_list(Request $request)
	{
		DB::enableQueryLog();
		$data['title'] = 'Stock List';
		
		$data['role_id'] = $role_id =  Auth::user()->role_id ;
		$data['type']='' ;
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();
		
		if($role_id ==11)
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id','=',$user_id)->where('stock.stock_type','in')->where('type','store')->orWhere('type','each')->orWhere('type','shared')->groupBy('stock_item_id','stock.sku_code')->get();
		}
		else
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id',$user_id)->where('stock.stock_type','in')->where('type','each')->orWhere('type','shared')->groupBy('stock_item_id','stock.sku_code')->get();
		}
		
		$query = DB::getQueryLog();
		$data['product_list'] = $product_list ;
		//t($query);
		//t($product_list);
		//exit();
		return view('salesref.store_delivary.itemlist',$data);
		
	}
	
	
	}
	
?>
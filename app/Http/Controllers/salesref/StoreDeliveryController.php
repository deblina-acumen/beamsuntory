<?php

namespace App\Http\Controllers\salesref;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductVariations;
use App\Model\Delivery_order;
use App\Model\Delivery_orderItem;
use Auth;
use DB;
use App\Model\Store;
use App\Model\Brand;
use App\Model\Region;
use App\Model\StoreCategory;
use App\Model\Supplier;
use App\Model\User;
use App\Model\Role;
use  App\Model\Country;
use  App\Model\POAllocation;
use  App\Model\Stock;
use  App\Model\ProductPrivacy;

class StoreDeliveryController extends Controller
{
	
	public function item_list(Request $request)
	{
		
		$posted_data = $request->all();
		$data['item_search'] = $item_search = isset($posted_data['item_search'])?$posted_data['item_search']:'';
		$data['title'] = 'Stock List';
		$data['role_id'] = $role_id =  Auth::user()->role_id ;
		$data['type']='' ;
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();
		$where ="";
		if($item_search!='')
		{
			$item_search = strtolower($item_search);
			$where =" and (lower(item.name) like '%$item_search%' or lower(stock.sku_code) like '%$item_search%')";
		}
		if($role_id ==11)
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id','=',$user_id)->whereRaw("stock.stock_type = 'in' and  (type='store'  or type = 'each' or type='shared') $where")->groupBy('stock_item_id','stock.sku_code')->get();
		}
		else
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id',$user_id)->whereRaw("stock.stock_type ='in' and (type ='each' or type='shared') $where")->groupBy('stock_item_id','stock.sku_code')->get();
		}
		
		
		$data['product_list'] = $product_list ;
		
		//t($product_list,1);
		//exit();
		return view('salesref.store_delivary.itemlist',$data);
		
	}
	public function edit_ship_request($id,Request $request)
	{
		$id = base64_decode($id);
		
		$posted_data = $request->all();
		$data['item_search'] = $item_search = isset($posted_data['item_search'])?$posted_data['item_search']:'';
		$data['title'] = 'Stock List';
		$data['role_id'] = $role_id =  Auth::user()->role_id ;
		$data['type']='' ;
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();
		$where ="";
		if($item_search!='')
		{
			$item_search = strtolower($item_search);
			$where =" and (lower(item.name) like '%$item_search%' or lower(stock.sku_code) like '%$item_search%')";
		}
		if($role_id ==11)
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity','delivery_order_item.id as do_item_id','delivery_order_item.item_sku as do_iem_sku','delivery_order_item.quantity as do_quantity')->join('stock','item.id','=',"stock.item_id")->join('delivery_order_item','delivery_order_item.item_sku','=','stock.sku_code','left')->where('stock.user_id','=',$user_id)->whereRaw("stock.stock_type = 'in' and  (type='store'  or type = 'each' or type='shared') $where")->groupBy('stock_item_id','stock.sku_code')->get();
		}
		else
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.stock_item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity','delivery_order_item.id as do_item_id','delivery_order_item.item_sku as do_iem_sku','delivery_order_item.quantity as do_quantity')->join('stock','item.id','=',"stock.item_id")->join('delivery_order_item','delivery_order_item.item_sku','=','stock.sku_code','left')->where('stock.user_id',$user_id)->whereRaw("stock.stock_type ='in' and (type ='each' or type='shared') $where")->groupBy('stock_item_id','stock.sku_code')->get();
		}
		//t($product_list,1);exit;
		
		$data['product_list'] = $product_list ;
		$data['do_items'] = Delivery_orderItem::where('do_id',$id)->get();
		//t($data['do_items'],1);
		return view('salesref.store_delivary.edititemlist',$data);
	}
	public function create_store_request(Request $request)
	{
		$data = $request->all(); //t($data,1);
		$total_requested_qtn =0;
		if(isset($data['sku_code']) && !empty($data['sku_code']))
		{
			foreach($data['sku_code'] as $k=>$sku)
			{
				if($data['request_quantity'][$sku] > $data['available_quantity'][$sku])
				{
					return redirect('ship-request')->with('error-msg', 'Please select valid quantity');
				}
				else{
					$request_quantity = isset($data['request_quantity'][$sku])?$data['request_quantity'][$sku]:0;
					$total_requested_qtn = $total_requested_qtn+$request_quantity ;
				}
			}
			$data['total_requested_qtn'] = $total_requested_qtn ;
		}
		else{
			
			return redirect('ship-request')->with('error-msg', 'Please select item');
		}
		$data['store_category'] = $store_category= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['agent'] = $delivery_agent = User::where('role_id','10')->where('is_active','Yes')->where('is_deleted','No')->get();
		if(isset($data['request_type']) && $data['request_type'] == 'ship_to_locker')
		{
			$data['supplier'] = Supplier::where('is_active','Yes')->where('is_deleted','No')->get();
			
			//t($delivery_agent,1);
			return view('salesref.store_delivary.create_locker_request',$data);
		}
		else
		{
		return view('salesref.store_delivary.create_store_request',$data);
		}
	}
	function save_locker_request(Request $request)
	{
		$posted_data = $request->all();
	//t($posted_data ,1);
		$insert_do['oder_no']='BEAM-DO'.time();
		$insert_do['suppler_id']=$posted_data['supplier'];
		$insert_do['delivery_agent']=$posted_data['agent'];
		$insert_do['status']='assign_for_pickup';
		$insert_do['type']='locker';
		$insert_do['created_by']=Auth::user()->id;
		$insert_do['is_active'] ='Yes';
		$insert_do['is_deleted'] ='No';
		$do_id = Delivery_order::insertGetId($insert_do);
		if($do_id!='')
		{
			$sku = isset($posted_data['sku_code'])?$posted_data['sku_code']:array();
			$quantuty = isset($posted_data['quantuty'])?$posted_data['quantuty']:array();
			$item_id = isset($posted_data['item_id'])?$posted_data['item_id']:array();
			
			foreach($sku as $k=>$skucode){
			$insert_do_item['do_id'] = $do_id;
			$insert_do_item['item_id'] = isset($item_id[$skucode])?$item_id[$skucode]:'';
			$insert_do_item['item_sku'] = $skucode;
			$insert_do_item['quantity'] =isset($quantuty[$skucode])&&$quantuty[$skucode]!=''?$quantuty[$skucode]:0;
			$insert_do_item['is_active'] ='Yes';
			$insert_do_item['is_deleted'] ='No';
			$insert_do_item['created_by'] = Auth::user()->id;
			Delivery_orderItem::insertGetId($insert_do_item);
			
			}
			return redirect('ship-request-list')->with('success-msg', 'Request successfully created');
		}
		else{
			return redirect('ship-request-list')->with('error-msg', 'Error!Please try after sometime');
		}
	}
	public function save_store_request(Request $request)
	{
		$posted_data = $request->all();
	//	t($posted_data ,1);
		$insert_do['oder_no']='BEAM-DO'.time();
		$insert_do['store_id']=$posted_data['store'];
		$insert_do['delivery_agent'] = $posted_data['agent'];
		$insert_do['status']='assign_for_pickup';
		$insert_do['type']='store';
		$insert_do['created_by']=Auth::user()->id;
		$insert_do['is_active'] ='Yes';
		$insert_do['is_deleted'] ='No';
		$do_id = Delivery_order::insertGetId($insert_do);
		if($do_id!='')
		{
			$sku = isset($posted_data['sku_code'])?$posted_data['sku_code']:array();
			$quantuty = isset($posted_data['quantuty'])?$posted_data['quantuty']:array();
			$item_id = isset($posted_data['item_id'])?$posted_data['item_id']:array();
			foreach($sku as $k=>$skucode){
			$insert_do_item['do_id'] = $do_id;
			$insert_do_item['item_id'] = isset($item_id[$skucode])?$item_id[$skucode]:'';
			$insert_do_item['item_sku'] = $skucode;
			$insert_do_item['quantity'] =isset($quantuty[$skucode])&&$quantuty[$skucode]!=''?$quantuty[$skucode]:0;
			$insert_do_item['is_active'] ='Yes';
			$insert_do_item['is_deleted'] ='No';
			$insert_do_item['created_by'] = Auth::user()->id;
			Delivery_orderItem::insertGetId($insert_do_item);
			
			}
			return redirect('ship-request-list')->with('success-msg', 'Request successfully created');
		}
		else{
			return redirect('ship-request-list')->with('error-msg', 'Error!Please try after sometime');
		}
	}
	public function update_store_request(Request $request)
	{
		$data =  $request->all();//t($data,1);
		if(isset($data['sku_code']) && !empty($data['sku_code']))
		{
			foreach($data['sku_code'] as $k=>$sku_code)
			{
				$do_item['item_id']=$data['item_id'][$sku_code];
				$do_item['item_sku']=$sku_code;
				$do_item['quantity']=$data['request_quantity'][$sku_code];
				if(isset($data['do_item_id'][$sku_code]) && $data['do_item_id'][$sku_code]!='')
				{
					Delivery_orderItem::where('id',$data['do_item_id'][$sku_code])->update($do_item);
				}
				else
				{
					Delivery_orderItem::insertGetId($do_item);
				}
			}
		}
		return redirect('ship-request-list')->with('success-msg', 'Item successfully updated');
	}
	public function update_store_info(Request $request)
	{
			$data = $request->all();
			$update_store['store_id'] =$data['store'];
			$update_store['delivery_agent'] = $data['agent'];
			$update_store['updated_by'] =Auth::user()->id;
			Delivery_order::where('id',$data['do_id'])->update($update_store);
			return redirect('ship-request-list')->with('success-msg', 'Store successfully updated');
	}
	public function edit_store_info($id)
	{
		$id= base64_decode($id);
		$data['do'] = $do = Delivery_order::select('delivery_order.*','store.store_category')->join('store','store.id','=','store_id','left')->where('delivery_order.id',$id)->get();
		//t($do,1);
		$data['store_category'] = $store_category= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['store'] = $store= Store::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['agent'] = $delivery_agent = User::where('role_id','10')->where('is_active','Yes')->where('is_deleted','No')->get();
		return view('salesref.store_delivary.edit_create_store_request',$data);
	}
	public function ship_request_list(Request $request)
	{
		$posted = $request->all();
		$where = "";
		if(isset($posted['search']) && $posted['search']!='')
		{
			$search = $posted['search'];
			//$where =" and delivery_order.oder_no = '$search' ";
			$do_list = Delivery_order::select('delivery_order.*','store_category.name as store_category')->join('store','store.id','=','store_id','left')->join('store_category','store_category.id','=','store.store_category','left')->where('delivery_order.created_by',Auth::user()->id)->where('delivery_order.is_active','Yes')->where('delivery_order.is_deleted','No')->where('delivery_order.oder_no', 'like',$search)->orderBy('id','desc')->get();
			
		}
		else{
			$do_list = Delivery_order::select('delivery_order.*','store_category.name as store_category')->join('store','store.id','=','store_id','left')->join('store_category','store_category.id','=','store.store_category','left')->where('delivery_order.created_by',Auth::user()->id)->where('delivery_order.is_active','Yes')->where('delivery_order.is_deleted','No')->orderBy('id','desc')->get();
		}
		$data['title'] = 'Ship Request List';
		
		$data['do_list'] = $do_list;
		//t($do_list,1);
		return view('salesref.store_delivary.ship_request_list',$data);
	}
	public function get_store_list(Request $request)
	{
		$data = $request->all();
		$province_id = Auth::user()->province_id;
		$store_cat =isset($data['cat_id'])?$data['cat_id']:'';
		$Store = Store::distinct('distinct(store.id)','store.store_name')->join('country','country.id','=','store.country','left')->join('provinces','country.id','=','provinces.country_id','left')->where('store_category',$store_cat)->where('store.is_active','Yes')->where('store.is_deleted','No')->where('provinces.id',$province_id)->get();
		$html ='<option value="">Select</option>';
		
		foreach($Store as $Storelist)
		{
			$html .='<option value="'.$Storelist->id.'">'.$Storelist->store_name.'</option>';
		}
		echo $html;
	}
	public function view_ship_request($id,Request $request)
	{
		$doId = base64_decode($id);
		
		$posted_data = $request->all();
		$data['title'] = 'Delivery Order Details';
		$data['role_id'] = $role_id =  Auth::user()->role_id ;
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();

		$data['doinfo']=$doinfo =Delivery_order::where('id',$doId)->get();
		//t($doinfo,1);
		
		
		$store_id = isset($doinfo[0]->store_id)?$doinfo[0]->store_id:0 ;
		$data['store']= $storeinfo = Store::where('id',$store_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$country_id = isset($storeinfo[0]->country)?$storeinfo[0]->country:0 ;
		$data['country']= Country::where('id',$country_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$province_id = isset($storeinfo[0]->state)?$storeinfo[0]->state:0 ;
		$data['province']= Region::where('id',$province_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$suppler_id = isset($doinfo[0]->suppler_id)?$doinfo[0]->suppler_id:0 ;
		$data['supplier']= Supplier::where('id',$suppler_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		
		$delivery_agent_id = isset($doinfo[0]->delivery_agent)?$doinfo[0]->delivery_agent:0 ;
		$data['delivery_agent']= User::where('id',$delivery_agent_id)->where('role_id',10)->where('is_deleted','No')->where('is_active','Yes')->get();
		
	
		
		$data['do_list'] = $do_list = Delivery_orderItem::select('delivery_order_item.*','item.name as item_name','item.product_type','item.regular_price','item.batch_no','item.expire_date','item.retail_price','item.image')->join('item','delivery_order_item.item_id','=','item.id','left')->where('delivery_order_item.is_active','Yes')->where('delivery_order_item.is_deleted','No')->get();
	
		return view('salesref.store_delivary.view_delivery_item',$data);
	}
		
	public function edit_supplier_info($id)
	{	$id = base64_decode($id);
		$data['supplier'] = Supplier::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['agent'] = $delivery_agent = User::where('role_id','10')->where('is_active','Yes')->where('is_deleted','No')->get();
		$data['do'] = $do = Delivery_order::select('delivery_order.*','store.store_category')->join('store','store.id','=','store_id','left')->where('delivery_order.id',$id)->get();
		return view('salesref.store_delivary.edit_locker_request',$data);
	}
	public function update_locker_info(Request $request)
	{
		$data =  $request->all();
		$update['suppler_id'] = $data['supplier'];
		$update['delivery_agent'] = $data['agent'];
		Delivery_order::where('id',$data['do_id'])->update($update);
		return redirect('ship-request-list')->with('success-msg', 'Supplier information successfully created');
	}
}
	
?>
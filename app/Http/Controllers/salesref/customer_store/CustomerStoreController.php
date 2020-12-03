<?php

namespace App\Http\Controllers\salesref\customer_store;

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
use  App\Model\POAllocation;
use  App\Model\Stock;
use  App\Model\ProductPrivacy;

use App\Model\StoreCategory;
use App\Model\Country;
use App\Model\Provinces;
use App\Model\Store;


class CustomerStoreController extends Controller
{
	
	public function customer_store_list()
	{
		DB::enableQueryLog();
		$data['title'] = 'Customers/Stores';
		
		$user_id = Auth::user()->id;
		$user_info = User::where('id',$user_id)->where('is_deleted','No')->get();
		
		$country_id = isset($user_info[0]->country_id)?$user_info[0]->country_id:0 ;
		$data['country'] = Country::
		select('country.*')
		->where('country.id','=',$country_id)
		->where('country.is_deleted','=','No')
		->get();

		
		$data['info']=Store::select('store.*','store_category.name as category','country.country_name','provinces.name as province')->leftjoin('store_category','store.store_category','=','store_category.id')->leftjoin('provinces','store.state','=','provinces.id')->leftjoin('country','store.country','=','country.id')->where('store.country',$country_id)->where('store.is_deleted','No')->get();
		//$query = DB::getQueryLog();
	    //t($query,1);
		return view('salesref.customer_store.customer_store_list',$data);
	}
	
	public function remove_store(Request $request)
	{
		DB::enableQueryLog();
		$data['title'] = 'Customers/Stores';
		$posteddata = $request->all();
		$check =$posteddata['check_list'];
		$check_box_val_arr = array();
		foreach($check as $checks){
			array_push($check_box_val_arr,$checks);
		}
		//t($check,1);

		$update_data['is_deleted'] = 'Yes';
		$updated=Store::whereIn('id',$check_box_val_arr)->update($update_data);
		$query = DB::getQueryLog();
		//t($query,1);
		if($updated)
            return redirect('customer-store-list')->with('success-msg', 'Store successfully deleted');
        else
        {
            return redirect('customer-store-list')->with('error-msg', 'Please try after some time');    
        }
		
		
	}
	public function add_customer_store()
    {
        $data['title']="Add Customer Store";
		$data['store_category']= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['country']= Country::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['Provinces']= Provinces::where('is_active','Yes')->where('is_deleted','No')->where('country_id',1)->get();
        return view('salesref.customer_store.customer_store_add',$data);
    }
	public function get_store_province_list_by_country(Request $Request)
	{
		$data = $Request->all();
		//t($data,1);
		$country_id = $data['country_id'];
		if($country_id == "")
		{
			$province_list = Region::where('is_deleted','No')->orderBy('name','asc')->get();
		}
		else if($country_id != "")
		 	$province_list = Region::where('country_id',$country_id)->orderBy('name','asc')->get();
		echo json_encode($province_list);
	}
	    public function save_customer_store(Request $request)
    {
        $data=$request->all();
		//t($data);
		//exit() ;
		$insertData['store_name']=isset($data['store_name'])?$data['store_name']:'' ;
		$insertData['store_category']=isset($data['store_category'])?$data['store_category']:0;
		$insertData['contact_person']= isset($data['contact_person'])?$data['contact_person']:'' ; 
		$insertData['email']= isset($data['email'])?$data['email']:'' ; 
		$insertData['phone']= isset($data['phone'])?$data['phone']:'' ;   
		$insertData['country']= isset($data['country'])?$data['country']:0; 
		$insertData['state']=  isset($data['state'])?$data['state']:0;  
		$insertData['city']=isset($data['city'])?$data['city']:'' ;
		$insertData['zipcode']= isset($data['zipcode'])?$data['zipcode']:'';
		$insertData['address']=isset($data['address'])?$data['address']:'';
		$insertData['created_by']=Auth::user()->id; ;
		
        
        $insertData['created_by'] = Auth::user()->id;
        $id=Store::insertGetId($insertData);
        if($id!='')
        {
            return redirect('customer-store-list')->with('success-msg', 'Store successfully added');
        }
        else			
        {
            return redirect('customer-store-list')->with('error-msg', 'Please try after some time');
        }
    }
	public function edit_customer_store($storeId)
    {
       if (base64_decode($storeId, true)) 
       {
            $id=base64_decode($storeId);
			//t($id,1);
            $data["title"]="Store";
			$data['store_category']= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['country']= Country::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['Provinces']= Region::where('is_active','Yes')->where('is_deleted','No')->get();
         $data["info"]=Store::where('id',$id)->get();
            return view('salesref.customer_store.customer_store_edit',$data);
       }
       else
            abort(404);    
    }

    public function update_customer_store(Request $request)
    {
        $data=$request->all();
        
		
		$insertData['store_name']=isset($data['store_name'])?$data['store_name']:'' ;
		$insertData['store_category']=isset($data['store_category'])?$data['store_category']:0;
		$insertData['contact_person']= isset($data['contact_person'])?$data['contact_person']:'' ; 
		$insertData['email']= isset($data['email'])?$data['email']:'' ; 
		$insertData['phone']= isset($data['phone'])?$data['phone']:'' ;   
		$insertData['country']= isset($data['country'])?$data['country']:0; 
		$insertData['state']=  isset($data['state'])?$data['state']:0;  
		$insertData['city']=isset($data['city'])?$data['city']:'' ;
		$insertData['zipcode']= isset($data['zipcode'])?$data['zipcode']:'';
		$insertData['address']=isset($data['address'])?$data['address']:'';
		
        $insertData['updated_by'] = Auth::user()->id;
        $id=$data["id"];
        $updated=Store::where('id',$id)->update($insertData);
        if($updated)
            return redirect('customer-store-list')->with('success-msg', 'Details successfully updated');
        else
        {
            $url="edit-customer-store/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	
	
	
	
	
	
	public function stock_category(Request $request,$type,$role_id)
	{
		$data['title'] = 'My Stock Category';
		$data['type'] = $type ;
		$posteddata = $request->all();
		$data['search_category'] = $search_category = isset($posteddata['search_category']) ? $posteddata['search_category'] : '';
		$where = '1=1';
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
				}
				else{
					$product_sku_id = Product::where('sku', 'LIKE', "%$search_category%")->get();
					if(!empty($product_sku_id)&& count($product_sku_id)>0)
						{
							foreach($product_sku_id as $product_sku_id_val)
							{
								array_push($product_id_arr,$product_sku_id_val->id);
							}
						}
						else{
							$product_name_id = Product::where('name', 'LIKE', "%$search_category%")->get();
							if(!empty($product_name_id)&& count($product_name_id)>0)
								{
									foreach($product_name_id as $product_name_id_val)
									{
										array_push($product_id_arr,$product_name_id_val->id);
									}
								}
								array_push($product_id_arr,0);
						}
						
						
								 $item_details = Product::whereIn('id',$product_id_arr)->get();
								 if(!empty($item_details)&& count($item_details)>0)
								 {
								 foreach($item_details as $item_details_val)
								 {
									 array_push($cat_id_arr,$item_details_val->category_id);
								 }
								 }
								 else{
									  array_push($cat_id_arr,0);
								 }
				}
				//$where .= " and lower(product_category.name) LIKE '%$search_category%'";
				$category_id_val = implode(',',$cat_id_arr);
				$where .= ' and product_category.id in('.$category_id_val.')';
			}
		}
		$data['category']=$category = ProductCategory::where('is_deleted','No')->whereRaw($where)->orderBy('id','asc')->get();
		return view('salesref.productcategorylist',$data);
	}
	
	public function item_list(Request $request,$type='',$role_id='',$cate_id='')
	{
		DB::enableQueryLog();
		$data['title'] = 'Stock List';
		$data['type'] = $type ;
		$data['role_id'] = $role_id =  base64_decode($role_id) ;
		$data['cate_id'] = $cate_id = base64_decode($cate_id) ;
		$user_id = Auth::user()->id ;
		$posteddata = $request->all();
		
		$where = '1=1' ;
		if($cate_id!='')
		{
			$where .= ' and item.category_id='.$cate_id;
			
		}
		if($type =='my-locker')
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id',$user_id)->where('stock.stock_type','in')->where('type','store')->whereRaw($where)->groupBy('stock_item_id','stock.sku_code')->get();
		}
		else if($type =='own-by-me')
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id',$user_id)->where('stock.stock_type','in')->where('type','each')->orWhere('type','shared')->whereRaw($where)->groupBy('stock_item_id','stock.sku_code')->get();
		}
		else if($type =='not-own-by-me')
		{
			$product_list = Product::select('item.name as itemname','item.description','item.image','item.regular_price','item.retail_price','item.batch_no','stock.item_id as stock_item_id','stock.id as stock_id','stock.sku_code','stock.quantity')->join('stock','item.id','=',"stock.item_id")->where('stock.user_id','!=',$user_id)->where('stock.stock_type','in')->where('type','store')->orWhere('type','each')->orWhere('type','shared')->whereRaw($where)->groupBy('stock_item_id','stock.sku_code')->get();
		}
		
		$query = DB::getQueryLog();
		$data['product_list'] = $product_list ;
		//t($query);
		//t($product_list);
		//exit();
		return view('salesref.mystock.itemlist',$data);
		
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
		
		
		$where = '1=1';
		if ($posteddata) {
			
			if ($purchase_order_no_val != '') {
				
				$where .= " and lower(purchase_order.order_no) LIKE '%".$purchase_order_no_val."%'";	
							
			}
			if ($purchase_order_status_val != '') {
				
				$where .= " and lower(purchase_order.status) LIKE '%$purchase_order_status_val%'";
			}
			

		}
		
		$user_id = Auth::user()->id;
		$data['purchase_order'] = $list = PO::select('purchase_order.*')->whereRaw($where)->where('purchase_order.is_deleted','No')->where('delivery_agent_id',$user_id)->orderBy('purchase_order.id','desc')->get();
		
		//t($list,1);
		//$query = DB::getQueryLog();
		//t($query);
		//exit();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('currior.pickuplist',$data);
    }
	
	public function purchase_order_confirmation($POorderId)
	{
		$data= array();
		$poId = base64_decode($POorderId);
		$po_details = PO::select('purchase_order.*','purchase_order_details.item_sku','purchase_order_details.id as po_item_id','purchase_order_details.item_variance_id','purchase_order_details.item_id','purchase_order_details.quantity','item.name','item.image','item.regular_price','item.retail_price','item.self_life','item.batch_no','purchase_order_details.self_life','purchase_order_details.quantity_received')->join('purchase_order_details','purchase_order_details.po_id','=','purchase_order.id','left')->join('item','item.id','=',"purchase_order_details.item_id","left")->where('purchase_order.id',$poId)->get();
		//t($po_details,1);
		$data['po_details'] = $po_details;
		 return view('currior.Orderconfirmation',$data);
	}
	
	public function save_packing_info(Request $request)
	{
		DB::beginTransaction();
		$data = $request->all();
	//t($data,1);
		$total_quantity =0;
		$item_matched = true;
		foreach($data['quantity'] as $k=>$quantity)
		{
			if($quantity < $data['item_orderd'][$k])
			{
				$item_matched = false;
			}
		}
		if($item_matched == false)
		{
			$update_status['status'] = 'pending_for_verification';
			PO::where('id',$data['po_id'])->update($update_status);
			foreach($data['po_item_id'] as $k=>$po_item_id)
			{
				$update_po_item['regular_price'] = $data['regular_price'][$k];
				$update_po_item['quantity_received'] =  $data['quantity'][$k];
				$update_po_item['quantity'] = $data['quantity'][$k];
				$update_po_item['retail_price'] =  $data['retail_price'][$k];
				$update_po_item['self_life'] =  $data['self_life'][$k];
				POItem::where('id',$po_item_id)->update($update_po_item);
			}
			return redirect('pickup-order-list')->with('error-msg', 'Item quantity no match with po details,po order send to admin for verification');
		}
		else
		{
			$update_status['status'] = 'in_transit';
			//$update_status['total_tiem_quantity'] = $data['total_item_quantity'];
			//$update_status['no_of_box'] = $data['no_of_box'];
			PO::where('id',$data['po_id'])->update($update_status); 
			foreach($data['po_item_id'] as $k=>$po_item_id)
			{
				$update_po_item['regular_price'] = $data['regular_price'][$k];
				$update_po_item['retail_price'] =  $data['retail_price'][$k];
				$update_po_item['self_life'] =  $data['self_life'][$k];
				$update_po_item['quantity_received'] =  $data['quantity'][$k];
				POItem::where('id',$po_item_id)->update($update_po_item);
				$have_packing_info = PoBox::where('po_item_id',$po_item_id)->get();
				if(empty($have_packing_info) || count($have_packing_info)==0)
				{
					DB::rollBack();
					return redirect('pickup-order-confirmation/'.base64_encode($data['po_id']))->with('error-msg', 'Please provide packing information for all item');
				}
			}
			DB::commit();
			return redirect('packing-box-info/'.base64_encode($data['po_id']))->with('success-message', 'Item verification successfully done');
		}
	}
	
	public function packing_box_info($po_itemId)
	{
		 $po_itemId = base64_decode($po_itemId);
		 $info['packing_info'] = PoBox::where('po_item_id',$po_itemId)->where('is_deleted','No')->where('is_active','Yes')->get();
		
		$po_details = PO::select('*','purchase_order_details.id as po_item_id','purchase_order.created_by as pocreated_by')->join('purchase_order_details','purchase_order_details.po_id','=','purchase_order.id','left')->join('item','item.id','=',"purchase_order_details.item_id","left")->where('purchase_order_details.id',$po_itemId)->get();
			$info['po_details'] = $po_details;
			//t($po_details,1);
			$user_details = User::where('id',$po_details[0]->pocreated_by)->get();
			$info['warehouse'] = $warehouse = Warehouse::where('id',$po_details[0]->warehouse_id)->get();
			$info['user_details']=$user_details;
			$info['BoxType']=BoxType::where('is_active','Yes')->where('is_deleted','No')->get();
			return view('currior.poboxInformation',$info);
	}
	public function save_box_info(Request $request)
	{
		$data = $request->all();// t($data,1);
		foreach($data['box_type'] as $k=>$box_type)
		{
			if(isset($data['box_packing_id'][$k]) && $data['box_packing_id'][$k]!=''){
			$insert_boxInfo['po_item_id'] = $data['po_item_id'];
			$insert_boxInfo['item_sku'] = $data['item_sku'];
			$insert_boxInfo['po_id'] = $data['po_id'];
			$insert_boxInfo['box_type'] =$box_type;
			$insert_boxInfo['updated_by'] =Auth::user()->id;
			$insert_boxInfo['box'] =$data['box'][$k];
			$insert_boxInfo['quantity_per_box'] = $data['qtn_per_box'][$k];
			PoBox::where('id',$data['box_packing_id'])->update($insert_boxInfo);
			}
			else{
			$insert_boxInfo['po_item_id'] = $data['po_item_id'];
			$insert_boxInfo['item_sku'] = $data['item_sku'];
			$insert_boxInfo['po_id'] = $data['po_id'];
			$insert_boxInfo['box_type'] =$box_type;
			$insert_boxInfo['created_by'] =Auth::user()->id;
			$insert_boxInfo['box'] =$data['box'][$k];
			$insert_boxInfo['quantity_per_box'] = $data['qtn_per_box'][$k];
			$id=PoBox::insertGetId($insert_boxInfo);
			}
		}
		return redirect('pickup-order-confirmation/'.base64_encode($data['po_id']))->with('success-msg', 'Item packing information save successfully');
	}
	}
	
?>
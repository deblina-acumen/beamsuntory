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

class StockController extends Controller
{
	
	public function stock_dashboard()
	{
		$data['title'] = 'My Stock dashboard';
		return view('salesref.my_stock_dashboard',$data);
	}
	
	public function stock_category(Request $request)
	{
		$data['title'] = 'My Stock Category';
		
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
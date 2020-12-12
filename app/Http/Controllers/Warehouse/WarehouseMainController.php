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
use App\Model\POAllocation;
use App\Model\Stock;
use Auth;
use DB;
class WarehouseMainController extends Controller
{
	
	public function incomming_stock_list(Request $request)
    {

		DB::enableQueryLog();
		$posteddata = $request->all();
		//t($posteddata);
		//exit();
        $data['title']="Incomming Stock List";
		
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
		$warehouse_details= get_warehouse_id_by_user($user_id );
		$ware_house_id = $warehouse_details[0]->id;
		
		$data['purchase_order'] = $list = PO::select('purchase_order.*')->whereRaw($where)->where('purchase_order.is_deleted','No')->where('warehouse_id',$ware_house_id)->orderBy('purchase_order.id','desc')->get();
		
		//t($list,1);
		//$query = DB::getQueryLog();
		//t($query);
		//exit();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('Warehouse.incomming_stock_list',$data);
    }
	
	public function purchase_order_confirmation($POorderId)
	{
		$data= array();
		$poId = base64_decode($POorderId);
		$po_details = PO::select('purchase_order.*','purchase_order_details.item_sku','purchase_order_details.id as po_item_id','purchase_order_details.item_variance_id','purchase_order_details.item_id','purchase_order_details.quantity','item.name','item.image','item.regular_price','item.retail_price','item.self_life','item.batch_no','purchase_order_details.self_life','purchase_order_details.quantity_received')->join('purchase_order_details','purchase_order_details.po_id','=','purchase_order.id','left')->join('item','item.id','=',"purchase_order_details.item_id","left")->where('purchase_order.id',$poId)->get();
		//t($po_details,1);
		$data['po_details'] = $po_details;
		 return view('Warehouse.Orderconfirmation',$data);
	}
	
	public function save_accpt_order_details(Request $request)
	{
		DB::beginTransaction();
		$data = $request->all();
		$po_details = PO::where('id',$data['po_id'])->get();
		//t($data);t($po_details );exit;
		$active_date = isset($po_details[0]->active_date)&& $po_details[0]->active_date!=''?date('Y-m-d',strtotime($po_details[0]->active_date)):'';
		$active_time = isset($po_details[0]->active_time)&& $po_details[0]->active_time!=''?date('H:i:s',strtotime($po_details[0]->active_time)):'';
		$total_quantity =0;
		$item_matched = true;
		
			
			foreach($data['po_item_id'] as $k1=>$po_item_id)
			{
				$allocation_detials = POAllocation::where('po_id',$data['po_id'])->where('podetails_id',$po_item_id)->where('is_deleted','No')->get();
			//t($allocation_detials);
			//$usr_arr=array();
			foreach($allocation_detials as $k=>$alocation)
			{
				
					$user = json_decode($alocation->user); 
					foreach($user as $usr)
					{
						$user_ids = explode(',',$usr);
						foreach($user_ids as $usrinfo)
						{
							$item_details = product($alocation->item_id);
							$user_data = User::where('id',$usrinfo)->get();
							//insert into stock 
							$stock_data['warehouse_id'] = $data['po_warehouse_id'];
							$stock_data['user_id'] = $user_data[0]->id;
							$stock_data['item_id'] = $alocation->item_id;
							$stock_data['sku_code'] = $data['item_sku'][$k1];
							$stock_data['item_type'] = isset($item_details->product_type)?$item_details->product_type:'';
							$stock_data['stock_type'] = 'in';
							$stock_data['order_type'] = 'po';
							$stock_data['order_type_id'] = $data['po_id'];
							$stock_data['allocation_id'] = $alocation->id;
							$stock_data['quantity'] = $alocation->quantity;
							if($active_date!='')
							{
								$stock_data['active_date'] = $active_date;
							}
							if($active_time!='')
							{
								$stock_data['active_time'] = $active_time;
							}
							 if($alocation->each_user =="each")
							{
							 $stock_data['type'] = 'each';
							 Stock::insert($stock_data);
							}
							 else if($alocation->share_user =="shared")
							{
							 $stock_data['type'] = 'shared';
							 Stock::insert($stock_data);
							}
							 
						}
					}
				
				
			}
				$update_status['status'] = 'delivered';
				$update_status['delivery_date'] = date('Y-m-d h:i:s');
				PO::where('id',$data['po_id'])->update($update_status); 
				//POItem::where('id',$po_item_id)->update($update_po_item);
				/* $have_packing_info = PoBox::where('po_item_id',$po_item_id)->whereRaw('box_recceived_by_wh  is null')->get();
				if(empty($have_packing_info) || count($have_packing_info)==0)
				{
					DB::rollBack();
					return redirect('wh-order-confirmation/'.base64_encode($data['po_id']))->with('error-msg', 'Please provide packing information for all item');
				} */
			}
			DB::commit();
			return redirect('wh-incomming-stock/')->with('success-msg', 'Successfully accept po items');
		
	}
	
	public function confirm_box($po_itemId)
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
			return view('Warehouse.poboxInformation',$info);
	}
	public function accpt_box_info(Request $request)
	{
		$data = $request->all(); //t($data,1);
		foreach($data['box_packing_id'] as $k=>$box_packing_id)
		{
			
			$insert_boxInfo['box_recceived_by_wh'] = $data['box'][$k];
			PoBox::where('id',$box_packing_id)->update($insert_boxInfo);
			
			
		}
		return redirect('wh-order-confirmation/'.base64_encode($data['po_id']))->with('success-msg', 'Box   successfully accepted');
	}
	}
	
?>
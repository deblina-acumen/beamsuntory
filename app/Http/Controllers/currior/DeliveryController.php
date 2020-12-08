<?php
namespace App\Http\Controllers\currior;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Delivery_order;
use App\Model\Delivery_orderItem;
use App\Model\POAllocation;
use App\Model\Stock;
use Auth;
use DB;
class DeliveryController extends Controller
{
	
	function do_list()
	{
		$user_id = Auth::user()->id;
		$data['do_list'] = Delivery_order::where('delivery_agent',$user_id)->where("is_active","Yes")->where("is_deleted",'No')->get();
		//t($do_list);
		return view('currior.do_list',$data);
	}
	
	function do_details($do_id)
	{
		 $do_id = base64_decode($do_id);
		 $data['do_details'] = $do_details= Delivery_order::join('delivery_order_item','delivery_order_item.do_id','=','delivery_order.id','left')->where('delivery_order.id',$do_id)->get();
		 //t($do_details,1);
		return view('currior.do_detais',$data);
	}
	function confirm_do_pickup($do_id)
	{
		$do_id = base64_decode($do_id);
		$do_details= Delivery_order::join('delivery_order_item','delivery_order_item.do_id','=','delivery_order.id','left')->where('delivery_order.id',$do_id)->get();
		
		//t($all_stock);
		foreach($do_details as $do){
		$all_stock = Stock::where('sku_code',$do->item_sku)->where('user_id',$do_details[0]->created_by)->where('Stock_type','in')->where('type','!=','store')->get();
		$stock_quantity = $do->quantity;
		$is_assigned_stock = false;
		foreach($all_stock as $allstock)
		{
			while($is_assigned_stock !=true)
			{
			if($allstock->type == 'each' && $stock_quantity<=$allstock->available_qtn)
			{
				
				$inset_stock['stock_id'] =$allstock->id;
				$inset_stock['user_id'] = $allstock->user_id;
				$inset_stock['item_id'] = $do->item_id;
				$inset_stock['sku_code']=$do->item_sku;
				$inset_stock['type']="each";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "DO";
				$inset_stock['quantity'] = $stock_quantity;
				Stock::insertGetId($inset_stock);
				$update_stock['available_qtn'] = $allstock->available_qtn - $stock_quantity;
				Stock::where('id',$allstock->id)->update($update_stock);
				$is_assigned_stock  = true;
				$stock_quantity = 0;
				if($do->type=='locker')
				{
				
				$inset_instock['user_id'] = $allstock->user_id;
				$inset_instock['item_id'] = $do->item_id;
				$inset_instock['sku_code']=$do->item_sku;
				$inset_instock['type']="store";
				$inset_instock['stock_type'] = "in";
				$inset_instock['order_type'] = "DO";
				$inset_instock['available_qtn'] =  $stock_quantity;
				$inset_instock['quantity'] = $stock_quantity;
				Stock::insertGetId($inset_instock);
				}
			}
			else if($allstock->type == 'each' && $stock_quantity > $allstock->available_qtn)
				
			{
				
				$inset_stock['stock_id'] =$allstock->id;
				$inset_stock['user_id'] = $allstock->user_id;
				$inset_stock['item_id'] = $do->item_id;
				$inset_stock['sku_code']=$do->item_sku;
				$inset_stock['type']="each";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "DO";
				$inset_stock['quantity'] = $allstock->quantity;
				Stock::insertGetId($inset_stock);
				$update_stock['available_qtn'] = 0;
				Stock::where('id',$allstock->id)->update($update_stock);
				$stock_quantity = $stock_quantity - $allstock->available_qtn;
				if($do->type=='locker')
				{
				
				$inset_instock['user_id'] = $allstock->user_id;
				$inset_instock['item_id'] = $do->item_id;
				$inset_instock['sku_code']=$do->item_sku;
				$inset_instock['type']="store";
				$inset_instock['stock_type'] = "in";
				$inset_instock['available_qtn'] =  $allstock->available_qtn;
				$inset_instock['order_type'] = "DO";
				$inset_instock['quantity'] = $allstock->available_qtn;
				Stock::insertGetId($inset_instock);
				}
			}
			elseif($allstock->type == 'shared' && $stock_quantity <= $allstock->available_qtn)
			{
				$another_stock_othruser = Stock::where('allocation_id',$allstock->allocation_id)->where('type','shared')->get();
			    foreach($another_stock_othruser as $shredstock)
				{
				
				
				$inset_stock['stock_id'] =$shredstock->id;
				$inset_stock['user_id'] = $shredstock->user_id;
				$inset_stock['item_id'] = $do->item_id;
				$inset_stock['sku_code']=$do->item_sku;
				$inset_stock['type']="shared";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "DO";
				$inset_stock['quantity'] = $stock_quantity;
				Stock::insertGetId($inset_stock);
				$update_stock['available_qtn'] = $shredstock->available_qtn - $stock_quantity;
				Stock::where('id',$shredstock->id)->update($update_stock);
				
				}
				if($do->type=='locker')
				{
				
				$inset_instock['user_id'] = $do->created_by;
				$inset_instock['item_id'] = $do->item_id;
				$inset_instock['sku_code']=$do->item_sku;
				$inset_instock['type']="store";
				$inset_instock['stock_type'] = "in";
				$inset_instock['order_type'] = "DO";
				$inset_instock['available_qtn'] =  $stock_quantity;
				$inset_instock['quantity'] = $stock_quantity;
				Stock::insertGetId($inset_instock);
				}
				$is_assigned_stock  = true;
				$stock_quantity = 0;
			}
			elseif($allstock->type == 'shared' && $stock_quantity > $allstock->available_qtn)
			{
				$another_stock_othruser = Stock::where('allocation_id',$allstock->allocation_id)->where('type','shared')->get();
			    foreach($another_stock_othruser as $shredstock)
				{
				$inset_stock['stock_id'] =$shredstock->id;
				$inset_stock['user_id'] = $shredstock->user_id;
				$inset_stock['item_id'] = $do->item_id;
				$inset_stock['sku_code']=$do->item_sku;
				$inset_stock['type']="shared";
				$inset_stock['stock_type'] = "out";
				$inset_stock['order_type'] = "DO";
				$inset_stock['quantity'] =  $allstock->available_qtn;
				Stock::insertGetId($inset_stock);
				$update_stock['available_qtn'] = $shredstock->available_qtn -  $allstock->available_qtn;
				Stock::where('id',$shredstock->id)->update($update_stock);
				
				}
				if($do->type=='locker')
				{
				//$inset_stock['stock_id'] =$allstock->stock_id;
				$inset_instock['user_id'] = $do->created_by;
				$inset_instock['item_id'] = $do->item_id;
				$inset_instock['sku_code']=$do->item_sku;
				$inset_instock['type']="store";
				$inset_instock['stock_type'] = "in";
				$inset_instock['order_type'] = "DO";
				$inset_instock['quantity'] =  $allstock->available_qtn;
				$inset_instock['available_qtn'] =  $allstock->available_qtn;
				Stock::insertGetId($inset_instock);
				}
				$is_assigned_stock  = true;
				$stock_quantity = 0;
			}
			
			}
		}
		}
		return redirect('delivery-order-list')->with('success-msg', 'Succssfully picked up');
		
	}
}
	
?>
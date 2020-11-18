<?php

namespace App\Http\Controllers\currior;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Warehouse;
use App\Model\Supplier;
use App\Model\PO;
use App\Model\User;
use App\Model\POItem;
use App\Model\ProductVariations;
use Auth;
use DB;
class PickupController extends Controller
{
	
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
		$po_details = PO::select('purchase_order.*','purchase_order_details.item_sku','purchase_order_details.id as po_item_id','purchase_order_details.item_variance_id','purchase_order_details.item_id','purchase_order_details.quantity','item.name','item.image','item.regular_price','item.retail_price','item.self_life')->join('purchase_order_details','purchase_order_details.po_id','=','purchase_order.id','left')->join('item','item.id','=',"purchase_order_details.item_id","left")->where('purchase_order.id',$poId)->get();
		//t($po_details,1);
		$data['po_details'] = $po_details;
		 return view('currior.Orderconfirmation',$data);
	}
	
	public function save_packing_info(Request $request)
	{
		$data = $request->all();
	//t($data,1);
		$total_quantity =0;
		foreach($data['quantity'] as $quantity)
		{
			$total_quantity = $total_quantity +$quantity;
		}
		if($total_quantity!= $data['prev_total_count'])
		{
			$update_status['status'] = 'pending_for_verification';
			PO::where('id',$data['po_id'])->update($update_status);
			return redirect('pickup-order-list')->with('error-msg', 'Item quantity no match with po details,po order send to admin for verification');
		}
		else
		{
			//$update_status['status'] = 'in_transit';
			$update_status['total_tiem_quantity'] = $data['total_item_quantity'];
			$update_status['no_of_box'] = $data['no_of_box'];
			PO::where('id',$data['po_id'])->update($update_status); 
			foreach($data['po_item_id'] as $k=>$po_item_id)
			{
				$update_po_item['regular_price'] = $data['regular_price'][$k];
				$update_po_item['retail_price'] =  $data['retail_price'][$k];
				$update_po_item['self_life'] =  $data['self_life'][$k];
				POItem::where('id',$po_item_id)->update($update_po_item);
			}
			$po_details = PO::select('purchase_order.*','purchase_order_details.item_sku','purchase_order_details.id as po_item_id','purchase_order_details.item_variance_id','purchase_order_details.item_id','purchase_order_details.quantity','item.name','item.image','item.regular_price','item.retail_price','item.self_life')->join('purchase_order_details','purchase_order_details.po_id','=','purchase_order.id','left')->join('item','item.id','=',"purchase_order_details.item_id","left")->where('purchase_order.id',$data['po_id'])->get();
			$info['po_details'] = $po_details;
			return view('currior.poboxInformation',$info);
		}
	}
}
?>
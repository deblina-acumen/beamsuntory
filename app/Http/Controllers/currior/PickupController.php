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
		
		
		//$query = DB::getQueryLog();
		//t($query);
		//exit();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('currior.pickuplist',$data);
    }
	
	public function purchase_order_confirmation($orderId)
	{
		$data= array();
		 return view('currior.Orderconfirmation',$data);
	}
	
}
?>
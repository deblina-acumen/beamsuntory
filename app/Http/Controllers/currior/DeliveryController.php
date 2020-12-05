<?php

namespace App\Http\Controllers\currior;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Delivery_order;
use App\Model\Delivery_orderItem;
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
		$data['do_details'] = $do_details= Delivery_order::join('delivery_order_item','delivery_order_item.do_id','=','delivery_order.id','left')->where('delivery_order.id',$do_id)->get();
		t($do_details,1);
	}
}
	
?>
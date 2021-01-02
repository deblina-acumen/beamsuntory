<?php

namespace App\Http\Controllers\salesref\user;

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
use Mail;

class CustomerUserController extends Controller
{
	
	public function customer_user_list(Request $request)
	{
		DB::enableQueryLog();
		$data['title'] = 'Customers/user';
		$posted_data = $request->all();
		$store_name = isset($posted_data['search_category'])?$posted_data['search_category']:'';
		$data['search_category'] =$store_name;
		$where=" 1=1 ";
		if($store_name !='')
		{
			$where .= " and `users`.`name` like '%$store_name%'";
		}
		$user_id = Auth::user()->id;
		
		$user_info = User::where('users.created_by',$user_id)->where('is_deleted','No')->get();
		$data['role_id'] = $role_id = Auth::user()->role_id;
		
		//t($role_id);
		
		
	 /* $chield_tree = $this->get_child_role($role_id);
	 echo "<pre>";
	 print_r($chield_tree);
	 echo count($chield_tree);
	 $chield_tree_arr = array();
	 foreach($chield_tree as $chield_tree_val)
	 {
		 if(is_array($chield_tree_val))
		 {
			 foreach($chield_tree_val as $chield_tree_val_val)
			 {
				 
							 array_push($chield_tree_arr,$chield_tree_val_val);
						
			 }
		 }
		 else{
			 array_push($chield_tree_arr,$chield_tree_val);
		 }
	 }
	 t($chield_tree_arr);
		exit(); */
		

		
		$data['info']=$user_info;
		$query = DB::getQueryLog();
	    //t($query,1);
		return view('salesref.customer_user.customer_user_list',$data);
	}
	
	public function get_child_role($role_id)
	{
		$chield_arr = array();
		$chile_role = Role::where('parent_id',$role_id)->get();
		if(!empty($chile_role)&& count($chile_role)>0)
		{
			
			foreach($chile_role as $chile_role_val)
			{
				$chiled_id  = $chile_role_val->id;
			//t($chiled_id);
			
		array_push($chield_arr,$chiled_id);
		$v1 = $this->get_child_child_role($chiled_id);
		array_push($chield_arr,$v1);
		//print_r($v1);
			}
			
		}
		return $chield_arr;
		
	}
	public function get_child_child_role($role_id)
	{
		$chield_arr_1 = array();
		$chile_role_1 = Role::where('parent_id',$role_id)->get();
		if(!empty($chile_role_1)&& count($chile_role_1)>0)
		{
			
			foreach($chile_role_1 as $chile_role_1_val)
			{
				$chiled_id_1  = $chile_role_1_val->id;
			//t($chiled_id);
			
		array_push($chield_arr_1,$chiled_id_1);
		$v2 = $this->get_child_role($chiled_id_1);
		array_push($chield_arr_1,$v2);
			}
			
			
		
		}
		return $chield_arr_1;
		
	}
	
	public function remove_user(Request $request)
	{
		DB::enableQueryLog();
		$data['title'] = 'user';
		$posteddata = $request->all();
		$check =$posteddata['check_list'];
		$check_box_val_arr = array();
		foreach($check as $checks){
			array_push($check_box_val_arr,$checks);
		}
		//t($check,1);

		$update_data['is_deleted'] = 'Yes';
		$updated=User::whereIn('id',$check_box_val_arr)->update($update_data);
		$query = DB::getQueryLog();
		//t($query,1);
		if($updated)
            return redirect('customer-user-list')->with('success-msg', 'Store successfully deleted');
        else
        {
            return redirect('customer-user-list')->with('error-msg', 'Please try after some time');    
        }
		
		
	}
	public function add_customer_user()
    {
        $data['title']="Add Customer User";
		 $data['roleList']=Role::where('parent_id',Auth::user()->role_id)->where('is_active','Yes')->where('is_deleted','No')->where('type','=','user')->get();
       // $data['info1']= Role::where('is_active','Yes')->where('is_deleted','No')->get();
		//$data['designation']=$doc_list = Module_master::where('mod_type','department')->get();
		//$data['user']= $user = User::where('fl_archive','N')->where('id','!=',$user_id)->get();
		//t($user,1);
		 $data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->where('country.is_active','=','Yes')
		->orderBy('country.country_name','asc')
		->get();
		$data['province'] = Region::
		select('provinces.*')
		->where('provinces.is_deleted','=','No')
		->where('provinces.is_active','=','Yes')
		->orderBy('provinces.name','asc')
		->get();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
        return view('salesref.customer_user.customer_user_add',$data);
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
	    public function save_customer_user(Request $request)
    {
       $posted = $request->all();
		//t($posted,1);
		if(isset($posted['userId']) && $posted['userId']!='')
		{
			$have_user_id = User::where('useId',$posted['userId'])->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-customer-user')->with('error-msg', 'User Id already added');
			}
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['email'] = $to_email = isset($posted['email'])?$posted['email']:'';
			//$insert_data['description'] = isset($posted['description'])?$posted['description']:'';
			$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
			$insert_data['useId'] = $userId = isset($posted['userId'])?$posted['userId']:'';
			$insert_data['phone'] = $phone = isset($posted['phone'])?$posted['phone']:'';
			$insert_data['password'] = isset($posted['password'])?bcrypt($posted['password']):bcrypt(123456);
			
			$insert_data['role_id'] = isset($posted['role'])?$posted['role']:0;
			$insert_data['brand_id'] = isset($posted['brand_id'])?$posted['brand_id']:0;
			$insert_data['country_id'] =isset($posted['country_id'])?$posted['country_id']:0;
			$insert_data['province_id'] =isset($posted['province_id'])?$posted['province_id']:0;
			$address = isset($posted['address'])?$posted['address']:'';
			$city = isset($posted['city'])?$posted['city']:'';
			$zip = isset($posted['zip'])?$posted['zip']:'';
			
			

			if($address != '' || $city !='' || $zip != '' ){
			$user_fulladdr['street']=$address ;
			$user_fulladdr['city']=$city ;
			$user_fulladdr['zip']=$zip ;
			
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr):'';
			
			
			
			
			}
			//t($insert_data,1);
			$insert_data['created_by'] = Auth::user()->id;
			 $password =  isset($posted['password'])?$posted['password']:123456;
			//$id = User::insertGetId($insert_data);
			$profile_pic = $request->file('profile_pic');
			
			if($profile_pic !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($profile_pic, 'RoleUserPic','RoleUserPic',$posted['name']);	
					if($cat_image_pic_name!='')
					{
						$insert_data['profile_pic'] = $cat_image_pic_name;
					}
				
			}
			$id = User::insertGetId($insert_data);
			if($id!='')
			{
			 $data2 = [
			        'userid'=>$userId,
					'password'=>$password,  
                ];
			   
              $template = 'master.user.NewUserAddMailSend'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data2, function ($message) use ($userId, $to_email) {
            $message->to($to_email, $userId)
                ->subject('New User Add');
            $message->from('no-repl@gmail.com', 'New user Add');
        });
					return redirect('customer-user-list')->with('success-msg', 'User added successfully');
			}
			else
			{
			 return redirect('customer-user-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('customer-user-list')->with('error-msg', 'Please Provide Uer Id');
		}	
    }
	public function edit_customer_user($id)
    {
		
		if (base64_decode($id, true)) 
       {
		   $user_id = Auth::user()->id;
		
            $id = base64_decode($id);
			
            $data['title']="User Management";
			$data['roleList']=Role::where('parent_id',Auth::user()->role_id)->where('is_active','Yes')->where('is_deleted','No')->where('type','=','user')->get();
			
			$data['country'] = Country::
			select('country.*')
			->where('country.is_deleted','=','No')
			->where('country.is_active','=','Yes')
			->orderBy('country.country_name','asc')
			->get();
			$data['province'] = Region::
			select('provinces.*')
			->where('provinces.is_deleted','=','No')
			->where('provinces.is_active','=','Yes')
			->orderBy('provinces.name','asc')
			->get();
			$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
			
            $data['info']=User::where('id',$id)->get(); 
            return view('salesref.customer_user.customer_user_edit',$data);
       }
       else
            abort(404);
		
		 
    }

    public function update_customer_user(Request $request)
    {
      $posted = $request->all();// t($posted,1);
		$have_user_id = User::where('useId',$posted['id'])->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('edit-customer-user/'.base64_encode($posted['id']))->with('error-msg', 'User Id already added');
		}
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['email'] = isset($posted['email'])?$posted['email']:'';
			$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
			$insert_data['useId'] = isset($posted['userId'])?$posted['userId']:'';
			
			$insert_data['brand_id'] = isset($posted['brand_id'])?$posted['brand_id']:0;
			$insert_data['country_id'] =isset($posted['country_id'])?$posted['country_id']:0;
			$insert_data['province_id'] =isset($posted['province_id'])?$posted['province_id']:0;
			$insert_data['phone'] = $phone = isset($posted['phone'])?$posted['phone']:'';
			$address = isset($posted['address'])?$posted['address']:'';
			$city = isset($posted['city'])?$posted['city']:'';
			$zip = isset($posted['zip'])?$posted['zip']:'';
			
			$is_same_locator_address = isset($posted['is_same_locator_address'])?$posted['is_same_locator_address']:'';
			
			$store_locator_country = isset($posted['store_locator_country_id'])?$posted['store_locator_country_id']:'';
			$store_locator_province = isset($posted['store_locator_province_id'])?$posted['store_locator_province_id']:'';
			$store_locator_address = isset($posted['store_locator_address'])?$posted['store_locator_address']:'';
			$store_locator_city = isset($posted['store_locator_city'])?$posted['store_locator_city']:'';
			$store_locator_zip = isset($posted['store_locator_zip'])?$posted['store_locator_zip']:'';
			if($address != '' || $city !='' || $zip != '' ){
			$user_fulladdr['street']=$address ;
			$user_fulladdr['city']=$city ;
			$user_fulladdr['zip']=$zip ;
			
			
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr):'';
			}
			
			
			
			
		if(isset($posted['password']) && $posted['password']!='')
		{
		 $insert_data['password'] = isset($posted['password'])?bcrypt($posted['password']):'';
		}
		
		$profile_pic = $request->file('profile_pic');
			
			if($profile_pic !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($profile_pic, 'RoleUserPic','RoleUserPic',$posted['name']);	
					if($cat_image_pic_name!='')
					{
						$insert_data['profile_pic'] = $cat_image_pic_name;
					}
				
			}
			
			User::where('id',$posted['id'])->update($insert_data);
			return redirect('customer-user-list')->with('success-msg', 'User updated successfully');
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
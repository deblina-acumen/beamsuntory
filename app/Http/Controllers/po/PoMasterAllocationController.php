<?php

namespace App\Http\Controllers\po;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Warehouse;
use App\Model\Supplier;
use App\Model\PO;
use App\Model\POItem;
use App\Model\ProductVariations;
use App\Model\Brand;
use App\Model\Region;
use App\Model\User;
use App\Model\Role;
use  App\Model\Country;
use  App\Model\POAllocation;
use Auth;
use DB;
class PoMasterAllocationController extends Controller
{
	
	 public function add_step2($id='')
    {
		
        $data['title']="Purchase Order";
		$poId= base64_decode($id);
		//t($poId);
		//exit();
		$data['poinfo']=$poinfo =PO::where('id',$poId)->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$suppler_id =$list= isset($poinfo[0]->supplier_id)?$poinfo[0]->supplier_id:0 ;
		$data['supplier']= Supplier::where('id',$suppler_id)->where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		
		$data['po_details'] = $po_details= POItem::select('purchase_order_details.item_sku','purchase_order_details.quantity','item.name','item.product_type','item.regular_price','item.batch_no','item.expire_date','item.retail_price','item.image','item_variation_details.variation','purchase_order_details.id as puchase_order_details_id','item.id as itemid','item_variation_details.id as varienceid','purchase_order_details.po_id as po_id')->join('item','item.id','=','purchase_order_details.item_id')->leftjoin('item_variation_details','item_variation_details.id','=','purchase_order_details.item_variance_id')->where('purchase_order_details.po_id',$poId)->get() ;
		
		$data['userRole'] =$userRole = Role::where('type','master')->orWhere('type','division')->orWhere('id',11)->get() ;
 

        return view('poallocation.add',$data);
    }
	
	public function get_role2(Request $request)
	{
		$data = $data=$request->all(); //t($data,1);
		$id = $data['value'];
		$dropdownarr = [] ;
		
		///////// sels ref ///////
		if($id == 11)
			{
				
			$province_list = Region::where('provinces.is_deleted','=','No')->where('provinces.is_active','=','Yes')->orderBy('provinces.name','asc')->get();
			$html2 = '';
			$html1 ='<option value="">Select Region</option>';
			
				foreach($province_list as $userlistval)
				{
					
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
			//$html1 .='<option value="'.$dropdownarr_val.'">All Region ('.count($province_list).')</option>';
				$returnarray['childid']=$id ;
				$html3 = $html1 . $html2;
				$returnarray['html']= $html3 ;
				
				return $returnarray ;
				//echo $html2 ;
			
			
			//return $province_list ;	
			}
			////// markting ///////
		else if($id == 5)
		{
			$brand_list = Brand::where('brand.is_deleted','=','No')->where('brand.is_active','=','Yes')->orderBy('brand.id','desc')->get();
			$html2 ='';
			$html1 ='<option value="">Select Brand</option>';
			
				foreach($brand_list as $userlistval)
				{
				 
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				//$html1 .='<option value="'.$dropdownarr_val.'">All Brand('.count($brand_list).')</option>';
				$returnarray['childid']=$id ;
				$html3 = $html1 . $html2;
				$returnarray['html']= $html3 ;
				
				return $returnarray ;
				
				
		}
		/////// field marketing //////
		else if($id == 9)
		{
			$brand_list = Country::where('is_deleted','=','No')->where('is_active','=','Yes')->orderBy('country_name','asc')->get();
			$html2='';
			$html1 ='<option value="">Select Country</option>';
			
				foreach($brand_list as $userlistval)
				{
				 
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->country_name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				//$html1 .='<option value="'.$dropdownarr_val.'">All Country ('.count($brand_list).')</option>';
				$returnarray['childid']=$id ;
				$html3 = $html1 . $html2;
				$returnarray['html']= $html3 ;
				
				return $returnarray ;
				
				
		}
		/////// mixit /////
		else if($id == 2)
		{
			$mixitrole = Role::where('id',$id)->get() ;
				$mixitmanagerid = Role::where('parent_id',$mixitrole[0]->id)->get() ;
				$userlist = User::where('role_id',$mixitmanagerid[0]->id)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				//t($userlist);
				//exit() ;
				$html2 ='' ;
				$html1 ='<option value="">Select Mixit Managers</option>';
 				 
				foreach($userlist as $userlistval)
				{
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				//$html1 .='<option value="'.$dropdownarr_val.'">All Mixit Managers('.count($userlist).')</option>';
				$returnarray['childid']=$mixitmanagerid[0]->id ;
				$html3 = $html1 . $html2;
				$returnarray['html']= $html3 ;
				
				return $returnarray ;
				
			
		}
		else{
		}
			
		
	}
	public function get_role3(Request $request)
	{
		$data = $request->all(); 
		
		$roletype = $data['usertype'] ;
		
		$incId = $data['incid'] ;
		$pod_id = $data['pod_id'] ;
		$role_id = $data['roleid'] ;
		//$dynamodropdownid = $data['dynamodropdownincid'];
		//t($roletype);
		//t($id);
		//t($role_id);
		if(isset($data['value'])&& $data['value']!='')
		{
		$useridarray= explode(',',$data['value']) ;
		}
		else{
			$useridarray= array()  ;
		}
		//t($useridarray);
		//exit() ;
		$sales_rep_region = [] ;
		$userrole_arr = [] ;
		$brand_id = [] ;
		$dropdownarr = [] ;
		if($roletype == 'sales_ref')
		{
		
				
				$userlist = User::whereIn('province_id',$useridarray)->where('role_id',$role_id)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				$html2='';
				$html1 ='<option value="">Select Sales Representative</option>';
				if(count($userlist)>0)
				{
				
				foreach($userlist as $userlistval)
				{
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				
				$html1 .='<option value="'.$dropdownarr_val.'">All Sales Representative('.count($userlist).')</option>';
				}
				$html3 = $html1 . $html2 ;
				$return_arr['html'] = $html3 ;
				$check_chieldId = Role::where('parent_id',$role_id)->get() ;
				$return_arr['childid']=isset($check_chieldId[0]->id)?$check_chieldId[0]->id:0 ;
				return $return_arr ;
				
				
			
		}
		else if($roletype == 'field_marking'){
			
				$userprovince = Region::whereIn('country_id',$useridarray)->where('provinces.is_deleted','=','No')->where('provinces.is_active','=','Yes')->get() ;
				//t($userprovince);
				//exit();
				
				$html2='';
				$html1 ='<option value="">Select Region</option>';
				if(count($userprovince)>0)
				{
				
				foreach($userprovince as $userlistval)
				{
					 
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				//$html1 .='<option value="'.$dropdownarr_val.'">All Region('.count($userprovince).')</option>';
				
				}
				$html3 = $html1 . $html2 ;
				$return_arr['html'] = $html3 ;
				
				$return_arr['childid']=$role_id ;
				return $return_arr ;
				
			
		}
		else if($roletype == 'marketing')
		{
			$userroleid = Role::where('parent_id',$role_id)->where('type','user')->get() ;
			foreach($userroleid as $userroleid)
			{
				array_push($userrole_arr,$userroleid->id);
			}
			
				
				//$userprovince = User::whereIn('id',$useridarray)->get() ;
				//$userprovince_id = $userprovince[0]->brand_id ;
				
				$userlist = User::whereIn('brand_id',$useridarray)->whereIn('role_id',$userrole_arr)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				
				$html2='';
				$html1 ='<option value="">Select Brand Marketing manager</option>';
				if(count($userlist)>0)
				{
				
				foreach($userlist as $userlistval)
				{
					 
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				
				$dropdownarr_val = implode(',',$dropdownarr);
				
				$html1 .='<option value="'.$dropdownarr_val.'">All Brand Marketing manager ('.count($userlist).')</option>';
				}
				$html3 = $html1 . $html2 ;
				$return_arr['html'] = $html3 ;
				$check_chieldId = Role::where('parent_id',$role_id)->get() ;
				$return_arr['childid']=isset($check_chieldId[0]->id)?$check_chieldId[0]->id:0 ;
				return $return_arr ;
				
		}
		else if($roletype == 'mixit'){
			
			$userroleid = Role::where('parent_id',$role_id)->where('type','user')->get() ;
			foreach($userroleid as $userroleid)
			{
				array_push($userrole_arr,$userroleid->id);
			}
			
				$userlist = User::whereIn('role_id',$userrole_arr)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				$html2='';
				$html1 ='<option value="">Select mixit assistant</option>';
				if(count($userlist)>0)
				{
				
				foreach($userlist as $userlistval)
				{
					 
				$html2 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				$html1 .='<option value="'.$dropdownarr_val.'">All mixit assistant ('.count($userlist).')</option>';
				}
				$html3 = $html1 . $html2 ;
				$return_arr['html'] = $html3 ;
				$check_chieldId = Role::where('parent_id',$role_id)->get() ;
				$return_arr['childid']=isset($check_chieldId[0]->id)?$check_chieldId[0]->id:0 ;
				return $return_arr ;
				
				
		}
		else{
		}
	}
	public function get_role4(Request $request)
	{
		$data = $request->all(); 
		//t($data);
		$useridarray=[] ;
		$roletype = $data['usertype'] ;
		
		$incId = $data['incid'] ;
		$pod_id = $data['pod_id'] ;
		$role_id = $data['roleid'] ;
		$dynamodropdownid = $data['dynamodropdownincid'];
		$incrimented_dynamodropdownid = $data['dynamodropdownincid']+1 ;
		$dropdownarr = [] ;
		
		$sales_rep_region = [] ;
		$userrole_arr = [] ;
		$brand_id = [] ;
		$user_details_arr=[] ;
		
		if($roletype == 'field_marking'){
			if(is_array($data['value']))
			{
				if(isset($data['value'])&&!empty($data['value'])&&count($data['value'])>0)
					{
					$useridarray= explode(',',implode(',',$data['value'])) ;
					}
					else{
						$useridarray= array()  ;
					}
				
			}else{
				
				if(isset($data['value'])&&$data['value']!='')
					{
					$useridarray= explode(',',$data['value']) ;
					}
					else{
						$useridarray= array()  ;
					}
			}
			
			//t($role_id);
			$userroleid = Role::where('parent_id',$role_id)->where('type','user')->get() ;
			foreach($userroleid as $userroleid)
			{
				array_push($userrole_arr,$userroleid->id);
			}
			//t($userrole_arr);
			if($dynamodropdownid ==0)
			{
				//echo "test";
				$userlist = User::whereIn('province_id',$useridarray)->whereIn('role_id',$userrole_arr)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				$provence_id_arry_new = $useridarray ;
				
			}else{
				//echo "test2";
				$user_details = User::whereIn('id',$useridarray)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				foreach($user_details as $user_details_val)
				{
					array_push($user_details_arr,$user_details_val->province_id);
				}
				//t($user_details_arr);
				$userlist = User::whereIn('province_id',$user_details_arr)->whereIn('role_id',$userrole_arr)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				
				$provence_id_arry_new = $user_details_arr ;
			}
				
				
				$html2 ='<div class="form-group"><select  name="userrole4_'.$incrimented_dynamodropdownid.'_'.$incId.'[]" id="dynamo'.$incrimented_dynamodropdownid.'_'.$incId.'_'.$pod_id.'" onchange=get_role4(this,'.$incId.','.$pod_id.') usertype="" roleid="" dynamodropdownincid="" class="form-control select2" multiple="multiple" data-placeholder="Select value">';
				$html3 ='';
				$html1 ='<option value="">Select</option>';
				
				if(count($userlist)>0)
				{
				
				foreach($userlist as $userlistval)
				{
					 
				$html3 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				$html1 .='<option value="'.$dropdownarr_val.'">All ('.count($userlist).')</option>';
				}
				$html3 .='</select></div>';
				$html4 = $html2 . $html1 . $html3 ;
				$return_arr['html'] = $html4 ;
				$check_chieldId = Role::where('parent_id',$role_id)->where('type','user')->get() ;
				//t($check_chieldId[0]->id);
				//t($provence_id_arry_new);
				$check_user_exist= User::whereIn('province_id',$provence_id_arry_new)->where('role_id',$check_chieldId[0]->id)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get();
				//echo count($check_user_exist);
				if(count($check_chieldId)>0 && count($check_user_exist)>0)
				{
					$return_arr['dynamodropdownid'] = $dynamodropdownid+1 ;
					$return_arr['prevdynamodropdownid'] = $dynamodropdownid ;
					$return_arr['countnextdiv'] = $dynamodropdownid+1 ;
					$return_arr['childid']=isset($check_chieldId[0]->id)?$check_chieldId[0]->id:0 ;
				}
				else{
					$return_arr['dynamodropdownid'] = $dynamodropdownid +1;
					$return_arr['prevdynamodropdownid'] = 0  ;
					$return_arr['countnextdiv'] = 0 ;
				}
				
				return $return_arr ;
			
		}
		else if($roletype == 'marketing')
		{
			if(isset($data['value'])&&!empty($data['value'])&&count($data['value'])>0)
		{
		$useridarray= explode(',',implode(',',$data['value'])) ;
		}
		else{
			$useridarray= array()  ;
		}
		
			$userroleid = Role::where('parent_id',$role_id)->get() ;
			foreach($userroleid as $userroleid)
			{
				array_push($userrole_arr,$userroleid->id);
			}
			
			
				$user_details = User::whereIn('id',$useridarray)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
				foreach($user_details as $user_details_val)
				{
					array_push($user_details_arr,$user_details_val->brand_id);
				}
				
				$userlist = User::whereIn('brand_id',$user_details_arr)->whereIn('role_id',$userrole_arr)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get() ;
			
		
			
				
				$html2 ='<div class="form-group"><select  name="userrole4_'.$incrimented_dynamodropdownid.'_'.$incId.'[]" id="dynamo'.$incrimented_dynamodropdownid.'_'.$incId.'_'.$pod_id.'" onchange=get_role4(this,'.$incId.','.$pod_id.') usertype="" roleid="" dynamodropdownincid="" class="form-control select2" multiple="multiple" data-placeholder="Select value">';
				$html3 ='';
				$html1 ='<option value="">Select</option>';
				if(count($userlist)>0)
				{
				
				foreach($userlist as $userlistval)
				{
					 
				$html3 .='<option value="'.$userlistval->id.'">'.$userlistval->name.'</option>';
				array_push($dropdownarr,$userlistval->id);
				}
				$dropdownarr_val = implode(',',$dropdownarr);
				
				$html1='<option value="all">All ('.count($userlist).')</option>';
				}
				$html3 .='</select></div>';
				$html4 = $html2 . $html1 . $html3 ;
				
				$return_arr['html'] = $html4 ;
				$check_chieldId = Role::where('parent_id',$role_id)->where('type','user')->get() ;
				//t($check_chieldId[0]->id);
				$check_user_exist= User::whereIn('brand_id',$user_details_arr)->where('role_id',$check_chieldId[0]->id)->where('users.is_deleted','=','No')->where('users.is_active','=','Yes')->get();
				//echo count($check_chieldId) ;
				//echo count($check_user_exist) ;
				//t($check_user_exist);
				if(count($check_chieldId)>0 && count($check_user_exist)>0)
				{
					$return_arr['dynamodropdownid'] = $dynamodropdownid+1 ;
					$return_arr['prevdynamodropdownid'] = $dynamodropdownid ;
					$return_arr['countnextdiv'] = $dynamodropdownid+1 ;
					$return_arr['childid']=isset($check_chieldId[0]->id)?$check_chieldId[0]->id:0 ;
				}
				else{
					$return_arr['dynamodropdownid'] = $dynamodropdownid +1;
					$return_arr['prevdynamodropdownid'] = 0 ;
					$return_arr['countnextdiv'] = 0 ;
				}
				
				return $return_arr ;
			
		}
		
	}
	
	public function get_allocation_window(Request $request)
	{
		$data=$request->all(); //t($data,1);
		$po_details_val= POItem::select('purchase_order_details.item_sku','purchase_order_details.quantity','item.name','item.product_type','item.regular_price','item.batch_no','item.brand_id','item.expire_date','item.retail_price','item.image','item.sku as skucode','item_variation_details.variation','purchase_order_details.id as puchase_order_details_id','item.id as itemid','item_variation_details.id as varienceid','purchase_order_details.po_id as po_id')->join('item','item.id','=','purchase_order_details.item_id')->leftjoin('item_variation_details','item_variation_details.id','=','purchase_order_details.item_variance_id')->where('purchase_order_details.id',$data['poDetailsId'])->get() ;
		$product_name = isset($po_details_val[0]->name)?$po_details_val[0]->name:'' ;
		
		$product_sku = isset($po_details_val[0]->item_sku)?$po_details_val[0]->item_sku:'' ;
		
		$quantity = isset($po_details_val[0]->quantity)?$po_details_val[0]->quantity:'' ;
		$brandName = isset($po_details_val[0]->brand_id)?get_brand_name($po_details_val[0]->brand_id):'';
		$userRole = Role::where('type','master')->orWhere('type','division')->orWhere('id',11)->get() ;
		
		$itemId = isset($po_details_val[0]->itemid)?$po_details_val[0]->itemid:'';
		$varienceId = isset($po_details_val[0]->varienceid)?$po_details_val[0]->varienceid:'';
		$poId = isset($po_details_val[0]->po_id)?$po_details_val[0]->po_id:'';
		
		$itemSkuCode = isset($po_details_val[0]->skucode)?$po_details_val[0]->skucode:'';
		$puchaseOrderDetailsId = isset($po_details_val[0]->puchase_order_details_id)?$po_details_val[0]->puchase_order_details_id:'';
		//t($userRole);
		//exit() ;
		
		$url = URL('save-po-steop2');
		 $html = '
		<form id="add_development_plan" action="'.$url.'" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
		<input type="hidden" name="_token" value="'.csrf_token().'">
		 <h4 class="box-title text-dark">Item:'.$product_name.'-'.$product_sku.'</h4>
            <p>Brand Association : '.$brandName.' <span class="pull-right" style="color: #000fff;">Stock Balance: '.$quantity .'</span></p>
			<input type="hidden" value="'.$quantity.'" class="total_quantity">
			<input type="hidden" name="itemid" value="'.$itemId.'">
			<input type="hidden" name="varienceid" value="'.$varienceId.'">
			<input type="hidden" name="poid" value="'.$poId.'">
			<input type="hidden" name="itemSkuCode" value="'.$itemSkuCode.'">
			<input type="hidden" name="puchaseOrderDetailsId" value="'.$puchaseOrderDetailsId.'">
            <hr class="my-15">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                <select  name="userrole1_0" id="role_0_'.$po_details_val[0]->puchase_order_details_id.'" onchange=get_role2(this,0,'.$po_details_val[0]->puchase_order_details_id.') aria-controls="project-table" class="form-control form-control-sm">
				<option value="">Select</option>
				';
				foreach($userRole as $userRole)
				{
					 $html.='<option value="'.$userRole->id.'">'.$userRole->name.'</option>';
				}
                 
               $html.=' </select>
              </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                <select  name="userrole2_0" id="role2_0_'.$po_details_val[0]->puchase_order_details_id.'" onchange=get_role3(this,0,'.$po_details_val[0]->puchase_order_details_id.') class="form-control select2" multiple="multiple" aria-controls="project-table" class="form-control form-control-sm" >
                  <option value=" ">Select</option>
                 
                </select>
              </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                <select  name="userrole3_0" id="role3_0_'.$po_details_val[0]->puchase_order_details_id.'" class="form-control select2" multiple="multiple" aria-controls="project-table" class="form-control form-control-sm">
                 
                </select>
              </div>
              <div class="input-group" style="margin-top: 20px;">
              <div class="checkbox checkbox-success"  id="hide_locker_0_'.$po_details_val[0]->puchase_order_details_id.'">
                <input id="checkbox3_0_'.$po_details_val[0]->puchase_order_details_id.'" type="checkbox" name="storelocator_0" >
                <label for="checkbox3_0_'.$po_details_val[0]->puchase_order_details_id.'"> Locker </label>
              </div>
              <div class="checkbox checkbox-success" style="margin-left: 30px;">
                <input id="checkbox4_0_'.$po_details_val[0]->puchase_order_details_id.'" type="checkbox" name="eachselectbox_0">
                <label for="checkbox4_0_'.$po_details_val[0]->puchase_order_details_id.'"> Each </label>
              </div>
            </div>
              </div>
              <div class="col-md-2">
        <div class="form-group">
                <input type="number" name="quantity_0" id="quantity_0_'.$po_details_val[0]->puchase_order_details_id.'" class="form-control quantity" placeholder="100" onblur="calculate_amount()">
                </div>
              </div>
              <div class="col-md-1">
              <div class="pull-right">
                <div class="input-group">
                <button type="button" onclick="addmorerow('.$po_details_val[0]->puchase_order_details_id.')" id="add_field_button_1_'.$po_details_val[0]->puchase_order_details_id.'" class="btn btn-danger btn-sm mb-5"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
                </div>
              </div>
            </div>
                        <hr class="my-15">
						<div class="input_fields_wrap_1"></div>
            
             
              <div class="modal-footer">
                <button type="submit" class="btn btn-dark waves-effect text-left submit_btn" data-dismiss="modal">Save</button>
              </div></form> ';
			  return $html;
	}
	
	public function add_allocation($itemid='',$podetailsId='',$poId='')
	{
		 $data['title']="Purchase Order";
		
		$data['itemid'] = $itemid= base64_decode($itemid);
		$data['podetailsId'] = $podetailsId= base64_decode($podetailsId);
		$data['poId'] = $poId= base64_decode($poId);
	$data['poinfo']=$poinfo =PO::where('id',$poId)->get();
	$data['po_details_val'] = $po_details_val= POItem::select('purchase_order_details.item_sku','purchase_order_details.quantity','item.name','item.product_type','item.regular_price','item.batch_no','item.brand_id','item.expire_date','item.retail_price','item.image','item.sku as skucode','item_variation_details.variation','purchase_order_details.id as puchase_order_details_id','item.id as itemid','item_variation_details.id as varienceid','purchase_order_details.po_id as po_id')->join('item','item.id','=','purchase_order_details.item_id')->leftjoin('item_variation_details','item_variation_details.id','=','purchase_order_details.item_variance_id')->where('purchase_order_details.id',$podetailsId)->get() ;
	
	$data['product_name'] = $product_name = isset($po_details_val[0]->name)?$po_details_val[0]->name:'' ;
		
	$data['product_sku'] =	$product_sku = isset($po_details_val[0]->item_sku)?$po_details_val[0]->item_sku:'' ;
		
	$data['quantity'] =	$quantity = isset($po_details_val[0]->quantity)?$po_details_val[0]->quantity:'' ;
	$data['brandName'] =	$brandName = isset($po_details_val[0]->brand_id)?get_brand_name($po_details_val[0]->brand_id):'';
	$data['userRole'] =	$userRole = Role::where('type','master')->orWhere('type','division')->orWhere('id',11)->get() ;
		
	$data['itemId'] =	$itemId = isset($po_details_val[0]->itemid)?$po_details_val[0]->itemid:'';
	$data['varienceId'] =	$varienceId = isset($po_details_val[0]->varienceid)?$po_details_val[0]->varienceid:'';
	$data['poId'] =	$poId = isset($po_details_val[0]->po_id)?$po_details_val[0]->po_id:'';
		
	$data['itemSkuCode'] =	$itemSkuCode = isset($po_details_val[0]->skucode)?$po_details_val[0]->skucode:'';
	$data['puchaseOrderDetailsId'] =	$puchaseOrderDetailsId = isset($po_details_val[0]->puchase_order_details_id)?$po_details_val[0]->puchase_order_details_id:'';
	
	
	
return view('poallocation.add_allocation',$data);
		
	}
	
	public function save_po_step2(Request $request)
	{
		 $data=$request->all(); //t($data);
		 //exit();
		 $userrole2=[];
		 $userrole5=[];
		 $userrole9=[];
		 $userrole11=[];
		 $count_row = $data['countrow'];
		 for($i=0;$i<$count_row;$i++)
		 {
			 //t($data['userrole1_'.$i]);
			$insertdata['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			$insertdata['po_id'] = isset($data['poid'])?$data['poid']:0 ;
			$insertdata['podetails_id'] = isset($data['puchaseOrderDetailsId'])?$data['puchaseOrderDetailsId']:0 ;
			$insertdata['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
			
			
			
			  if($data['userrole1_'.$i]==2)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole2['roleuser1']= (isset($data['userrole2_'.$i])&&$data['userrole2_'.$i]!='')?implode(',',$data['userrole2_'.$i]):'';
				 $userrole2['roleuser2']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] = '' ;
				 }
				 else{
					 $insertdata['each_user'] = '';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole2); 
			 }
			 if($data['userrole1_'.$i]==5)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['brand_id']= implode(',',$data['userrole2_'.$i]);
				 
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   
				 
				  $userrole5['roleuser1']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 for($j=1;$j<$data['dynamoselectcount_'.$i];$j++)
				 {
					 $j1 = $j+1 ;
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					 {
					$userrole5['roleuser'. $j1]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					 }
				 }
				
				/*  $userrole['roleuser2']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] ='' ;
				 }
				 else{
					 $insertdata['each_user'] = '' ;
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole5); 
			 } 
			  if($data['userrole1_'.$i]==9)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['country_id']= implode(',',$data['userrole2_'.$i]);
				  $insertdata['region_id']= '';
				 
				   $insertdata['brand_id']= '';
				 $insertdata['region_id']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 
				  for($j=1;$j<=$data['dynamoselectcount_'.$i];$j++)
				 {
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					{
					$userrole9['roleuser'.$j]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					}
				 }
				 
				/*  $userrole['roleuser1']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser2']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_5_'.$i])?implode(',',$data['userrole4_5_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] = '' ;
				 }
				 else{
					 $insertdata['share_user'] = "shared" ;
					 $insertdata['each_user'] = '' ;
				 }
				 $insertdata['user'] = json_encode($userrole9); 
			 } 
			  if($data['userrole1_'.$i]==11)
			 {
				 //t($data['userrole3_'.$i]);
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['region_id']= isset($data['userrole2_'.$i])?implode(',',$data['userrole2_'.$i]):'';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole11['roleuser1']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
					 $insertdata['share_user'] ='';
				 }
				  if(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store')
				 {
					 $insertdata['store_locker'] = $data['storelocator_'.$i]  ;
					 $insertdata['share_user']='';
				 }
				 if((isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each') ||(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store'))
				 {
				 }
				 else{
					 $insertdata['each_user'] ='';
					 $insertdata['store_locker'] ='';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole11); 
			 }
			// t(json_encode($userrole));
			 
		 //t($insertdata);
			// exit() ;
			 POAllocation::insert($insertdata);
		 }
		 //$insertdata['user'] =json_encode($userrole); 
		 
		 return redirect('add-po-step2/'.base64_encode($data['poid']))->with('success-msg', 'Allocation Added Successfully');
		 
	}
	
	public function edit_allocation($itemid='',$podetailsId='',$poId='')
	{
		
		$data['title']="Purchase Order";
		
		$data['itemid'] = $itemid= base64_decode($itemid);
		$data['podetailsId'] = $podetailsId= base64_decode($podetailsId);
		$data['poId'] = $poId= base64_decode($poId);
	$data['poinfo']=$poinfo =PO::where('id',$poId)->get();
	$data['po_details_val'] = $po_details_val= POItem::select('purchase_order_details.item_sku','purchase_order_details.quantity','item.name','item.product_type','item.regular_price','item.batch_no','item.brand_id','item.expire_date','item.retail_price','item.image','item.sku as skucode','item_variation_details.variation','purchase_order_details.id as puchase_order_details_id','item.id as itemid','item_variation_details.id as varienceid','purchase_order_details.po_id as po_id')->join('item','item.id','=','purchase_order_details.item_id')->leftjoin('item_variation_details','item_variation_details.id','=','purchase_order_details.item_variance_id')->where('purchase_order_details.id',$podetailsId)->get() ;
	
	$data['product_name'] = $product_name = isset($po_details_val[0]->name)?$po_details_val[0]->name:'' ;
		
	$data['product_sku'] =	$product_sku = isset($po_details_val[0]->item_sku)?$po_details_val[0]->item_sku:'' ;
		
	$data['quantity'] =	$quantity = isset($po_details_val[0]->quantity)?$po_details_val[0]->quantity:'' ;
	$data['brandName'] =	$brandName = isset($po_details_val[0]->brand_id)?get_brand_name($po_details_val[0]->brand_id):'';
	$data['userRole'] =	$userRole = Role::where('type','master')->orWhere('type','division')->orWhere('id',11)->get() ;
		
	$data['itemId'] =	$itemId = isset($po_details_val[0]->itemid)?$po_details_val[0]->itemid:'';
	$data['varienceId'] =	$varienceId = isset($po_details_val[0]->varienceid)?$po_details_val[0]->varienceid:'';
	$data['poId'] =	$poId = isset($po_details_val[0]->po_id)?$po_details_val[0]->po_id:'';
		
	$data['itemSkuCode'] =	$itemSkuCode = isset($po_details_val[0]->skucode)?$po_details_val[0]->skucode:'';
	$data['puchaseOrderDetailsId'] =	$puchaseOrderDetailsId = isset($po_details_val[0]->puchase_order_details_id)?$po_details_val[0]->puchase_order_details_id:'';
	
	$data['info'] = $info = POAllocation::where('item_id',$itemid)->where('po_id',$poId)->where('podetails_id',$podetailsId)->get();
	$data['count_allocation'] = count($info);
	
	$data['province_list'] =$province_list = Region::where('provinces.is_deleted','=','No')->where('provinces.is_active','=','Yes')->orderBy('provinces.id','desc')->get();
	$data['brand_list'] = $brand_list = Brand::where('brand.is_deleted','=','No')->where('brand.is_active','=','Yes')->orderBy('brand.id','desc')->get();
	
	$data['country_list'] = $country_list = Country::where('is_deleted','=','No')->where('is_active','=','Yes')->orderBy('country_name','asc')->get();
	$mix_manager_role = Role::where('parent_id',2)->get() ;
	$mixit_assistant_role = Role::where('parent_id',$mix_manager_role[0]->id)->get() ;
	$data['mixitmanager'] = User::where('role_id',$mix_manager_role[0]->id)->get() ;
	$data['mixitassistant'] = User::where('role_id',$mixit_assistant_role[0]->id)->get() ;
	
	//t($info);
	//exit();
	return view('poallocation.edit_allocation',$data);
	}
	
	public function update_po_step2(Request $request)
	{
		 $data=$request->all(); 
		 //t($data);
		// exit();
		 $userrole2=[];
		 $userrole5=[];
		 $userrole9=[];
		 $userrole11=[];
		 $count_row = $data['countrow'];
		 $allcation_id_array= [] ;
		 $existing_allcation_id_array= [] ;
		 $item_id = isset($data['itemid'])?$data['itemid']:0 ;
		$po_id = isset($data['poid'])?$data['poid']:0 ;
		$podetails_id = isset($data['puchaseOrderDetailsId'])?$data['puchaseOrderDetailsId']:0 ;
		
		$existing_allcation =POAllocation::where('item_id',$item_id)->where('po_id',$po_id)->where('podetails_id',$podetails_id)->get();
		
		foreach($existing_allcation as $existing_allcation_val)
		{
			array_push($existing_allcation_id_array,$existing_allcation_val->id);
		}
		
		for($exal=0;$exal<$count_row;$exal++)
		 {
			
			 array_push($allcation_id_array,isset($data['allocation_id_'.$exal])?$data['allocation_id_'.$exal]:0);
		 }
		// t($allcation_id_array);
		$diff_array = array_diff($existing_allcation_id_array,$allcation_id_array);
		
		if(!empty($diff_array)&&count($diff_array)>0)
		{
		POAllocation::whereIn('id',$diff_array)->delete();
		}
		 for($i=0;$i<$count_row;$i++)
		 {
			 //t($data['userrole1_'.$i]);
			$insertdata['item_id'] = isset($data['itemid'])?$data['itemid']:0 ;
			$insertdata['po_id'] = isset($data['poid'])?$data['poid']:0 ;
			$insertdata['podetails_id'] = isset($data['puchaseOrderDetailsId'])?$data['puchaseOrderDetailsId']:0 ;
			$insertdata['item_sku'] = isset($data['itemSkuCode'])?$data['itemSkuCode']:0 ;
			
			
			
			  if(isset($data['userrole1_'.$i])&& $data['userrole1_'.$i]==2)
			 {
				 $insertdata['role_id'] = (isset($data['userrole1_'.$i])&& $data['userrole1_'.$i]!='')?$data['userrole1_'.$i]:0;
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole2['roleuser1']= (isset($data['userrole2_'.$i])&&$data['userrole2_'.$i]!='')?implode(',',$data['userrole2_'.$i]):'';
				 $userrole2['roleuser2']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['share_user'] ='';
					 $insertdata['each_user'] = isset($data['eachselectbox_'.$i])?$data['eachselectbox_'.$i]:''  ;
				 }
				 else{
					 $insertdata['each_user'] = '';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole2); 
			 }
			 if(isset($data['userrole1_'.$i]) && $data['userrole1_'.$i]==5)
			 {
				 $insertdata['role_id'] = isset($data['userrole1_'.$i])?$data['userrole1_'.$i]:0;
				 $insertdata['brand_id']= isset($data['userrole2_'.$i])?implode(',',$data['userrole2_'.$i]):'';
				 
				  $insertdata['region_id']= '';
				  $insertdata['country_id']= '';
				   
				 
				  $userrole5['roleuser1']= isset($data['userrole3_'.$i])?implode(',',$data['userrole3_'.$i]):'';
				 for($j=1;$j<$data['dynamoselectcount_'.$i];$j++)
				 {
					 $j1 = $j+1 ;
					 if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					 {
					$userrole5['roleuser'. $j1]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					 }
				 }
				
				/*  $userrole['roleuser2']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['share_user'] = '' ;
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
				 }
				 else{
					 $insertdata['each_user'] = '';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole5); 
			 } 
			  if($data['userrole1_'.$i]==9)
			 {
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['country_id']= implode(',',$data['userrole2_'.$i]);
				  $insertdata['region_id']= '';
				 
				   $insertdata['brand_id']= '';
				 $insertdata['region_id']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				
				  for($j=1;$j<=$data['dynamoselectcount_'.$i];$j++)
				 {
					if(isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')
					{
					$userrole9['roleuser'.$j]= (isset($data['userrole4_'.$j.'_'.$i])&&$data['userrole4_'.$j.'_'.$i]!='')?implode(',',$data['userrole4_'.$j.'_'.$i]):''; 
					}
				 }
				 
				/*  $userrole['roleuser1']= isset($data['userrole4_1_'.$i])?implode(',',$data['userrole4_1_'.$i]):'';
				 $userrole['roleuser2']= isset($data['userrole4_2_'.$i])?implode(',',$data['userrole4_2_'.$i]):'';
				 $userrole['roleuser3']= isset($data['userrole4_3_'.$i])?implode(',',$data['userrole4_3_'.$i]):'';
				 $userrole['roleuser4']= isset($data['userrole4_4_'.$i])?implode(',',$data['userrole4_4_'.$i]):'';
				 $userrole['roleuser5']= isset($data['userrole4_5_'.$i])?implode(',',$data['userrole4_5_'.$i]):''; */
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				 
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['share_user']='';
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
				 }
				 else{
					 $insertdata['share_user'] = "shared" ;
					 $insertdata['each_user'] ='';
				 }
				 $insertdata['user'] = json_encode($userrole9); 
			 } 
			  if($data['userrole1_'.$i]==11)
			 {
				 //t($data['userrole3_'.$i]);
				 $insertdata['role_id'] = $data['userrole1_'.$i];
				 $insertdata['region_id']= isset($data['userrole2_'.$i])?implode(',',$data['userrole2_'.$i]):'';
				  $insertdata['country_id']= '';
				   $insertdata['brand_id']= '';
				 $userrole11['roleuser1']= (isset($data['userrole3_'.$i])&&$data['userrole3_'.$i]!='')?implode(',',$data['userrole3_'.$i]):'';
				 $insertdata['quantity'] = isset($data['quantity_'.$i])?$data['quantity_'.$i]:'';
				  if(isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each')
				 {
					 $insertdata['share_user']='';
					 $insertdata['each_user'] = $data['eachselectbox_'.$i]  ;
				 }
				  if(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store')
				 {
					 $insertdata['share_user']='';
					 $insertdata['store_locker'] = $data['storelocator_'.$i]  ;
				 }
				 if((isset($data['eachselectbox_'.$i])&&$data['eachselectbox_'.$i]== 'each') ||(isset($data['storelocator_'.$i])&&$data['storelocator_'.$i]== 'store'))
				 {
				 }
				 else{
					 $insertdata['each_user'] ='';
					 $insertdata['store_locker'] ='';
					 $insertdata['share_user'] = "shared" ;
				 }
				 $insertdata['user'] = json_encode($userrole11); 
			 }
			 
			 
		 //t($insertdata);
			
			if(isset($data['allocation_id_'.$i])&& $data['allocation_id_'.$i])
			{
				POAllocation::where('id',$data['allocation_id_'.$i])->update($insertdata);
			}
			else{
				POAllocation::insert($insertdata);
			}
			 
		 } 
		 //exit() ;
		 //$insertdata['user'] =json_encode($userrole); 
		 
		return redirect('add-po-step2/'.base64_encode($data['poid']))->with('success-msg', 'Purchase Order Update Successfully');
	}
	
    
	
}
?>
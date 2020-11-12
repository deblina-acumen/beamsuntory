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
use Auth;
use DB;
class PoMasterController extends Controller
{
	
	 public function add($id='')
    {
        $data['title']="Purchase Order";
		
		$data['category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['warehouse']=$list = Warehouse::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['product']=$list = Product::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
		//t($data,1);
		if($id=='')
		{
        return view('po.add',$data);
		}
		else
		{
			$id = base64_decode($id);
			$data['po'] = $po = PO::where('id',$id)->get();
			$data['po_item'] = $po_item = POItem::select('purchase_order_details.*','item.name','item.sku','item.product_type')->join('item','item.id','=','purchase_order_details.item_id','left')->where('po_id',$id)->get();
			//t($po);t($po_item);exit;
			return view('po.edit',$data);
		}
    }
	
	
	public function save_po_step1(Request $request)
    {
        $data=$request->all(); //t($data,1);
		
        $insert_data['order_no']='PO-BEAM-'.rand(0,1500).'-'.rand(5,500);
		$insert_data['ownership_type']=$data['ownership_type'];
		$insert_data['status']=$data['status'];
		$insert_data['active_date']=isset($data['active_date']) && $data['active_date']!=''?date('Y-m-d',strtotime($data['active_date'])):'';
		$insert_data['active_time']=isset($data['active_time']) && $data['active_time']!=''?date('h:i:s',strtotime($data['active_time'])):'';
		$insert_data['supplier_id']=isset($data['supplier'])?$data['supplier']:'';
		$insert_data['warehouse_id']=isset($data['warehouse'])?$data['warehouse']:'';
		$insert_data['remarks']='';
        $insert_data['created_by'] = Auth::user()->id;
        $id=PO::insertGetId($insert_data);
		$variation=array();
		for($i=0;$i<count($data['item']);$i++)
		{
			//t($data['item'][$i]);echo"fffffffffff";
			$item_variance_id = explode('_', $data['item'][$i]); 
			$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
			$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
			$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
			$insert_item['po_id'] = $id;
			$insert_item['quantity'] = $data['quantity'][$i];
			$insert_item['created_by'] = Auth::user()->id;
			POItem::insertGetId($insert_item);
		}
		
        if($id!='')
        {
			
            return redirect('add-po-step1/'.base64_encode($id))->with('success-msg', 'Purchase order successfully added..');
        }
        else			
        {
            return redirect('add-po-step1')->with('error-msg', 'Please try after some time');
        }
    }
	
	public function update_po_steop1(Request $request)
	{
		$data = $request->all();
		//t($data,1);
		$update_data['order_no']='PO-BEAM-'.rand(0,1500).'-'.rand(5,500);
		$update_data['ownership_type']=$data['ownership_type'];
		$update_data['status']=$data['status'];
		$update_data['active_date']=isset($data['active_date']) && $data['active_date']!=''?date('Y-m-d',strtotime($data['active_date'])):'';
		$update_data['active_time']=isset($data['active_time']) && $data['active_time']!=''?date('h:i:s',strtotime($data['active_time'])):'';
		$update_data['supplier_id']=isset($data['supplier'])?$data['supplier']:'';
		$update_data['warehouse_id']=isset($data['warehouse'])?$data['warehouse']:'';
		$update_data['remarks']='';
        $update_data['created_by'] = Auth::user()->id;
        $id=PO::where('id',$data['po_id'])->update($update_data);
		$variation=array();
		$po_item_id = implode(',',array_filter($data['po_item_id']));
		POItem::whereRaw("id not in ($po_item_id)")->delete();
		for($i=0;$i<count($data['item']);$i++)
		{
			if($data['po_item_id'][$i] =="")
			{
			$item_variance_id = explode('_', $data['item'][$i]); 
			$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
			$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
			$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
			$insert_item['po_id'] = $data['po_id'];
			$insert_item['quantity'] = $data['quantity'][$i];
			$insert_item['created_by'] = Auth::user()->id;
			POItem::insertGetId($insert_item);
			}
			else
			{
				$item_variance_id = explode('_', $data['item'][$i]); 
				$insert_item['item_id'] = isset($item_variance_id[1])?$item_variance_id[1]:0;
				$insert_item['item_sku'] = isset($item_variance_id[0])?$item_variance_id[0]:'';
				$insert_item['item_variance_id'] = isset($item_variance_id[2])?$item_variance_id[2]:0;
				$insert_item['po_id'] = $data['po_id'];
				$insert_item['quantity'] = $data['quantity'][$i];
				$insert_item['updated_by'] = Auth::user()->id;
				$insert_item['updated_at'] = date('Y-m-d h:i:s');
				POItem::where('id',$data['po_item_id'][$i])->update($insert_item);
			}
		}
		return redirect('add-po-step1/'.base64_encode($data['po_id']))->with('success-msg', 'Purchase order successfully updated..');
	}
	public function get_item_details(Request $request)
	{
		$html = '<option value="">Select</option>';
		$posteddata = $request->all();
		$type = $posteddata['type'];
		$product_list = Product::where('is_deleted','No')->where('is_active','Yes')->where('product_type',$type)->orderBy('name','asc')->get();
		foreach($product_list as $k=>$product)
		{
			$variance = array();
			if($product->product_type == 'variable_product')
			{
				$variance = ProductVariations::where('item_id',$product->id)->where('is_deleted','No')->get();
				foreach($variance as $variancedt)
				{
					$sku = json_decode($variancedt->variation);
					$sku = isset($sku->sku)?$sku->sku:'';
					$html .= '<option value="'.$sku.'_'.$product->id.'_'.$variancedt->id.'">'.$product->name.'-'.$sku.'</option>';
				}
			}
			else
			{
				$html .= '<option value="'.$product->sku.'_'.$product->id.'">'.$product->name.'-'.$product->sku.'</option>';
			}
		}
		echo $html;
	}
	
    public function product_list(Request $request)
    {
		DB::enableQueryLog();
		$posteddata = $request->all();
		//t($posteddata);
		//exit();
        $data['title']="Product category";
		
		$data['product_category_val'] = $product_category_val = isset($posteddata['product_category_val']) ? $posteddata['product_category_val'] : '';
		$data['product_brand'] = $product_brand = isset($posteddata['product_brand']) ? $posteddata['product_brand'] : '';
		$data['product_type'] = $product_type = isset($posteddata['product_type']) ? $posteddata['product_type'] : '';
		$data['product_sku'] = $product_sku = isset($posteddata['product_sku']) ? $posteddata['product_sku'] : '';
		
		$where = '1=1';
		if ($posteddata) {
			
			if ($product_category_val != '') {
				
				$where .= ' and item.category_id='.$product_category_val;
				
							
			}
			if ($product_brand != '') {
				$where .= ' and item.brand_id=' . $product_brand;				
				
			}
			if ($product_type != '') {
				$where .= " and item.product_type='$product_type'";				
								
			}

			if ($product_sku != '') {
				
				$where .= " and lower(item.sku) LIKE '%$product_sku%'";
			}
			
		}
		
        $data['product_list']=$list = Product::select('item.*','brand.name as brand_name','product_category.name as cat_name','supplier_name')->join('product_category','product_category.id','=','item.category_id','left')->join('brand','brand.id','=','item.brand_id','left')->join('supplier','supplier.id','=','item.supplier_id','left')->whereRaw($where)->where('item.is_deleted','No')->orderBy('item.name','asc')->get();
		$data['product_category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//$query = DB::getQueryLog();
		//t($query);
		///exit();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('product.ProductMaster.list',$data);
    }

    
    
    

    public function edit_product($id)
    {
		$data['id'] =$product_id = base64_decode($id);
       
            $data['title']="Product category";
		
		$data['category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['product_attribute']=$list = ProductAttribute::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
		
		$data['info'] = $info = Product::where('id',$product_id)->get() ;
		$data['varience_count'] = $varience =  ProductVariations::where('item_id',$product_id)->count();
		//echo count($varience);
		//exit();
		
        return view('product.ProductMaster.edit',$data);
        
    }

    public function update_product(Request $request)
    {
        $data=$request->all();// t($data,1);
		
		$have_product = Product::where('name',$data['product_name'])->where('is_deleted','No')->get();
		if(!empty($have_product) && count($have_product)>0 && $have_product[0]->id !=  $data["id"])
		{
			return redirect('edit-product/'.base64_encode($data['id']))->with('error-msg', 'Product  already exist');
		}
        $insert_data['name']=$data['product_name'];
		$insert_data['description']=isset($data['product_description'])?$data['product_description']:0;
		$insert_data['brand_id']=$data['brand'];
		$insert_data['product_type']=isset($data['product_type'])?$data['product_type']:'';
		$insert_data['category_id']=$data['category'];
		$insert_data['supplier_id']=$data['vendor'];
		$insert_data['regular_price']=$data['regular_price'];
		$insert_data['retail_price']=$data['retail_price'];
		$insert_data['sku']=$data['sku'];
		$insert_data['low_stock_level']=$data['low_stock_level'];
		$insert_data['status']=$data['status'];
		//$insert_data['batch_no']='BEAM-'.rand(0,1500).'-'.rand(5,500);
		$insert_data['weight']=$data['weight'];
		$insert_data['length']=$data['length'];
		$insert_data['width']=$data['Width'];
		$insert_data['height']=$data['Height'];
		//upload image2wbmp
		$cat_image = $request->file('image');
			if($cat_image !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($cat_image, 'product','product',$data['product_name']);	
					if($cat_image_pic_name!='')
					{
						$insert_data['image'] = $cat_image_pic_name;
					}
				
			}
        $insert_data['updated_by'] = Auth::user()->id;
		$insert_data['updated_at'] = date('Y-m-d h:i:s');
       $id = Product::where('id',$data["id"])->update($insert_data);
	   
	   
	    $varience_id_arr = [] ;
		for($i=0;$i<$data['variation_count'];$i++)
		{
			
			if($data['varience_id'.$i][0]!='')
			{
			array_push($varience_id_arr,implode(',',$data['varience_id'.$i]));
			}
		}
		
		ProductVariations::where('item_id',$data["id"])->whereNotIn('id', $varience_id_arr)->delete(); 
		
	 
		
		for($i=0;$i<$data['variation_count'];$i++)
		{
			$varience_id = $data['varience_id'.$i] ;
			$variation=array();
			foreach($data['attribute_name'.$i] as $k=>$variations)
			{
				//t($variations);
				//echo $k;
				//t($data['variation'.$i][$k]);
				$variation[$variations] =$data['variation'.$i][$k];
				$variation['sku']= $data['attribute_sku'.$i];
				
			}
			//t($variation);
			//t(json_encode($variation));
			$insert_variation['item_id'] = $data['id'];
			$insert_variation['variation'] = json_encode($variation);
			$insert_variation['created_by'] = Auth::user()->id;
			 if($varience_id[0]!='')
			{
				ProductVariations::where('id',$varience_id[0])->update($insert_variation);
			}
			else{
			ProductVariations::insertGetId($insert_variation);
			}
		} 
		
        if($id!='')
        {
			
            return redirect('product-list')->with('success-msg', 'Product Category successfully Updated');
        }
        else			
        {
            return redirect('edit-product/'.base64_encode($data['id']))->with('error-msg', 'Please try after some time');
        }
		
    }
		public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=Product::where('id',$id)->update($update_data);
		if($updated)
            return redirect('product-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('product-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function delete_product($id)
	{
		$id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=Product::where('id',$id)->update($update_data);
        if($updated)
            return redirect('product-list')->with('success-msg', 'Product  successfully deleted');
        else
        {
            return redirect('product-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function view(Request $Request)
	 {
		 $data = $Request->all();
		 //t($data,1);
		$profile_pic = $current_date = $description = $active = $userid = $email =
		$phone_number = $address = $member = $logo = '';
		//$no_image_path = URL("assets/images/avatar/user.jpg");
		$no_image_path = '';
		//$profile_pic_rel_path = 'public/profile_pic';
		$profile_pic_rel_path = 'public/product';
		//$logo_pic_rel_path = 'public/logo';
		
		$info = Product::select('item.*','brand.name as brand_name','product_category.name as cat_name','supplier_name')->join('product_category','product_category.id','=','item.category_id','left')->join('brand','brand.id','=','item.brand_id','left')->join('supplier','supplier.id','=','item.supplier_id','left')->where('item.is_deleted','No')->
		where('item.id','=',$data['item_id'])->get();

		$item_variation = ProductVariations::select('item_variation_details.*')->where('item_id','=',$data['item_id'])
		->where('is_deleted','=','No')->get();
		//t($item_variation[0]->variation,1);
		/* for($i=0;$i<count($item_variation);$i++){
			$variation_value = isset($item_variation[$i]->variation)?json_decode($item_variation[$i]->variation,true):array() ;
			
			$item_variation_val = array();
			 foreach($variation_value as $key=>$value){
				$item_variation_val[$key]=$value;
				t($item_variation_val);

			} 
		}
		exit(); */
		//t($item_variation_val,1);

			$name = isset($info[0]->name) ? $info[0]->name : '' ;

			
			$profile_pic = (isset($info[0]->image)&&$info[0]->image!='') ? asset($profile_pic_rel_path.'/'.$info[0]->image):$no_image_path;

			$current_date = date('d/m/Y',strtotime($info[0]->created_at)) ;
			if($info[0]->is_active!='Y'){
				$active = '<span class="badge badge-success">Active</span>' ;
			}else{
				$active = '<span class="badge badge-danger">Inactive</span>' ;
			}
			$description = isset($info[0]->description) ? $info[0]->description : '' ;
			$batch_no = isset($info[0]->batch_no) ? $info[0]->batch_no : '' ;
			$brand_name = isset($info[0]->brand_name) ? $info[0]->brand_name : '' ;
			$cat_name = isset($info[0]->cat_name) ? $info[0]->cat_name : '' ;
			$supplier_name = isset($info[0]->supplier_name) ? $info[0]->supplier_name : '' ;
			$regular_price = isset($info[0]->regular_price) ? $info[0]->regular_price : '' ;
			$retail_price = isset($info[0]->retail_price) ? $info[0]->retail_price : '' ;
			$sku = isset($info[0]->sku) ? $info[0]->sku : '' ;
			$status = isset($info[0]->status) ? str_replace("_"," ",$info[0]->status) : '' ;
			$status = ucwords($status);
			$low_stock_level = isset($info[0]->low_stock_level) ? $info[0]->low_stock_level : '' ;
			$weight = isset($info[0]->weight) ? $info[0]->weight : '' ;
			$length = isset($info[0]->length) ? $info[0]->length : '' ;
			$width = isset($info[0]->width) ? $info[0]->width : '' ;
			$height = isset($info[0]->height) ? $info[0]->height : '' ;
			$expire_date = isset($info[0]->expire_date) ? date('d/m/Y',strtotime($info[0]->expire_date)) : '' ;


	$html = '
		   <div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <a class="avatar avatar-lg status-success" href="#">
						<img src="'.$profile_pic.'" alt="...">
					  </a>
					  <div class="media-body">
						<p class="font-size-16">
						  <a class="hover-primary" href="#"><strong>'. $name .'</strong></a>
						</p>'.$current_date.'
						 
						<p>'.$description.'</p>
						</div>
					  <div class="media-right">'.$active.'</div>
					  
					</div>					
					
				  </div>
				 
				   <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-striped mb-0">
					  
					  <tbody>
						<tr>
						  <th scope="row"> Batch No:</th>
						  <td>'.$batch_no.'</td>
						</tr>
						<tr>
						  <th scope="row"> Brand Name:</th>
						  <td>'.$brand_name.'</td>
						</tr>
						<tr>
						  <th scope="row">  category Name:</th>
						  <td>'.$cat_name.'</td>
						</tr>
						<tr>
						  <th scope="row">  Supplier Name:</th>
						  <td>'.$supplier_name.'</td>
						</tr>
						<tr>
						  <th scope="row">  Price:</th>
						   <td>'.$regular_price.'</td>
						</tr>
						<tr>
						  <th scope="row">  Retail Price:</th>
						   <td>'.$retail_price.'</td>
						</tr>
						<tr>
						  <th scope="row">  SKU:</th>
						   <td>'.$sku.'</td>
						</tr>
						<tr>
						  <th scope="row">  Status:</th>
						   <td>'.$status.'</td>
						</tr>
						<tr>
						  <th scope="row">  Low Stock Level:</th>
						   <td>'.$low_stock_level.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Weight:</th>
						   <td>'.$weight.'</td>
						</tr>
						<tr>
						  <th scope="row">  Length:</th>
						   <td>'.$length.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Width:</th>
						   <td>'.$width.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Height:</th>
						   <td>'.$height.'</td>
						   
						</tr>
						<tr>
						  <th scope="row">  Expiration Date:</th>
						   <td>'.$expire_date.'</td>
						   
						</tr>';
						for($i=0;$i<count($item_variation);$i++){
							
							$html.= '<tr scope="row">';
							if($i==0){
							$html.= '<th> Item Variations</th>';
							}else { 
							$html.= '<th></th>';
							}
							$variation_value = isset($item_variation[$i]->variation)?json_decode($item_variation[$i]->variation,true):array() ;
						    //t($variation_value,1);
							$html .='<td>';
							foreach($variation_value as $key=>$value){	
							$html .= $key ." : ".$value." , ";
							//t($item_variation_val);
						} 
						$html .='</td>
						</tr>';
					}
					  $html .='</tbody>
					</table>
					
				</div>
            </div>' ;
			//$html = '<div>HIIII</div>';
				 echo $html;
	 }
	
}
?>
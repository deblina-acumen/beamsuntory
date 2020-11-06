<?php

namespace App\Http\Controllers\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Brand;
use App\Model\Supplier;
use App\Model\ProductAttribute;
use App\Model\ProductVariations;
use Auth;
use DB;
class ProductController extends Controller
{
    public function product_list()
    {
        $data['title']="Product category";
        $data['product_list']=$list = Product::select('item.*','brand.name as brand_name','product_category.name as cat_name','supplier_name')->join('product_category','product_category.id','=','item.category_id','left')->join('brand','brand.id','=','item.brand_id','left')->join('supplier','supplier.id','=','item.supplier_id','left')->where('item.is_deleted','No')->where('item.is_active','Yes')->orderBy('item.name','asc')->get();
		$data['product_category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		//t($data,1);
        return view('product.ProductMaster.list',$data);
    }

     public function add()
    {
        $data['title']="Product category";
		
		$data['category']=$list = ProductCategory::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['supplier']=$list = Supplier::where('is_deleted','No')->where('is_active','Yes')->orderBy('id','asc')->get();
		$data['product_attribute']=$list = ProductAttribute::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
		//t($data,1);
        return view('product.ProductMaster.add',$data);
    }
    public function get_attribute_detsils(Request $request)
	{
		$data=$request->all();
		$variation_count =isset($data['variation_count']) && $data['variation_count']!=''? $data['variation_count']:0;
		$attribute = isset($data['attribute']) && $data['attribute']!=''?implode(',',$data['attribute']):'';
		$attribute_details = ProductAttribute::whereRaw("id in ($attribute)")->orderBy('id','asc')->get();
		$html='';
		
			
			$html.='<div class="row">';
			foreach($attribute_details as $attributeDetails)
			{
			  $attribute_val = isset($attributeDetails->value)&& $attributeDetails->value!=''?explode(',',$attributeDetails->value):array();
              $html.='<div class="col-md-3">
                <label>Select '.$attributeDetails->name.'</label>
                <div class="input-group">
				
                <select  aria-controls="project-table" name="variation'.$variation_count.'[]" required class="form-control form-control-sm" onchange="remove_sku('.$variation_count.')">';
				foreach($attribute_val as $attributeVal){
                 $html.='<option value="'.$attributeVal.'">'.$attributeVal.'</option>';
				} 
                 $html.='</select>
                </div> 
              </div><input type="hidden" name="attribute_name'.$variation_count.'[]" value="'.$attributeDetails->name.'">
			  ';
			}
              $html.='
              <div class="col-md-3">
                <label>SKU</label>
                <div class="input-group">
                  <input type="text" class="form-control" required name="attribute_sku'.$variation_count.'" id="sku'.$variation_count.'">
                <button type="button" class="btn btn-dark btn-sm" onclick="genarate_sku(this)">Generate SKU</button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="pull-right">
                                    <label>Action</label>
                <div class="input-group">
                  <button type="button" class="btn btn-danger btn-sm" onclick="remove_variation(this)">Remove Variation</button>
                </div>
                </div>
              </div>
            </div> <hr class="my-15">';
		
		echo $html;
	}
    public function save_produt(Request $request)
    {
        $data=$request->all(); //t();
		$have_product = Product::where('name',$data['product_name'])->where('is_deleted','No')->get();
		if(!empty($have_product) && count($have_product)>0)
		{
			return redirect('add-product')->with('error-msg', 'Product Category already exist');
		}
        $insert_data['name']=$data['product_name'];
		$insert_data['description']=isset($data['product_description'])?$data['product_description']:0;
		$insert_data['brand_id']=$data['brand'];
		$insert_data['category_id']=$data['category'];
		$insert_data['supplier_id']=$data['vendor'];
		$insert_data['regular_price']=$data['regular_price'];
		$insert_data['retail_price']=$data['retail_price'];
		$insert_data['sku']=$data['sku'];
		$insert_data['low_stock_level']=$data['low_stock_level'];
		$insert_data['status']=$data['status'];
		$insert_data['batch_no']='BEAM-'.rand(0,1500).'-'.rand(5,500);
		//$insert_data['category_id']=$data['shelf_life'];
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
        $insert_data['created_by'] = Auth::user()->id;
        $id=Product::insertGetId($insert_data);
		
		$variation=array();
		
		for($i=0;$i<$data['variation_count'];$i++)
		{
			
			foreach($data['attribute_name'.$i] as $k=>$variations)
			{
				
				$variation[$variations] =$data['variation'.$i][$k];
				$variation['sku']= $data['attribute_sku'.$i];
				
			}
			$insert_variation['item_id'] = $id;
			$insert_variation['variation'] = json_encode($variation);
			$insert_variation['created_by'] = Auth::user()->id;
			ProductVariations::insertGetId($insert_variation);
		}
		
        if($id!='')
        {
			
            return redirect('produt-list')->with('success-msg', 'Product Category successfully added');
        }
        else			
        {
            return redirect('produt-list')->with('error-msg', 'Please try after some time');
        }
    }

    public function edit_product_category($id)
    {
       
            $id=base64_decode($id);
			$data['product_categoryList'] = ProductCategory::where('is_active','Yes')->where('is_deleted','No')->get();
            $data["title"]="Product Category List";
            $data["info"]=ProductCategory::where('id',$id)->get();
            return view('product.ProductCategory.edit',$data);
       
        
    }

    public function update_product_category(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_store_category = ProductCategory::where('name',$data['product_category_name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0 && $have_store_category[0]->id !=  $data["id"] )
		{
			return redirect('edit-Produt-Category/'.base64_encode($data['id']))->with('error-msg', 'Product Category already exist');
		}
        $update_data['name']=$data['product_category_name'];
		$update_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		
		
		$update_data['description']=$data['description'];
        $update_data['updated_by'] = Auth::user()->id;
		$update_data['updated_at'] = date('Y-m-d h:i:s');
        $id=$data["id"];
        $updated=ProductCategory::where('id',$id)->update($update_data);
        if($updated)
            return redirect('product-category-list')->with('success-msg', 'Product Category successfully updated');
        else
        {
            $url="edit-Produt-Category/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	public function delete_product_category($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=ProductCategory::where('id',$id)->update($update_data);
        if($updated)
            return redirect('product-category-list')->with('success-msg', 'Product Category successfully deleted');
        else
        {
            return redirect('product-category-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function change_status_product_category($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=ProductCategory::where('id',$id)->update($update_data);
		if($updated)
            return redirect('product-category-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('product-category-list')->with('error-msg', 'Please try after some time');    
        }
	} 
}
?>
<?php

namespace App\Http\Controllers\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ProductCategory;
use Auth;
use DB;
class ProductCategoryController extends Controller
{
    public function product_category_list()
    {
        $data['title']="Product category";
        $data['info']=$list = ProductCategory::where('is_deleted','No')->orderBy('id','asc')->get();
		//t($list,1);
        return view('product.ProductCategory.list',$data);
    }

     public function add_product_category()
    {
        $data['title']="Product category";
		
		$data['product_categoryList'] = ProductCategory::where('is_active','Yes')->where('is_deleted','No')->get();
        return view('product.ProductCategory.add',$data);
    }

    public function save_product_category(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_store_category = ProductCategory::where('name',$data['product_category_name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0)
		{
			return redirect('add-Produt-Category')->with('error-msg', 'Product Category already exist');
		}
        $insert_data['name']=$data['product_category_name'];
		$insert_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:0;
		$insert_data['description']=$data['description'];
		
        $insert_data['created_by'] = Auth::user()->id;
        $id=ProductCategory::insertGetId($insert_data);
        if($id!='')
        {
            return redirect('product-category-list')->with('success-msg', 'Product Category successfully added');
        }
        else			
        {
            return redirect('add-Produt-Category')->with('error-msg', 'Please try after some time');
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
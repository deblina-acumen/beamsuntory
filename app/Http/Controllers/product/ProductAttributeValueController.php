<?php

namespace App\Http\Controllers\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ProductAttribute;
use Auth;
use DB;
class ProductAttributeValueController extends Controller
{
    public function list_product_attribute_value()
    {
        $data['title']="Product category";
        $data['info']=$list = ProductAttribute::where('is_deleted','No')->orderBy('id','asc')->get();
		//t($list,1);
        return view('product.productattribute.list',$data);
    }

     public function add_product_attribute_value()
    {
        $data['title']="Product Attribute";
		
		//echo "test";
		//exit();
        return view('product.productattribute.add',$data);
    }
	
	public function save_product_attribute_value(Request $request)
	{
		$data=$request->all(); //t($data,1);
		
		$have_store_category = ProductAttribute::where('name',$data['attr_name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0)
		{
			return redirect('add-Produt-attribute-value')->with('error-msg', 'Product Attribute already exist');
		}
		else{
			
			$insert_data['name']=$data['attr_name'];
		$insert_data['value']=implode(',',$data['attr_val']);
		
        $insert_data['created_by'] = Auth::user()->id;
        $id=ProductAttribute::insertGetId($insert_data);
        if($id!='')
        {
            return redirect('Produt-attribute-list')->with('success-msg', 'Product Attribute successfully added');
        }
        else			
        {
            return redirect('add-Produt-attribute-value')->with('error-msg', 'Please try after some time');
        }
			
		}
	}

 

    public function edit_product_attribute_value($id)
    {
       
            $id=base64_decode($id);
			
            $data["title"]="Product Attribute";
			$data['id'] = $id ;
            $data["info"]=ProductAttribute::where('id',$id)->get();
            return view('product.productattribute.edit',$data);
       
        
    }

    public function update_product_attribute_value(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_store_category = ProductAttribute::where('name',$data['attr_name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0 && $have_store_category[0]->id !=  $data["id"] )
		{
			return redirect('edit-Produt-attribute-value/'.base64_encode($data['id']))->with('error-msg', 'Product Attribute already exist');
		}
        $update_data['name']=$data['attr_name'];
		$update_data['value']=implode(',',$data['attr_val']);
		
        $update_data['updated_by'] = Auth::user()->id;
		$update_data['updated_at'] = date('Y-m-d h:i:s');
        $id=$data["id"];
        $updated=ProductAttribute::where('id',$id)->update($update_data);
        if($updated)
            return redirect('Produt-attribute-list')->with('success-msg', 'Product Attribute successfully updated');
        else
        {
            $url="edit-Produt-attribute-value/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	public function delete_product_attribute($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=ProductAttribute::where('id',$id)->update($update_data);
        if($updated)
            return redirect('Produt-attribute-list')->with('success-msg', 'Product Category successfully deleted');
        else
        {
            return redirect('Produt-attribute-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function change_status_product_attribute($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=ProductAttribute::where('id',$id)->update($update_data);
		if($updated)
            return redirect('Produt-attribute-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('Produt-attribute-list')->with('error-msg', 'Please try after some time');    
        }
	} 
}
?>
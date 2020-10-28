<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StoreCategory;
use Auth;
use DB;
class StoreCategoryController extends Controller
{
    public function store_category_list()
    {
        $data['title']="store_category Management";
        $data['info']=$list = StoreCategory::where('is_deleted','No')->get();
		//t($list,1);
        return view('master.StoreCategory.list',$data);
    }

    public function add_store_category()
    {
        $data['title']="store_category";
		$data["title"]="store_category Management";
		$data['store_categoryList'] = StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
        return view('master.StoreCategory.add',$data);
    }

    public function save_store_category_data(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_store_category = StoreCategory::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0)
		{
			return redirect('add-store-category')->with('error-msg', 'Store Category already exist');
		}
        $insert_data['name']=$data['name'];
		$insert_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		//$insert_data['description']=$data['description'];
		$cat_image = $request->file('cat_image');
			if($cat_image !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($cat_image, 'storeCategory','storeCategory',$data['name']);	
					if($cat_image_pic_name!='')
					{
						$insert_data['image'] = $cat_image_pic_name;
					}
				
			}
        $insert_data['created_by'] = Auth::user()->id;
        $id=StoreCategory::insertGetId($insert_data);
        if($id!='')
        {
            return redirect('store-category-list')->with('success-msg', 'Store Category successfully added');
        }
        else			
        {
            return redirect('add-store-category')->with('error-msg', 'Please try after some time');
        }
    }

    public function store_category_edit($id)
    {
       if (base64_decode($id, true)) 
       {
            $id=base64_decode($id);
			$data['store_categoryList'] = StoreCategory::where('is_active','Yes')->where('is_deleted','No')->where('id','!=',$id)->get();
            $data["title"]="store_category Management";
            $data["info"]=StoreCategory::where('id',$id)->get();
            return view('master.StoreCategory.edit',$data);
       }
       else
            abort(404);    
    }

    public function update_store_category_data(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_store_category = StoreCategory::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_store_category) && count($have_store_category)>0 && $have_store_category[0]->id !=  $data["id"] )
		{
			return redirect('edit-store-category/'.base64_encode($data['id']))->with('error-msg', 'store_category already exist');
		}
        $update_data['name']=$data['name'];
		$update_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		
		$cat_image = $request->file('cat_image');
			if($cat_image !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($cat_image, 'storeCategory','storeCategory',$data['name']);	
					if($cat_image_pic_name!='')
					{
						$update_data['image'] = $cat_image_pic_name;
					}
				
			}
	//	$update_data['description']=$data['description'];
        $update_data['updated_by'] = Auth::user()->id;
		$update_data['updated_at'] = date('Y-m-d h:i:s');
        $id=$data["id"];
        $updated=StoreCategory::where('id',$id)->update($update_data);
        if($updated)
            return redirect('store-category-list')->with('success-msg', 'store_category successfully updated');
        else
        {
            $url="edit-store-category/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	public function delete_store_category($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=StoreCategory::where('id',$id)->update($update_data);
        if($updated)
            return redirect('store-category-list')->with('success-msg', 'store_category successfully deleted');
        else
        {
            return redirect('store-category-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=StoreCategory::where('id',$id)->update($update_data);
		if($updated)
            return redirect('store-category-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('store-category-list')->with('error-msg', 'Please try after some time');    
        }
	}
}
?>
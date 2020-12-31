<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use Auth;
use DB;
class BrandController extends Controller
{
    public function Brand_list()
    {
        $data['title']="Brand Management";
        $data['info']=$list = Brand::where('is_deleted','No')->orderBy('name', 'ASC')->get();
		//t($list,1);
        return view('master.Brand.list',$data);
    }

    public function add_Brand()
    {
        $data['title']="Brand";
		$data["title"]="Brand Management";
		$data['BrandList'] = Brand::where('is_active','Yes')->where('is_deleted','No')->orderBy('name', 'ASC')->get();
        return view('master.Brand.add',$data);
    }

    public function save_Brand_data(Request $request)
    {
        $data=$request->all();//t($data,1);
		
		$have_Brand = Brand::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_Brand) && count($have_Brand)>0)
		{
			return redirect('add-brand')->with('error-msg', 'Brand already exist');
		}
        $insert_data['name']=$data['name'];
		$insert_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:0;
		$cat_image = $request->file('image');
			if($cat_image !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($cat_image, 'brandMaster','brandMaster',$data['name']);	
					if($cat_image_pic_name!='')
					{
						$insert_data['image'] = $cat_image_pic_name;
					}
				
			}
        $insert_data['created_by'] = Auth::user()->id;
        $id=Brand::insertGetId($insert_data);
        if($id!='')
        {
            return redirect('brand-list')->with('success-msg', 'Brand successfully added');
        }
        else			
        {
            return redirect('add-brand')->with('error-msg', 'Please try after some time');
        }
    }

    public function Brand_edit($id)
    {
       if (base64_decode($id, true)) 
       {
            $id=base64_decode($id);
			$data['BrandList'] = Brand::where('is_active','Yes')->where('is_deleted','No')->where('id','!=',$id)->orderBy('name', 'ASC')->get();
            $data["title"]="Brand Management";
            $data["info"]=Brand::where('id',$id)->get();
            return view('master.Brand.edit',$data);
       }
       else
            abort(404);    
    }

    public function update_Brand_data(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_Brand = Brand::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_Brand) && count($have_Brand)>0 && $have_Brand[0]->id !=  $data["id"] )
		{
			return redirect('edit-brand/'.base64_encode($data['id']))->with('error-msg', 'Brand already exist');
		}
        $update_data['name']=$data['name'];
		$update_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		$cat_image = $request->file('image');
			if($cat_image !='')
			{
				
					$cat_image_pic_name = upload_file_single_with_name($cat_image, 'brandMaster','brandMaster',$data['name']);	
					if($cat_image_pic_name!='')
					{
						$update_data['image'] = $cat_image_pic_name;
					}
				
			}
        $update_data['updated_by'] = Auth::user()->id;
		$update_data['updated_at'] = date('Y-m-d h:i:s');
        $id=$data["id"];
        $updated=Brand::where('id',$id)->update($update_data);
        if($updated)
            return redirect('brand-list')->with('success-msg', 'Brand successfully updated');
        else
        {
            $url="edit-brand/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	public function delete_Brand($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=Brand::where('id',$id)->update($update_data);
        if($updated)
            return redirect('brand-list')->with('success-msg', 'Brand successfully deleted');
        else
        {
            return redirect('brand-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=Brand::where('id',$id)->update($update_data);
		if($updated)
            return redirect('brand-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('brand-list')->with('error-msg', 'Please try after some time');    
        }
	}
}
?>
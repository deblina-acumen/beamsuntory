<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use Auth;
use DB;
class RoleController extends Controller
{
    public function role_list()
    {
        $data['title']="Role Management";
        $data['info']=$list = Role::where('is_deleted','No')->get();
		//t($list,1);
        return view('master.role.list',$data);
    }

    public function add_role()
    {
        $data['title']="Role";
		$data["title"]="Role Management";
		$data['roleList'] = Role::where('is_active','Yes')->where('is_deleted','No')->get();
        return view('master.role.add',$data);
    }

    public function save_role_data(Request $request)
    {
        $data=$request->all();
		$have_role = Role::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_role) && count($have_role)>0)
		{
			return redirect('add-role')->with('error-msg', 'Role already exist');
		}
        $insert_data['name']=$data['name'];
		$insert_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		$insert_data['description']=$data['description'];
        $insert_data['created_by'] = Auth::user()->id;
        $id=Role::insertGetId($insert_data);
        if($id!='')
        {
            return redirect('role-list')->with('success-msg', 'Role successfully added');
        }
        else			
        {
            return redirect('add-role')->with('error-msg', 'Please try after some time');
        }
    }

    public function role_edit($id)
    {
       if (base64_decode($id, true)) 
       {
            $id=base64_decode($id);
			$data['roleList'] = Role::where('is_active','Yes')->where('is_deleted','No')->where('id','!=',$id)->get();
            $data["title"]="Role Management";
            $data["info"]=Role::where('id',$id)->get();
            return view('master.role.edit',$data);
       }
       else
            abort(404);    
    }

    public function update_role_data(Request $request)
    {
        $data=$request->all(); //t($data,1);
		$have_role = Role::where('name',$data['name'])->where('is_deleted','No')->get();
		if(!empty($have_role) && count($have_role)>0 && $have_role[0]->id !=  $data["id"] )
		{
			return redirect('edit-role/'.base64_encode($data['id']))->with('error-msg', 'Role already exist');
		}
        $update_data['name']=$data['name'];
		$update_data['parent_id']=isset($data['parent_id'])?$data['parent_id']:'0';
		$update_data['description']=$data['description'];
        $update_data['updated_by'] = Auth::user()->id;
		$update_data['updated_at'] = date('Y-m-d h:i:s');
        $id=$data["id"];
        $updated=Role::where('id',$id)->update($update_data);
        if($updated)
            return redirect('role-list')->with('success-msg', 'Role successfully updated');
        else
        {
            $url="edit-role/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	public function delete_role($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=Role::where('id',$id)->update($update_data);
        if($updated)
            return redirect('role-list')->with('success-msg', 'Role successfully deleted');
        else
        {
            return redirect('role-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=Role::where('id',$id)->update($update_data);
		if($updated)
            return redirect('role-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('role-list')->with('error-msg', 'Please try after some time');    
        }
	}
}
?>
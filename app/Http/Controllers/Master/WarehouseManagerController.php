<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use  App\Model\User;
use App\Model\Module_master;
use App\Model\Designation;
use Auth;
use App\Model\Role;
use DB;
use Mail;

class WarehouseManagerController extends Controller
{
    public function manager_list()
    {
        $data['title']="Warehouse Manager Management";

        $data['info'] = DB::table('users')
		->select('users.name as first_name','users.lastname as last_name','users.useId','users.email as email','users.is_deleted as is_deleted','users.is_active as is_active','users.id as userid')
		->where('users.is_deleted','No')
		->where('users.role_id',2)
		->orderBy('users.id','desc')
		->get()->toArray();

        return view('master.WarehouseManager.lists',$data);
    }

    public function add_warehouse_manager()
    {
		$user_id = Auth::user()->id;
        $data['title']="Warehouse Manager Management";

        return view('master.WarehouseManager.add',$data);
    }

    
    public function save_warehoue_manager_data(Request $request)
    {
        
		$posted = $request->all();

		if(isset($posted['userId']) && $posted['userId']!='')
		{
			$have_user_id = User::where('useId',$posted['userId'])->where('is_deleted','No')->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-warehouse-manager')->with('error-msg', 'User Name already added');
			}
			$insert_data['useId'] =  $userId =  isset($posted['userId'])?$posted['userId']:'';
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
			$insert_data['password'] = isset($posted['password'])?bcrypt($posted['password']):bcrypt(123456);
			$insert_data['email'] = $to_email = isset($posted['email'])?$posted['email']:'';
			$insert_data['phone'] = isset($posted['phone'])?$posted['phone']:'';
			$insert_data['address'] = isset($posted['address'])?$posted['address']:'';
			$insert_data['gender'] = isset($posted['gender'])?$posted['gender']:'';

			$insert_data['role_id'] = isset($posted['role_id'])?$posted['role_id']:2;
			$insert_data['created_by'] = Auth::user()->id;
			
			 $password =  isset($posted['password'])?$posted['password']:123456;

			
			$id = User::insertGetId($insert_data);
			if($id!='')
			{
				  $data2 = [
			        'userid'=>$userId,
					'password'=>$password,  
                ];
			   
              $template = 'master.user.AddWirehouseManagerMailSend'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data2, function ($message) use ($userId, $to_email) {
            $message->to($to_email, $userId)
                ->subject('Warehouse manager Add Mail');
            $message->from('no-repl@gmail.com', 'Warehouse manager Add Mail');
        });
			return redirect('manager-list')->with('success-msg', 'Warehouse Manager added successfully');
			}
			else
			{
			 return redirect('manager-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('manager-list')->with('error-msg', 'Please Provide Uer Id');
		}			
		
    }
    
    public function warehouse_manager_edit($id)
    {
       if (base64_decode($id, true)) 
       {
		   $user_id = Auth::user()->id;
		
            $id = base64_decode($id);
            $data['title']="Warehouse Manager Management";
            $data['info']=User::where('id',$id)->get(); 
            return view('master.WarehouseManager.edit',$data);
       }
       else
            abort(404);
    }

    public function update_warehouse_manager_data(Request $request)
    {
       $posted = $request->all();
		$have_user_id = User::where('useId',$posted['userId'])->where('is_deleted','No')->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('warehouse-manager-edit/'.base64_encode($posted['id']))->with('error-msg', 'User Id already added');
		}
		$insert_data['useId'] = isset($posted['userId'])?$posted['userId']:'';
		$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
		$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
		
		if(isset($posted['password']) && $posted['password']!='')
		{
		 $insert_data['password'] = isset($posted['password'])?bcrypt($posted['password']):'';
		}
		$insert_data['email'] = isset($posted['email'])?$posted['email']:'';
		$insert_data['phone'] = isset($posted['phone'])?$posted['phone']:'';
		$insert_data['address'] = isset($posted['address'])?$posted['address']:'';
		$insert_data['gender'] = isset($posted['gender'])?$posted['gender']:'';

		$insert_data['role_id'] = isset($posted['role_id'])?$posted['role_id']:2;
		$insert_data['updated_by'] = Auth::user()->id;
		
		

		
		/*$profile_pic = $request->file('profile_pic');
			if($profile_pic !='')
			{
				
					$profile_pic_name = upload_file_single_with_name($profile_pic, 'facilityMaster','profile_pic',$posted['userId']);	
					if($profile_pic_name!='')
					{
						$insert_data['profile_pic'] = $profile_pic_name;
					}
				
			}*/
			
			User::where('id',$posted['id'])->update($insert_data);
			return redirect('manager-list')->with('success-msg', 'Warehouse Manager updated successfully');
        
    }
	
	
	public function delete_warehouse_manager($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=User::where('id',$id)->update($update_data);
        if($updated)
            return redirect('manager-list')->with('success-msg', 'Warehouse Manager successfully deleted');
        else
        {
            return redirect('manager-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=User::where('id',$id)->update($update_data);
		if($updated)
            return redirect('manager-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('manager-list')->with('error-msg', 'Please try after some time');    
        }
	}

    // sending mail when an new user is created
    public function send_mail($email="",$name="")
    {
        $to_name = $name;
        $to_email = $email;
        $data = [
                    'name' => $name,
                    'data' => $email,
                    'password' => '123456'
                ];
        $template = 'master.user.test_mail'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Century Testing Mail');
            $message->from('salma.cyber.swift@gmail.com', 'Credentials');
        });
    }

    public function test_mail()
    {
        return view('master.user.test_mail');
    }
}
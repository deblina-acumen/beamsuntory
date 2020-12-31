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
use  App\Model\Country;
use  App\Model\Region;
use App\Model\Brand;
use DB;
use Mail;

class RoleUserController extends Controller
{
    public function user_list()
    {
        $data['title']="User Management";
        
       // $data['resource'] = Input::get('resource') ;
        $data['info'] = DB::table('users')
		->select('users.name as first_name','users.lastname as last_name','users.useId','profile_pic','users.email as email','users.is_deleted as is_deleted','users.is_active as is_active','users.id as userid','user_role.name as rolename')->join('user_role','user_role.id','=','users.role_id','left')
		->where('users.is_deleted','No')->where('user_role.type','=','user')
		->orderBy('users.id','desc')
		->get()->toArray();

        return view('master.roleUser.lists',$data);
    }

    public function add_user()
    {
		$user_id = Auth::user()->id;
        $data['title']="User Management";
        $data['roleList']=Role::where('is_active','Yes')->where('is_deleted','No')->where('type','=','user')->get();
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
		$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
        return view('master.roleUser.add',$data);
    }

    
    public function save_user_data(Request $request)
    {
        
		$posted = $request->all();
		//t($posted,1);
		if(isset($posted['userId']) && $posted['userId']!='')
		{
			$have_user_id = User::where('useId',$posted['userId'])->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-role-user')->with('error-msg', 'User Id already added');
			}
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['email'] = $to_email = isset($posted['email'])?$posted['email']:'';
			//$insert_data['description'] = isset($posted['description'])?$posted['description']:'';
			$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
			$insert_data['useId'] = $userId = isset($posted['userId'])?$posted['userId']:'';
			$insert_data['password'] = isset($posted['password'])?bcrypt($posted['password']):bcrypt(123456);
			
			$insert_data['role_id'] = isset($posted['role'])?$posted['role']:0;
			$insert_data['brand_id'] = isset($posted['brand_id'])?$posted['brand_id']:0;
			$insert_data['country_id'] =isset($posted['country_id'])?$posted['country_id']:0;
			$insert_data['province_id'] =isset($posted['province_id'])?$posted['province_id']:0;
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
			}
			if($is_same_locator_address == true){
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr) :'';
			
			$store_locator_fulladdr['country']=isset($posted['country_id'])?$posted['country_id']:0;
			$store_locator_fulladdr['province']=isset($posted['province_id'])?$posted['province_id']:0;
			$store_locator_fulladdr['street']=$address ;
			$store_locator_fulladdr['city']=$city ;
			$store_locator_fulladdr['zip']=$zip ;
			
			$insert_data['storelocator_address'] = isset($store_locator_fulladdr) ? json_encode($store_locator_fulladdr) :'';
			}else{
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr):'';
			
			if($store_locator_country != '' || $store_locator_province != '' || $store_locator_address !='' || $store_locator_city != '' || $store_locator_zip != '' ){
			$store_locator_fulladdr['country']=$store_locator_country ;
			$store_locator_fulladdr['province']=$store_locator_province ;
			$store_locator_fulladdr['street']=$store_locator_address ;
			$store_locator_fulladdr['city']=$store_locator_city ;
			$store_locator_fulladdr['zip']=$store_locator_zip ;
			}
			$insert_data['storelocator_address'] = isset($store_locator_fulladdr) ? json_encode($store_locator_fulladdr):'';
			
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
					return redirect('role-user-list')->with('success-msg', 'User added successfully');
			}
			else
			{
			 return redirect('role-user-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('role-user-list')->with('error-msg', 'Please Provide Uer Id');
		}			
		
    }
    
    public function user_edit($id)
    {
       if (base64_decode($id, true)) 
       {
		   $user_id = Auth::user()->id;
		
            $id = base64_decode($id);
			
            $data['title']="User Management";
			$data['roleList']=Role::where('is_active','Yes')->where('is_deleted','No')->where('type','=','user')->get();
			
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
			$data['brand']=$list = Brand::where('is_deleted','No')->where('is_active','Yes')->orderBy('name','asc')->get();
			
            $data['info']=User::where('id',$id)->get(); 
            return view('master.roleUser.edit',$data);
       }
       else
            abort(404);
    }


    public function update_user_data(Request $request)
    {
       $posted = $request->all();// t($posted,1);
		$have_user_id = User::where('useId',$posted['id'])->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('role-user-edit/'.base64_encode($posted['id']))->with('error-msg', 'User Id already added');
		}
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['email'] = isset($posted['email'])?$posted['email']:'';
			$insert_data['lastname'] = isset($posted['lastname'])?$posted['lastname']:'';
			$insert_data['useId'] = isset($posted['userId'])?$posted['userId']:'';
			
			$insert_data['brand_id'] = isset($posted['brand_id'])?$posted['brand_id']:0;
			$insert_data['country_id'] =isset($posted['country_id'])?$posted['country_id']:0;
			$insert_data['province_id'] =isset($posted['province_id'])?$posted['province_id']:0;
			
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
			}
			if($is_same_locator_address == true){
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr):'';
			
			$store_locator_fulladdr['country']=isset($posted['country_id'])?$posted['country_id']:0;
			$store_locator_fulladdr['province']=isset($posted['province_id'])?$posted['province_id']:0;
			$store_locator_fulladdr['street']=$address ;
			$store_locator_fulladdr['city']=$city ;
			$store_locator_fulladdr['zip']=$zip ;
			
			$insert_data['storelocator_address'] = isset($store_locator_fulladdr) ? json_encode($store_locator_fulladdr) :'';
			
			}else{
				
			$insert_data['user_address'] = isset($user_fulladdr) ? json_encode($user_fulladdr):'';
			if($store_locator_country != '' || $store_locator_province != '' || $store_locator_address !='' || $store_locator_city != '' || $store_locator_zip != '' ){
			$store_locator_fulladdr['country']=$store_locator_country ;
			$store_locator_fulladdr['province']=$store_locator_province ;
			$store_locator_fulladdr['street']=$store_locator_address ;
			$store_locator_fulladdr['city']=$store_locator_city ;
			$store_locator_fulladdr['zip']=$store_locator_zip ;
			}
			$insert_data['storelocator_address'] = isset($store_locator_fulladdr) ? json_encode($store_locator_fulladdr):'';
			
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
			return redirect('role-user-list')->with('success-msg', 'User updated successfully');
        
    }
	
	
	public function delete_user($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=User::where('id',$id)->update($update_data);
        if($updated)
            return redirect('role-user-list')->with('success-msg', 'User successfully deleted');
        else
        {
            return redirect('role-user-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=User::where('id',$id)->update($update_data);
		if($updated)
            return redirect('role-user-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('role-user-list')->with('error-msg', 'Please try after some time');    
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
	/*public function getStates(Country $country)
    {
        //return $country->states()->select('id', 'name')->get();
		 $data['province'] = Region::
		select('provinces.*')
		->where('provinces.is_deleted','=','No')
		->where('provinces.is_active','=','Yes')
		->orderBy('provinces.id','desc')
		->get(); 
		return Region::
		select('provinces.*')
		->where('provinces.is_deleted','=','No')
		->where('provinces.country','=',$country)
		->orderBy('provinces.id','desc')
		->get();
    }*/
	public function get_province_list_by_country(Request $Request)
	{
		$data = $Request->all();
		//t($data,1);
		$country_id = $data['country_id'];
		if($country_id == "")
		{
			$village_list = Region::where('is_deleted','No')->orderBy('name','asc')->get();
		}
		else if($country_id != "")
		 	$village_list = Region::where('country_id',$country_id)->orderBy('name','asc')->get();
		echo json_encode($village_list);
	}
	public function get_storelocator_province_list_by_country_id(Request $Request)
	{
		$data = $Request->all();
		//t($data,1);
		$country_id = $data['country_id'];
		if($country_id == "")
		{
			$village_list = Region::where('is_deleted','No')->orderBy('name','asc')->get();
		}
		else if($country_id != "")
		 	$village_list = Region::where('country_id',$country_id)->orderBy('name','asc')->get();
		echo json_encode($village_list);
	}
}
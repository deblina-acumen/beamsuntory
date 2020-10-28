<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Input;
use  App\Model\User;
use  App\Model\UserLoginHistory;
 use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Auth;
use Response;

class UserController extends Controller
{

   

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request){
		echo "sudip";
      
    }
	//registration
	public function registration(Request $request)
	{
	  $data = $request->all(); 
	  $name =  isset($data['name'])?$data['name']:'';	
	  $email =  isset($data['email'])?$data['email']:'';	
	  $phone =  isset($data['phone'])?$data['phone']:'';	
	  $password =  isset($data['password'])?$data['password']:'';
	  $have_email = User::where('email', $email)->where('is_deleted','N')->get();
	  if($email=='')
	  {
		  $result['status']=false;
		  $result['message']='Please Proivide Valid Email Id';
		  $result['data']=array();
	  }
	  else if(!empty($have_email) && count($have_email)>0)
	  {
		  $result['status']=false;
		  $result['message']='Please Try With Another Email Id';
		  $result['data']=array();
	  }
	  else if($password=='')
	  {
		  $result['status']=false;
		  $result['message']='Please Proivide Password';
		  $result['data']=array();
	  }
	  else
	  {
		  $insert_data['name'] = $name;
		  $insert_data['email'] = $email;
		  $insert_data['useId'] = $email;
		  $insert_data['phone_number'] =  $phone;
		  $insert_data['password'] =  bcrypt($password);
		  $insert_data['role_id'] = 3;
		  $insertedId = User::insertGetId($insert_data);
		  if($insertedId!='')
		  {
			  $result['status']=true;
			  $result['message']='You have successfully Registered,Please login with you credentials';
			  $result['data']=array();
		  }else
		  {
			  $result['status']=false;
			  $result['message']='Registration Failed,Please try after sometime';
			  $result['data']=array();
		  }
	  }
	  return response()->json(['success'=>$result], 200);
	}
  
	//user login
	public function login(Request $request)
	{
		 $data = $request->all();
		 $email =  isset($data['email'])?$data['email']:'';
		 $password =  isset($data['password'])?$data['password']:'';
		 $device_id =  isset($data['device_id'])?$data['device_id']:'';
		 if( $email=="" ||  $password=="")
		 {
		 }
		 else if($device_id =="")
		 {
			$result['status']=false;
			$result['message']='Please Provide Device Id';
			$result['data']=array();
		 }
		else
		{
		 if(Auth::attempt(['useId' => $email, 'password' => $password,'is_active' => 'N','is_deleted' => 'N'])){
            $user = Auth::user(); 
            $uid= Auth::id();
			$api_token =  Str::random(60);     
			$user['status']=true;
			$user['api_token'] = $api_token ;
			if(isset($user['profile_pic']) && $user['profile_pic']!=''){
				$user['profile_pic']=URL('public/user_profile_pic/'.$user['profile_pic']);
			}
			$result['message']='User Details';
			$result['status']=true;
			$result['data']=$user;
			//update 
			$user_token['api_token'] = $api_token ;
			$date = Carbon::now()->format('Y-m-d H:i:s');
			$user_token['last_login'] =$date;
			User::where('id',$user['id'])->update($user_token);
			//insert login details
			$insert_user_login_histry['user_id'] = $user['id'];
			$insert_user_login_histry['login_date'] = $date;
			$insert_user_login_histry['device_id'] = $device_id;
			UserLoginHistory::insertGetId($insert_user_login_histry);
            
        }
        else{
            $result['status']=false;
			$result['message']='Invalid Credential';
			$result['data']=array();
           
        }
		}
		 return response()->json(['success'=>$result], 200);
	 }

	public function reset_password(Request $request)
	{
		$data = $request->all();
		if($data['staus'] == "success")
		{
			$id = isset($data['id'])?$data['id']:'';
			$current_password = $data['current_password'];
			
			$password = $data['password'];
			$password = $password;
			$user_info = User::where('id',$id)->get();
			
			if(empty($user_info) || count($user_info)==0)
			{
				$result['message']='User not Found';
				$result['status']=true;
				$result['data']=array();
			}
			else
			{
				if(!Hash::check($current_password , $user_info[0]->password))
				{
				$result['message']='Current Password Not Matched';
				$result['status']=false;
				$result['data']=array();
				}
				else
				{
					$update_user['password'] = bcrypt($password);
					$isupdate = User::where('id',$id)->update($update_user);
					if($isupdate)
					{
						$result['message']='Password successfully changed';
						$result['status']=true;
						$result['data']= array();
					}
					else
					{
						$result['message']='Try after sometime';
						$result['status']=false;
						$result['data']=array();
					}
				}
			}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['status']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}
	
	public function edit_profile(Request $request)
	{
		$data = $request->all();
		if($data['staus'] == "success")
		{
			$user_id  = isset($data['id'])?$data['id']:'';
			$name 	  = isset($data['name'])?$data['name']:'';
			$phone 	  = isset($data['phone'])?$data['phone']:'';
			$address 	  = isset($data['address'])?$data['address']:'';
			$password 	  = isset($data['password'])?$data['password']:'';
			$profile_pic  = isset($data['pic'])?$data['pic']:'';
			
			$update_user['name'] = $name;
			$update_user['phone_number'] = $phone;
			$update_user['address'] = $address;
			if($password !=''){
			$update_user['password'] = bcrypt($password);
			}
			$image = $profile_pic;  // your base64 encoded
			$image = str_replace('data:image/png;base64,', '', $image);
			$image = str_replace(' ', '+', $image);
			$imageName = $user_id.$name.'.'.'png';
			\File::put(public_path(). '/user_profile_pic/' . $imageName, base64_decode($image));
			$update_user['profile_pic'] = $imageName;
			$is_updated = User::where('id',$user_id)->update($update_user);
			if($is_updated)
			{
				$result['message']='Profile information updated successfully';
				$result['status']=true;
				$result['data']=array();
			}
			else{
				$result['message']='Sorry!Please try after sometime';
				$result['status']=false;
				$result['data']=array();
			}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['status']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}

}
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Model\User;
use Auth;
use App\Model\Role;
use DB;
use App\Model\MailActivity;
use Mail;
use Illuminate\Support\Facades\Redirect;
class ProfileController extends Controller
{
     public function profile($id)
     {
        if (base64_decode($id, true)) 
        {
			$no_image_path = URL("assets/images/avatar/no_image.jpg");
		$profile_pic_rel_path = 'public/profile_pic';
		
			
            $id=base64_decode($id);
            $data["title"]="Profile Management";
            $data["info"]= $info= User::where('id',$id)
            ->where('is_active','Yes')
            ->get();
           if(count($data['info'])>0)
           {
			   
			$data["profile_pic"]= $profile_pic = (isset($info[0]->profile_pic)&&$info[0]->profile_pic!='') ? asset($profile_pic_rel_path.'/'.$info[0]->profile_pic):$no_image_path;
			
			   
               return view('profile.user',$data);
               exit;
           }
           else
           {
                abort(404);
           }
        } 
        else 
        {
            abort(404);
        }  
     }

     public function profile_update(Request $request)
     {
        
       $posted = $request->all();
	   
		$have_user_id = User::where('useId',$posted['info']['userId'])->where('is_deleted','N')->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			return redirect('profile-management/profile/'.base64_encode($id))->with('error-msg', 'User Id already added');
			 
		}
		$update_data['name'] = isset($posted['info']['name'])?$posted['info']['name']:'';
		$update_data['lastname'] = isset($posted['info']['lastname'])?$posted['info']['lastname']:'';
		$update_data['email'] = isset($posted['info']['email'])?$posted['info']['email']:'';
		//$update_data['description'] = isset($posted['info']['description'])?$posted['info']['description']:'';
		$update_data['phone'] = isset($posted['info']['phone'])?$posted['info']['phone']:'';
		//$update_data['address'] = isset($posted['info']['address'])?$posted['info']['address']:'';
		$update_data['useId'] = isset($posted['info']['userId'])?$posted['info']['userId']:'';
		if(isset($posted['password']) && $posted['password']!='')
		{
		 $update_data['password'] = isset($posted['password'])?bcrypt($posted['password']):'';
		}
		//$update_data['fl_archive'] = isset($posted['status'])?$posted['status']:'';
		$profile_pic = $request->file('profile_pic');
			if($profile_pic !='')
			{
				
					$profile_pic_name = upload_file_single_with_name($profile_pic, 'facilityMaster','profile_pic',$posted['info']['userId']);	
					if($profile_pic_name!='')
					{
						$update_data['profile_pic'] = $profile_pic_name;
					}
				
			}
			/* $logo = $request->file('logo');
			if($logo !='')
			{
				
					$logo_name = upload_file_single_with_name($logo, 'facilityMaster','logo',$posted['info']['userId']);	
					if($logo_name!='')
					{
						$update_data['logo'] = $logo_name;
					}
				
			} */
			User::where('id',$posted['id'])->update($update_data);
        
            return redirect('profile-management/profile/'.base64_encode($posted['id']))->with('success-msg', 'Profile details successfully updated');
        
     }
	 public function forgot_password()
	 {
		     //echo "x";
			//exit();
               return view('profile.forgot_password');
             
	 }
	 public function submit_forgot_pass(Request $request)
	 {
		 $data = $request->all();
		// t($data,1);
		  $data["info"]=User::where('email',$data['email'])
            ->where('fl_archive','N')
            ->get();
			$no_image_path = URL("assets/images/avatar/user.jpg");
			$no_from_user_image_path = URL("assets/images/1.jpg");
			$profile_pic_rel_path = 'public/profile_pic';
           if(count($data['info'])>0)
           {
			   $rand= rand(0,1000);
			   $endodedid = base64_encode($data['info'][0]->id);
			    $to_email = $data['info'][0]->email ;
			   $to_name = $data['info'][0]->name ;
			   $updatedata['encodedid']= $rand ;
			  $profile_pic = (isset($data['info'][0]->profile_pic)&&$data['info'][0]->profile_pic!='') ? asset($profile_pic_rel_path.'/'.$data['info'][0]->profile_pic):$no_image_path;
			    $updated= User::where('id',$data['info'][0]->id)->update($updatedata);
			   $data2 = [
			      'fromname'=>'Facility Management',
				  'fromemail'=>'noreply@gmail.com',
			        'name'=>$to_name,
					'email'=>$to_email,
					'profile_pic'=>$no_from_user_image_path,
			        'url'=>url('/set-new-password/').'/'.base64_encode($rand).'/'.$endodedid,
					'forgot_pass_url'=>url('/forget-password'),
                ];
			   
              $template = 'master.user.forgotpasswordchange'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data2, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Forgot password mail');
            $message->from('admin@gmail.com', 'Forgot password mail');
        });
		//t($data2 ,1);
		
		return redirect('forget-password/')->with('success-msg', 'Mail Send Successfully');
		//return Redirect::back()->with('success-msg', 'mail send successfully');
           }
		   else{
			   return redirect('forget-password/')->with('danger-msg', 'Mail Does Not Send ,Please add Registered Mail Id');
			 // return Redirect::back()->with('success-msg', 'Mail does not send ,Please add registered mail id');
		   }
	 }
	 public function set_new_password($number,$id)
	 {
		 $decodedid = base64_decode($id);
		 $decodenumber = base64_decode($number);
		 $datapass['id'] = $decodedid ;
		 $datapass['number'] = $decodenumber ;
		 $data["info"]=$info = User::where('id',$decodedid)
            ->where('fl_archive','N')
            ->get();
			//t($info,1);
			if($info[0]->encodedid != 0)
			{
				return view('profile.setnewpassword',$datapass);
			}
			else{
				abort(404);
			}
		  
	 }
	 public function submit_newset_pass(Request $request)
	 {
		 $data = $request->all();
		 //t($data,1);
		 
		 if($data['pass'] == $data['conpass'] )
		 {
			 $updatedata['password']=bcrypt($data['pass']);
			 $updatedata['encodedid']= 0 ;
			 $updated= User::where('id',$data['id'])->update($updatedata);
			    return redirect('/')->with('success-msg', 'Password Changed Successfully');;
		 }
		 else{
			 return Redirect::back()->with('danger-msg', 'Password Doesnot matched');
		 }
	 }
}
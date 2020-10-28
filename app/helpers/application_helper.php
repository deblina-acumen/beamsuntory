<?php
use Illuminate\Contracts\Encryption\DecryptException;
use App\Model\Module;
use App\Model\User;
use App\Model\StoreCategory;
use  App\Model\Notification;
use App\Model\Role;

function upload_file_single_with_name($file,$type,$file_name,$userId)
{
	//file upload 
		if($file!=''){
		$new_file_name =$userId;			
		 $upload_path =  public_path($file_name);
		// image upload in public/upload folder.
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true);
		}		
		$files = glob(public_path($file_name.'\*'));// get all file names		
		//end unlik file section
		$extention =$file->getClientOriginalExtension();
		$org_name = $file->getClientOriginalName() ;
		$image_name = $new_file_name.'_'.$org_name;
		$upload = $file->move($upload_path, $image_name); 
		
		if(!empty($upload))
		{
			return $image_name;
		}
		else
		{
			$image_name='';
			return $image_name;
		}
	 }
}

function get_facility_name_by_id($id)
{
	$details = User::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}

function get_number_of_member_by_id($id)
{
	$details = FacilityMemberDetails::where('facility_id',$id)->count();
	return isset($details)?$details:'';
}

	///////////////////////////////////////////Notification Section/////////////////////////////////////////////////
	function get_all_notification($user_id,$type='')
	{
		
		$notification_list = Notification::where('user_id',$user_id)->where('is_opened','N')->get();
		
		return $notification_list;
	}
	
	function is_approver_notification($user_id,$memberId)
	{
		
		$notification_list = Notification::where('user_id',$user_id)->where('member_id',$memberId)->where('is_opened','N')->get();
		
		return $notification_list;
	}
	
	function get_role_by_id($id)
{
	$details = Role::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}
function get_category_by_id($id)
{
	$details = StoreCategory::where('id',$id)->get();
	return isset($details[0]->name)?$details[0]->name:'';
}	

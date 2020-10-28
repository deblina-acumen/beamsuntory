<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Model\User;

use  App\Model\FacilityMemberDetails;

use  App\Model\Notification;

use Auth;
use App\Model\Role;
use DB;
use App\Model\MailActivity;
use Mail;
use Illuminate\Support\Facades\Redirect;
class NotificationController extends Controller
{
     
     public function index(){
		DB::enableQueryLog();
	  $userId = Auth::user()->id;
	 $all_noti = get_all_notification(Auth::user()->id,''); 
	   $count_noti = count($all_noti);
	   $data['count_noti'] = $count_noti ;
	   $data['notification_details'] = $all_noti ;
	  return view('notification.notificationlist',$data);
	}
	
	public function notification_url($memberId,$facilityId)
	{
		$data['memberId'] = $memberId = base64_decode($memberId);
		$data['facilityId'] =$facilityId = base64_decode($facilityId);
		$no_image_path = URL("assets/images/avatar/user.jpg");
		$profile_pic_rel_path = 'public/user_profile_pic';
		$logo_pic_rel_path = 'public/logo';
		
		 $info=DB::table('users')
		->select('users.*')->where('users.id','=',$memberId)->get();
		$data['userid'] = isset($info[0]->useId) ? $info[0]->useId : '' ;
			$data['name'] = isset($info[0]->name) ? $info[0]->name : '' ;
			$data['email'] = isset($info[0]->email) ? $info[0]->email : '' ;
			$data['phone_number'] = isset($info[0]->phone_number) ? $info[0]->phone_number : '' ;
			$data['address'] = isset($info[0]->address) ? $info[0]->address : '' ;
			
			$data['profile_pic'] = (isset($info[0]->profile_pic)&&$info[0]->profile_pic!='') ? asset($profile_pic_rel_path.'/'.$info[0]->profile_pic):$no_image_path;
			
			$data['current_date'] = date('d/m/Y',strtotime($info[0]->created_at)) ;
			$data['active']= $info[0]->is_active ;
			
			$data['description'] = isset($info[0]->description) ? $info[0]->description : '' ;
			
		return view('notification.approval_view',$data);
	}
	
	public function change_approval_status(Request $request)
	{
		$data = $request->all();
		$userId = Auth::user()->id;
		$notification_details = Notification::where('user_id',$data['facility_id'])->where('member_id',$data['memberId'])->where('is_opened','N')->get();
		if(!empty($notification_details)&&count($notification_details)>0)
		{
			if($notification_details[0]->user_id == $userId)
			{
				
				if(isset($data['approve'])&& $data['approve']=='Approve')
				{
					$approved = 'approved' ;
					//QR CODE
					$QR_CODE = base64_encode($userId.$userId).rand(5000,5000000);
					$image=\QrCode::size(80)->errorCorrection('H')->generate($QR_CODE);
					$uPdata['qr_code'] = base64_encode($image);
					$uPdata['qr_code_no'] = $QR_CODE;
					
				}
				if(isset($data['reject'])&& $data['reject']=='Reject')
				{
					$approved = 'rejected' ;
				}
				$uPdata['approval_status'] = $approved ;
				$uPdata['approval_date'] = date('Y-m-d') ;
				$uPdata['approved_by'] = Auth::user()->id ;
				$uPdata['approval_comments'] = $data['comment'] ;
				FacilityMemberDetails::where('user_id',$data['memberId'])->where('facility_id',$data['facility_id'])->update($uPdata);
				
				$InsData['notification_status']='approved';
				$InsData['is_opened'] = 'Y';
				Notification::where('id',$notification_details[0]->id)->update($InsData);
				return redirect('approval-view/'.base64_encode($data['memberId']).'/'.base64_encode($data['facility_id']))->with('success-msg', 'Status change Successfully');
			}
		}
		 
	}
     
	
	
	 
	 
}
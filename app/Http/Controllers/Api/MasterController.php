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
use Illuminate\Support\Str;
use Auth;
use Response;
use  App\Model\User;
use  App\Model\Module_master;
use  App\Model\FacilityMemberDetails;
use  App\Model\Notification;
use  App\Model\AttendanceTable;

class MasterController extends Controller
{
	//sate list search with state name
	public function facilityList(Request $request)
	{
		$data = $request->all(); //t($data ,1);
		$facility_name = isset($data['name'])?$data['name']:'';
		   
		if($data['staus'] == "success")
		{
			$where = "1=1";
            if($facility_name!='')
            {
                
                $where .= " and name LIKE '" . strtolower($facility_name) ."%'";
            }
           
			$facility_list =  User::WhereRaw($where)->where('is_deleted','N')->where('is_active','N')->where('role_id','2')->get();
			foreach($facility_list as $k=>$facility)
				{
					if(isset($facility->profile_pic) && $facility->profile_pic!=''){
					$facility_list[$k]->profile_pic = URL('public/profile_pic/'.$facility->profile_pic);
					}
				}
			if(empty($facility_list) || count($facility_list)==0)
			{
				$result['message']='Facility Not Found';
				$result['success']=true;
				$result['data']=array();
			}
			else
			{
				$result['message']='Facility List';
				$result['success']=true;
				$result['data']= $facility_list;
			}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['success']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}
	
	public function registerFacility(Request $request)
	{
		$data = $request->all(); //t($data ,1);
		$user_id = isset($data['id'])?$data['id']:'';
		$facility_id = isset($data['facility_id'])?$data['facility_id']:'';
		
		if($data['staus'] == "success")
		{
			$have_requested = FacilityMemberDetails::where('user_id',$user_id)->where('facility_id',$facility_id)->where('status','Y')->where('is_active','Y')->get();
			if(!empty($have_requested) && count($have_requested)>0)
			{
				$result['message']='You aleady send resquest for this facility';
				$result['success']=false;
				$result['data']=array();
			}
			else{
	
			$facility_list =  User::Where('id',$facility_id)->where('is_deleted','N')->where('is_active','N')->where('role_id','2')->get();
			$user_details =  User::Where('id',$user_id)->where('role_id','3')->get();
			//t($user_details,1);
			$user_name = isset($user_details[0]->name)?$user_details[0]->name:'';
			if(empty($facility_list) || count($facility_list)==0)
			{
				$result['message']='Facility information Not Found';
				$result['success']=true;
				$result['data']=array();
			}
			else
			{
				
				$register['user_id'] = $user_id ;
				$register['facility_id'] = $facility_id;
				$register['status'] = 'Y';
				$register['approval_status'] = 'pending';
				$insertId = FacilityMemberDetails::insertGetId($register);
				if($insertId!='')
				{
					//insert notification
					$notification['notification_type'] = 'approval';
					$notification['notification_status'] = 'pending';
					$notification['is_opened'] = 'N';
					$notification['user_id'] =  $facility_id;
					$notification['member_id'] =$user_id;
					$notification['created_at'] =date('Y-m-d') ;
					$notification['created_by'] =$user_id ;
					$notification['notification_text'] ="You have received an approval request from ".$user_name." on ".date('d-m-Y');
					$notification['notification_url'] = 'approval-view/'.base64_encode($user_id).'/'.base64_encode($facility_id);
					Notification::insertGetId($notification);

					$result['message']='Success!Your request successfully send to the facility';
					$result['success']=true;
					$result['data']=array();
				}
				else
				{
					$result['message']='Something wrong,Please try after sometime';
					$result['success']=false;
					$result['data']=array();
				}
			}
		
		
		}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['success']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}
	public function myFacility(Request $request)
	{
		$data = $request->all(); //t($data ,1);
		$user_id = isset($data['id'])?$data['id']:'';
		$facility_name = isset($data['name'])?$data['name']:'';
		if($data['staus'] == "success")
		{
				$where = "1=1";
				if($facility_name!='')
				{
					
					$where .= " and name LIKE '" . strtolower($facility_name) ."%'";
				}
				$facilityLIst = FacilityMemberDetails::select("users.id","users.name","users.email","users.phone_number","users.address","users.profile_pic","facility_member_details.qr_code as qr_code_image")->join('users','users.id','=','facility_member_details.facility_id','left')->where('facility_member_details.user_id',$user_id)->whereRaw($where)->where('user_id',$user_id)->get();
				foreach($facilityLIst as $k=>$facility)
				{
					if(isset($facility->profile_pic) && $facility->profile_pic!=''){
					$facilityLIst[$k]->profile_pic = URL('public/profile_pic/'.$facility->profile_pic);
					}
				}
				if(!empty($facilityLIst) && count($facilityLIst))
				{
						$result['message']='My Facility List';
						$result['success']=true;
						$result['data']=$facilityLIst;
				}
				else{
						$result['message']='No Facility List Found';
						$result['success']=false;
						$result['data']=array();
				}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['success']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}
	//check in /check out
	public function check_in(Request $request)
	{
		$data = $request->all(); //t($data ,1);
		$user_id = isset($data['id'])?$data['id']:'';
		$QRCODE = isset($data['qrcode'])?$data['qrcode']:'';
		if($data['staus'] == "success")
		{
			$user_deatils = FacilityMemberDetails::where('user_id',$user_id)->where('qr_code_no',$QRCODE)->get();
			if(!empty($user_deatils) && count($user_deatils)>0)
			{
				$have_attandance = AttendanceTable::where('facility_id',$user_deatils[0]->facility_id)->where('member_id',$user_id)->whereRaw("date(created_at)='".date('Y-m-d')."'")->get();
				//t($have_attandance,1);
				if(empty($have_attandance) || count($have_attandance)==0)
				{
					$insert_data['facility_id'] = $user_deatils[0]->facility_id;
					$insert_data['member_id'] = $user_id;
					$insert_data['login_time'] = date('H:i:s', time());
					//$insert_data['login_time'] = date('H:i:s');
					$atId = AttendanceTable::insertGetId($insert_data);
					if($atId!='')
					{
						$result['message']='Successfully checked In';
						$result['success']=true;
						$result['data']=array();
					}
					else
					{
						$result['message']='Sorry,Please try after some time';
						$result['success']=false;
						$result['data']=array();
					}
				}
				else
				{
					$update_data['logout_time'] =date('H:i:s', time());
						AttendanceTable::where('id',$have_attandance[0]->id)->update($update_data);
						$result['message']='Successfully checked out';
						$result['success']=true;
						$result['data']=array();
				}
			}
		}
		else
		{
				$result['message']='Invalid credentials';
				$result['success']=false;
				$result['data']=array();
		}
		return response()->json(['result'=>$result], 200);
	}
}
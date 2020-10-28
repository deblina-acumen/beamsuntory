<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use  App\Model\Region;
use  App\Model\Country;
use Auth;
	use DB;
use Session ;
//use Mail;

class RegionController extends Controller
{
	public function list()
    {
        $data['title']="Region Management";
        //$data['info']=User::where('fl_archive','N')->get();
        
        //$data['info'] = DB::table('users')
        $data['info'] = Region::
		select('provinces.*','country.country_name','country.id as country_id')
		->leftjoin('country','provinces.country_id','=','country_id')
		->where('provinces.is_deleted','=','No')
		->orderBy('provinces.id','desc')
		->get();

        return view('master.region.lists',$data);
    } 
     public function addRegion()
    {
        $data["title"] = "Region Master";
       // $data['country'] = DB::table('country')
        $data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->where('country.is_active','=','Yes')
		->orderBy('country.id','desc')
		->get();
		$data['province'] = Region::
		select('provinces.*')
		->where('provinces.is_deleted','=','No')
		->where('provinces.is_active','=','Yes')
		->orderBy('provinces.id','desc')
		->get();
        return view('master.region.add', $data);
    }

	public function save_region(Request $Request)
    {
		
        $data["title"] = "Region Master";
		$posted = $Request->all();
	
		if(isset($posted['province']) && $posted['province']!='')
		{
			
			$have_user_id = Region::where('name',$posted['province'])->where('country_id',$posted['country_id'])->where('is_deleted','No')->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-region')->with('error-msg', 'Region already added');
			 }
		
			$insert_data['name'] = isset($posted['province'])?$posted['province']:'';
			$insert_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
			$insert_data['created_by'] = Auth::user()->id;

			$id = Region::insertGetId($insert_data);
			if($id!='')
			{
			return redirect('region-master-list')->with('success-msg', 'Region master added successfully');
			}
			else
			{
			 return redirect('region-master-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('region-master-list')->with('error-msg', 'Please Provide Province');
		}			
		
    }
	public function editRegion($id)
	{
		$id = base64_decode($id);
		$data["title"] = "Region Master";
		$data['info']=$regionInfo = Region::where('id',$id)->where('is_deleted','No')->get();

		$data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->get();
       
        return view('master.region.edit', $data);
	}
	public function update_region(Request $Request)
	{
			$posted = $Request->all();
		$have_user_id = Region::where('name',$posted['province'])->where('country_id',$posted['country_id'])->where('is_deleted','No')->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('edit-region/'.base64_encode($posted['id']))->with('error-msg', 'Region already added');
		}
		$update_data['name'] = isset($posted['province'])?$posted['province']:'';
		$update_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
		$update_data['updated_by'] = Auth::user()->id;



		Region::where('id',$posted['id'])->update($update_data);
		return redirect('region-master-list')->with('success-msg', 'Region master updated successfully');
	}
	
	
	public function view(Request $Request)
	 {
		 $data = $Request->all();
		 //t($data) ;
		
		/* $no_image_path = URL("assets/images/avatar/user.jpg");
		$profile_pic_rel_path = 'public/profile_pic';
		$logo_pic_rel_path = 'public/logo'; */
		
		 $info=Supplier::
		select('provinces.*','country.*')
		->leftjoin('country','provinces.country_id','=','country.id')
        ->where('provinces.id','=',$data['facility_id'])->get();
		

		
		    /* $userid = isset($info[0]->useId) ? $info[0]->useId : '' ;
			$name = isset($info[0]->name) ? $info[0]->name : '' ;
			$email = isset($info[0]->email) ? $info[0]->email : '' ;
			$phone_number = isset($info[0]->phone_number) ? $info[0]->phone_number : '' ;
			$address = isset($info[0]->address) ? $info[0]->address : '' ;
			
			$profile_pic = (isset($info[0]->profile_pic)&&$info[0]->profile_pic!='') ? asset($profile_pic_rel_path.'/'.$info[0]->profile_pic):$no_image_path;
			$logo = (isset($info[0]->logo)&&$info[0]->logo!='') ? asset($logo_pic_rel_path.'/'.$info[0]->logo):$no_image_path;
			//$now_date = date('Y-m-d H:i:s');
			$current_date = date('d/m/Y',strtotime($info[0]->created_at)) ; */
			$profile_pic = $current_date = $description = $logo = $name = '';
			$province_name = isset($info[0]->name) ? $info[0]->name : '' ;
			$country_name = isset($info[0]->country_name) ? $info[0]->country_name : '' ;
			
			if($info[0]->is_active!='Y'){
				$active = '<span class="badge badge-success">Active</span>' ;
			}else{
				$active = '<span class="badge badge-danger">Inactive</span>' ;
			}
			/* $description = isset($info[0]->description) ? $info[0]->description : '' ;
			$member = get_number_of_member_by_id($info[0]->id) ; */
		// $diff = strtotime($current_date) - strtotime($now_date); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
	//$day_difference = abs(round($diff / 86400)) ;
	
		  $html = '
		   <div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <a class="avatar avatar-lg status-success" href="#">
						<img src="'.$profile_pic.'" alt="...">
					  </a>
					  <div class="media-body">
						<p class="font-size-16">
						  <a class="hover-primary" href="#"><strong>'. $name .'</strong></a>
						</p>'.$current_date.'
						 
						<p>'.$description.'</p>
						</div>
					  <div class="media-right">'.$active.'</div>
					  
					</div>					
					
				  </div>
				 
				   <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-striped mb-0">
					  
					  <tbody>
						<tr>
						  <th scope="row"> Province Name:</th>
						  <td>'.$province_name.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row"> Country Name:</th>
						  <td>'.$country_name.'</td>
						   <td></td>
						</tr>
					  </tbody>
					</table>
				</div>
            </div>' ;
				 echo $html;
	 }
	 
	 public function changeStatus($id='',$value='')
	{
	   if($id!='')
	   {
		$region_id = base64_decode($id);
		$updateVal['is_active']= $value ;
		$updated=Region::where('id',$region_id)->update($updateVal);
	
		Session::flash('success-msg','status change successfully');
		return redirect('region-master-list');
	   }
	}
	
	public function delete_fn($id='',$value='')
	{
	   if($id!='')
	   {
		$region_id = base64_decode($id);
		//t($supplier_id,1);
		$updateVal['is_deleted']= $value ;
		$updated=Region::where('id',$region_id)->update($updateVal);
	
		Session::flash('success-msg','successfully Deleted');
		return redirect('region-master-list');
	   }
	}
}
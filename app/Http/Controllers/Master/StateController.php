<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use  App\Model\State;
use  App\Model\Country;
use Auth;
	use DB;
use Session ;
//use Mail;

class StateController extends Controller
{
	public function list()
    {
        $data['title']="State Management";

        $data['info'] = State::
		select('state.*','country.country_name','country.id as country_id')
		->leftjoin('country','state.country_id','=','country_id')
		->where('state.is_deleted','=','No')
		->orderBy('state.id','desc')
		->get();

        return view('master.state.lists',$data);
    } 
     public function addState()
    {
        $data["title"] = "State Master";

        $data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->where('country.is_active','=','Yes')
		->orderBy('country.id','desc')
		->get();
        return view('master.state.add', $data);
    }

	public function save_state(Request $Request)
    {
		
        $data["title"] = "State Master";
		$posted = $Request->all();

		if(isset($posted['state']) && $posted['state']!='')
		{
			
			$have_user_id = State::where('state_name',$posted['state'])->where('country_id',$posted['country_id'])->where('is_deleted','No')->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-state')->with('error-msg', 'State already added');
			 }
		
			$insert_data['state_name'] = isset($posted['state'])?$posted['state']:'';
			$insert_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
			$insert_data['created_by'] = Auth::user()->id;

			$id = State::insertGetId($insert_data);
			if($id!='')
			{
			return redirect('state-master-list')->with('success-msg', 'State master added successfully');
			}
			else
			{
			 return redirect('state-master-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('state-master-list')->with('error-msg', 'Please Provide State');
		}			
		
    }
	public function editState($id)
	{
		$id = base64_decode($id);
		$data["title"] = "State Master";
		$data['info']=$stateInfo = State::where('id',$id)->where('is_deleted','No')->get();

		$data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->get();
       
        return view('master.state.edit', $data);
	}
	public function update_state(Request $Request)
	{
			$posted = $Request->all();
		$have_user_id = State::where('state_name',$posted['state'])->where('country_id',$posted['country_id'])->where('is_deleted','No')->get();
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('edit-state/'.base64_encode($posted['id']))->with('error-msg', 'State already added');
		}
			$update_data['state_name'] = isset($posted['state'])?$posted['state']:'';
			$update_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
	


			State::where('id',$posted['id'])->update($update_data);
			return redirect('state-master-list')->with('success-msg', 'State master updated successfully');
	}
	
	 
	 public function changeStatus($id='',$value='')
	{
	   if($id!='')
	   {
		$state_id = base64_decode($id);

		$updateVal['is_active']= $value ;
		$updated=State::where('id',$state_id)->update($updateVal);
	
		Session::flash('success-msg','status change successfully');
		return redirect('state-master-list');
	   }
	}
	
	public function delete_fn($id='',$value='')
	{
	   if($id!='')
	   {
		$state_id = base64_decode($id);

		$updateVal['is_deleted']= $value ;
		$updated=State::where('id',$state_id)->update($updateVal);
	
		Session::flash('success-msg','successfully Deleted');
		return redirect('state-master-list');
	   }
	}
}
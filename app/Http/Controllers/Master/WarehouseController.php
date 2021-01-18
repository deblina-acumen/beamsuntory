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
use  App\Model\Region;
use  App\Model\Country;
use  App\Model\State;
use App\Model\Warehouse;
use DB;
use Mail;

class WarehouseController extends Controller
{
    public function warehouse_list()
    {
        $data['title']="Warehouse Manager Management";
        //$data['info']=User::where('fl_archive','N')->get();
       // $data['resource'] = Input::get('resource') ;
        $data['info'] = Warehouse::
		select('warehouse.*','country.country_name','provinces.name AS province_name','users.name AS users_name')
		->leftjoin('country','warehouse.country_id','=','country.id')
		->leftjoin('provinces','warehouse.province_id','=','provinces.id')
		->leftjoin('users','warehouse.user_id','=','users.id')
		->where('warehouse.is_deleted','No')
		->orderBy('warehouse.id','desc')
		->get();

        return view('master.Warehouse.lists',$data);
    }

     public function addWarehouse()
    {
        $data["title"] = "Warehouse Master";

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
		$data['warehouse_manager'] = DB::table('users')
		->select('users.name as first_name','users.lastname as last_name','users.useId','users.email as email','users.is_deleted as is_deleted','users.is_active as is_active','users.id as userid')
		->where('users.is_deleted','No')
		->where('users.role_id',2)
		->orderBy('users.id','desc')
		->get();
        return view('master.Warehouse.add', $data);
    }

    

	public function save_warehouse(Request $request)
    {
		
        $data["title"] = "Warehouse Master";
		//$posted = $request->all();
		$name =  $request->input('name');
		$manager_id =  $request->input('manager_id');
		$country_id =  $request->input('country_id');
		$province_id =  $request->input('province_id');
		$city =  $request->input('city');
		$zip =  $request->input('zip');
		$address =  $request->input('address');
		$city =  $request->input('city');
		$warehouse = new Warehouse;
		if(isset($name) && trim($name)!='')
		{
			 $have_user_id = Warehouse::where('name',$name)->where('is_deleted','No')->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-warehouse')->with('error-msg', 'Warehouse name already added');
			} 
			$warehouse->name = isset($name)?$name:'';
			$warehouse->user_id = isset($manager_id)?$manager_id:'';
			$warehouse->country_id = isset($country_id)?$country_id:'';
			$warehouse->province_id = isset($province_id)?$province_id:'';
			$warehouse->city = isset($city)?$city:'';
			$warehouse->zip = isset($zip)?$zip:'';
			$warehouse->address = isset($address)?$address:'';
			$warehouse->created_by = Auth::user()->id;

			 $warehouse->save();
			 $id = $warehouse->id;
			if($id!='')
			{
			return redirect('warehouse-list')->with('success-msg', 'Warehouse added successfully');
			}
			else
			{
			 return redirect('warehouse-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('warehouse-list')->with('error-msg', 'Please Provide Warehouse name');
		}			
		
    }
    
    public function editWarehouse($id)
    {
       if (base64_decode($id, true)) 
       {
		   //$user_id = Auth::user()->id;
		
            $id = base64_decode($id);
            $data['title']="Warehouse Management";
			//$data['info1']= Role::where('is_active','Yes')->where('is_deleted','No')->get();
            $data['info']=Warehouse::where('id',$id)->get();
			$data['country'] = Country::
			select('country.*')
			->where('country.is_deleted','=','No')
			->orderBy('country.country_name','asc')
			->get();
			$data['province'] = Region::
			select('provinces.*')
			->where('provinces.is_deleted','=','No')
			->where('provinces.is_active','=','Yes')
			->orderBy('provinces.name','asc')
			->get();
			$data['warehouse_manager'] = DB::table('users')
			->select('users.id as userid','users.name as first_name','users.lastname as last_name')
			->where('users.role_id','=',2)
			->where('users.is_deleted','=','No')
			->get();
            return view('master.Warehouse.edit',$data);
       }
       else
            abort(404);
    }

    public function update_warehouse_data(Request $request)
    {
       $posted = $request->all();
		$have_user_id = Warehouse::where('name',$posted['name'])->where('is_deleted','No')->get();
	    //t($have_user_id,1);
		if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('edit-warehouse/'.base64_encode($posted['id']))->with('error-msg', 'Warehouse is already added');
		}
			$insert_data['name'] = isset($posted['name'])?$posted['name']:'';
			$insert_data['user_id'] = isset($posted['manager_id'])?$posted['manager_id']:'';
			$insert_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
			$insert_data['province_id'] = isset($posted['province_id'])?$posted['province_id']:'';
			$insert_data['city'] = isset($posted['city'])?$posted['city']:'';
			$insert_data['zip'] = isset($posted['zip'])?$posted['zip']:'';
			$insert_data['address'] = isset($posted['address'])?$posted['address']:'';

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
			
			Warehouse::where('id',$posted['id'])->update($insert_data);
			return redirect('warehouse-list')->with('success-msg', 'Warehouse updated successfully');
        
    }
	
	
	public function delete_warehouse($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=Warehouse::where('id',$id)->update($update_data);
        if($updated)
            return redirect('warehouse-list')->with('success-msg', 'Warehouse successfully deleted');
        else
        {
            return redirect('warehouse-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=Warehouse::where('id',$id)->update($update_data);
		if($updated)
            return redirect('warehouse-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('warehouse-list')->with('error-msg', 'Please try after some time');    
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
	public function get_warehouse_province_list_by_country(Request $Request)
	{
		$data = $Request->all();
		//t($data,1);
		$country_id = $data['country_id'];
		if($country_id == "")
		{
			$province_list = Region::where('is_deleted','No')->orderBy('name','asc')->get();
		}
		else if($country_id != "")
		 	$province_list = Region::where('country_id',$country_id)->orderBy('name','asc')->get();
		echo json_encode($province_list);
	}
	
}
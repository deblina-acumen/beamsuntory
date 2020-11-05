<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use  App\Model\Region;
use  App\Model\Country;
use  App\Model\State;
use  App\Model\Supplier;
use Auth;
	use DB;
use Session ;
use Mail;

class SupplierController extends Controller
{
	public function list()
    {
        $data['title']="Supplier Management";

        $data['info'] = Supplier::
		select('supplier.id','supplier.supplier_name','supplier.supplier_email','supplier.supplier_phone','supplier.city','supplier.postal_code','supplier.address',
		'supplier.is_active','country.country_name','provinces.name')
		->leftjoin('country','supplier.country_id','=','country.id')
		->leftjoin('provinces','supplier.province_id','=','provinces.id')
		->where('supplier.is_deleted','=','No')
		->orderBy('supplier.id','desc')
		->get();

        return view('master.supplier.lists',$data);
    } 
     public function addSupplier()
    {
        $data["title"] = "Supplier Master";

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
        return view('master.supplier.add', $data);
    }

	public function save_supplier(Request $Request)
    {
		
        $data["title"] = "Supplier Master";
		$posted = $Request->all();

		if(isset($posted['supplier_name']) && $posted['supplier_name']!='')
		{
			 $have_user_id = Supplier::where('supplier_name',$posted['supplier_name'])->where('is_deleted','No')->get();
			if(!empty($have_user_id) && count($have_user_id)>0)
			{
				 return redirect('add-supplier')->with('error-msg', 'Supplier name already added');
			} 
			$insert_data['supplier_name'] = $supplier_name = isset($posted['supplier_name'])?$posted['supplier_name']:'';
			$insert_data['supplier_email'] = $supplier_email= isset($posted['email'])?$posted['email']:'';
			$insert_data['supplier_phone'] = $supplier_phone = isset($posted['phone'])?$posted['phone']:'';
			$insert_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
			$insert_data['province_id'] = isset($posted['province_id'])?$posted['province_id']:'';
			$insert_data['city'] = isset($posted['city'])?$posted['city']:'';
			$insert_data['postal_code'] = isset($posted['zip'])?$posted['zip']:'';
			$insert_data['address'] = isset($posted['address'])?$posted['address']:'';
			$insert_data['notes'] = isset($posted['notes'])?$posted['notes']:'';
			$supplier_image = $Request->file('image');
			if($supplier_image !='')
			{
				
					$supplier_image_pic_name = upload_file_single_with_name($supplier_image, 'supplierMaster','supplierMaster',$posted['supplier_name']);	
					if($supplier_image_pic_name!='')
					{
						$insert_data['image'] = $supplier_image_pic_name;
					}
				
			}
			$insert_data['created_by'] = Auth::user()->id;

			$id = Supplier::insertGetId($insert_data);
			if($id!='')
			{
			 $data2 = [
			        'supplier_email'=>$supplier_email,
					'supplier_name'=>$supplier_name, 
										
                ];
			   
              $template = 'master.user.NewSupplierAddMailSend'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data2, function ($message) use ($supplier_name, $supplier_email) {
            $message->to($supplier_email, $supplier_name)
                ->subject('Supplier Add');
            $message->from('no-repl@gmail.com', 'Supplier Add');
        });
			return redirect('supplier-master-list')->with('success-msg', 'Supplier  added successfully');
			}
			else
			{
			 return redirect('supplier-master-list')->with('error-msg', 'Please try after some time');
			}
		}
		else
		{
		 return redirect('supplier-master-list')->with('error-msg', 'Please Provide Supplier name');
		}			
		
    }
	public function editSupplier($id)
	{
		$id = base64_decode($id);
		$data["title"] = "Supplier Master";
		$data['info']=$supplierInfo = Supplier::where('id',$id)->where('is_deleted','No')->get();

		$data['country'] = Country::
		select('country.*')
		->where('country.is_deleted','=','No')
		->get();
		$data['province'] = Region::
		select('provinces.*')
		->get();
		
		
       
        return view('master.supplier.edit', $data);
	}
	public function update_supplier(Request $Request)
	{
		
		$posted = $Request->all();
		$have_user_id = Supplier::where('supplier_name',$posted['supplier_name'])->where('is_deleted','No')->get();
		 if(isset($have_user_id[0]->id) && $have_user_id[0]->id != $posted['id'])
		{
			 return redirect('edit-supplier/'.base64_encode($posted['id']))->with('error-msg', 'Supplier Name already added');
		} 
			$update_data['supplier_name'] = isset($posted['supplier_name'])?$posted['supplier_name']:'';
			$update_data['supplier_email'] = isset($posted['email'])?$posted['email']:'';
			$update_data['supplier_phone'] = isset($posted['phone'])?$posted['phone']:'';
			$update_data['country_id'] = isset($posted['country_id'])?$posted['country_id']:'';
			$update_data['city'] = isset($posted['city'])?$posted['city']:'';
			$update_data['postal_code'] = isset($posted['zip'])?$posted['zip']:'';
			$update_data['address'] = isset($posted['address'])?$posted['address']:'';
			$update_data['notes'] = isset($posted['notes'])?$posted['notes']:'';
			$supplier_image = $Request->file('image');
			if($supplier_image !='')
			{
				
					$supplier_image_pic_name = upload_file_single_with_name($supplier_image, 'supplierMaster','supplierMaster',$posted['supplier_name']);	
					if($supplier_image_pic_name!='')
					{
						$update_data['image'] = $supplier_image_pic_name;
					}
				
			}
			$update_data['updated_by'] = Auth::user()->id;
	


			Supplier::where('id',$posted['id'])->update($update_data);
			return redirect('supplier-master-list')->with('success-msg', 'Supplier master updated successfully');
	}
	
	
	public function view(Request $Request)
	 {
		 $data = $Request->all();
		 //t($data) ;
		
		$no_image_path = URL("assets/images/avatar/user.jpg");
		$profile_pic_rel_path = 'public/profile_pic';
		$logo_pic_rel_path = 'public/logo';
		
		 $info=Supplier::
		select('supplier.*','country.*','provinces.*','state.*')
		->leftjoin('country','supplier.country_id','=','country.id')
		->leftjoin('provinces','supplier.province_id','=','provinces.id')
        ->where('supplier.id','=',$data['facility_id'])->get();
		
			$profile_pic = $current_date = $description = $logo = '';
			$supplier_name = isset($info[0]->supplier_name) ? $info[0]->supplier_name : '' ;
			$supplier_email = isset($info[0]->supplier_email) ? $info[0]->supplier_email : '' ;
			$supplier_phone = isset($info[0]->supplier_phone) ? $info[0]->supplier_phone : '' ;
			$country_name = isset($info[0]->country_name) ? $info[0]->country_name : '' ;
			$province_name = isset($info[0]->name) ? $info[0]->name : '' ;
			$state_name = isset($info[0]->state_name) ? $info[0]->state_name : '' ;
			$city = isset($info[0]->city) ? $info[0]->city : '' ;
			$address = isset($info[0]->address) ? $info[0]->address : '' ;
			$postal_code = isset($info[0]->postal_code) ? $info[0]->postal_code : '' ;
			
			if($info[0]->is_active!='Y'){
				$active = '<span class="badge badge-success">Active</span>' ;
			}else{
				$active = '<span class="badge badge-danger">Inactive</span>' ;
			}
	
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
						  <th scope="row"> Supplier Name:</th>
						  <td>'.$supplier_name.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row"> Email:</th>
						  <td>'.$supplier_email.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Phone Number:</th>
						  <td>'.$supplier_phone.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Address:</th>
						  <td>'.$address.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Country:</th>
						  <td>'.$country_name.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Provinces:</th>
						  <td>'.$province_name.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  State:</th>
						  <td>'.$state_name.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  City:</th>
						  <td>'.$city.'</td>
						   <td></td>
						</tr>
						<tr>
						  <th scope="row">  Zip:</th>
						  <td>'.$postal_code.'</td>
						   <td></td>
						</tr>
						
						<tr>
						  <th scope="row">  Logo:</th>
						  <td><a class="avatar avatar-lg status-success" href="#">
						   <img src="'.$logo.'" alt="...">
					       </a>
						   </td>
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
		$supplier_id = base64_decode($id);
		$updateVal['is_active']= $value ;
		$updated=Supplier::where('id',$supplier_id)->update($updateVal);
	
		Session::flash('success-msg','status change successfully');
		return redirect('supplier-master-list');
	   }
	}
	
	public function delete_fn($id='',$value='')
	{
	   if($id!='')
	   {
		$supplier_id = base64_decode($id);

		$updateVal['is_deleted']= $value ;
		$updated=Supplier::where('id',$supplier_id)->update($updateVal);
	
		Session::flash('success-msg','successfully Deleted');
		return redirect('supplier-master-list');
	   }
	}
}
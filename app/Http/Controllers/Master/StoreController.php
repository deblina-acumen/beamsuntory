<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StoreCategory;
use App\Model\Country;
use App\Model\Provinces;
use App\Model\Store;
use Auth;
use DB;
class StoreController extends Controller
{
    public function store_list()
    {
        $data['title']="Store List";
        $data['info']=Store::select('store.*','store_category.name as category','country.country_name','provinces.name as province')->leftjoin('store_category','store.store_category','=','store_category.id')->leftjoin('provinces','store.state','=','provinces.id')->leftjoin('country','store.country','=','country.id')->where('store.is_deleted','No')->get();
		//t($data['info'],1);
        return view('master.store.list',$data);
    }

    public function add_store()
    {
        $data['title']="Add Store";
		$data['store_category']= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['country']= Country::where('is_active','Yes')->where('is_deleted','No')->where('id',1)->get();
		$data['Provinces']= Provinces::where('is_active','Yes')->where('is_deleted','No')->where('country_id',1)->get();
        return view('master.store.add',$data);
    }

    public function save_store(Request $request)
    {
        $data=$request->all();
		//t($data);
		//exit() ;
		$insertData['store_name']=isset($data['store_name'])?$data['store_name']:'' ;
		$insertData['store_category']=isset($data['store_category'])?$data['store_category']:0;
		$insertData['contact_person']= isset($data['contact_person'])?$data['contact_person']:'' ; 
		$insertData['email']= isset($data['email'])?$data['email']:'' ; 
		$insertData['phone']= isset($data['phone'])?$data['phone']:'' ;   
		$insertData['country']= isset($data['country'])?$data['country']:0; 
		$insertData['state']=  isset($data['state'])?$data['state']:0;  
		$insertData['city']=isset($data['city'])?$data['city']:'' ;
		$insertData['zipcode']= isset($data['zipcode'])?$data['zipcode']:'';
		$insertData['address']=isset($data['address'])?$data['address']:'';
		$insertData['created_by']=Auth::user()->id; ;
		
        
        $insertData['created_by'] = Auth::user()->id;
        $id=Store::insertGetId($insertData);
        if($id!='')
        {
            return redirect('store-list')->with('success-msg', 'Store successfully added');
        }
        else			
        {
            return redirect('store-list')->with('error-msg', 'Please try after some time');
        }
    }

    public function edit_store($storeId)
    {
       if (base64_decode($storeId, true)) 
       {
            $id=base64_decode($storeId);
            $data["title"]="Store";
			$data['store_category']= StoreCategory::where('is_active','Yes')->where('is_deleted','No')->get();
		$data['country']= Country::where('is_active','Yes')->where('is_deleted','No')->where('id',1)->get();
		$data['Provinces']= Provinces::where('is_active','Yes')->where('is_deleted','No')->where('country_id',1)->get();
            $data["info"]=Store::where('id',$id)->get();
            return view('master.store.edit',$data);
       }
       else
            abort(404);    
    }

    public function update_store(Request $request)
    {
        $data=$request->all();
        
		
		$insertData['store_name']=isset($data['store_name'])?$data['store_name']:'' ;
		$insertData['store_category']=isset($data['store_category'])?$data['store_category']:0;
		$insertData['contact_person']= isset($data['contact_person'])?$data['contact_person']:'' ; 
		$insertData['email']= isset($data['email'])?$data['email']:'' ; 
		$insertData['phone']= isset($data['phone'])?$data['phone']:'' ;   
		$insertData['country']= isset($data['country'])?$data['country']:0; 
		$insertData['state']=  isset($data['state'])?$data['state']:0;  
		$insertData['city']=isset($data['city'])?$data['city']:'' ;
		$insertData['zipcode']= isset($data['zipcode'])?$data['zipcode']:'';
		$insertData['address']=isset($data['address'])?$data['address']:'';
		
        $insertData['updated_by'] = Auth::user()->id;
        $id=$data["id"];
        $updated=Store::where('id',$id)->update($insertData);
        if($updated)
            return redirect('store-list')->with('success-msg', 'Details successfully updated');
        else
        {
            $url="edit-store/".base64_encode($id);
            return redirect($url)->with('error-msg', 'Please try after some time');    
        }
    }
	
	public function delete_store($id)
	{
		 $id= base64_decode($id);
		 $update_data['is_deleted'] = 'Yes';
		 $updated=Store::where('id',$id)->update($update_data);
        if($updated)
            return redirect('store-list')->with('success-msg', 'Store successfully deleted');
        else
        {
            return redirect('store-list')->with('error-msg', 'Please try after some time');    
        }
	}
	public function changeStatus($id,$status)
	{
		$id= base64_decode($id);
		$update_data['is_active'] = $status;
		$updated=Store::where('id',$id)->update($update_data);
		if($updated)
            return redirect('store-list')->with('success-msg', 'Status successfully changed');
        else
        {
            return redirect('store-list')->with('error-msg', 'Please try after some time');    
        }
	}
}
?>
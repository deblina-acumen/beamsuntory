<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Model\User;
use  App\Model\FacilityMemberDetails;
use  App\Model\AttendanceTable;

use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Warehouse;
use App\Model\Supplier;
use App\Model\PO;
use App\Model\POItem;
use App\Model\ProductVariations;
use App\Model\Brand;
use App\Model\Region;

use App\Model\Role;
use  App\Model\Country;
use  App\Model\POAllocation;

use Auth;
use DB;
use Session ;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$userId = Auth::user()->id ;
		$user_role = Auth::user()->role_id ;
		$arrOutputData=array();
		if($user_role==1)
		{
			$arrOutputData['total_product'] = Product::where('is_deleted','No')->where('is_active','Yes')->count();
			$arrOutputData['total_user'] = User::where('is_deleted','No')->where('is_active','Yes')->count();
			$arrOutputData['total_po'] = PO::where('is_deleted','No')->where('is_active','Yes')->count();
			//t($arrOutputData);
			//exit();
			
			return view('dashboard.dashboard',$arrOutputData);
		}
		else if($user_role==10 )
		{
			return view('dashboard.currior',$arrOutputData);
		}
		else if($user_role==2 )
		{
			return view('dashboard.warehouse',$arrOutputData);
		}
		else
		{
			return view('dashboard.sales_ref',$arrOutputData);
		}
		
    }
	
	
}

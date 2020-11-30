<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Model\User;
use  App\Model\FacilityMemberDetails;
use  App\Model\AttendanceTable;
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

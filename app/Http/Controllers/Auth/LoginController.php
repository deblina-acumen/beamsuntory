<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('guest')->except('logout');
		
    }
 
	
	 public function check_login_details(Request $Request)
  {
	  
	  $data = $Request->all();
	  if($Request->all())
	  {
	  $user_id = isset($data['email'])?$data['email']:'';
	  $password = isset($data['password'])?$data['password']:'';
	  if($user_id=='' || $password=='')
	  {
		   return redirect('/')->with('error',"All fields are required");
	  }
	  
	  if(Auth::attempt(['useId'=>$user_id,'password'=>$password,'is_active'=>'Yes','is_deleted'=>'No']))
	  {
		   
		      return redirect('dashboard')->with('success',"Successfully log you in");
				
		   
	  }
	  else{
		  return redirect('/')->with('error',"Please provide valid credentials");
	  }
	  }else{
		  return view('login');
	  }
  }
  
  public function loginauth()
  {
	 if(!Auth::user()){
	   return view('login');
	 }
	
  }
}

<?php

namespace App\Http\Middleware;

use Closure;
use  App\Model\User;
class IsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$token =  $request->header('Authorization');
		$data =  $request->all();
		$id = isset($data['id'])?($data['id']):'';
		if($id!=''   && $token != '')
		{
		$user_info = User::where('id',$id)->where('api_token',$token)->where('is_deleted','N')->where('is_active','N')->get();
		}
		else
		{
			$user_info = array();
		}
		
		 if (!empty($user_info) && count($user_info)>0) {
         $request['staus']='success';
		  return $next($request);
        }
		else
		{
			$request['staus']='error';
			 return $next($request);
		}
       
    }
}

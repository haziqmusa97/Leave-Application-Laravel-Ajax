<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Cart;
use validator;
use Auth;
use Illuminate\Support\Facades\Redirect; 


class AdminLogController extends Controller
{
    //check login
    public function adminlogin_check(){

    	return view('adminlog');
    }

    //login
    public function admin_login(Request $request){

    	$id=$request->id;
    	$password=$request->password;
    	$result=DB::table('employees')
    			->where('id',$id)
                ->where('password',$password)
                ->where('role_name','1')
    			->first();

    	if($result){

            Session::put('id',$result->id);
            Session::put('dept_name',$result->dept_name);
            //dd(session()->all());
            return view('admin.dashboard');
            // print_r($id);
            //print_r($username);
    	}else{
            Session::put('message','ID or Password Invalid');
    		return Redirect::to('/adminlogin-check');
    	}
    }

    public function admin_logout(){

    	Session::flush();
    	return Redirect::to('/a');
    }


    

    
}

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


class LeaveController extends Controller
{
    //check login
    public function login_check(){

    	return view('login');
    }

    //login
    public function customer_login(Request $request){

    	$id=$request->id;
    	$password=$request->password;
    	$result=DB::table('employees')
    			->where('id',$id)
                ->where('password',$password)
    			->first();

    	if($result){

            Session::put('id',$result->id);
            Session::put('username',$result->username);
            Session::put('role_name',$result->role_name);
            Session::put('dept_name',$result->dept_name);
            Session::put('AL',$result->AL);
            Session::put('MC',$result->MC);

            //dd(session()->all());
            return view('emp.emp_profile');
            // print_r($id);
            //print_r($username);
    	}else{
            Session::put('message','ID or Password Invalid');
    		return Redirect::to('/login-check');
    	}
    }

    public function staff_logout(){

    	
    	return Redirect::to('/a');
    }
    

    
}

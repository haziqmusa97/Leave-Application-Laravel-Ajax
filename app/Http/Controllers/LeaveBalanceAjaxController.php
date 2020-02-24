<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveBalanceAjaxController extends Controller
{
    public function store(){

        $AL = DB::table('leaves')
         ->count('status');
         

        

         return view('emp.emp_profile', compact('AL'));

         
    }
}

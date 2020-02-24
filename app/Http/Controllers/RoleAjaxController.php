<?php

namespace App\Http\Controllers;

use App\Role;
use DB;
use Illuminate\Http\Request;
use DataTables;

class RoleAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   							
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a>';
   
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRole">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('roleAjax',compact('roles'));
    }
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::updateOrCreate(['id' => $request->role_id],
                ['role_name' => $request->role_name]);        
   
        return response()->json(['success'=>'Role saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
     
        return response()->json(['success'=>'Role deleted successfully.']);
    }
}

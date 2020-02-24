<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use DataTables;
use DB;

class DepartmentAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Department::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   							
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editDepartment">Edit</a>';
   
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteDepartment">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        
      
        return view('departmentAjax',compact('departments'));
    }

    public function index2(){

        $depart = DB::table('departments')
        ->get();

        $role = DB::table('roles')
        ->get();

    return view('admin.employee', compact('depart','role'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Department::updateOrCreate(['id' => $request->department_id],
                ['dept_name' => $request->dept_name]);        
   
        return response()->json(['success'=>'Department saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        return response()->json($department);
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::find($id)->delete();
     
        return response()->json(['success'=>'Department deleted successfully.']);
    }

    
}

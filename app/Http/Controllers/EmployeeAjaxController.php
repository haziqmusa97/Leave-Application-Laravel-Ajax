<?php

namespace App\Http\Controllers;
          
use App\Employee;
use App\Department;
use App\LeaveBalance;
use Illuminate\Http\Request;
use DataTables;
use Session;

class EmployeeAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $val=Session::get('dept_name');
            $data = Employee::join('departments','employees.dept_name','=','departments.id')
            ->join('roles', 'employees.role_name', '=', 'roles.id')

            ->select('employees.*','departments.dept_name AS DP','roles.role_name AS RN')
            ->where('employees.dept_name',$val)
            ->get(); 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   							
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editEmployee">Edit</a>';
   
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteEmployee">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

      
        return view('employeeAjax',compact('employees'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Employee::updateOrCreate(['id' => $request->employee_id],
                ['username' => $request->username, 'password' => $request->password, 'role_name' => $request->role_name, 'dept_name' => $request->dept_name, 'AL' => $request->AL, 'MC' => $request->MC]);        
        

        return response()->json(['success'=>'Employee saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    public function editaa(Post $post)
    {
        $department = Department::all();
        return view('admin.employee', compact('post', 'department'));
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();
     
        return response()->json(['success'=>'Employee deleted successfully.']);
    }
}

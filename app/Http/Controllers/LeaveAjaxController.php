<?php

namespace App\Http\Controllers;
          
use App\Leave;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Session;

class LeaveAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $val=Session::get('id');
            $data = Leave::join('employees','leaves.approves_id','=','employees.id')
            ->join('leavetypes', 'leaves.leaveType_name', '=', 'leavetypes.id')
            ->select('leaves.*','employees.username AS us','leavetypes.leavename AS LN','employees.AL AS AL', 'employees.MC AS MC')
            ->where('emp_id',$val)    
            ->get();
            // $data = Leave::latest()->get();
                                    
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('leaveAjax',compact('leaves'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Leave::updateOrCreate(['id' => $request->id],
                ['emp_id' => $request->emp_id, 'status' => $request->status, 'date_start' => $request->date_start, 'date_end' => $request->date_end, 'numday' => $request->numday, 'leaveType_name' => $request->leaveType_name, 'approves_id' => $request->approves_id, 'descr' => $request->descr]);        
   

            
        return response()->json(['success'=>'Leave saved successfully.']);
    }

   

    public function count(Request $request){

        $odata=array();
        $odata['id']=Session::get('id');
        $all= DB::table('leaves')
        ->where('leaveType_name','2')
        ->where('status','Approve')
        ->where('emp_id',$odata)
        ->sum('leaves.numday');

        $mc=Session::get('MC') - $all;

        $all= DB::table('leaves')
        ->where('leaveType_name','1')
        ->where('status','Approve')
        ->where('emp_id',$odata)
        ->sum('leaves.numday');

        $al=Session::get('AL') - $all;

        DB::table('employees')
            ->where('id',$odata)
            ->update(['AL'=>$al,'MC'=>$mc]);

        $LT = DB::table('leavetypes')
        ->get();


        return view('emp.emp_leave', compact('al','mc','LT'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
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

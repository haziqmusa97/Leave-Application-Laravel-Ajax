<?php

namespace App\Http\Controllers;
          
use App\Leave;
use Illuminate\Http\Request;
use DataTables;

class ApprovesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Leave::join('employees','leaves.emp_id','=','employees.id')
            ->select('leaves.*','employees.username AS us')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   							
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editApprove">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteApprove">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      //print_r($data);
        return view('approveAjax',compact('approves'));
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
                ['emp_id' => $request->emp_id, 'leaveType_name' => $request->leaveType_name, 'date_start' => $request->date_start, 'date_end' => $request->date_end, 'status' => $request->status, 'approves_id' => $request->approves_id]);        
   
        return response()->json(['success'=>'Leave saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $approve = Leave::find($id);
        return response()->json($approve);
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Leave::find($id)->delete();
     
        return response()->json(['success'=>'Leave deleted successfully.']);
    }
}

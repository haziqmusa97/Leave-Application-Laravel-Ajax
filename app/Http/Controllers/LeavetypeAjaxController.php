<?php

namespace App\Http\Controllers;
use App\Leavetype;
use Illuminate\Http\Request;
use DataTables;

class LeavetypeAjaxController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = Leavetype::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   							
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLeavetype">Edit</a>';
   
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLeavetype">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        
      
        return view('leavetypeAjax',compact('leavetypes'));
    }

     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Leavetype::updateOrCreate(['id' => $request->leavetype_id],
                ['leavename' => $request->leavename]);        
   
        return response()->json(['success'=>'Leave Type saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leavetype  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leavetype = Leavetype::find($id);
        return response()->json($leavetype);
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leavetype  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Leavetype::find($id)->delete();
     
        return response()->json(['success'=>'Leavetype deleted successfully.']);
    }

}

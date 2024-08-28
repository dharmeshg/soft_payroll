<?php

namespace App\Http\Controllers;

use App\Models\Leavetype;
use App\Models\Leave;
use Illuminate\Http\Request;
use Auth;

class LeavetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $leavetypes = Leavetype::all();
        $leavetypes = Leavetype::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('leave_type.index',compact('leavetypes'));
    }

    public function yearedit()
    {
        $leavetypes = Leavetype::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        // dd($leavetypes);
        return view('leave_type.yearedit',compact('leavetypes'));
    }

    public function FetchLeaveCycle(Request $request)
    {
        $data['LeCy'] = Leavetype::where('id', '=', $request->leaveType_id)->first();
        return response()->json($data);
        
    }


    public function yearupdate(Request $request)
    {
        $leavetype = Leavetype::find($request->name);
        $leavetype->leave_cycle = $request->leave_cycle;
        if($request->leave_cycle == "Other"){
            $leavetype->from_date = date($request->from_date);
            $leavetype->to_date = date($request->to_date);
        }else{
            $leavetype->from_date = null;
            $leavetype->to_date = null;
        }
        $leavetype->update();

        return redirect()->route('leavetype.index')
                        ->with('success','Leave Cycle Updated Successfully');
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leavetype = Leavetype::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('leave_type.add',compact('leavetype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'leave_name' => 'required',
            'leave_cycle' => 'required',
            'days' => 'required|numeric',
            'leave_description' => 'required',
            'max_allow_days' => 'required|numeric',
            'rules' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $leavetype = new Leavetype();
        $leavetype->name = $request['leave_name'];
        $leavetype->days = $request['days'];
        $leavetype->leave_cycle = $request['leave_cycle'];
        $leavetype->description = $request['leave_description'];
        $leavetype['accrual_method'] = implode(',', $request['accrual_method']);
        // @dd($request->days);
        // @dd($request->max_allow_days);

        if($request->max_allow_days <= $request->days){
            $leavetype->max_allow_days = $request['max_allow_days'];
        }else{
            return redirect()->route('add.leavetype')->with('error',"Max Allow Days Less Than Total Number of Days");
        }
        $leavetype->max_allow_days = $request['max_allow_days'];
        $leavetype->carry_over_policy = $request->carryover_policy == 'on' ? 1 : 0;
        if($leavetype->carry_over_policy == 1){
            $leavetype->all_remaning_leaves = $request->all_remaning_leaves == 'on' ? 1 : 0;
        }else{
            $leavetype->all_remaning_leaves = 0;
        }
        // $leavetype->max_leave_carry_forword = $request->max_leave_carry_forword;
        if($leavetype->all_remaning_leaves==1){
            $leavetype->max_leave_carry_forword = null;
        }else{
            $leavetype->max_leave_carry_forword = $request->max_leave_carry_forword;
        }
        $leavetype->rules = $request['rules'];
        $leavetype->institution_id = $instiID;
        $leavetype->save();

        if($leavetype)
            return redirect()->route('leavetype.index')->with('success',"Leave Added Successfully.");
        else
            return redirect()->route('leavetype.index')->with('error',"Error In Adding Leave.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leavetype  $leavetype
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leavetype  $leavetype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $leavetype = Leavetype::find($id);
        
        // $leavetype['accrual_method'] = explode($leavetype['accrual_method'],',');
        return view('leave_type.edit',compact('leavetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leavetype  $leavetype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'leave_name' => 'required',
            'leave_cycle' => 'required',
            'days' => 'required|numeric',
            'leave_description' => 'required',
            'max_allow_days' => 'required|numeric',
            'rules' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $leavetype = Leavetype::find($id);
        $leavetype->name = $request['leave_name'];
        if($request->leave_cycle != "Other"){
            $leavetype->leave_cycle = $request['leave_cycle'];
            $leavetype->from_date = null;
            $leavetype->to_date = null;
        }
        $leavetype->days = $request['days'];
        $leavetype->description = $request['leave_description'];
        if(isset($request['accrual_method']) && $request['accrual_method'] != null){
            $leavetype['accrual_method'] = implode(',', $request['accrual_method']);
        }else{
            $leavetype['accrual_method'] = null;
        }
        // $leavetype['accrual_method'] = implode(',', $request['accrual_method']);
        // @dd($request->days);
        // @dd($request->max_allow_days);

        if($request->max_allow_days <= $request->days){
            $leavetype->max_allow_days = $request['max_allow_days'];
        }else{
            return redirect()->route('leavetype.index')->with('error',"Max Allow Days Less Than Total Number of Days");
        }
        $leavetype->carry_over_policy = $request->carryover_policy == 'on' ? 1 : 0;
        if($leavetype->carry_over_policy == 1){
            $leavetype->all_remaning_leaves = $request->all_remaning_leaves == 'on' ? 1 : 0;
        }else{
            $leavetype->all_remaning_leaves = 0;
        }
        
        if($leavetype->all_remaning_leaves==1){
            $leavetype->max_leave_carry_forword = null;
        }else{
            $leavetype->max_leave_carry_forword = $request->max_leave_carry_forword;
        }
        $leavetype->rules = $request['rules']; 
        $leavetype->institution_id = $instiID;
        $leavetype->update();
        return redirect()->route('leavetype.index')
                        ->with('success','Leave updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leavetype  $leavetype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leavetype $leavetype,$id)
    {
        $leavetype=Leavetype::find($id);
        $leave=Leave::where('leavetype_id',$leavetype->id)->delete();
        $leavetype->delete();
    
        return redirect()->route('leavetype.index')
                        ->with('success','Leave Type deleted successfully');
    }
}

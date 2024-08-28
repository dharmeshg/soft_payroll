<?php

namespace App\Http\Controllers;

use App\Models\InstitutePermission;
use Illuminate\Http\Request;
use Auth;

class InstitutePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = InstitutePermission::where('institute_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('InstituteRP.AddPermission',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'permissions' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $permission = new InstitutePermission();
        $permission->permissions = $request['permissions'];
        $permission->institute_id = $instiID;
        $permission->save();

        if($permission)
            return redirect()->route('insti.permissions')->with('success',"Permission Added Successfully.");
        else
            return redirect()->route('insti.permissions')->with('error',"Error In Adding Permission.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstitutePermission  $institutePermission
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutePermission $institutePermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutePermission  $institutePermission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = InstitutePermission::find($id);
        
        // $leavetype['accrual_method'] = explode($leavetype['accrual_method'],',');
        return view('InstituteRP.editPermission',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutePermission  $institutePermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'permissions' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $permission = InstitutePermission::find($id);
        $permission->permissions = $request['permissions'];
        $permission->institute_id = $instiID;
        $permission->update();
        return redirect()->route('insti.permissions')
                        ->with('success','Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutePermission  $institutePermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutePermission $institutePermission,$id)
    {
        $permission=InstitutePermission::find($id);
        $permission->delete();
    
        return redirect()->route('insti.permissions')
                        ->with('success','Permission deleted successfully');
    }
}

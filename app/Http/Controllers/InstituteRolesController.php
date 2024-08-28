<?php

namespace App\Http\Controllers;

use App\Models\InstituteRoles;
use Illuminate\Http\Request;
use Auth;

class InstituteRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = InstituteRoles::orderBy('id', 'DESC')->get();
        return view('InstituteRP.AddRoles',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('Institue.AddRoles');
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
            'roles' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $role = new InstituteRoles();
        $role->roles = $request['roles'];
        $role->save();

        if($role)
            return redirect()->route('insti.roles')->with('success',"Role Added Successfully.");
        else
            return redirect()->route('insti.roles')->with('error',"Error In Adding Role.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstituteRoles  $instituteRoles
     * @return \Illuminate\Http\Response
     */
    public function show(InstituteRoles $instituteRoles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstituteRoles  $instituteRoles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = InstituteRoles::find($id);
        
        // $leavetype['accrual_method'] = explode($leavetype['accrual_method'],',');
        return view('InstituteRP.editRole',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstituteRoles  $instituteRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'roles' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $role = InstituteRoles::find($id);
        $role->roles = $request['roles'];
        $role->update();
        return redirect()->route('insti.roles')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstituteRoles  $instituteRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstituteRoles $instituteRoles,$id)
    {
        $role=InstituteRoles::find($id);
        $role->delete();
    
        return redirect()->route('insti.roles')
                        ->with('success','Role deleted successfully');
    }
}

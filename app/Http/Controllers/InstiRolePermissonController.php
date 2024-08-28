<?php

namespace App\Http\Controllers;

use App\Models\InstiRolePermisson;
use App\Models\InstitutePermission;
use App\Models\InstituteRoles;
use Auth;
use DB;
use Illuminate\Http\Request;

class InstiRolePermissonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $leave=DB::table('insti_role_permissons')
        ->select(['insti_role_permissons.*'])
        ->where('insti_role_permissons.institute_id', $user_id)
        ->get();
        // dd($leave);
        $instiPermission=[];
        if($leave !=null){
        foreach($leave as $leav){
            $check=$leav->permission_id;
            $leaveId = explode(',', $check);
            $instiPermission = DB::table('institute_permissions')
            ->select(['institute_permissions.permissions'])->whereIn('id', $leaveId)->get();
        }
    }else{
        $instiPermission=[];
    }
            //  $IRP = DB::table('insti_role_permissons')
            //     ->join('institute_roles','insti_role_permissons.role_id','=','institute_roles.id')
            //     ->select('insti_role_permissons.*','institute_roles.roles')
            //     ->where('insti_role_permissons.institute_id', $user_id)
            //     ->get();
                
                
        $permissions = InstitutePermission::orderBy('id', 'DESC')->get();
        $roles = InstituteRoles::orderBy('id', 'DESC')->get();

        $IRP = DB::table('insti_role_permissons')
                ->join('institute_roles','insti_role_permissons.role_id','=','institute_roles.id')
                ->select('insti_role_permissons.*','institute_roles.roles')
                ->where('insti_role_permissons.institute_id', $user_id)
                ->get();
                // ->each(function($query){
                //     $query->permission_id = explode(",", $query->permission_id);
                // });
                
        
        return view('InstituteRP.rolesPermission',compact('permissions','roles','IRP','instiPermission','leave'));
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

    public function fetchPermission(Request $request)
    {
        $oneRole = InstiRolePermisson::where('role_id',$request->role_id)->first();
        $x = explode(',',$oneRole->permission_id);
            $data['Permission_Role'] = DB::table('institute_permissions')->select(['institute_permissions.*'])->whereIn('id',$x)->get();
        return response()->json($data);
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
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $InstiRolPer = new InstiRolePermisson();
        $InstiRolPer->role_id = $request['role_id'];
        $InstiRolPer->permission_id =implode(',', $request['permission_id']);
        $InstiRolPer->institute_id = $instiID;
        $InstiRolPer->save();

        if($InstiRolPer)
            return redirect()->route('insti.rolespermissions')->with('success',"Role And Permission Assign Successfully.");
        else
            return redirect()->route('insti.rolespermissions')->with('error',"Error In Assign Role And Permission.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstiRolePermisson  $instiRolePermisson
     * @return \Illuminate\Http\Response
     */
    public function show(InstiRolePermisson $instiRolePermisson)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstiRolePermisson  $instiRolePermisson
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = InstitutePermission::orderBy('id', 'DESC')->get();
        $roles = InstituteRoles::orderBy('id', 'DESC')->get();
        $IRP = InstiRolePermisson::find($id);
        return view('InstituteRP.editRolePermission',compact('permissions','roles','IRP'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstiRolePermisson  $instiRolePermisson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        $instiID = Auth::user()->id;
        $InstiRolPer = InstiRolePermisson::find($id);
        $InstiRolPer->role_id = $request['role_id'];
        $InstiRolPer->permission_id = implode(',', $request['permission_id']);
        $InstiRolPer->institute_id = $instiID;
        $InstiRolPer->update();
        return redirect()->route('insti.rolespermissions')
                        ->with('success','Role & Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstiRolePermisson  $instiRolePermisson
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstiRolePermisson $instiRolePermisson,$id)
    {
        $InstiRolPer=InstiRolePermisson::find($id);
        $InstiRolPer->delete();
    
        return redirect()->route('insti.rolespermissions')
                        ->with('success','Role & Permission deleted successfully');
    }
}

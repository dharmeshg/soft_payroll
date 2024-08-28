<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;


function permission_employee(){
    $user_id = Auth::user()->id;
    $emp=DB::table('employees')
        ->select(['employees.*'])
        ->where('employees.user_id', $user_id)
        ->first();
    $per_id=$emp->permission_id;
    if($per_id != 0){
    $PermissionId = explode(',', $per_id);
    $Permission = DB::table('institute_permissions')
        ->select(['institute_permissions.id'])->whereIn('id', $PermissionId)->get();
        foreach($Permission as $Permissions){
            $ar[]=$Permissions;
        }
        return $ar;
    }else{
        $ar=[];
        return $ar;
    }
}

function NotificationDashboard(){
    $notifications = App\Models\Notification::where('visible_users','=',Auth::user()->id)->where('is_read','=',0)->limit(5)->get();
    return $notifications;
}
?>
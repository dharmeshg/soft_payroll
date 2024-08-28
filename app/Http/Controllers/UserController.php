<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends Controller
{

    public function index(Request $request){
         return view('admin/users/edit');
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
    
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $request->image->move('public/images/', $filename);
            Auth()->user()->update(['image'=>$filename]);
        }
        // else{
        //     return back()->with('erorr','Profile Not Updated');
        // }

        $user = Auth::user();
        $user->email = $request['email'];
        $user->contact_no = $request['contact_no'];
        $user->mobile = $request['moblie'];
        $user->address = $request['address'];  
        $user->save();
       
        return back()->with('success','Profile Updated');
    }

    // Logout
    public function userLogout() {
        auth()->logout();
        // redirect to homepage
        return redirect('/login');
    }

    public function changepasswordget()
    {
        return view('admin/users/changepassword');
    }

    public function changePasswordPost(Request $request) {
        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $input = $request->validate([
            'password'     => 'required',
            'new-password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password successfully changed!");
    }   


    // public function profile(){
    //     return view('admin/users/profile');
    // }

    // public function updateprofile(Request $request){
    //     $validatedData = $request->validate([
    //         'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //     ]);
    
    //     if($request->hasFile('image')){
    //         $filename = $request->image->getClientOriginalName();
    //         $request->image->move('public/images/', $filename);
    //         Auth()->user()->update(['image'=>$filename]);
    //     }
    //     // else{
    //     //     return back()->with('erorr','Profile Not Updated');
    //     // }

    //     $user = Auth::user();
    //     $user->email = $request['email'];
    //     $user->contact_no = $request['contact_no'];
    //     $user->mobile = $request['moblie'];
    //     $user->address = $request['address'];  
    //     $user->save();
       
    //     return back()->with('success','Profile Updated Successfully');
    // }

}

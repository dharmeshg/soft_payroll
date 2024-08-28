<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;

class SchoolController extends Controller
{
    public function add()
    {
        // $school = User::all();
        return view('admin/school/add');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'password'=>'required|min:8',
            'instiimage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);


        if($request->hasFile('instiimage')){
            $filename = $request->instiimage->getClientOriginalName();
       
            $request->instiimage->move('public/images/', $filename);            
        }else{
           
            return back()->with('erorr','Profile Not Updated');
        }
        $request->merge([
            'is_school' => 2,
        ]);
        
        $data = $request->all();

         $email = User::where('email', '=', $request->input('email'))->first();
            if ($email != '') {
                return redirect()->route('add.school')->with('error',"Email address is already Exits.");
            }
        $school = new User;
        $data['password'] = Hash::make($data['password']);
        $data['instiimage'] = $filename; 
        $ins = $school->create($data);
       
        if($ins)
            return redirect()->route('school.list')->with('success',"School Added Successfully.");
        else
            return redirect()->route('school.list')->with('error',"Error In Adding School.");
    }

    public function index()
    {
        $data = User::select('*')
                ->where('is_school', '=', 2)
                ->orderBy('id', 'DESC')
                ->get();
        return view('admin/school/index',['data'=> $data]);
    }
    public function edit($id)
    {
        $school = User::findOrFail($id);
        return view('admin/school/add', compact('school' , 'id'));
    }

    public function update(Request $request, $code)
    {
        $school = User::findOrFail($code);
        $data = $request->input();
        if(!isset($data['password']) && $data['password'] == null){
            unset($data['password']);
        }else{
            $data['password'] = bcrypt($data['password']);
        }

        if($request->hasFile('instiimage')){
            $institution1 = 'public/images/'.'$school->instiimage';            
            $file = $request->file('instiimage');
            $filename = $file->getClientOriginalName();
            //$filename = time().'.'.$extension;
            $file->move('public/images/', $filename);  
            $school->instiimage = $filename;          
        }
            if($school){
                if($school->update($data))
                    return redirect()->route('school.list')->with('success',"School Edited Successfully.");
                else
                    return redirect()->route('school.list')->with('error',"Error in Updating School.");
            }else{
                return redirect()->route('school.list')->with('error',"School Not Found.");
            }
        //}
    }

    public function delete($code)
    {
        $school = User::where('id', '=', $code)->first();   
        $school->delete();

        return redirect()->route('school.list')->with('success',"School Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_schoolid'] ) && !empty( $_POST['data_schoolid'] ) ) {
            $school_id = $_POST['data_schoolid'];
            User::where('id', $school_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;


class Institutioncontroller extends Controller
{
    public function add()
    {
        $Institution = Institution::all();
        return view('admin/institution/add');
    }
    
    public function store(Request $request)
    {
        // $validate = $request->validate([
        //     'password'=>'required|min:8',
        //     'instiimage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);

        $input = $request->validate([
            'password'=>'required|min:8',
            'instiimage' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ]);


        if($request->hasFile('instiimage')){
            $filename = $request->instiimage->getClientOriginalName();
       
            $request->instiimage->move('public/images/', $filename);            
        }else{
           
            return back()->with('erorr','Profile Not Updated');
        }
        $request->merge([
            'is_school' => 1,
        ]);
        
        $data = $request->all();
        $email = User::where('email', '=', $request->input('email'))->first();
          //dd($email);
            if ($email != '') {
                //dd("fdsfds");
                return redirect()->route('add.institution')->with('error',"Email address is already Exits.");
            }
            // else{
            //     dd("aaaaaaa");
            // }

        $Institution = new User;
        //dd($Institution);
        $data['password'] = Hash::make($data['password']);
        $data['instiimage'] = $filename; 
        $ins = $Institution->create($data);
        
        if($ins)
            return redirect()->route('institution.list')->with('success',"Institution Added Successfully.");
        else
            return redirect()->route('institution.list')->with('error',"Error In Adding Institution.");
    }

    public function index()
    {
        //$data = User::all();
        $data = User::select('*')
                ->where('is_school', '=', 1)
                ->orderBy('id', 'DESC')
                ->get();
        return view('admin/institution/index',['data'=> $data]);
    }
    public function edit($id)
    {
        $institution = User::findOrFail($id);
        return view('admin/institution/add', compact('institution' , 'id'));
    }

    public function update(Request $request, $code)
    {
        $institution = User::findOrFail($code);
        $data = $request->input();
        if(!isset($data['password']) && $data['password'] == null){
            unset($data['password']);
        }else{
            $data['password'] = bcrypt($data['password']);
        }

        if($request->hasFile('instiimage')){
            $institution1 = 'public/images/'.'$institution->instiimage';            
            $file = $request->file('instiimage');
            $filename = $file->getClientOriginalName();
            //$filename = time().'.'.$extension;
            $file->move('public/images/', $filename);  
            $institution->instiimage = $filename;          
        }
        //if (!empty($request->input('password'))) {
            //$abcdef = $data['password'];
            //dd($abcdef);
            if($institution){
                if($institution->update($data))
                    return redirect()->route('institution.list')->with('success',"Institution Edited Successfully.");
                else
                    return redirect()->route('institution.list')->with('error',"Error in Updating Institution.");
            }else{
                return redirect()->route('institution.list')->with('error',"Institution Not Found.");
            }
        //}
    }

    public function delete($code)
    {
        $Institution = User::where('id', '=', $code)->first();   
        $Institution->delete();

        return redirect()->route('institution.list')->with('success',"Institution Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_institutionid'] ) && !empty( $_POST['data_institutionid'] ) ) {
            $Institution_id = $_POST['data_institutionid'];
            User::where('id', $Institution_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
    

}

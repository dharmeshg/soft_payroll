<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\User;
use App\Models\FacultyDirectorate;
use Illuminate\Support\Facades\Hash;
use APP\Models\School;
use Auth;


class FacultyDirectorateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $FacultyDirectorate = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        if(Auth::user()->is_school == 3){
           $FacultyDirectorate = FacultyDirectorate::where('user_id','=',Auth::user()->employee->institution_id)->get();
        } 
        return view('facultydirectorate/index', compact('FacultyDirectorate'));       
    }
    public function add()
    {    	
    	$FacultyDirectorate = FacultyDirectorate::all();
        return view('facultydirectorate/add');       
    }     
    public function store(Request $request)
    {
    	// $data = $request->all();
    	$FacultyDirectorate = new FacultyDirectorate;
        $FacultyDirectorate->facultyname = $request['facultyname'];
        $FacultyDirectorate->faculty_description = $request['faculty_description'];
        $FacultyDirectorate->user_id = Auth::user()->id;
        $FacultyDirectorate->save();
    	// $ins = $FacultyDirectorate->create($data);  
   
        if($FacultyDirectorate)
            return redirect()->route('facultydirectorate.list')->with('success',"Faculty Added Successfully.");
        else
            return redirect()->route('facultydirectorate.list')->with('error',"Error In Adding Faculty.");
    }

    public function edit($id)
    {
       
        $FacultyDirectorate = FacultyDirectorate::findOrFail($id);
        return view('facultydirectorate/add', compact('FacultyDirectorate' , 'id'));
    }

    public function update(Request $request, $id)
    { 

        $FacultyDirectorate = FacultyDirectorate::findOrFail($id);
        $data = $request->input();        
        if($FacultyDirectorate){
            if($FacultyDirectorate->update($data))
                return redirect()->route('facultydirectorate.list')->with('success',"Faculty Edited Successfully.");
            else
                return redirect()->route('facultydirectorate.list')->with('error',"Error in Updating Faculty.");
        }else{
            return redirect()->route('facultydirectorate.list')->with('error',"Faculty Not Found.");
        }
        
    }

    public function delete($id)
    {
        $FacultyDirectorate = FacultyDirectorate::where('id', '=', $id)->first();   
        $FacultyDirectorate->delete();

        return redirect()->route('facultydirectorate.list')->with('success',"Faculty Deleted Successfully.");
    }
}

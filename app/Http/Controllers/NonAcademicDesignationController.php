<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Illuminate\Support\Facades\File;
use App\Models\Department;
use App\Models\FacultyDirectorate;
use App\Models\NonAcademicsDepartment;
use App\Models\NonAcademicsDesignation;
use App\Models\Division;
use Auth;


class NonAcademicDesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function add()
    // {
    //     // $unit = Unit::all();
    //         $faculty = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
    //         $department = Department::get();
    //         $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
    //         $division = Division::get();
    //         return view('/designation/add',compact('faculty','department', 'nonAcademicDepartment', 'division'));
    // }

    // public function store(Request $request)  
    // {
    //     $validatedData = $request->validate([
    //         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //     ]);
    
    //     if($request->hasFile('image')){
    //         $filename = $request->image->getClientOriginalName();
    //         $request->image->move('public/images/', $filename);            
    //     }else{
    //         return back()->with('erorr','Profile Not Updated');
    //     }

    //     if($request->category_unit == 'Non-Academic'){
    //         $designation = new NonAcademicsDesignation();
    //         $designation->title = $request['title'];
    //         $designation->description = $request['description'];
    //         $designation->faculty_id = $request['noe_academic_department'];
    //         $designation->department_id = $request['noe_academic_division'];
    //         $designation->image = $filename; 
    //         $designation->user_id = Auth::user()->id;  
    //         $designation->save();
    
    //         if($designation)
    //             return redirect()->route('designation.list')->with('success',"Designation Added Successfully.");
    //         else
    //             return redirect()->route('designation.list')->with('error',"Error In Adding Designation.");

    //     }else{
    //         $designation = new Designation();
    //         $designation->title = $request['title'];
    //         $designation->description = $request['description'];
    //         $designation->faculty_id = $request['directorate'];
    //         $designation->department_id = $request['department'];
    //         $designation->image = $filename; 
    //         $designation->user_id = Auth::user()->id;  
    //         $designation->save();
    
    //         if($designation)
    //             return redirect()->route('designation.list')->with('success',"Designation Added Successfully.");
    //         else
    //             return redirect()->route('designation.list')->with('error',"Error In Adding Designation.");

    //     }


    // }

    public function index()
    {
        $data = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();
        // if(Auth::user()->is_school == 3){
        //    $data = Designation::where('user_id','=',Auth::user()->employee->institution_id)->get();
        // } 
        return view('/designation/non_academic_index',['data'=> $data]);
    }

    public function edit($id)
    {
        $faculty = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();  
        $designation = NonAcademicsDesignation::findOrFail($id);
        $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
        $division = Division::get();
        $designation['category'] = 'Non-Academic';

        return view('/designation/add', compact('designation' , 'id','faculty','nonAcademicDepartment', 'division'));
    }

    // public function update(Request $request, $id)
    // {
    //     $designation = Designation::find($id);
    //     $designation->title = $request['title'];
    //     $designation->description = $request['description'];
    //     $designation->faculty_id = $request['directorate'];
    //     $designation->department_id = $request['department'];

    //     if($request->hasFile('image')){
    //         $designation1 = 'public/images/'.'$designation->image';
    //         if(File::exists($designation))
    //         {
    //             File::delete($designation);
    //         }
    //         $file = $request->file('image');
    //         $extension = $file->getClientOriginalName();
    //         $filename = time().'.'.$extension;
    //         $file->move('public/images/', $filename);  
    //         $designation->image = $filename;          
    //     }
    //     // $designation = Designation::findOrFail($code);
    //     // $data = $request->input();

    //     if($designation){
    //         if($designation->update())
    //             return redirect()->route('designation.list')->with('success',"Designation Edited Successfully.");
    //         else
    //             return redirect()->route('designation.list')->with('error',"Error in Updating Designation.");
    //     }else{
    //         return redirect()->route('designation.list')->with('error',"Designation Not Found.");
    //     }
    // }

    public function delete($code)
    {
        $designation = NonAcademicsDesignation::where('id', '=', $code)->first();   
        $designation->delete();

        return redirect()->route('non_academic_designation.list')->with('success',"Designation Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_designationid'] ) && !empty( $_POST['data_designationid'] ) ) {
            $designation_id = $_POST['data_designationid'];
            NonAcademicsDesignation::where('id', $designation_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 

    // public function getDepartment(Request $request)
    // {
    //     $data['departmentname'] = Department::where("faculty_id", $request->directorate_id)
    //         ->get();
    //     return response()->json($data);
    // }
}

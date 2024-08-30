<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\User;
use App\Models\Department;
use App\Models\Division;
use App\Models\NonAcademicsDepartment;

use App\Models\FacultyDirectorate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Auth;


class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // dd(Auth::user()->employee->official_information->non_Academic_department);
        $Department = Division::where('user_id', '=', Auth::user()->id)->get();
        if(Auth::user()->category == 'Non-Academic' && Auth::user()->role == 'HOD'){
            $Department = Division::where('user_id', '=', Auth::user()->employee->institution_id)->where('faculty_id', '=', Auth::user()->employee->official_information->non_Academic_department)->get();
        }
        // if (Auth::user()->is_school == 3) {
        //     $Department = Division::where('user_id', '=', Auth::user()->employee->institution_id)->get();
        // }
        return view('division/index', compact('Department'));
    }
    public function add()
    {
        $faculty = NonAcademicsDepartment::all();
        if(Auth::user()->category == 'Non-Academic' && Auth::user()->role == 'HOD'){
           $faculty = NonAcademicsDepartment::where('id', '=', Auth::user()->employee->official_information->non_Academic_department)->get();
        }

        return view('division/add', compact('faculty'));
    }
    public function store(Request $request)
    {

        // $validatedData = $request->validate([
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);

        // if ($request->hasFile('image')) {
        //     $filename = $request->image->getClientOriginalName();
        //     $request->image->move('public/images/', $filename);
        // } else {
        //     return back()->with('erorr', 'Profile Not Updated');
        // }


        $department = new Division();
        $department->departmentname = $request['departmentname'];
        $department->departmentdescription = $request['departmentdescription'];
        $department->faculty_id = $request['directorate'];
        // $department->image = $filename;
        if(Auth::user()->category == 'Non-Academic' && Auth::user()->role == 'HOD'){
            $department->user_id = Auth::user()->employee->institution_id;
        }else{
            $department->user_id = Auth::user()->id;
        }
        
        $department->save();

        if ($department)
            return redirect()->route('division.list')->with('success', "Division Added Successfully.");
        else
            return redirect()->route('division.list')->with('error', "Error In Adding Division.");
    }

    public function edit($id)
    {
        $Department = Division::findOrFail($id);
        
        if(Auth::user()->category == 'Non-Academic' && Auth::user()->role == 'HOD'){
           $faculty = NonAcademicsDepartment::where('id', '=', Auth::user()->employee->official_information->non_Academic_department)->get();
        }else{
            $faculty = NonAcademicsDepartment::all();
        }
        // $faculty = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();

        return view('division/add', compact('Department', 'id', 'faculty'));
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        $department = Division::find($id);
        $department->departmentname = $request['departmentname'];
        $department->departmentdescription = $request['departmentdescription'];
        $department->faculty_id = $request['directorate'];

        // if ($request->hasFile('image')) {
        //     if (File::exists($department)) {
        //         File::delete($department);
        //     }
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalName();
        //     $filename = time() . '.' . $extension;
        //     $file->move('public/images/', $filename);
        //     $department->image = $filename;
        // }

        if ($department) {
            if ($department->update())
                return redirect()->route('division.list')->with('success', "Division Edited Successfully.");
            else
                return redirect()->route('division.list')->with('error', "Error in Updating Division.");
        } else {
            return redirect()->route('division.list')->with('error', "Division Not Found.");
        }
    }

    public function delete($id)
    {
        $Department = Division::where('id', '=', $id)->first();
        $Department->delete();

        return redirect()->route('division.list')->with('success', "Division Deleted Successfully.");
    }

    public function statusUpdate()
    {
        if (isset($_POST['data_departmentid']) && !empty($_POST['data_departmentid'])) {
            $department_id = $_POST['data_departmentid'];
            Division::where('id', $department_id)->update(['status' => $_POST['data_status']]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        die;
    }
}
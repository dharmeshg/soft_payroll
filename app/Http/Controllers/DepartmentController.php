<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\User;
use App\Models\Department;
use App\Models\FacultyDirectorate;
use App\Models\NonAcademicsDepartment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Auth;


class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Department = Department::where('user_id', '=', Auth::user()->id)->get();
        if (Auth::user()->is_school == 3) {
            $Department = Department::where('user_id', '=', Auth::user()->employee->institution_id)->get();
        }
        return view('department/index', compact('Department'));
    }
    public function add()
    {
        $Department = Department::all();
        $faculty = FacultyDirectorate::where('user_id', '=', Auth::user()->id)->get();
        $non_academic_department = "";

        return view('department/add', compact('faculty', 'non_academic_department'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $request->image->move('public/images/', $filename);
        } else {
            return back()->with('erorr', 'Profile Not Updated');
        }

        if($request->category_unit == 'Non-Academic'){
            $department = new NonAcademicsDepartment();
            $department->departmentname = $request['departmentname'];
            $department->departmentdescription = $request['departmentdescription'];
            // $department->faculty_id = $request['directorate'];
            $department->image = $filename;
            $department->user_id = Auth::user()->id;
            $department->save();
    
            if ($department)
                return redirect()->route('non_academic_department.list')->with('success', "Department Added Successfully.");
            else
                return redirect()->route('non_academic_department.list')->with('error', "Error In Adding Department.");

        }else{
            $department = new Department();
            $department->departmentname = $request['departmentname'];
            $department->departmentdescription = $request['departmentdescription'];
            $department->faculty_id = $request['directorate'];
            $department->image = $filename;
            $department->user_id = Auth::user()->id;
            $department->save();
    
            if ($department)
                return redirect()->route('department.list')->with('success', "Department Added Successfully.");
            else
                return redirect()->route('department.list')->with('error', "Error In Adding Department.");
        }


    }

    public function edit($id)
    {
        $Department = Department::findOrFail($id);
        $faculty = FacultyDirectorate::where('user_id', '=', Auth::user()->id)->get();
     
        $Department['category'] = 'Academic';

        return view('department/add', compact('Department', 'id', 'faculty'));
    }

    public function update(Request $request, $id)
    {
        if ($request->directorate != '') {
            $department = Department::find($id);
            $department->departmentname = $request['departmentname'];
            $department->departmentdescription = $request['departmentdescription'];
            $department->faculty_id = $request['directorate'];
    
            if ($request->hasFile('image')) {
                if (File::exists($department)) {
                    File::delete($department);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalName();
                $filename = time() . '.' . $extension;
                $file->move('public/images/', $filename);
                $department->image = $filename;
            }
    
            if ($department) {
                if ($department->update())
                    return redirect()->route('department.list')->with('success', "Department Edited Successfully.");
                else
                    return redirect()->route('department.list')->with('error', "Error in Updating Department.");
            } else {
                return redirect()->route('department.list')->with('error', "Department Not Found.");
            }

        }else{
            $department = NonAcademicsDepartment::find($id);
            $department->departmentname = $request['departmentname'];
            $department->departmentdescription = $request['departmentdescription'];
            // $department->faculty_id = $request['directorate'];
    
            if ($request->hasFile('image')) {
                if (File::exists($department)) {
                    File::delete($department);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalName();
                $filename = time() . '.' . $extension;
                $file->move('public/images/', $filename);
                $department->image = $filename;
            }
    
            if ($department) {
                if ($department->update())
                    return redirect()->route('non_academic_department.list')->with('success', "Department Edited Successfully.");
                else
                    return redirect()->route('non_academic_department.list')->with('error', "Error in Updating Department.");
            } else {
                return redirect()->route('non_academic_department.list')->with('error', "Department Not Found.");
            }

        }


    }

    public function delete($id)
    {
        $Department = Department::where('id', '=', $id)->first();
        $Department->delete();

        return redirect()->route('department.list')->with('success', "Department Deleted Successfully.");
    }

    public function statusUpdate()
    {
        if (isset($_POST['data_departmentid']) && !empty($_POST['data_departmentid'])) {
            $department_id = $_POST['data_departmentid'];
            Department::where('id', $department_id)->update(['status' => $_POST['data_status']]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        die;
    }
}
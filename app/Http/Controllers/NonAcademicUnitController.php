<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Department;
use App\Models\FacultyDirectorate;
use App\Models\Division;
use App\Models\NonAcademicsDepartment;
use App\Models\NonAcademicUnit;



use Illuminate\Support\Facades\Hash;
use Auth;

class NonAcademicUnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        $faculty = FacultyDirectorate::where('user_id', '=', Auth::user()->id)->get();
        $department = Department::get();

        $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
        $division = Division::get();


        // $unit = Unit::all();
        return view('/unit/add', compact('faculty', 'department', 'nonAcademicDepartment', 'division'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->category_unit == 'Non-Academic') {

            $unit = new NonAcademicUnit;
            $unit->name = $request['name'];
            $unit->description = $request['description'];
            $unit->faculty_id = $request['noe_academic_department'];
            $unit->department_id = $request['noe_academic_division'];
            $unit->user_id = Auth::user()->id;
            $unit->save();

            if ($unit)
                return redirect()->route('unit.list')->with('success', "unit Added Successfully.");
            else
                return redirect()->route('unit.list')->with('error', "Error In Adding Unit.");
        } else {

            $unit = new Unit;
            $unit->name = $request['name'];
            $unit->description = $request['description'];
            $unit->faculty_id = $request['directorate'];
            $unit->department_id = $request['department'];
            $unit->user_id = Auth::user()->id;
            $unit->save();

            if ($unit)
                return redirect()->route('unit.list')->with('success', "unit Added Successfully.");
            else
                return redirect()->route('unit.list')->with('error', "Error In Adding Unit.");
        }



        // $validatedData = $request->validate([
        //         'name' => 'required',
        //         'description' => 'required',                
        //     ],
        //     [
        //         'name.required' => 'Please enter blogname.'
        //     ]
        // );
        // $unit = Unit::create($validatedData);
        // return redirect('home');

    }

    public function index()
    {
        $data = NonAcademicUnit::where('user_id', '=', Auth::user()->id)->get();
        if (Auth::user()->is_school == 3) {
            $data = NonAcademicUnit::where('user_id', '=', Auth::user()->employee->institution_id)->get();
        }
        return view('/unit/non_academic_index', ['data' => $data]);
    }

    public function edit($id)
    {
        $faculty = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
        $unit = NonAcademicUnit::findOrFail($id);
        $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
        $division = Division::get();
        $unit['category'] = 'Non-Academic';
        return view('/unit/add', compact('unit', 'id', 'faculty', 'nonAcademicDepartment', 'division'));
    }

    public function update(Request $request, $code)
    {
        $validatedData = $request->validate([]);

        $unit = Unit::findOrFail($code);
        $unit->faculty_id = $request['directorate'];
        $unit->department_id = $request['department'];
        $data = $request->input();

        if ($unit) {
            if ($unit->update($data))
                return redirect()->route('unit.list')->with('success', "Unit Edited Successfully.");
            else
                return redirect()->route('unit.list')->with('error', "Unit in Updating Unit.");
        } else {
            return redirect()->route('unit.list')->with('error', "Unit Not Found.");
        }
    }

    public function delete($code)
    {
        $unit = NonAcademicUnit::where('id', '=', $code)->first();
        $unit->delete();

        return redirect()->route('non_academic_unit.list')->with('success', "Product Deleted Successfully.");
    }

    public function getDepartment(Request $request)
    {
        $data['departmentname'] = Department::where("faculty_id", $request->directorate_id)
            ->get();
        return response()->json($data);
    }

    public function getDivision(Request $request)
    {
        $data['division'] = Division::where("faculty_id", $request->directorate_id)
            ->get();
        return response()->json($data);
    }
}
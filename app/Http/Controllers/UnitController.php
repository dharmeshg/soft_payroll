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

class UnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        if(Auth::user()->category == 'Academic' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HOS')){
            $faculty = FacultyDirectorate::where('id', '=', Auth::user()->employee->official_information->non_Academic_department)->get();
            $department = Department::get();

        }else{
            $faculty = FacultyDirectorate::where('user_id', '=', Auth::user()->id)->get();
            $department = Department::get();
        }
        if(Auth::user()->category == 'Non-Academic' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV')){
            $nonAcademicDepartment = NonAcademicsDepartment::where('id', '=', Auth::user()->employee->official_information->non_Academic_department)->get();
            $division = Division::get();
        }else{
            $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
            $division = Division::get();
        }
     
        // $unit = Unit::all();
        return view('/unit/add', compact('faculty', 'department', 'nonAcademicDepartment', 'division'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->category_unit == 'Non-Academic' || Auth::user()->category == 'Non-Academic') {

            $unit = new NonAcademicUnit;
            $unit->name = $request['name'];
            $unit->description = $request['description'];
            $unit->faculty_id = $request['noe_academic_department'];
            $unit->department_id = $request['noe_academic_division'];

            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS')){
                $unit->user_id = Auth::user()->employee->institution_id;
            }else{
                $unit->user_id = Auth::user()->id;
            }
            
            $unit->save();

            if ($unit)
                return redirect()->route('non_academic_unit.list')->with('success', "unit Added Successfully.");
            else
                return redirect()->route('non_academic_unit.list')->with('error', "Error In Adding Unit.");
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
        $data = Unit::where('user_id', '=', Auth::user()->id)->get();
        if (Auth::user()->is_school == 3) {
            $data = Unit::where('user_id', '=', Auth::user()->employee->institution_id)->get();
        }
        return view('/unit/index', ['data' => $data]);
    }

    public function edit($id)
    {
        $faculty = FacultyDirectorate::where('user_id', '=', Auth::user()->id)->get();
        $unit = Unit::findOrFail($id);
        $nonAcademicDepartment = NonAcademicsDepartment::where('user_id', '=', Auth::user()->id)->get();
        $division = Division::get();
        $unit['category'] = 'Academic';

        return view('/unit/add', compact('unit', 'id', 'faculty', 'nonAcademicDepartment', 'division'));
    }

    public function update(Request $request, $code)
    {
        // $validatedData = $request->validate([]);
        if ($request->noe_academic_department != '') {
            $unit = NonAcademicUnit::findOrFail($code);
            $unit->faculty_id = $request['noe_academic_department'];
            $unit->department_id = $request['noe_academic_division'];
            $data = $request->input();

            if ($unit) {
                if ($unit->update($data))
                    return redirect()->route('non_academic_unit.list')->with('success', "Unit Edited Successfully.");
                else
                    return redirect()->route('non_academic_unit.list')->with('error', "Unit in Updating Unit.");
            } else {
                return redirect()->route('non_academic_unit.list')->with('error', "Unit Not Found.");
            }
        } else {
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
    }

    public function delete($code)
    {
        $unit = Unit::where('id', '=', $code)->first();
        $unit->delete();

        return redirect()->route('unit.list')->with('success', "Product Deleted Successfully.");
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
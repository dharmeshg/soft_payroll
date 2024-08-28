<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Acadamicqualification;
use DB;


class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {        
        $acadamicqualification = Acadamicqualification::all();
        return view('/employee/add');
    }
    public function store(Request $request)
    {
        $data = $request->all();         	
    	$acadamicqualification = new Acadamicqualification;
        $data['staff_id'] = $request->staff_id;
        foreach ($request->institutionname as  $key => $value) {            
           $data = array(
                'staff_id' => $request->staff_id,
                'institutionname' => $request->institutionname[$key],
                'institutioncategory' => $request->institutioncategory[$key]
           );
           Acadamicqualification::create($data);
        }
        return back()->with('success', 'New subject has been added.');
    }
    public function index()
    {
        $data = Employee::all();
        return view('/employee/index',['data'=> $data]);
    }
    public function edit($id)
    {
        $data = Employee::findOrFail($id);
        $staff_id = $data->staff_id;
        $acadamicdata = Acadamicqualification::select('*')
                ->where('staff_id', '=', $staff_id)
                ->get();       
        return view('/employee/add', compact('data' , 'acadamicdata', 'id'));
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $staff_id = $employee->staff_id;
        $acadamicqualification = Acadamicqualification::select('*')
        ->where('staff_id', '=', $staff_id)
        ->get();
        $data = [];
        foreach ($acadamicqualification as  $key => $value){
            $data[$key] = $value->id;            
        }          
        foreach ($request->institutionname as  $key => $value) {  
            if(isset($request->institutionid[$key])) {
                $acd_id = $request->institutionid[$key];    
            }            
            if (in_array($acd_id, $data))
            {       
                echo $acd_id."<br>";
                $acadamicqualification = Acadamicqualification::findOrFail($acd_id);
                $acadamydata = array(
                    'staff_id' => $employee->staff_id,
                    'institutionname' => $request->institutionname[$key],
                    'institutioncategory' => $request->institutioncategory[$key]
               );
               $acadamicqualification->update($acadamydata);    
               $acd_id = '';
            }
            else
            {
                $data = array(
                    'staff_id' => $employee->staff_id,
                    'institutionname' => $request->institutionname[$key],
                    'institutioncategory' => $request->institutioncategory[$key]
               );
               Acadamicqualification::create($data);
            }
         }
         //exit;
         return back()->with('success', 'Employee data has been updated.');
        
    }

    public function delete($code)
    {
        
    }
    public function removeDealers() {
        //dd();
        if( isset( $_POST['data_dealers_buy'] ) && !empty( $_POST['data_dealers_buy'] ) ) {
            $data_dealers_buy = $_POST['data_dealers_buy'];
            Acadamicqualification::where( 'id', $data_dealers_buy )->delete();
        }
    }
}

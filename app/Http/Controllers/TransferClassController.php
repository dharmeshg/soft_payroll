<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferClass;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Auth;

class TransferClassController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    { 
        return view('transferclass/add');
    }

    public function store(Request $request)  
    {
        $data = $request->all();
        $transferclass = new TransferClass;
        $transferclass->classname = $request['classname'];
        $transferclass->description = $request['description'];
        $transferclass->user_id = Auth::user()->id;
        $transferclass->save();
       
        if($transferclass)
            return redirect()->route('transferclass.list')->with('success',"Transfer Class Added Successfully.");
        else
            return redirect()->route('transferclass.list')->with('error',"Error In Adding Transfer Class.");
    }

    public function index()
    {
        $data = TransferClass::all();
        return view('/transferclass/index',['data'=> $data]);

    }

    public function edit($id)
    {
        $transferclass = TransferClass::findOrFail($id);
        return view('/transferclass/add', compact('transferclass' , 'id'));
    }

    public function update(Request $request, $code)
    { 

        $transferclass = TransferClass::findOrFail($code);
        $data = $request->input();

        if($transferclass){
            if($transferclass->update($data))
                return redirect()->route('transferclass.list')->with('success',"Transfer Class Edited Successfully.");
            else
                return redirect()->route('transferclass.list')->with('error',"Transfer Class in Updating Unit.");
        }else{
            return redirect()->route('transferclass.list')->with('error',"Transfer Class Not Found.");
        }
    }

    public function delete($code)
    {
        $transferclass = TransferClass::where('id', '=', $code)->first();   
        $transferclass->delete();

        return redirect()->route('transferclass.list')->with('success',"Transfer Class Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_transferclassid'] ) && !empty( $_POST['data_transferclassid'] ) ) {
            $transferclass_id = $_POST['data_transferclassid'];
            TransferClass::where('id', $transferclass_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
}

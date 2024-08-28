<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferType;
use Illuminate\Support\Facades\Hash;
use Auth;

class TransferTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        return view('transfertype/add');
    }

    public function store(Request $request)  
    {
        $data = $request->all();
        $transfertype = new TransferType;
        $transfertype->typetitle = $request['typetitle'];
        $transfertype->description = $request['description'];
        $transfertype->user_id = Auth::user()->id;
        $transfertype->save();
       
        if($transfertype)
            return redirect()->route('transfertype.list')->with('success',"Transfer Type Added Successfully.");
        else
            return redirect()->route('transfertype.list')->with('error',"Error In Adding Transfer Type.");
    }

    public function index()
    {
        $data = TransferType::all();
        return view('/transfertype/index',['data'=> $data]);
    }

    public function edit($id)
    {
        $transfertype = TransferType::findOrFail($id);
        return view('/transfertype/add', compact('transfertype' , 'id'));
    }

    public function update(Request $request, $code)
    { 
        $transfertype = TransferType::findOrFail($code);
        $data = $request->input();

        if($transfertype){
            if($transfertype->update($data))
                return redirect()->route('transfertype.list')->with('success',"Transfer Type Edited Successfully.");
            else
                return redirect()->route('transfertype.list')->with('error',"Transfer Type in Updating Unit.");
        }else{
            return redirect()->route('transfertype.list')->with('error',"Transfer Type Not Found.");
        }
    }

    public function delete($code)
    {
        $transfertype = TransferType::where('id', '=', $code)->first();   
        $transfertype->delete();

        return redirect()->route('transfertype.list')->with('success',"Transfer Type Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_transfertypeid'] ) && !empty( $_POST['data_transfertypeid'] ) ) {
            $transfertype_id = $_POST['data_transfertypeid'];
            TransferType::where('id', $transfertype_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
}

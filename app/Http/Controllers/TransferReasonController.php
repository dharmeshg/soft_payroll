<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferReason;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Auth;

class TransferReasonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        return view('TransferReason/add');
    }

    public function store(Request $request)  
    {
        $data = $request->all();
        $transferreason = new TransferReason;
        $transferreason->transferreason = $request['transferreason'];
        $transferreason->description = $request['description'];
        $transferreason->user_id = Auth::user()->id;
        $transferreason->save();
       
        if($transferreason)
            return redirect()->route('transferreason.list')->with('success',"Transfer Reason Added Successfully.");
        else
            return redirect()->route('transferreason.list')->with('error',"Error In Adding Transfer Reason.");
    }

    public function index()
    {
        $data = TransferReason::all();
        return view('/TransferReason/index',['data'=> $data]);

    }

    public function edit($id)
    {
        $transferreason = TransferReason::findOrFail($id);
        return view('/TransferReason/add', compact('transferreason' , 'id'));
    }

    public function update(Request $request, $code)
    { 

        $transferreason = TransferReason::findOrFail($code);
        $data = $request->input();

        if($transferreason){
            if($transferreason->update($data))
                return redirect()->route('transferreason.list')->with('success',"Transfer Reason Edited Successfully.");
            else
                return redirect()->route('transferreason.list')->with('error',"Transfer Reason in Updating Unit.");
        }else{
            return redirect()->route('transferreason.list')->with('error',"Transfer Reason Not Found.");
        }
    }

    public function delete($code)
    {
        $transferreason = TransferReason::where('id', '=', $code)->first();   
        $transferreason->delete();

        return redirect()->route('transferreason.list')->with('success',"Transfer Reason Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_transferreasonid'] ) && !empty( $_POST['data_transferreasonid'] ) ) {
            $transferreason_id = $_POST['data_transferreasonid'];
            TransferReason::where('id', $transferreason_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
}

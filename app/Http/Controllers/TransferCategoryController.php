<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferCategory;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Auth;

class TransferCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        return view('transfercategory/add');
    }

    public function store(Request $request)  
    {
        $data = $request->all();
        $transfercategory = new TransferCategory;
        $transfercategory->categoryname = $request['categoryname'];
        $transfercategory->description = $request['description'];
        $transfercategory->user_id = Auth::user()->id;
        $transfercategory->save();
       
        if($transfercategory)
            return redirect()->route('transfercategory.list')->with('success',"Transfer Category Added Successfully.");
        else
            return redirect()->route('transfercategory.list')->with('error',"Error In Adding Transfer Category.");
    }

    public function index()
    {
        $data = TransferCategory::all();
        return view('/transfercategory/index',['data'=> $data]);

    }

    public function edit($id)
    {
        $transfercategory = TransferCategory::findOrFail($id);
        return view('/transfercategory/add', compact('transfercategory' , 'id'));
    }

    public function update(Request $request, $code)
    { 

        $transfercategory = TransferCategory::findOrFail($code);
        $data = $request->input();

        if($transfercategory){
            if($transfercategory->update($data))
                return redirect()->route('transfercategory.list')->with('success',"Transfer Category Edited Successfully.");
            else
                return redirect()->route('transfercategory.list')->with('error',"Transfer Category in Updating Unit.");
        }else{
            return redirect()->route('transfercategory.list')->with('error',"Transfer Category Not Found.");
        }
    }

    public function delete($code)
    {
        $transfercategory = TransferCategory::where('id', '=', $code)->first();   
        $transfercategory->delete();

        return redirect()->route('transfercategory.list')->with('success',"Transfer Category Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate() {
        if( isset( $_POST['data_transfercategoryid'] ) && !empty( $_POST['data_transfercategoryid'] ) ) {
            $transfercategory_id = $_POST['data_transfercategoryid'];
            TransferCategory::where('id', $transfercategory_id)->update([ 'status' => $_POST['data_status'] ]);
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode( [ 'status' => 'error' ] );
        }
        die;
    } 
}

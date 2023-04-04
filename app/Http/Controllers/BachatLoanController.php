<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\BachatLoan;

class BachatLoanController extends Controller
{
    public function getBachatLoan(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = BachatLoan::where('client_id',$request['client_id'])->where('loan_id',$request['id'])->first();
        } else {
            $data = BachatLoan::where('client_id',$request['client_id'])->where('loan_type',$request['loan_type'])->orderBy('loan_id')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveBachatLoan(Request $request) {

        $postData = $request->All();
        
        \Log::info($postData);
        $data     = BachatLoan::saveBachatLoanData($postData);
        
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBachatLoan(Request $request) {
        $postData = $request->All();
        $loan   = BachatLoan::where('loan_id',$postData['id'])->first();
        if(!empty($loan)) {
            $loan->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

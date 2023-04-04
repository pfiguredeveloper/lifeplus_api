<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\BachatRdsetup;

class BachatrdsetupController extends Controller
{
     public function getBachatPolicy(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = BachatRdsetup::where('clientid',$request['clientid'])->where('Rdsetupid',$request['id'])->first();
        } else {
            $data = BachatRdsetup::where('clientid',$request['clientid'])->where('productid',$request['productid'])->where('schemeid',$request['schemeid'])->orderBy('Rdsetupid')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveBachatrdsetup(Request $request) {

        $postData = $request->All();
        
        \Log::info($postData);
        $data     = BachatRdsetup::saveBachatLoanData($postData);
        
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBachatLoan(Request $request) {
        $postData = $request->All();
        $loan   = BachatRdsetup::where('Rdsetupid',$postData['id'])->first();
        if(!empty($loan)) {
            $loan->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

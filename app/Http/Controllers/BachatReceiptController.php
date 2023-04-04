<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\BachatReceipt;

class BachatReceiptController extends Controller
{
    public function getBachatReceipt(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = BachatReceipt::where('client_id',$request['client_id'])->where('RECEIPTID',$request['id'])->first();
        } else {
            $data = BachatReceipt::where('client_id',$request['client_id'])->orderBy('RECEIPTID')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveBachatReceipt(Request $request) {
        $postData = $request->All();
        $data     = BachatReceipt::saveBachatReceiptData($postData);
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBachatReceipt(Request $request) {
        $postData = $request->All();
        $Receipt   = BachatReceipt::where('RECEIPTID',$postData['id'])->first();
        if(!empty($Receipt)) {
            $Receipt->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

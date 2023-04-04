<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\BachatPolicy;

class BachatPolicyController extends Controller
{
    public function getBachatPolicy(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = BachatPolicy::where('client_id',$request['client_id'])->where('POLICYID',$request['id'])->first();
        } else {
            $data = BachatPolicy::where('client_id',$request['client_id'])->where('productid',$request['productid'])->where('schemeid',$request['schemeid'])->orderBy('POLICYID')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveBachatPolicy(Request $request) {
        $postData = $request->All();
        \Log::info($postData);
        $data     = BachatPolicy::saveBachatPolicyData($postData);
        
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBachatPolicy(Request $request) {
        $postData = $request->All();
        $policy   = BachatPolicy::where('POLICYID',$postData['id'])->first();
        if(!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

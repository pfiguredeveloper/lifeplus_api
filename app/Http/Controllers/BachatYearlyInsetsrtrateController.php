<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\BachatYearlyInsetsrtrate;
use DB;
class BachatYearlyInsetsrtrateController extends Controller
{
    public function getBachatPolicy(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = BachatYearlyInsetsrtrate::where('clientid',$request['clientid'])->where('interst_id',$request['id'])->first();
        } else {
            $data = BachatYearlyInsetsrtrate::where('clientid',$request['clientid'])->where('productid',$request['productid'])->where('schemeid',$request['schemeid'])->orderBy('interst_id')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }






    public function saveBachatPolicy(Request $request) {
        $postData = $request->All();
        \Log::info($postData);
        $data     = BachatYearlyInsetsrtrate::saveBachatinsterstData($postData);
        
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBachatPolicy(Request $request) {
        $postData = $request->All();
        $policy   = BachatYearlyInsetsrtrate::where('interst_id',$postData['id'])->first();
        if(!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\GiPolicy;
use App\Models\LifeCellLic\GIFireFloaterDetails;
use App\Models\LifeCellLic\GIPolicyMediClaimDetails;
use App\Models\LifeCellLic\GIPolicyVehicleDetails;
use App\Models\LifeCellLic\GIPolicyVehicleRelatedQuestions;
use App\Models\LifeCellLic\GIVehicleSystemRelatedQuestions;

class GiPolicyController extends Controller
{
    public function getGiPolicy(Request $request) {
        if(!empty($request['id'])) {
            $data = GiPolicy::where(['id'=>$request['id'],"is_active"=>1])->first();
            if(!empty($data)) {
                if($data['Form_id']==GiPolicy::FIRE_FORM) {
                    $data["fire_floater"] = GIFireFloaterDetails::where(['PolicyId'=>$data['id'],"is_active"=>1])->get();
                }
                else if($data['Form_id']==GiPolicy::HEALTH_CARE_FORM) {
                    $data["mediclaim_details"] = GIPolicyMediClaimDetails::where(['PolicyId'=>$data['id'],"is_active"=>1])->get();
                }
                else if($data['Form_id']==GiPolicy::MOTOR_FORM) {
                    $data["question_answer"] = GIPolicyVehicleRelatedQuestions::where(['PolicyId'=>$data['id'],"is_active"=>1])->pluck("VehicalQuestionId");
                    $data["vehicle_details"] = GIPolicyVehicleDetails::where(['PolicyId'=>$data['id'],"is_active"=>1])->first();
                }
            }
        } else {
            $data = GiPolicy::where(["is_active"=>1])->latest('id')->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveGiPolicy(Request $request) {
        $postData = $request->All();
        $data = GiPolicy::saveGiPolicyData($postData);
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteGiPolicy(Request $request) {
        $postData = $request->All();
        $policy = GiPolicy::where('id',$postData['id'])->first();
        if(!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

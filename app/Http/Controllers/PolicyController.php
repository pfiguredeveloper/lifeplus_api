<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\Policy;
use App\Models\LifeCellLic\MultiPolicy;
use App\Models\LifeCellUsers\TblClient;
use DB;

class PolicyController extends Controller
{
    public function getPolicy(Request $request)
    {
        //Validation
        if (!empty($request['id'])) {
            $data = Policy::with(['polNominee', 'polBoc'])->where('client_id', $request['client_id'])->where('PUNIQID', $request['id'])->first();
        } else {
            $data = Policy::with(['polNominee', 'polBoc'])->where('client_id', $request['client_id'])->orderBy('PUNIQID', 'DESC')->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.", "data" => $data]);
    }

    public function savePolicy(Request $request)
    {
        $postData = $request->All();
        info($postData);
        $data     = Policy::savePolicyData($postData);
        if (!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!", "data" => $data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!", "data" => $data]);
        }
    }

    public function savePolicyInsurance(Request $request)
    {
        $postData = $request->All();
        $data     = TblClient::where('c_id', $postData['client_id'])->first();
        if (!empty($data)) {
            $data['is_first_login'] = 1;
            $data['policy_insurance_id'] = !empty($postData['policy_insurance_id']) ? $postData['policy_insurance_id'] : '';
            $data->save();
        }
        return response()->json(["success" => 1, "msg" => "Record inserted Successfully!", "data" => $data]);
    }

    public function deletePolicy(Request $request)
    {
        $postData = $request->All();
        $policy   = Policy::where('PUNIQID', $postData['id'])->first();

        if (!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!", "data" => []]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.", "data" => []]);
        }
    }

    public function getMultiPolicy(Request $request)
    {
        //Validation
        if (!empty($request['id'])) {
            $data = MultiPolicy::with('multiPolicyRiders')->where('client_id', $request['client_id'])->where('PUNIQID', $request['id'])->first();
        } else {
            $data = MultiPolicy::with('multiPolicyRiders')->where('client_id', $request['client_id'])->orderBy('PUNIQID')->get();
        }

        return response()->json(["success" => 1, "msg" => "Success.", "data" => $data]);
    }

    public function saveMultiPolicy(Request $request)
    {
        $postData = $request->All();
        $data     = MultiPolicy::saveMultiPolicyData($postData);

        if (!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!", "data" => $data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!", "data" => $data]);
        }
    }

    public function deleteMultiPolicy(Request $request)
    {
        $postData = $request->All();
        $policy   = MultiPolicy::where('PUNIQID', $postData['id'])->first();

        if (!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!", "data" => []]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.", "data" => []]);
        }
    }
}

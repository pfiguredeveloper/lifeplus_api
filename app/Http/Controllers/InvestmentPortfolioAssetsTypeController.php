<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\AssetsType;

class InvestmentPortfolioAssetsTypeController extends Controller
{
    public function getInvestmentPortfolioAssetsType(Request $request) {
        //Validation
        if(!empty($request['id'])) {
            $data = AssetsType::where('client_id',$request['client_id'])->where('id',$request['id'])->first();
        } else {
            $data = AssetsType::where('client_id',$request['client_id'])->orderBy('id')->get();
        }
        return response()->json(["success" => 1, "msg" => "Success1.","data"=>$data,"req"=>$request->all()]);
    }

    public function saveInvestmentPortfolioAssetsType(Request $request) {
        $postData = $request->All();
        $data = AssetsType::saveMaster($postData);
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteInvestmentPortfolioAssetsType(Request $request) {
        $postData = $request->All();
        $policy  = AssetsType::where('id',$postData['id'])->first();
        if(!empty($policy)) {
            $policy->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCell\Bonus2020;
use DB;

class BonusApiController extends Controller
{
    public function getBonus(Request $request) {
    	
        if(!empty($request['id'])) {
            $data = Bonus2020::where('id',$request['id'])->first();
        } else {
            $data = Bonus2020::get();
        }
		return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveBonus(Request $request) {
    	
        $postData = $request->All();
        $data     = Bonus2020::saveBonus($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteBonus(Request $request) {
    	
        $postData = $request->All();
        $bonus    = Bonus2020::where('id',$postData['id'])->first();
        
    	if(!empty($bonus)) {
    		$bonus->delete();
    		return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
    	} else {
    		return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
    	}
    }
}

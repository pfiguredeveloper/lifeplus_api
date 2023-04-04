<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\Policy;
use App\Models\LifeCellLic\MultiPolicy;
use App\Models\LifeCellUsers\TblClient;
use App\Models\LifeCellLic\GIVehicleSystemRelatedQuestions;
use DB;

class GIVehicleSystemRelatedQuestionsController extends Controller
{
    public function getGIVehicleSystemRelatedQuestions(Request $request)
    {
        if (!empty($request['id'])) {
            $data = GIVehicleSystemRelatedQuestions::where(['id'=>$request['id'],'is_active'=>1])->first();
        } else {
            $data = GIVehicleSystemRelatedQuestions::where('is_active',1)->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.", "data" => $data]);
    }

}

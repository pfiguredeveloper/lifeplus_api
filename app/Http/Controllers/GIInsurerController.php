<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\Policy;
use App\Models\LifeCellLic\GIInsurer;
use App\Models\LifeCellLic\MultiPolicy;
use App\Models\LifeCellUsers\TblClient;
use DB;

class GIInsurerController extends Controller
{
    public function getGIInsurer(Request $request)
    {
        if (!empty($request['id'])) {
            $data = GIInsurer::where(['id'=>$request['id'],'is_active'=>1])->first();
        } else {
            $data = GIInsurer::where('is_active',1)->latest('id')->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.", "data" => $data]);
    }

}

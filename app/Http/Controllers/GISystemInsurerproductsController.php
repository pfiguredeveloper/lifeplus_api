<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\Policy;
use App\Models\LifeCellLic\GISystemInsurerproducts;
use App\Models\LifeCellLic\MultiPolicy;
use App\Models\LifeCellUsers\TblClient;
use DB;

class GISystemInsurerproductsController extends Controller
{
    public function getSystemInsurerproducts(Request $request)
    {

        if (!empty($request['id'])) {
            $data = GISystemInsurerproducts::where(['id'=>$request['id'],'IsurerId'=>$request['IsurerId'],'is_active'=>1])->first();
        }
        else if (!empty($request['IsurerId'])) {
            $data = GISystemInsurerproducts::where(['IsurerId'=>$request['IsurerId'],'is_active'=>1])->latest('id')->get();
        }
        else {
            $data = GISystemInsurerproducts::where('is_active',1)->latest('id')->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.", "data" => $data]);
    }

}

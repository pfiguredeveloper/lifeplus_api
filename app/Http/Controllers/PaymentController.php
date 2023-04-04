<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Redirect;
use App\Models\LifeCellUsers\Sales;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $input = $request->all();

        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        
        \Session::put('success', 'Payment successful');
        return redirect()->back();
    }

    public function getSales(Request $request) {
        
        if(!empty($request['id'])) {
            $data = Sales::where('id',$request['id'])->first();
        } else {
            $data = Sales::get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveSales(Request $request) {
        
        $postData = $request->All();
        $data     = Sales::saveSales($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteSales(Request $request) {
        
        $postData    = $request->All();
        $Sales       = Sales::where('id',$postData['id'])->first();
        
        if(!empty($Sales)) {
            $Sales->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }

    public function getRenewal(Request $request) {
        
        if(!empty($request['id'])) {
            $data = Sales::where('id',$request['id'])->first();
        } else {
            $data = Sales::get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveRenewal(Request $request) {
        
        $postData = $request->All();
        $data     = Sales::saveSales($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteRenewal(Request $request) {
        
        $postData    = $request->All();
        $Sales       = Sales::where('id',$postData['id'])->first();
        
        if(!empty($Sales)) {
            $Sales->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
}

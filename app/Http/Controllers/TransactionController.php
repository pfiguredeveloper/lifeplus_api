<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\Chmod;
use App\Models\LifeCellLic\Ledger;
use App\Models\LifeCellLic\LoanEntry;
use DB;

class TransactionController extends Controller
{
    public function saveModeChangeAction(Request $request) {
        $postData = $request->All();
        $data     = Chmod::saveChmod($postData);
        return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
    }

    public function saveSinglePremiumPosting(Request $request) {
        $postData = $request->All();
        info($postData);
		$data='';     
		$id=$postData['pono'];
		$polInfo2 = DB::connection('lifecell_lic')->select("SELECT * FROM pol where PONO = $id");
		$polInfo1  = !empty($polInfo2) ? $polInfo2['0'] : "";
		$polInfo = json_decode(json_encode($polInfo1), true);


		$pono=$polInfo['PUNIQID'];
		$fupdate=date('Y-m-d',date(strtotime("+1 day", strtotime($polInfo['FUPDATE']))));//$postData['duedt'];
		$type='';
		$paymentdate=$polInfo['FUPDATE'];
		Ledger::saveLedger($fupdate,$pono,$type,$paymentdate);

		return response()->json(["success" => 1, "msg8" => "Record inserted Successfully!","data"=> $data]);
    }

    public function saveMultiPremiumPosting(Request $request) {
        $postData = $request->All();
        $paymentdate1=$request['paiddate'];
        $pono1=$request['policyno'];
        $riskdate1=$request['RDT'];
        $fupdate1=$request['fupdate'];

        $data='';
        info($request->all());
        info($pono1);
        foreach ($pono1 as $key => $value) {

            $paymentdate = !empty($request['paiddate'][$key]) ? $request['paiddate'][$key] : '';
            $pono=$request['policyno'][$key];
            $riskdate=$request['RDT'][$key];
            $fupdate=$request['fupdate'][$key];
            if($paymentdate != '')
            {
                $data = $key;
				$pono=$pono;
				//$fupdate=$fupdate;
		        $fupdate=date('Y-m-d',date(strtotime("+1 day",strtotime($fupdate))));
        		$type='';
				Ledger::saveLedger($fupdate,$pono,$type,$paymentdate);
            }
        }
        return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
    }

    public function saveLoan(Request $request) {
        $postData = $request->All();
        $data     = LoanEntry::saveLoanEntry($postData);
        return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
    }
}



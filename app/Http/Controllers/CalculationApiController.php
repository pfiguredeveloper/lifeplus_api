<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCell\Plan;
use App\Models\LifeCell\SaOption;
use App\Models\LifeCell\Bonus;
use App\Library\Lib;

class CalculationApiController extends Controller
{
	public $lib;

    public function __construct() {
        $this->lib = new Lib;
	}

    public function getPlans(Request $request) {
        try {
            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
            $id      = $request->get('plan','');
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }
            if(!empty($id)) {
                $getPaln = Plan::where('plno',$id)->skip($skip)->take($take)->first();
                if(!empty($getPaln)) {
                    $getPaln['po_term']    = !empty($getPaln['po_term']) ? $getPaln['po_term'] : "0";
                    $getPaln['pr_term']    = !empty($getPaln['pr_term']) ? $getPaln['pr_term'] : "0";
                    $getPaln['wdab']       = !empty($getPaln['wdab']) ? $getPaln['wdab'] : "No";
                    $getPaln['term_rider'] = !empty($getPaln['term_rider']) ? $getPaln['term_rider'] : "No";
                    $getPaln['ci_rider']   = !empty($getPaln['ci_rider']) ? $getPaln['ci_rider'] : "No";
                    $getPaln['commission'] = !empty($getPaln['commission']) ? $getPaln['commission'] : "No";
                    $getPaln['sp_po_term'] = !empty($getPaln['sp_po_term']) ? $getPaln['sp_po_term'] : "";
                    $getPaln['sp_pr_term'] = !empty($getPaln['sp_pr_term']) ? $getPaln['sp_pr_term'] : "";
                    $getPaln['use_shortfall'] = !empty($getPaln['mb']) ? $getPaln['mb'] : "No";
                    $getPaln['yield_claim'] = !empty($getPaln['yield_claim']) ? $getPaln['yield_claim'] : "No";
                    $getPaln['yield_summary'] = !empty($getPaln['yield_summary']) ? $getPaln['yield_summary'] : "No";
                    $getPaln['cash_value'] = !empty($getPaln['cash_value']) ? $getPaln['cash_value'] : "No";
                    $getPaln['settlement_option'] = !empty($getPaln['settlement_option']) ? $getPaln['settlement_option'] : "No";
                    $getPaln['assumed_age'] = !empty($getPaln['assumed_age']) ? $getPaln['assumed_age'] : "No";
                    $getPaln['assumed_paidup_age'] = !empty($getPaln['assumed_paidup_age']) ? $getPaln['assumed_paidup_age'] : "No";
                    $getPaln['prop_age'] = !empty($getPaln['prop_age']) ? $getPaln['prop_age'] : "No";
                    $getPaln['isloyalty'] = (!empty($getPaln['isloyalty']) && $getPaln['isloyalty'] == 1)  ? "Yes" : "No";
                }
            } else {
                $getPaln = Plan::skip($skip)->take($take)->get();
            }
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getPaln]);

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getPlansLifeCell(Request $request) {
        try {
            $id      = $request->get('plan','');
            $age     = $request->get('age','');
            if(!empty($id)) {
                if(!empty($age)) {
                    $getPaln = \DB::connection('lifecell')->select("select `pltype` from `plan` where `plno` = $id and `agemin` <= $age and `agemax` >= $age  and `mobile` = 'Y' group by `pltype`");
                } else {
                    $getPaln = \DB::connection('lifecell')->select("select `pltype` from `plan` where `plno` = $id and `mobile` = 'Y' group by `pltype`");
                }
                //$getPaln = Plan::select('pltype','agemin')->where('plno',$id)->where('agemin','>=',$age)->where('mobile','Y')->groupBy('pltype')->get();
            } else {
                $getPaln = \DB::connection('lifecell')->select("select `pltype` from `plan` where `mobile` = 'Y' group by `pltype`");
                //$getPaln = Plan::select('pltype')->where('mobile','Y')->groupBy('pltype')->get();
            }
            $data = [];
            if(count($getPaln) > 0 && !empty($getPaln)) {
            	foreach ($getPaln as $key => $value) {
                    if(!empty($id)) {
        			    $getP = Plan::select('plannm','agemin','agemax','rtermmin as mtermmin','rtermmax as mtermmax','termmin as ptermmin','termmax as ptermmax','samin','samax','plno')->where('pltype',$value->pltype)->where('plno',$id)->where('mobile','Y')->get();
                    } else {
                        $getP = Plan::select('plannm','agemin','agemax','rtermmin as mtermmin','rtermmax as mtermmax','termmin as ptermmin','termmax as ptermmax','samin','samax','plno')->where('pltype',$value->pltype)->where('mobile','Y')->get();
                    }
                    if($value->pltype == 'A') {
                        $planType = "ANNUITY PLANS";
                    } else if($value->pltype == 'C') {
                        $planType = "CHILDREN PLANS";
                    } else if($value->pltype == 'E') {
                        $planType = "ENDOWMENT PLANS";
                    } else if($value->pltype == 'H') {
                        $planType = "HEALTH PLANS";
                    } else if($value->pltype == 'M') {
                        $planType = "MONEY BACK PLANS";
                    } else if($value->pltype == 'O') {
                        $planType = "OTHER PLANS";
                    } else if($value->pltype == 'T') {
                        $planType = "TERM PLANS";
                    } else if($value->pltype == 'U') {
                        $planType = "ULIP PLANS";
                    } else if($value->pltype == 'W') {
                        $planType = "WHOLE LIFE PLANS";
                    } else {
                        $planType = $value->pltype;
                    }
        			$data[] = [
            			'pltype'   => $planType,
            			'planinfo' => $getP
            		];
	            }
            }
            
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getAge(Request $request) {
        try {
        	//Validation
            $validation['plan']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" =>implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }

            $getAge = Plan::select('agemin','agemax')->where('plno',$postData['plan'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getMTerm(Request $request) {
        try {
        	//Validation
            $validation['plan']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }

            $getAge = Plan::select('rtermmin as mtermmin','rtermmax as mtermmax')->where('plno',$postData['plan'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getPTerm(Request $request) {
        try {
        	//Validation
            $validation['plan']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }

            $getAge = Plan::select('termmin as ptermmin','termmax as ptermmax')->where('plno',$postData['plan'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getMode(Request $request) {
        try {
            //Validation
            $validation['plan']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
            $take    = $request->get('limit',1000000000);
            $skip    = 0;
            if($page != 1) {
                $skip = (int) (($page - 1) * $take);
            }

            $getAge = Plan::select('valmod')->where('plno',$postData['plan'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getSAMinMax(Request $request) {
        try {
        	//Validation
            $validation['plan']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }

            $getAge = Plan::select('samin','samax')->where('plno',$postData['plan'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getBonus(Request $request) {
        try {
        	//Validation
            $validation['plan']  = 'required';
            $validation['term']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $page    = $request->get('page',1);
        	$take    = $request->get('limit',1000000000);
        	$skip    = 0;
	        if($page != 1) {
	            $skip = (int) (($page - 1) * $take);
	        }

            $getAge = Bonus::select('field7 as bonus')->where('field1',$postData['plan'])->where('field4','<=',$postData['term'])->where('field5','>=',$postData['term'])->skip($skip)->take($take)->get();
            return response()->json(["success" => 1, "msg" => "Success.","data"=>$getAge]);
            
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getPremiumPrentation(Request $request) {
    	try {
    		//Validation
            $validation['method']      = 'required';
            $validation['plno']        = 'required';
            $validation['age']  	   = 'required';
            $validation['pterm']       = 'required';
            $validation['mterm']       = 'required';
            $validation['sa']  		   = 'required';
            $validation['dabsa']       = 'required';
            $validation['trsa']        = 'required';
            $validation['cirsa']       = 'required';
            $validation['option']      = 'required';
            $validation['waive']       = 'required';
            $validation['PropAge']     = 'required';
            $validation['curr_year']   = 'required';
            $validation['tax_benifit'] = 'required';
            $validation['bonus'] 	   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

	    	$data  		 = [];
			$mterm  	 = $postData["mterm"];
			$pterm       = $postData["pterm"];
			$age         = $postData["age"];
			$sa          = $postData["sa"];
			$dabsa       = $postData["dabsa"];
			$trsa        = $postData["trsa"];
			$cirsa       = $postData["cirsa"];
			$option      = $postData["option"];
			$plno        = $postData["plno"];
			$waive       = $postData["waive"];
			$PropAge     = $postData["PropAge"];
			$curr_year   = $postData["curr_year"];
			$tax_benifit = $postData["tax_benifit"];
			$bonus  	 = $postData["bonus"];
            $daboption   = !empty($postData["daboption"]) ? $postData["daboption"] : 0;
            $dabcheck    = !empty($postData["DAB_CHECK"]) ? $postData["DAB_CHECK"] : '';
            $trcheck     = !empty($postData["TR_CHECK"]) ? $postData["TR_CHECK"] : '';
            $circheck    = !empty($postData["CIR_CHECK"]) ? $postData["CIR_CHECK"] : '';
            $pwbcheck    = !empty($postData["PWB_CHECK"]) ? $postData["PWB_CHECK"] : '';
            $settcheck   = !empty($postData["SETT_CHECK"]) ? $postData["SETT_CHECK"] : '';
            $saoption    = !empty($postData["SAOPTION"]) ? $postData["SAOPTION"] : 0;
			
			$premium = $this->lib->getPremium($mterm,$pterm,$age,$sa,$dabsa,$trsa,$cirsa,$option,$plno,$waive,$PropAge,$curr_year,$tax_benifit,$bonus,$daboption,$dabcheck,$trcheck,$circheck,$pwbcheck,$settcheck,$saoption);
			
			if($postData["method"] == "GetPremium" || $postData["method"] == "GetPremiumPrentation") {
				$data['Premium'] = $premium;
			}
			
			if($postData["method"] == "GetPrentation" || $postData["method"] == "GetPremiumPrentation") {
				$data['Presentation'] = $this->lib->get_presentation($premium);
			}
			
			return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);

		} catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getSaOption(Request $request)
    {
        try {
            //Validation
            $validation['plan']  = 'required';

            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()), "data" => []]);
            }

            $page    = $request->get('page', 1);
            $take    = $request->get('limit', 1000000000);
            $skip    = 0;
            if ($page != 1) {
                $skip = (int) (($page - 1) * $take);
            }

            $getSaOption = Plan::select('sa_option')->where('plno', $postData['plan'])->skip($skip)->take($take)->first();

            $saoptionIds = explode(',', $getSaOption['sa_option']);

            $getSaOptionData = SaOption::select("*")
                ->whereIn('id', $saoptionIds)
                ->get();

            //dd($getSaOption);
            return response()->json(["success" => 1, "msg" => "Success.", "data" => $getSaOptionData]);
        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong", "data" => []]);
        }
    }
}

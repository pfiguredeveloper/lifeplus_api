<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellUsers\TblApi;
use App\Models\LifeCellLic\Addgroup;
use App\Models\LifeCellLic\Address;
use App\Models\LifeCellLic\Agency;
use App\Models\LifeCellLic\Appoint;
use App\Models\LifeCellLic\Area;
use App\Models\LifeCellLic\Articals;
use App\Models\LifeCellLic\Bank;
use App\Models\LifeCellLic\Branch;
use App\Models\LifeCellLic\Caption;
use App\Models\LifeCellLic\Caste;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Country;
use App\Models\LifeCellLic\District;
use App\Models\LifeCellLic\Doctor;
use App\Models\LifeCellLic\Dolic;
use App\Models\LifeCellLic\Family_group;
use App\Models\LifeCellLic\Gender;
use App\Models\LifeCellLic\Invest;
use App\Models\LifeCellLic\Nav;
use App\Models\LifeCellLic\Pacode;
use App\Models\LifeCellLic\Paidby;
use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Rela;
use App\Models\LifeCellLic\State;
use App\Models\LifeCellLic\Status;
use App\Models\LifeCellLic\Surname;
use App\Models\LifeCellLic\Smsformat;
use App\Models\LifeCellLic\Courier;
use App\Models\LifeCellLic\Dealer;
use App\Models\LifeCellLic\Franchisee;
use App\Models\LifeCellLic\Product;
use App\Models\LifeCellLic\FranchiseComm;
use App\Models\LifeCellLic\LifeInsurance;
use App\Models\LifeCellLic\Division;
use App\Models\LifeCellLic\Postoffice;
use App\Models\LifeCellLic\Receiver;
use App\Models\LifeCellLic\Surveryors;
use App\Models\LifeCellLic\Tpahospital;
use App\Models\LifeCellLic\TPA;
use App\Models\LifeCellLic\Vehicles;
use App\Models\LifeCellLic\TypeOfBody;
use App\Models\LifeCellLic\TypeVehicle;
use App\Models\LifeCellLic\VehicleMake;
use DB;

class LifePlusApiController extends Controller
{
    public function getMasters(Request $request) {
    	//Validation
        $validation['tag']  = 'required';
        
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

        // GET TABLE NAME
        $getTableName = TblApi::select('tableName')->where('tag',$postData['tag'])->first();
        $table_name   = '';
        if(!empty($getTableName)) {
        	$table_name = !empty($getTableName['tableName']) ? $getTableName['tableName'] : '';
        }

        $getFieldName = TblApi::select('fieldName')->where('tag',$postData['tag'])->where('isOnSearch','1')->get();
        $field_name   = [];
        if(!empty($getFieldName) && count($getFieldName) > 0) {
        	foreach ($getFieldName as $key => $value) {
        		$field_name[] = $value['fieldName'];
        	}
        }

        if(!empty($postData['id']) && $postData['id'] != 0) {
        	$getFieldName = TblApi::select('fieldName')->where('tag',$postData['tag'])->where('isKey','1')->get();
        	$field_name   = [];
	        if(!empty($getFieldName) && count($getFieldName) > 0) {
	        	foreach ($getFieldName as $key => $value) {
	        		$field_name[] = $value['fieldName'];
	        	}
	        }
		}

		// GET RETURN FIELDS
		$getSelectedFields = TblApi::select('fieldName','alias')->where('tag',$postData['tag'])->get();
		$selected_fields   = [];
		if(!empty($getSelectedFields) && count($getSelectedFields) > 0) {
			foreach ($getSelectedFields as $key => $value) {
				// $selected_fields[] = $value['fieldName']." as ".$value['alias'];
                $selected_fields[] = $value['fieldName'];
			}
		}

		// Search By STRING
		$where  = "";
		$search = !empty($postData['search']) ? $postData['search'] : '';
        
        if(!empty($postData['client_id'])) {
            $where .= "client_id = ".$postData['client_id']." AND";
        }

        if(!empty($postData['p_id'])) {
            $where .= " p_id = ".$postData['p_id']." AND";
        }
        
		if($search != "") {
			if(!empty($field_name) && count($field_name) > 0) {
				foreach($field_name as $field) {
					$where.=" $field LIKE '%".$search."%' OR ";
				}
			}
		}

        if($search == "" && !empty($postData['id']) && $postData['id'] != 0)
            $where .= " 1=1 AND";
		else if($search == "")
			$where .= " 1=1 ";
		else
			$where = substr($where, 0, -3);
		
		// Search By ID
		if(!empty($postData['id']) && $postData['id'] != 0) {
			$where .=" ".$field_name[0]." = '".$postData['id']."' ";
		}

		if(!empty($selected_fields) && count($selected_fields) > 0) {
			$selected_fields_1 = "";
			foreach($selected_fields as $field) {
				$selected_fields_1 .= $field.",";
			}
		}

		$selectedData = " * ";
		if(!empty($selected_fields_1)) {
			$selectedData = rtrim($selected_fields_1,',');
		}

		$data 	   = DB::connection('lifecell_lic')->select("SELECT $selectedData FROM $table_name where $where limit $take offset $skip");
        if(!empty($postData['id']) && $postData['id'] != 0) {
            $id = $postData['id'];
            //$data['address'] = DB::connection('lifecell_lic')->select("SELECT * FROM contact where tableName = '$table_name' AND tableID = $id");
        }
		$totalRows = DB::connection('lifecell_lic')->select("SELECT $selectedData FROM $table_name where $where");
		
		return response()->json(["success" => 1, "msg" => "Success.","data"=>$data,"totalRows"=>count($totalRows)]);
    }

    public function saveMasters(Request $request) {
    	//Validation
        $validation['tag']     = 'required';
        $validation['is_edit'] = 'required';
        
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
        }

        if($postData['is_edit'] == 1) {
        	if(empty($postData['id'])) {
        		return response()->json(["success" => 0, "msg" => "The id is required.","data"=>[]]);
        	}
        }

        // GET TABLE NAME
        $getTableName = TblApi::select('tableName')->where('tag',$postData['tag'])->first();
        $table_name   = '';
        if(!empty($getTableName)) {
        	$table_name = !empty($getTableName['tableName']) ? $getTableName['tableName'] : '';
        }

        if($table_name == 'country') {
            $validation['COUNTRY'] = 'required';
            //$validation['ISD']     = 'required';
            //$validation['ISO']     = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Country::saveMaster($postData);
        } else if($table_name == 'area') {
            $validation['ARE1'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Area::saveMaster($postData);
        } else if($table_name == 'surname') {
            $validation['SURNAME'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Surname::saveMaster($postData);
        } else if($table_name == 'do') {
            $validation['DONAME']    = 'required';
            $validation['DO_CODE']   = 'required';
            $validation['APP_MONTH'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Dolic::saveMaster($postData);
        } else if($table_name == 'paidby') {
            $validation['PAIDBY']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Paidby::saveMaster($postData);
        } else if($table_name == 'pacode') {
            $validation['PACODE']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Pacode::saveMaster($postData);
        } else if($table_name == 'caption') {
            $validation['CAP1']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Caption::saveMaster($postData);
        } else if($table_name == 'rela') {
            $validation['RELA']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Rela::saveMaster($postData);
        } else if($table_name == 'addgroup') {
            $validation['ADDGROUP']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Addgroup::saveMaster($postData);
        } else if($table_name == 'bank') {
            $validation['BANK']     = 'required';
            $validation['BANKBR']   = 'required';
            $validation['BANKMICR'] = 'required';
            $validation['BANKIFS']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Bank::saveMaster($postData);
        } else if($table_name == 'branch') {
            $validation['BRANCH']    = 'required';
            $validation['BRANCHNM']  = 'required';
            $validation['BR_MGR_NM'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Branch::saveMaster($postData);
        } else if($table_name == 'caste') {
            $validation['CASTE']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Caste::saveMaster($postData);
        } else if($table_name == 'invest') {
            $validation['INVESTMENT']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Invest::saveMaster($postData);
        } else if($table_name == 'gender') {
            $validation['NAME']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Gender::saveMaster($postData);
        } else if($table_name == 'status') {
            $validation['STATUS']   = 'required';
            $validation['GENDER']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Status::saveMaster($postData);
        } else if($table_name == 'articals') {
            $validation['DESC1']   = 'required';
            $validation['DESC2']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Articals::saveMaster($postData);
        } else if($table_name == 'state') {
            $validation['STATE']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = State::saveMaster($postData);
        } else if($table_name == 'district') {
            $validation['DISTRICT']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = District::saveMaster($postData);
        } else if($table_name == 'city') {
            $validation['CITY']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = City::saveMaster($postData);
        } else if($table_name == 'family_group') {
            $validation['GNM']    = 'required';
            $validation['GEMAIL'] = 'required|email';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Family_group::saveMaster($postData);
        } else if($table_name == 'doctor') {
            $validation['DOCTOR']   = 'required';
            $validation['DOC_CODE'] = 'required';
            $validation['STATUS'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Doctor::saveMaster($postData);
        } else if($table_name == 'appoint') {
            $validation['PCODE'] = 'required';
            $validation['NAME']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Appoint::saveMaster($postData);
        } else if($table_name == 'party') {
            $validation['NAME']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Party::saveMaster($postData);
        } else if($table_name == 'agency') {
            $validation['AGCODE']  = 'required';
            $validation['ANAME']   = 'required';
            $validation['DOCODE']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Agency::saveMaster($postData);
        } else if($table_name == 'division') {
            $validation['division'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Division::saveMaster($postData);
        } else if($table_name == 'nav') {
            $validation['FULL_PREM']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Nav::saveMaster($postData);
        } else if($table_name == 'address') {
            $validation['NAME']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Address::saveMaster($postData);
        } else if($table_name == 'smsformat') {
            $validation['MESSAGE']       = 'required';
            $validation['MESSAGETYPE']   = 'required';
            $validation['MESSAGETITLE']  = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Smsformat::saveMaster($postData);
        } else if($table_name == 'courier') {
            $validation['COURIER_NAME']     = 'required';
            $validation['COURIER_PERSON']   = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Courier::saveMaster($postData);
        } else if($table_name == 'dealer') {
            $validation['dealer'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Dealer::saveMaster($postData);
        } else if($table_name == 'franchise') {
            $validation['franchnm'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Franchisee::saveMaster($postData);
        } else if($table_name == 'product') {
            $validation['productname'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Product::saveMaster($postData);
        } else if($table_name == 'life_insurance') {
            $validation['company_name'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = LifeInsurance::saveMaster($postData);
        } else if($table_name == 'surveryors') {
            $validation['NAME'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Surveryors::saveMaster($postData);
        } else if($table_name == 'tpahospital') {
            $validation['NAME'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Tpahospital::saveMaster($postData);
        } else if($table_name == 'tpa') {
            $validation['NAME'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = TPA::saveMaster($postData);
        } else if($table_name == 'vehicles') {
            $validation['NAME'] = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Vehicles::saveMaster($postData);
        } else if($table_name == 'type_of_body') {
            $data = TypeOfBody::saveMaster($postData);
        } else if($table_name == 'type_vehicle') {
            $data = TypeVehicle::saveMaster($postData);
        } else if($table_name == 'vehicle_make') {
            $data = VehicleMake::saveMaster($postData);
        } else if($table_name == 'franchise_commision') {
            $data = FranchiseComm::saveMaster($postData);
        }else if($table_name == 'postoffice') {
            $validation['PostOffice']    = 'required';
            $validation['Address']    = 'required';
            $validation['City_Id']    = 'required';
            $validation['PinCode']    = 'required';
            $validation['Phone']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Postoffice::saveMaster($postData);
        } else if($table_name == 'receiver') {
            $validation['recivername']    = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }
            $data = Receiver::saveMaster($postData);
        } else {
            return response()->json(["success" => 0, "msg" => "invalid tag","data"=>[]]);
        }
        
        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deletemasterss(Request $request) {
        $postData = $request->All();
        return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$postData]);

    }
    public function deleteMasters(Request $request) {
    	//Validation
        $validation['tag'] = 'required';
        $validation['id']  = 'required';
        
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
        }

        // GET TABLE NAME
        $getTableName = TblApi::select('tableName')->where('tag',$postData['tag'])->first();
        $table_name   = '';
        if(!empty($getTableName)) {
        	$table_name = !empty($getTableName['tableName']) ? $getTableName['tableName'] : '';
        }

        $getField = TblApi::select('fieldName')->where('tag',$postData['tag'])->where('isKey','1')->first();
        	
    	if(!empty($getField['fieldName'])) {
    		$where = $getField['fieldName']." = ".$postData['id'];
        	DB::connection('lifecell_lic')->select("DELETE FROM $table_name WHERE $where");
    		return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
    	} else {
    		return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
    	}
    }
}

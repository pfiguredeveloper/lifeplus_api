<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellUsers\ClientMenu;
use App\Models\LifeCellUsers\ClientPermissions;
use App\Models\LifeCellUsers\ClientRoles;
use App\Models\LifeCellUsers\ClientPermissionsRole;
use App\Models\LifeCellUsers\TblClient;
use App\Models\LifeCellUsers\TblClientProduct;
use App\Models\LifeCellUsers\TblProduct;
use App\Models\LifeCellUsers\TblClientProductDevice;
use App\Models\LifeCellUsers\ClientProductLicense;
use DB;

class ClientApiController extends Controller
{

    public function getPermissions(Request $request) {
    	
        if(!empty($request['id'])) {
            $data = ClientPermissions::where('id',$request['id'])->first();
        } else {
            $data = ClientPermissions::get();
        }
		return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function savePermissions(Request $request) {
    	
        $postData = $request->All();
        $data     = ClientPermissions::savePermissions($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deletePermissions(Request $request) {
    	
        $postData    = $request->All();
        $permissions = ClientPermissions::where('id',$postData['id'])->first();
        
    	if(!empty($permissions)) {
    		$permissions->delete();
    		return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
    	} else {
    		return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
    	}
    }

    public function getClientMenu(Request $request) {
        
        if(!empty($request['id'])) {
            $data = ClientMenu::where('id',$request['id'])->first();
        } else {
            $data = ClientMenu::get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveClientMenu(Request $request) {
        
        $postData = $request->All();
        $data     = ClientMenu::saveClientMenu($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteClientMenu(Request $request) {
        
        $postData    = $request->All();
        $clientMenu  = ClientMenu::where('id',$postData['id'])->first();
        
        if(!empty($clientMenu)) {
            $clientMenu->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }

    public function getRoles(Request $request) {
        
        if(!empty($request['id'])) {
            $role    = ClientRoles::where('id',$request['id'])->first();
            $perRole = ClientPermissionsRole::select('permission_id')->where('role_id',$request['id'])->get();
            $perData = [];
            if(!empty($perRole) && count($perRole) > 0) {
                foreach ($perRole as $key => $value) {
                    $perData[] = $value['permission_id'];
                }    
            }

            $data = [
                'role'    => $role,
                'perRole' => $perData
            ];
        } else {
            $data = ClientRoles::get();
            foreach ($data as $key => $value) {
                $value['permissions'];
            }
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveRoles(Request $request) {

        $postData = $request->All();
        $data     = ClientRoles::saveRoles($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteRoles(Request $request) {
        $postData    = $request->All();
        $permissions = ClientRoles::where('id',$postData['id'])->first();
        
        if(!empty($permissions)) {
            $perRole = ClientPermissionsRole::where('role_id',$postData['id'])->get();
            if(!empty($perRole) && count($perRole) > 0) {
                foreach ($perRole as $key => $value) {
                    $value->delete();
                }
            }
            $permissions->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }

    public function getUsers(Request $request) {
        
        if(!empty($request['id'])) {
            $data = TblClient::where('c_id',$request['id'])->first();
        } else {
            $data = TblClient::get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveUsers(Request $request) {
        
        $postData = $request->All();
        
        // Client Insert ***************************************************
        if(!empty($postData['id'])) {
            $client  = TblClient::where('c_id',$postData['id'])->first();
        } else {
            $client  = new TblClient;
        }
        $client['c_name']           = !empty($postData['c_name']) ? $postData['c_name'] : '';
        $client['c_mobile']         = !empty($postData['c_mobile']) ? $postData['c_mobile'] : '';
        $client['c_email']          = !empty($postData['c_email']) ? $postData['c_email'] : '';
        $client['c_password']       = !empty($postData['c_password']) ? app('hash')->make($postData['c_password']) : '';
        $client['c_city_id']        = !empty($postData['c_city_id']) ? $postData['c_city_id'] : 0;
        $client['c_type']           = !empty($postData['c_type']) ? $postData['c_type'] : 'DO';
        $client['c_agt_ad1']        = !empty($postData['c_agt_ad1']) ? $postData['c_agt_ad1'] : '';
        $client['c_agt_ad2']        = !empty($postData['c_agt_ad2']) ? $postData['c_agt_ad2'] : '';
        $client['c_agt_ad3']        = !empty($postData['c_agt_ad3']) ? $postData['c_agt_ad3'] : '';
        $client['c_branch_id']      = !empty($postData['c_branch_id']) ? $postData['c_branch_id'] : 0;
        $client['c_country_id']     = !empty($postData['c_country_id']) ? $postData['c_country_id'] : 0;
        $client['c_state_id']       = !empty($postData['c_state_id']) ? $postData['c_state_id'] : 0;
        $client['c_pin']            = !empty($postData['c_pin']) ? $postData['c_pin'] : '';
        $client['c_phone_o']        = !empty($postData['c_phone_o']) ? $postData['c_phone_o'] : '';
        $client['c_phone_r']        = !empty($postData['c_phone_r']) ? $postData['c_phone_r'] : '';
        $client['c_do']             = !empty($postData['c_do']) ? $postData['c_do'] : '';
        $client['c_docode']         = !empty($postData['c_docode']) ? $postData['c_docode'] : 0;
        $client['c_birth_date']     = !empty($postData['c_birth_date']) ? $postData['c_birth_date'] : '';
        $client['c_marriagedt']     = !empty($postData['c_marriagedt']) ? $postData['c_marriagedt'] : '';
        $client['c_reference_id']   = !empty($postData['c_reference_id']) ? $postData['c_reference_id'] : 0;
        $client['c_is_verified']    = !empty($postData['c_is_verified']) ? $postData['c_is_verified'] : 0;
        $client['c_mail_group_id']  = !empty($postData['c_mail_group_id']) ? $postData['c_mail_group_id'] : 0;
        $client['c_remark']         = !empty($postData['c_remark']) ? $postData['c_remark'] : '';
        $client['roles_id']         = !empty($postData['roles_id']) ? $postData['roles_id'] : 3;
        $client->save();

        
        $tblProduct = Product::where('productid',$postData['p_id'])->first();
        $cpRegDt    = date("Y-m-d");
        $cpLicenseExpDt = '';
        if(!empty($tblProduct)) {
            $cpLicenseExpDt = date('Y-m-d', strtotime($cpRegDt. ' + '.$tblProduct['demodays'].' days'));
        }
        
        // Client Product Insert ***************************************************
        $clientProduct                      = new TblClientProduct;
        $clientProduct['c_id']              = $client['c_id'];
        $clientProduct['p_id']              = $postData['p_id'];
        $clientProduct['cp_reg_dt']         = $cpRegDt;
        $clientProduct['cp_license_exp_dt'] = $cpLicenseExpDt;
        $clientProduct['cp_hddno']          = !empty($postData['cp_hddno']) ? $postData['cp_hddno'] : '';
        $clientProduct['cp_sitekey']        = !empty($postData['cp_sitekey']) ? $postData['cp_sitekey'] : '';
        $clientProduct['cp_licencekey']     = !empty($postData['cp_licencekey']) ? $postData['cp_licencekey'] : '';
        $clientProduct['cp_dealer_id']      = !empty($postData['cp_dealer_id']) ? $postData['cp_dealer_id'] : 0;
        $clientProduct['cp_dealer_name']    = !empty($postData['cp_dealer_name']) ? $postData['cp_dealer_name'] : '';
        $clientProduct['cp_uniqno']         = !empty($postData['cp_uniqno']) ? $postData['cp_uniqno'] : 0;
        $clientProduct['cp_password']       = !empty($postData['c_password']) ? app('hash')->make($postData['c_password']) : '';
        $clientProduct['cp_mobile_no']      = !empty($postData['c_mobile']) ? $postData['c_mobile'] : '';
        $clientProduct['cp_email']          = !empty($postData['c_email']) ? $postData['c_email'] : '';
        $clientProduct['cp_title']          = !empty($postData['cp_title']) ? $postData['cp_title'] : '';
        $clientProduct['cp_prch_dt']        = !empty($postData['cp_prch_dt']) ? $postData['cp_prch_dt'] : null;
        $clientProduct['cp_prch_price']     = !empty($postData['cp_prch_price']) ? $postData['cp_prch_price'] : '';
        $clientProduct['cp_sal_id']         = !empty($postData['cp_sal_id']) ? $postData['cp_sal_id'] : '';
        $clientProduct['cp_sal_by']         = !empty($postData['cp_sal_by']) ? $postData['cp_sal_by'] : '';
        $clientProduct['cp_surrender_date'] = !empty($postData['cp_surrender_date']) ? $postData['cp_surrender_date'] : null;
        $clientProduct['cp_is_surrender']   = !empty($postData['cp_is_surrender']) ? $postData['cp_is_surrender'] : 0;
        $clientProduct['cp_is_demo']        = !empty($postData['cp_is_demo']) ? $postData['cp_is_demo'] : 0;
        $clientProduct['roles_id']          = !empty($postData['roles_id']) ? $postData['roles_id'] : 3;
        $clientProduct->save();

        // License Log ***************************************************
        $clientLog                    = new ClientProductLicense;
        $clientLog['cp_id']           = $clientProduct['cp_id'];
        $clientLog['cpl_license_dt']  = $cpRegDt;
        $clientLog['cpl_exp_dt']      = $cpLicenseExpDt;
        $clientLog['cpl_sitekey']     = !empty($postData['cpl_sitekey']) ? $postData['cpl_sitekey'] : '';
        $clientLog['cpl_licencekey']  = !empty($postData['cpl_licencekey']) ? $postData['cpl_licencekey'] : '';
        $clientLog['cpl_is_verified'] = !empty($postData['cpl_is_verified']) ? $postData['cpl_is_verified'] : 0;
        $clientLog['cpl_type']        = !empty($postData['cpl_type']) ? $postData['cpl_type'] : '';
        $clientLog['cpl_remark']      = !empty($postData['cpl_remark']) ? $postData['cpl_remark'] : '';
        $clientLog->save();

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>[]]);
        }
    }

    public function deleteUsers(Request $request) {
        
        $postData    = $request->All();
        $tblClient   = TblClient::where('c_id',$postData['id'])->first();
        
        if(!empty($tblClient)) {
            $tblClient->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }

    public function getDemoClient(Request $request) {
        
        if(!empty($request['id'])) {
            $data = TblClient::with('tblClientProduct')->where('c_id',$request['id'])->where('c_type',"Demo")->first();
        } else {
            $data = TblClient::with('tblClientProduct')->where('c_type',"Demo")->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveDemoClient(Request $request) {
        
        $postData       = $request->All();
        $clientProduct  = TblClientProduct::where('c_id',$postData['id'])->first();

        if(!empty($clientProduct)) {
            $clientProduct['cp_demo_from_dt'] = $postData['from_date'];
            $clientProduct['cp_demo_to_dt']   = $postData['to_date'];
            $clientProduct->save();

            $clientProductLicense  = ClientProductLicense::where('cp_id',$clientProduct['cp_id'])->first();
            if(!empty($clientProductLicense)) {
                $clientProductLicense['cpl_demo_from_dt'] = $postData['from_date'];
                $clientProductLicense['cpl_demo_to_dt']   = $postData['to_date'];
                $clientProductLicense->save();
            }
        }

        return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>[]]);
    }
}

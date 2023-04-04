<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\LifeCellUsers\TblClient;
use App\Models\LifeCellUsers\OldTblClient;
use App\Models\LifeCellUsers\TblClientProduct;
use App\Models\LifeCellUsers\OldTblClientProduct;
use App\Models\LifeCellUsers\TblClientProductDevice;
use App\Models\LifeCellUsers\TblProduct;
use App\Models\LifeCellUsers\ClientProductLicense;
use App\Models\LifeCellUsers\ClientMenu;
use App\Models\LifeCellLic\ClientWiseMenuSetup;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\LifeCellLic\Product;
use App\Models\LifeCellLic\SetupPlan;
use App\Models\LifeCellLic\SetupGSTRate;
use App\Models\LifeCellLic\SetupServicingReports;
use App\Models\LifeCellLic\SetupReminder;
use App\Models\LifeCellLic\OldDataFile;
use App\Models\LifeCellLic\Country;
use App\Models\LifeCellLic\State;
use App\Models\LifeCellLic\District;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Area;
use App\Models\LifeCellLic\Bank;
use App\Models\LifeCellLic\Branch;
use App\Models\LifeCellLic\Dolic;
use App\Models\LifeCellLic\Family_group;
use App\Models\LifeCellLic\Agency;
use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Doctor;
use App\Models\LifeCellLic\Policy;



use App\Imports\ImportOldAreaData;
use App\Imports\ImportOldCasteData;
use App\Imports\ImportOldCountryData;
use App\Imports\ImportOldDOData;
use App\Imports\ImportOldSurNameData;
use App\Imports\ImportOldArticalsData;
use App\Imports\ImportOldStateData;
use App\Imports\ImportOldDistrictData;
use App\Imports\ImportOldCityData;
use App\Imports\ImportOldBankData;
use App\Imports\ImportOldBranchData;
use App\Imports\ImportOldDoctorData;
use App\Imports\ImportOldGroupData;
use App\Imports\ImportOldRelationData;
use App\Imports\ImportOldAgencyData;
use App\Imports\ImportOldPartyData;
use App\Imports\ImportOldPACodeData;
use App\Imports\ImportOldPaidByData;
use App\Imports\ImportOldStatusData;
use App\Imports\ImportOldCaptionData;
use App\Imports\ImportOldPolicyData;
use App\Imports\ImportOldControlData;
use App\Imports\ImportOldPartyWiseBankData;
use App\Imports\ImportOldLedgerData;
use App\Imports\ImportOldChmodData;
use App\Imports\ImportOldReligionData;
use App\Imports\ImportOldHistData;
use App\Imports\ImportOldSBDueData;
use App\Library\Lib;
use Excel;

class LoginApiController extends Controller
{
    public $lib;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lib = new Lib;
    }

    public function login(Request $request) {
        try {
            //Validation
            $validation['c_mobile']    = 'required';
            $validation['c_password']  = 'required';
            $validation['p_id']        = 'required';
            
            $postData = $request->All();
            $valid    = Validator::make($postData, $validation);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $tblClient = TblClient::where('c_mobile',$postData['c_mobile'])->first();
            if (empty($tblClient)) {
                return response()->json(["success" => 0, "msg" => "Mobile number is incorrect. Please try again.","data"=>[]]);
            } else {

                if (!Hash::check($postData['c_password'], $tblClient['c_password'])) {
                    return response()->json(["success" => 0, "msg" => "Password is incorrect. Please try again.","data"=>[]]);
                } else {
                    $tblClientProduct = TblClientProduct::where('c_id',$tblClient['c_id'])->where('p_id',$postData['p_id'])->first();
                    unset($tblClient['c_password']);

                    // Client Log ***************************************************
                    $clientLog                   = new TblClientProductDevice;
                    $clientLog['cp_id']          = !empty($tblClientProduct['cp_id']) ? $tblClientProduct['cp_id'] : '';
                    $clientLog['cp_imei']        = !empty($postData['imei']) ? $postData['imei'] : '';
                    $clientLog['cp_device_name'] = !empty($postData['device_name']) ? $postData['device_name'] : '';
                    $clientLog['cp_last_login']  = date("Y-m-d H:i:s");
                    $clientLog->save();

                    return response()->json(["success" => 1, "msg" => "login Successfully.","data"=>$tblClient]);
                }
            }

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function GenerateSerial() {
        $chars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $sn = '';
        $max = count($chars)-1;
        for($i=0;$i<20;$i++){
            $sn .= (!($i % 4) && $i ? '-' : '').$chars[rand(0, $max)];
        }
        return $sn;
    }

    public function login_web(Request $request) {
        try {
            $postData = $request->All();
            $path = base_path(). '/public/CL21085';
            $user_name = "pfigerftpuser";
            if(!file_exists($path)) {
                mkdir($path,0777,true);
            }


            // shell_exec('chmod -R 777 a.txt');

            
            // $api_key = '3603CB40158B48';
            // $contacts = '6352073225';
            // $from = 'PFIGER';
            // $template_id= '';
            // $sms_text = urlencode('Hello People, have a great day');

            // $api_url = "http://sms.hitechsms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;

            // //Submit to server
            
            if(!preg_match('#[^0-9]#',$postData['emailormobile'])) {
                $tblClient = TblClientProduct::where('cp_mobile_no',$postData['emailormobile'])->where('p_id',$postData['p_id'])->first();
                
                if(empty($tblClient)) {
                    return response()->json(["success" => 0, "msg" => "Mobile is incorrect. Please try again.","data"=>[]]);
                }
            } else {
                $tblClient = TblClientProduct::where('cp_email',$postData['emailormobile'])->where('p_id',$postData['p_id'])->first();
            }
            if (empty($tblClient)) {
                return response()->json(["success" => 0, "msg" => "Email is incorrect. Please try again.","data"=>[], 'path' => base_path()]);
            } else {

                if (!Hash::check($postData['password'], $tblClient['cp_password'])) {
                    return response()->json(["success" => 0, "msg" => "Password is incorrect. Please try again.","data"=>[]]);
                } else {
                    // To Block User To enter into software
                    // if($tblClient['cp_is_block'] == 1) {
                    //     return response()->json(["success" => 0, "msg" => "You will no longer be able to use","data"=>[]]);
                    // }
                    //$serial = $this->GenerateSerial() ;
                    $oldDataCheck = OldDataFile::where('client_id',$tblClient['old_client_id'])->first();
              
                    $tblClient['old_client_id'] = 1057;

                    //$theCollection = Excel::toCollection([],$request->file('file'));
                    // info(array_chunk($theCollection[0]->toArray(),5));
                

                    if(!empty($oldDataCheck) && $oldDataCheck['is_convert_data'] != 1) {
                       

                        //Old Area Data Add
                        if (file_exists(base_path().'/public/CL'.$tblClient['old_client_id'].'/AREA.CSV')) {
                            Excel::import(new ImportOldAreaData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/AREA.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/AREA.CSV');
                        }
                        //Old Caste Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/CASTE.CSV')) {
                            Excel::import(new ImportOldCasteData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/CASTE.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/CASTE.CSV');
                        }
                        //Old Country Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/COUNTRY.CSV')) {
                            Excel::import(new ImportOldCountryData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/COUNTRY.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/COUNTRY.CSV');
                        }
                        //Old DO Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/DO.CSV')) {
                            Excel::import(new ImportOldDOData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/DO.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/DO.CSV');
                        }
                        //Old Surname Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/SURNAME.CSV')) {
                            Excel::import(new ImportOldSurNameData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/SURNAME.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/SURNAME.CSV');
                        }
                        //Old Articals Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/ARTICALS.CSV')) {
                            Excel::import(new ImportOldArticalsData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/ARTICALS.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/ARTICALS.CSV');
                        }
                        $country_list = get_old_data(Country::class,$tblClient['old_client_id']);
                        //Old State Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATE.CSV')) {
                            Excel::import(new ImportOldStateData($tblClient['c_id'],$tblClient['old_client_id'],$country_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATE.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATE.CSV');
                        }
                        $state_list = get_old_data(State::class,$tblClient['old_client_id']);
                        //Old District Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/DISTRICT.CSV')) {
                            Excel::import(new ImportOldDistrictData($tblClient['c_id'],$tblClient['old_client_id'],$country_list,$state_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/DISTRICT.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/DISTRICT.CSV');
                        }

                        $districe_list = get_old_data(District::class,$tblClient['old_client_id']);

                        //Old City Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/CITY.CSV')) {
                            Excel::import(new ImportOldCityData($tblClient['c_id'],$tblClient['old_client_id'],$country_list,$state_list,$districe_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/CITY.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/CITY.CSV');
                        }
                        $city_list = get_old_data(City::class,$tblClient['old_client_id']);
                        //Old Bank Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/BANK.CSV')) {
                            Excel::import(new ImportOldBankData($tblClient['c_id'],$tblClient['old_client_id'],$city_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/BANK.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/BANK.CSV');
                        }
                        //Old Branch Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/BRANCH.CSV')) {
                            Excel::import(new ImportOldBranchData($tblClient['c_id'],$tblClient['old_client_id'],$city_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/BRANCH.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/BRANCH.CSV');
                        }
                        $area_list = get_old_data(Area::class,$tblClient['old_client_id']);
                        //Old Doctor Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/DOCTOR.CSV')) {
                            Excel::import(new ImportOldDoctorData($tblClient['c_id'],$tblClient['old_client_id'],$city_list,$area_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/DOCTOR.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/DOCTOR.CSV');
                        }
                        //Old Family Group Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/GROUP.CSV')) {
                            Excel::import(new ImportOldGroupData($tblClient['c_id'],$tblClient['old_client_id'],$city_list,$area_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/GROUP.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/GROUP.CSV');
                        }
                        //Old Relation Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELA.CSV')) {
                            Excel::import(new ImportOldRelationData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELA.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELA.CSV');
                        }
                        $bank_list = get_old_data(Bank::class,$tblClient['old_client_id']);
                        $branch_list = get_old_data(Branch::class,$tblClient['old_client_id']);
                        $do_list = get_old_data(Dolic::class,$tblClient['old_client_id']);
                        //Old Agency Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/AGENCY.CSV')) {
                            Excel::import(new ImportOldAgencyData($tblClient['c_id'],$tblClient['old_client_id'],$city_list,$bank_list,$branch_list,$do_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/AGENCY.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/AGENCY.CSV');
                        }

                        $family_group_list = get_old_data(Family_group::class,$tblClient['old_client_id']);
                        //Old Party Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/PARTY.CSV')) {
                            Excel::import(new ImportOldPartyData($tblClient['c_id'],$tblClient['old_client_id'],$city_list,$area_list,$family_group_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/PARTY.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/PARTY.CSV');
                        }
                        //Old P A Code Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/PACODE.CSV')) {
                            Excel::import(new ImportOldPACodeData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/PACODE.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/PACODE.CSV');
                        }
                        //Old PaidBy Code Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/PAIDBY.CSV')) {
                            Excel::import(new ImportOldPaidByData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/PAIDBY.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/PAIDBY.CSV');
                        }
                        //Old Status Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATUS.CSV')) {
                            Excel::import(new ImportOldStatusData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATUS.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/STATUS.CSV');
                        }
                        //Old Caption Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/CAPTION.CSV')) {
                            Excel::import(new ImportOldCaptionData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/CAPTION.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/CAPTION.CSV');
                        }
                        $agency_list = get_old_data(Agency::class,$tblClient['old_client_id']);
                        $party_list = get_old_data(Party::class,$tblClient['old_client_id']);
                        $doctor_list = get_old_data(Doctor::class,$tblClient['old_client_id']);
                        //Old Policy Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/POL.CSV')) {
                            Excel::import(new ImportOldPolicyData($tblClient['c_id'],$tblClient['old_client_id'],$agency_list,$party_list,$doctor_list,$bank_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/POL.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/POL.CSV');
                        }
                        //Old Control Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/CONTROL.CSV')) {
                            Excel::import(new ImportOldControlData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/CONTROL.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/CONTROL.CSV');
                        }
                        //Old Party Wise Bank Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/PRTWBNK.CSV')) {
                            Excel::import(new ImportOldPartyWiseBankData($tblClient['c_id'],$tblClient['old_client_id'],$party_list,$bank_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/PRTWBNK.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/PRTWBNK.CSV');
                        }
                        $policy_list = get_old_data(Policy::class,$tblClient['old_client_id']);
                        //Old Ledger Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/LEDGER.CSV')) {
                            Excel::import(new ImportOldLedgerData($tblClient['c_id'],$tblClient['old_client_id'],$policy_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/LEDGER.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/LEDGER.CSV');
                        }

                        /*Excel::filter('chunk')->load(base_path() . '/public/CL'.$tblClient['old_client_id'].'/LEDGER.CSV')->chunk(250, function($results) {
                            info($results);
                        });*/


                        //Old SB Due Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/SB_DUE.CSV')) {
                            Excel::import(new ImportOldSBDueData($tblClient['c_id'],$tblClient['old_client_id'],$policy_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/SB_DUE.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/SB_DUE.CSV');
                        }
                        //Old Chmod Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/CHMOD.CSV')) {
                            Excel::import(new ImportOldChmodData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/CHMOD.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/CHMOD.CSV');
                        }
                        //Old Religion Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELIGION.CSV')) {
                            Excel::import(new ImportOldReligionData($tblClient['c_id'],$tblClient['old_client_id']),base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELIGION.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/RELIGION.CSV');
                        }
                        //Old Hist Data Add
                        if (file_exists( base_path() . '/public/CL'.$tblClient['old_client_id'].'/HIST.CSV')) {
                            Excel::import(new ImportOldHistData($tblClient['c_id'],$tblClient['old_client_id'],$policy_list),base_path() . '/public/CL'.$tblClient['old_client_id'].'/HIST.CSV');
                            unlink(base_path() . '/public/CL'.$tblClient['old_client_id'].'/HIST.CSV');
                        }

                        $oldDataCheck['is_convert_data'] = 1;
                        $oldDataCheck->save();
                    }

                    unset($tblClient['cp_password']);

                    if($tblClient['is_first_login'] == 0) {
                        //default Client Wise Menu Add ***************************************************
                        $clientMenu = ClientMenu::where('product_id',$tblClient['p_id'])->get();
                        if(!empty($clientMenu) && count($clientMenu) > 0) {
                            $clientMenuData = [];
                            foreach($clientMenu as $key => $value) {
                                $clientMenuData[] = [
                                    'font_color'            => $value['font_color'],
                                    'back_color'            => $value['font_color'],
                                    'ordering'              => $value['ordering'],
                                    'quick_menu'            => $value['quick_menu'],
                                    'quick_menu_ordering'   => $value['quick_menu_ordering'],
                                    'menu_id'               => $value['id'],
                                    'client_id'             => $tblClient['c_id'],
                                ];
                            }
                            if (!empty($clientMenuData) && count($clientMenuData) > 0) {
                                ClientWiseMenuSetup::insert($clientMenuData);
                            }
                        }

                        $setUpPlan = SetupPlan::where('client_id',$tblClient['c_id'])->first();
                        if(empty($setUpPlan)) {
                            //default Plan Setup Record Add
                            $planInfo = new SetupPlan;
                            $planInfo['loan_relnv_rate']      = '11.00';
                            $planInfo['mb_relnv_rate']        = '15.00';
                            $planInfo['yield']                = 'No';
                            $planInfo['other_interest_rate']  = '7.00';
                            $planInfo['db_invest_rate']       = '9.50';
                            $planInfo['client_id']            = $tblClient['c_id'];
                            $planInfo->save();
                        }
                        
                        $setUpGSTRate = SetupGSTRate::where('client_id',$tblClient['c_id'])->first();
                        if(empty($setUpGSTRate)) {
                            //default GST Rate Setup Record Add
                            $GSTInfo = new SetupGSTRate;
                            $GSTInfo['from_date']       = '';
                            $GSTInfo['to_date']         = '';
                            $GSTInfo['gst_in_report']   = 'Yes';
                            $GSTInfo['gst_ann']         = '1.80%';
                            $GSTInfo['tax_ann_1']       = '0.050';
                            $GSTInfo['tax_ann_2']       = '0.050';
                            $GSTInfo['gst_term']        = '18.00%';
                            $GSTInfo['tax_term_1']      = '0.500';
                            $GSTInfo['tax_term_2']      = '0.500';
                            $GSTInfo['gst_risk_1']      = '4.500';
                            $GSTInfo['gst_risk_2']      = '2.250';
                            $GSTInfo['tax_risk_1']      = '0.125';
                            $GSTInfo['tax_risk_2']      = '0.125';
                            $GSTInfo['client_id']       = $tblClient['c_id'];
                            $GSTInfo->save();
                        }
                        
                        $setUpServicingReport = SetupServicingReports::where('client_id',$tblClient['c_id'])->first();
                        if(empty($setUpServicingReport)) {
                            //default Report Setup Record Add
                            $servicingInfo = new SetupServicingReports;
                            $servicingInfo['title']     = 'Pfiger Software Technolgoies';
                            $servicingInfo['address1']  = 'Software Devlopment & Consultant';
                            $servicingInfo['address2']  = '';
                            $servicingInfo['address3']  = 'Email : pfiger@gmail.com';
                            $servicingInfo['address4']  = 'Web : www.pfiger.com';
                            $servicingInfo['address5']  = '';
                            $servicingInfo['warning']   = 'These calculations are presently based on specific data feeding & are liable to revision / alterations according to Govt.policies.';
                            $servicingInfo['cap1']      = 'THERE IS NO SUBSTITUTE FOR LIFE INSURANCE';
                            $servicingInfo['cap2']      = 'INSURANCE TODAY FOR BETTER TOMORROW';
                            $servicingInfo['client_id'] = $tblClient['c_id'];
                            $servicingInfo->save();
                        }
                        
                        $setUpReminder = SetupReminder::where('client_id',$tblClient['c_id'])->first();
                        if(empty($setUpReminder)) {
                            //default Report Setup Record Add
                            $reminderInfo = new SetupReminder;
                            $reminderInfo['is_disable_reminder']  = 'No';
                            $reminderInfo['birthday_rm']          = 'Yes';
                            $reminderInfo['birthday_rm_bf']       = 15;
                            $reminderInfo['birthday_rm_af']       = 0;
                            $reminderInfo['agent_birthday_rm']    = 'Yes';
                            $reminderInfo['agent_birthday_rm_bf'] = 15;
                            $reminderInfo['agent_birthday_rm_af'] = 0;
                            $reminderInfo['marriage_ann_rm']      = 'Yes';
                            $reminderInfo['marriage_ann_rm_bf']   = 15;
                            $reminderInfo['marriage_ann_rm_af']   = 0;
                            $reminderInfo['fup_rm']               = 'Yes';
                            $reminderInfo['fup_rm_bf']            = 15;
                            $reminderInfo['fup_rm_af']            = 0;
                            $reminderInfo['term_insurance_rm']    = 'Yes';
                            $reminderInfo['term_insurance_rm_bf'] = 15;
                            $reminderInfo['term_insurance_rm_af'] = 0;
                            $reminderInfo['ulip_plan_rm']         = 'Yes';
                            $reminderInfo['ulip_plan_rm_bf']      = 15;
                            $reminderInfo['ulip_plan_rm_af']      = 0;
                            $reminderInfo['agency_expiry_rm']     = 'Yes';
                            $reminderInfo['agency_expiry_rm_bf']  = 15;
                            $reminderInfo['agency_expiry_rm_af']  = 0;
                            $reminderInfo['licence_expiry_rm']    = 'Yes';
                            $reminderInfo['licence_expiry_rm_bf'] = 15;
                            $reminderInfo['licence_expiry_rm_af'] = 0;
                            $reminderInfo['last_renew_rm']        = 'Yes';
                            $reminderInfo['last_renew_rm_bf']     = 15;
                            $reminderInfo['last_renew_rm_af']     = 0;
                            $reminderInfo['to_do_rm']             = 'No';
                            $reminderInfo['to_do_rm_bf']          = 0;
                            $reminderInfo['to_do_rm_af']          = 0;
                            $reminderInfo['health_plan_rm']       = 'No';
                            $reminderInfo['health_plan_rm_bf']    = 0;
                            $reminderInfo['health_plan_rm_af']    = 0;
                            $reminderInfo['maturity_rm']          = 'No';
                            $reminderInfo['maturity_rm_bf']       = 0;
                            $reminderInfo['maturity_rm_af']       = 0;
                            $reminderInfo['money_back_rm']        = 'No';
                            $reminderInfo['money_back_rm_bf']     = 0;
                            $reminderInfo['money_back_rm_af']     = 0;
                            $reminderInfo['client_id']            = $tblClient['c_id'];
                            $reminderInfo->save();
                        }
                        
                    }

                    $tblClient['is_first_login'] = 1;
                    $tblClient->save();

                    return response()->json(["success" => 1, "msg" => "login Successfully.","data"=>$tblClient]);
                }
            }

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function register(Request $request) {
        try {
            // $api_key = '3603CB40158B48';
            // $contacts = '6352073225';
            // $from = 'PFIGER';
            // $template_id= '';
            // $sms_text = urlencode('Hello People, have a great day');

            // $api_url = "http://sms.hitechsms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
            
            //Validation
            $postData = $request->All();
            if($request['p_id'] == 6) {
                $validation['c_name']       = 'required';
                // $validation['c_mobile']     = 'required|unique:lifecell_users.tbl_client_product,cp_mobile_no';
                $validation['c_mobile']     = 'required';
                // $validation['c_email']      = 'required|email|unique:lifecell_users.tbl_client_product,cp_email';
                $validation['c_email']      = 'required|email';
                $validation['c_city_id']    = 'required';
                $validation['c_type']       = 'required';
                $validation['c_password']   = 'required';
                
                //Validation Message
                $messages['c_name.required']      = "The name field is required.";
                $messages['c_mobile.required']    = "The mobile field is required.";
                //$messages['c_mobile.unique']      = "The mobile has already been taken.";
                $messages['c_email.required']     = "The email field is required.";
                $messages['c_email.email']        = "The email must be a valid email address.";
                //$messages['c_email.unique']       = "The email has already been taken.";
                $messages['c_city_id.required']   = "The city field is required.";
                $messages['c_type.required']      = "The type field is required.";
                $messages['c_password.required']  = "The password field is required.";
                
                $postData = $request->All();
                $valid    = Validator::make($postData, $validation, $messages);

                if (!empty($valid->fails())) {
                    return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
                }
            } else {
                $postData = $request->All();
            }

            //add new client registerr
            $clientProduct = $this->addNewClientRegister($postData);

            unset($clientProduct['cp_password']);
            return response()->json(["success" => 1, "msg" => "Registered Successfully.","data"=>$clientProduct]);

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function getProfile(Request $request) {
        try {
            //Validation
            $validation['c_id']  = 'required';
            //Validation Message
            $messages['c_id.required'] = "The Client ID is required.";

            $postData = $request->All();
            $valid    = Validator::make($postData, $validation, $messages);
            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $client = TblClient::where("c_id", $postData['c_id'])->first();
            if (empty($client)) {
                return response()->json(["success" => 0, "msg" => "Client Id Wrong.","data"=>[]]);

                //return response()->json(["success" => 0, "msg" => "Your account may be logged in from other device or deactivated, please try to login again.","data"=>[]]);
            }
            unset($client['c_password']);
            return response()->json(["success" => 1, "msg" => "Success","data"=>$client]);

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function updateProfile(Request $request) {
        try {
            //Validation
            $validation['c_id']  = 'required';
            //Validation Message
            $messages['c_id.required'] = "The Client ID is required.";

            $postData = $request->All();
            $valid    = Validator::make($postData, $validation, $messages);
            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            $client = TblClient::where("c_id", $postData['c_id'])->first();
            if (empty($client)) {
                return response()->json(["success" => 0, "msg" => "Client Id Wrong.","data"=>[]]);
            } else {
                $client->update($postData);

                unset($client['c_password']);
                return response()->json(["success" => 1, "msg" => "Profile Updated Successfully","data"=>$client]);
            }

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function forgotPassword(Request $request) {
        try {
            if(!preg_match('#[^0-9]#',$request['c_email'])) {
                //Validation
                $validation['c_email']  = 'required';
                //Validation Message
                $messages['c_email.required']     = "The emailormobile field is required.";
            } else {
                //Validation
                $validation['c_email']  = 'required|email';
                //Validation Message
                $messages['c_email.required']     = "The email field is required.";
                $messages['c_email.email']        = "The email must be a valid email address.";
            }

            $postData = $request->All();
            $valid    = Validator::make($postData, $validation, $messages);

            if (!empty($valid->fails())) {
                return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
            }

            if(!preg_match('#[^0-9]#',$request['c_email'])) {
                $client = TblClientProduct::where("cp_mobile_no", $postData['c_email'])->where('p_id',$postData['p_id'])->first();
                if (empty($client)) {
                    return response()->json(["success" => 0, "msg" => "Invalid Mobile number.","data"=>[]]);
                }
            } else {
                $client = TblClientProduct::where("cp_email", $postData['c_email'])->where('p_id',$postData['p_id'])->first();
            }
            
            if (empty($client)) {
                return response()->json(["success" => 0, "msg" => "Invalid email address.","data"=>[]]);
            } else {
                $pass = str_random(8);
                \Log::info($pass);
                $client->cp_password = app('hash')->make($pass);
                $client->save();

                $clientDdata = TblClient::where("c_id", $client['c_id'])->first();
                $clientDdata->c_password = $client['cp_password'];
                $clientDdata->save();
                                
                $to       = $postData['c_email'];
                $subject  = 'Forget Password';
                $mailcontent = "Dear <b>" .$clientDdata['c_name']."</b>, <p>You have requested to reset your password. Please use the password <b>" .$pass. "</b> to log in. After log in, please go to Profile page to change your password.</p>";
                $data     = array('content' => $mailcontent);
                Mail::send('forgetpasswordemail', $data, function($message) use ($to,$subject) {
                    $message->to($to)->subject($subject);
                    $message->from('moneycarts.pfiger@gmail.com','Pfiger Software Technolgoies');
                });

                return response()->json(["success" => 1, "msg" => "A new password has been sent to your registered email address.","data"=>[]]);
            }

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }

    public function checkExistingClient(Request $request) {
        
        $checkClient = TblClientProduct::where('old_client_id',$request['c_id'])->where('p_id',$request['p_id'])->orderBy('cp_id', 'DESC')->first();

        //if client not found in new client data then add old client to new clientdata
        if(empty($checkClient)) {
            $this->addOldClientToNewClient($request['c_id'],$request['p_id']);
        }
        
        $client = TblClientProduct::where('old_client_id',$request['c_id'])->where('p_id',$request['p_id'])->orderBy('cp_id', 'DESC')->first();
        
        if(!empty($client)) {
            
            // if old_client_id = client_id and productid = productid and hddno = hddno and surrender = 0 ()
            // send license key encrypted 
            if($client['cp_hddno'] == $request['hddno'] && $client['cp_is_surrender'] == 0) {
                $response = "success:1"."|"."msg:This Case Of Format HDD"."|"."product_id:".$client['p_id']."|"."client_id:".$client['c_id']."|"."client_type:".$client['cp_type']."|"."next_due:".$client['cp_license_exp_dt']."|"."title:".$client['cp_title']."|"."features:".$client['cp_features']."|"."stop_dt:".$client['cp_stopdt']."|"."old_client_id:".$client['old_client_id'];
                
                return $this->Encrypt($response);
                //$encrypt = $this->Encrypt($response);
                //return $this->Decrypt($encrypt);+
            }

            // if old_client_id = client_id and productid = productid and hddno != hddno and surrender = 0 (diffrent system)
            // desktop software already exist in other system
            if($client['cp_hddno'] != $request['hddno'] && $client['cp_is_surrender'] == 0) {
                $response = "success:2"."|"."msg:This Case Of Desktop Software Already Exist In Other System"."|"."product_id:".$client['p_id']."|"."client_id:".$client['c_id']."|"."client_type:".$client['cp_type']."|"."next_due:".$client['cp_license_exp_dt']."|"."title:".$client['cp_title']."|"."features:".$client['cp_features']."|"."stop_dt:".$client['cp_stopdt']."|"."old_client_id:".$client['old_client_id'];
                
                return $this->Encrypt($response);
            }

            // if old_client_id = client_id and productid = productid and hddno != hddno and surrender = 1
            // send license key encrypted
            // add new record hddno in tbl_client_product and client_product_license
            if($client['cp_hddno'] != $request['hddno'] && $client['cp_is_surrender'] == 1) {

                $setClientProductLicense = ClientProductLicense::where('cp_id',$client['cp_id'])->orderBy('cpl_id', 'DESC')->first();
                
                // Client Product ***************************************************
                $client['cp_hddno']          = $request['hddno'];
                $client['cp_surrender_date'] = null;
                $client['cp_is_surrender']   = 0;
                $clientProduct = $this->addNewClientProductData($client);
                
                // Client Product License ***************************************************
                $setClientProductLicenseData['cp_id'] = $clientProduct['cp_id'];
                $clientProductLicense = $this->addNewClientProductLicenseData($setClientProductLicenseData);

                $response = "success:2"."|"."msg:This Case Of Client Trying To Install Lifeplus In Another PC"."|"."product_id:".$client['p_id']."|"."client_id:".$client['c_id']."|"."client_type:".$client['cp_type']."|"."next_due:".$client['cp_license_exp_dt']."|"."title:".$client['cp_title']."|"."features:".$client['cp_features']."|"."stop_dt:".$client['cp_stopdt']."|"."old_client_id:".$client['old_client_id'];
                
                return $this->Encrypt($response);
            }
        } else {
            
            //if client not found in new client table and old client table then add new client record
            $postData      = $request->all();
            $clientProduct = $this->addNewClientRegister($postData);

            $response = "success:1"."|"."msg:This Is Demo Case"."|"."product_id:".$clientProduct['p_id']."|"."client_id:".$clientProduct['c_id']."|"."client_type:".$clientProduct['cp_type']."|"."next_due:".$clientProduct['cp_license_exp_dt']."|"."title:".$clientProduct['cp_title']."|"."features:".$clientProduct['cp_features']."|"."stop_dt:".$clientProduct['cp_stopdt']."|"."old_client_id:".$clientProduct['old_client_id']."|"."is_demo:".$clientProduct['cp_is_demo']."|"."end_demo_date:".$clientProduct['cp_license_exp_dt'];
                
            return $this->Encrypt($response);
        }
    }

    public function clientLicenseSurrender(Request $request) {
        $client = TblClientProduct::where('old_client_id',$request['c_id'])->where('p_id',$request['p_id'])->where('cp_hddno',$request['hddno'])->orderBy('cp_id', 'DESC')->first();
        if(!empty($client)) {
            $client['cp_surrender_date'] = date('Y-m-d');
            $client['cp_is_surrender']   = 1;
            $client->save();

            $response = "success:1"."|"."msg:Surrender Successfully"."|"."product_id:".$client['p_id']."|"."client_id:".$client['c_id']."|"."client_type:".$client['cp_type']."|"."next_due:".$client['cp_license_exp_dt']."|"."title:".$client['cp_title']."|"."features:".$client['cp_features']."|"."stop_dt:".$client['cp_stopdt']."|"."old_client_id:".$client['old_client_id']."|"."is_surrender:".$client['cp_is_surrender']."|"."surrender_date:".$client['cp_surrender_date'];

            return $this->Encrypt($response);
        }
        $response = "success:0"."|"."msg:Client Not Found";
        return $this->Encrypt($response);
    }

    public function clientProductPayment(Request $request) {
        $client = TblClientProduct::where('old_client_id',$request['c_id'])->where('p_id',$request['p_id'])->where('cp_hddno',$request['hddno'])->orderBy('cp_id', 'DESC')->first();
        if(!empty($client)) {
            $client['cp_reg_dt']           = date('Y-m-d');
            $client['cp_license_exp_dt']   = date('Y-m-d');
            $client->save();

            $clientProductPayment                   = new TblClientProductPayment;
            $clientProductPayment['c_id']           = $client['c_id'];
            $clientProductPayment['cp_id']          = $client['cp_id'];
            $clientProductPayment['p_id']           = $client['p_id'];
            $clientProductPayment['device_id']      = !empty($request['device_id']) ? $request['device_id'] : '';
            $clientProductPayment['new_licence']    = !empty($request['new_licence']) ? $request['new_licence'] : '';
            $clientProductPayment['renew_licence']  = !empty($request['renew_licence']) ? $request['renew_licence'] : '';
            $clientProductPayment['amount']         = !empty($request['amount']) ? $request['amount'] : '';
            $clientProductPayment['tr_dt']          = !empty($request['tr_dt']) ? $request['tr_dt'] : '';
            $clientProductPayment['sales_dt']       = !empty($request['sales_dt']) ? $request['sales_dt'] : '';
            $clientProductPayment['dealer_id']      = !empty($request['dealer_id']) ? $request['dealer_id'] : '';
            $clientProductPayment['old_due_dt']     = date('Y-m-d');
            $clientProductPayment['new_due_dt']     = date('Y-m-d');
            $clientProductPayment->save();

            $response = "success:1"."|"."msg:Payment Successfully"."|"."product_id:".$client['p_id']."|"."client_id:".$client['c_id']."|"."client_type:".$client['cp_type']."|"."next_due:".$client['cp_license_exp_dt']."|"."title:".$client['cp_title']."|"."features:".$client['cp_features']."|"."stop_dt:".$client['cp_stopdt']."|"."old_client_id:".$client['old_client_id'];

            return $this->Encrypt($response);
        }
        $response = "success:0"."|"."msg:Client Not Found";
        return $this->Encrypt($response);
    }

    public function addNewClientRegister($postData) {
        // Client Insert ***************************************************
        $setClientData = [
            'c_name'            => !empty($postData['c_name']) ? $postData['c_name'] : '',
            'c_mobile'          => !empty($postData['c_mobile']) ? $postData['c_mobile'] : '',
            'c_email'           => !empty($postData['c_email']) ? $postData['c_email'] : '',
            'c_password'        => !empty($postData['c_password']) ? Hash::make($postData['c_password']) : '',
            'c_city_id'         => !empty($postData['c_city_id']) ? $postData['c_city_id'] : 0,
            'c_type'            => !empty($postData['c_type']) ? $postData['c_type'] : 'DO',
            'c_agt_ad1'         => !empty($postData['c_agt_ad1']) ? $postData['c_agt_ad1'] : '',
            'c_agt_ad2'         => !empty($postData['c_agt_ad2']) ? $postData['c_agt_ad2'] : '',
            'c_agt_ad3'         => !empty($postData['c_agt_ad3']) ? $postData['c_agt_ad3'] : '',
            'c_branch_id'       => !empty($postData['c_branch_id']) ? $postData['c_branch_id'] : 0,
            'c_country_id'      => !empty($postData['c_country_id']) ? $postData['c_country_id'] : 0,
            'c_state_id'        => !empty($postData['c_state_id']) ? $postData['c_state_id'] : 0,
            'c_pin'             => !empty($postData['c_pin']) ? $postData['c_pin'] : '',
            'c_phone_o'         => !empty($postData['c_phone_o']) ? $postData['c_phone_o'] : '',
            'c_phone_r'         => !empty($postData['c_phone_r']) ? $postData['c_phone_r'] : '',
            'c_do'              => !empty($postData['c_do']) ? $postData['c_do'] : '',
            'c_docode'          => !empty($postData['c_docode']) ? $postData['c_docode'] : 0,
            'c_birth_date'      => !empty($postData['c_birth_date']) ? $postData['c_birth_date'] : null,
            'c_marriagedt'      => !empty($postData['c_marriagedt']) ? $postData['c_marriagedt'] : null,
            'c_reference_id'    => !empty($postData['c_reference_id']) ? $postData['c_reference_id'] : 0,
            'c_is_verified'     => !empty($postData['c_is_verified']) ? $postData['c_is_verified'] : 0,
            'c_mail_group_id'   => !empty($postData['c_mail_group_id']) ? $postData['c_mail_group_id'] : 0,
            'c_remark'          => !empty($postData['c_remark']) ? $postData['c_remark'] : '',
            'roles_id'          => !empty($postData['roles_id']) ? $postData['roles_id'] : 3,
            'old_client_id'     => 0,
        ];

        $client = $this->addNewClientData($setClientData);
        
        $tblProduct = Product::where('productid',$postData['p_id'])->first();
        $cpRegDt    = date("Y-m-d");
        $cpLicenseExpDt = '';
        if(!empty($tblProduct)) {
            $cpLicenseExpDt = date('Y-m-d', strtotime($cpRegDt. ' + '.$tblProduct['demodays'].' days'));
        }

        // Client Product Insert ***************************************************
        $setClientProductData = [
            'c_id'              => $client['c_id'],
            'p_id'              => !empty($postData['p_id']) ? $postData['p_id'] : '',
            'cp_reg_dt'         => $cpRegDt,
            'cp_license_exp_dt' => $cpLicenseExpDt,
            'cp_hddno'          => !empty($postData['cp_hddno']) ? $postData['cp_hddno'] : '',
            'cp_sitekey'        => !empty($postData['cp_sitekey']) ? $postData['cp_sitekey'] : '',
            'cp_licencekey'     => !empty($postData['cp_licencekey']) ? $postData['cp_licencekey'] : '',
            'cp_dealer_id'      => !empty($postData['cp_dealer_id']) ? $postData['cp_dealer_id'] : 0,
            'cp_dealer_name'    => !empty($postData['cp_dealer_name']) ? $postData['cp_dealer_name'] : '',
            'cp_uniqno'         => !empty($postData['cp_uniqno']) ? $postData['cp_uniqno'] : 0,
            'cp_password'       => !empty($postData['c_password']) ? $postData['c_password'] : '',
            'cp_mobile_no'      => $client['c_mobile'],
            'cp_email'          => $client['c_email'],
            'cp_title'          => !empty($postData['cp_title']) ? $postData['cp_title'] : '',
            'cp_prch_dt'        => !empty($postData['cp_prch_dt']) ? $postData['cp_prch_dt'] : null,
            'cp_prch_price'     => !empty($postData['cp_prch_price']) ? $postData['cp_prch_price'] : '',
            'cp_surrender_date' => null,
            'cp_is_surrender'   => 0,
            'cp_is_demo'        => 1,
            'cp_type'           => $client['c_type'],
            'cp_user_type'      => !empty($postData['cp_user_type']) ? $postData['cp_user_type'] : 1,
            'cp_stopdt'         => !empty($postData['cp_stopdt']) ? $postData['cp_stopdt'] : null,
            'cp_payment'        => !empty($postData['cp_payment']) ? $postData['cp_payment'] : '',
            'cp_sales_amt'      => !empty($postData['cp_sales_amt']) ? $postData['cp_sales_amt'] : '',
            'cp_sales_mrp'      => !empty($postData['cp_sales_mrp']) ? $postData['cp_sales_mrp'] : '',
            'cp_reason'         => !empty($postData['cp_reason']) ? $postData['cp_reason'] : '',
            'cp_device_type'    => !empty($postData['cp_device_type']) ? $postData['cp_device_type'] : '',
            'cp_imei'           => !empty($postData['cp_imei']) ? $postData['cp_imei'] : '',
            'roles_id'          => !empty($postData['roles_id']) ? $postData['roles_id'] : 3,
            'cp_features'       => 0,
            'old_client_id'     => 0,
        ];

        $clientProduct = $this->addNewClientProductData($setClientProductData);

        // Client Product License Insert ***************************************************
        $setClientProductLicenseData = [
            'cp_id'             => $clientProduct['cp_id'],
            'cpl_license_dt'    => $clientProduct['cp_reg_dt'],
            'cpl_exp_dt'        => $clientProduct['cp_license_exp_dt'],
            'cpl_is_demo'       => $clientProduct['cp_is_demo'],
            'cpl_renew_price'   => $clientProduct['cp_prch_price'],
            'cpl_sitekey'       => $clientProduct['cp_sitekey'],
            'cpl_licencekey'    => $clientProduct['cp_licencekey'],
            'cpl_remark'        => !empty($postData['cpl_remark']) ? $postData['cpl_remark'] : '',
            'cpl_licissuedt'    => null,
        ];

        $clientProductLicense = $this->addNewClientProductLicenseData($setClientProductLicenseData);

        return $clientProduct;
    }

    public function addOldClientToNewClient($oldClientId,$productid) {
        $oldClient = OldTblClient::where('clientid',$oldClientId)->first();

        if(!empty($oldClient)) {
            //add new record in client table
            $setClientData = [
                'c_name'            => !empty($oldClient['client']) ? $oldClient['client'] : '',
                'c_mobile'          => !empty($oldClient['mobile']) ? $oldClient['mobile'] : '',
                'c_email'           => !empty($oldClient['e_mail']) ? $oldClient['e_mail'] : '',
                'c_password'        => !empty($oldClient['c_password']) ? Hash::make($oldClient['c_password']) : '',
                'c_city_id'         => !empty($oldClient['cityid']) ? $oldClient['cityid'] : 0,
                'c_type'            => !empty($oldClient['progfor']) ? $oldClient['progfor'] : 'DO',
                'c_agt_ad1'         => !empty($oldClient['agt_ad1']) ? $oldClient['agt_ad1'] : '',
                'c_agt_ad2'         => !empty($oldClient['agt_ad2']) ? $oldClient['agt_ad2'] : '',
                'c_agt_ad3'         => !empty($oldClient['agt_ad3']) ? $oldClient['agt_ad3'] : '',
                'c_branch_id'       => !empty($oldClient['branchid']) ? $oldClient['branchid'] : 0,
                'c_country_id'      => !empty($oldClient['countryid']) ? $oldClient['countryid'] : 0,
                'c_state_id'        => !empty($oldClient['stateid']) ? $oldClient['stateid'] : 0,
                'c_pin'             => !empty($oldClient['pin']) ? $oldClient['pin'] : '',
                'c_phone_o'         => !empty($oldClient['phone_o']) ? $oldClient['phone_o'] : '',
                'c_phone_r'         => !empty($oldClient['phone_r']) ? $oldClient['phone_r'] : '',
                'c_do'              => !empty($oldClient['do']) ? $oldClient['do'] : '',
                'c_docode'          => !empty($oldClient['docode']) ? $oldClient['docode'] : 0,
                'c_birth_date'      => (!empty($oldClient['birth_date']) && $oldClient['birth_date'] != '/  /') ? date('Y-m-d', strtotime(strtr($oldClient['birth_date'], '/', '-'))) : null,
                'c_marriagedt'      => (!empty($oldClient['marriagedt']) && $oldClient['marriagedt'] != '/  /') ? date('Y-m-d', strtotime(strtr($oldClient['marriagedt'], '/', '-'))) : null,
                'c_reference_id'    => !empty($oldClient['reference_id']) ? $oldClient['reference_id'] : 0,
                'c_is_verified'     => !empty($oldClient['c_is_verified']) ? $oldClient['c_is_verified'] : 0,
                'c_mail_group_id'   => !empty($oldClient['c_mail_group_id']) ? $oldClient['c_mail_group_id'] : 0,
                'c_remark'          => !empty($oldClient['remarks']) ? $oldClient['remarks'] : '',
                'roles_id'          => !empty($oldClient['roles_id']) ? $oldClient['roles_id'] : 1,
                'old_client_id'     => $oldClientId,
            ];

            $client = $this->addNewClientData($setClientData);
            
            $oldProductId = 0;
            if($productid == 1) {
                $oldProductId = 3; //LIFEPLUS
            } else if($productid == 2) {
                $oldProductId = 1; //BACHAT
            } else if($productid == 3) {
                $oldProductId = 5; //GI
            } else if($productid == 4) {
                $oldProductId = 4; //SPEED
            }

            $oldClientProduct = OldTblClientProduct::where('clientid',$oldClientId)->where('productid',$oldProductId)->get();
            if(!empty($oldClientProduct) && count($oldClientProduct) > 0) {
                foreach($oldClientProduct as $key => $value) {
                    $userType = 1;
                    if(!empty($value['progfor'])) {
                        if(strtolower($value['progfor']) == 'do') {
                            $userType = 2;
                        }
                    }
                    //add new record in client Product table
                    $setClientProductData = [
                        'c_id'              => $client['c_id'],
                        'p_id'              => !empty($productid) ? $productid : 0,
                        'cp_reg_dt'         => (!empty($value['prch_dt']) && $value['prch_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($value['prch_dt'], '/', '-'))) : null,
                        'cp_license_exp_dt' => (!empty($value['next_due']) && $value['next_due'] != '/  /') ? date('Y-m-d', strtotime(strtr($value['next_due'], '/', '-'))) : null,
                        'cp_hddno'          => !empty($value['hddno1']) ? $value['hddno1'] : '',
                        'cp_sitekey'        => !empty($value['sitekey']) ? $value['sitekey'] : '',
                        'cp_licencekey'     => !empty($value['licencekey']) ? $value['licencekey'] : '',
                        'cp_dealer_id'      => !empty($value['dealerid']) ? $value['dealerid'] : 0,
                        'cp_dealer_name'    => !empty($value['dealer']) ? $value['dealer'] : '',
                        'cp_uniqno'         => !empty($value['uniqno']) ? $value['uniqno'] : 0,
                        'cp_password'       => $client['c_password'],
                        'cp_mobile_no'      => $client['c_mobile'],
                        'cp_email'          => $client['c_email'],
                        'cp_title'          => !empty($value['ltitle']) ? $value['ltitle'] : '',
                        'cp_prch_dt'        => (!empty($value['prch_dt']) && $value['prch_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($value['prch_dt'], '/', '-'))) : null,
                        'cp_prch_price'     => !empty($value['yly_amt']) ? $value['yly_amt'] : '',
                        'cp_surrender_date' => null,
                        'cp_is_surrender'   => 0,
                        'cp_is_demo'        => 0,
                        'cp_type'           => !empty($value['progfor']) ? $value['progfor'] : '',
                        'cp_user_type'      => $userType,
                        'cp_stopdt'         => (!empty($value['stopdt']) && $value['stopdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($value['stopdt'], '/', '-'))) : null,
                        'cp_payment'        => !empty($value['payment']) ? $value['payment'] : '',
                        'cp_sales_amt'      => !empty($value['sales_amt']) ? $value['sales_amt'] : '',
                        'cp_sales_mrp'      => !empty($value['sales_mrp']) ? $value['sales_mrp'] : '',
                        'cp_reason'         => !empty($value['reason']) ? $value['reason'] : '',
                        'cp_device_type'    => !empty($value['mobmodel']) ? $value['mobmodel'] : '',
                        'cp_imei'           => '',
                        'roles_id'          => !empty($value['roles_id']) ? $value['roles_id'] : 1,
                        'cp_features'       => 0,
                        'old_client_id'     => $oldClientId,
                    ];

                    $clientProduct = $this->addNewClientProductData($setClientProductData);

                    //add new record in client Product License table
                    $setClientProductLicenseData = [
                        'cp_id'             => $clientProduct['cp_id'],
                        'cpl_license_dt'    => $clientProduct['cp_reg_dt'],
                        'cpl_exp_dt'        => $clientProduct['cp_license_exp_dt'],
                        'cpl_is_demo'       => $clientProduct['cp_is_demo'],
                        'cpl_renew_price'   => $clientProduct['cp_prch_price'],
                        'cpl_sitekey'       => $clientProduct['cp_sitekey'],
                        'cpl_licencekey'    => $clientProduct['cp_licencekey'],
                        'cpl_remark'        => !empty($value['remarks']) ? $value['remarks'] : '',
                        'cpl_licissuedt'    => (!empty($value['licissuedt']) && $value['licissuedt'] != '/  /') ? date('Y-m-d', strtotime(strtr($value['licissuedt'], '/', '-'))) : null,
                    ];

                    $clientProductLicense = $this->addNewClientProductLicenseData($setClientProductLicenseData);
                }
            }
        }
    }

    //Client table insert
    public function addNewClientData($param) {
        if(!empty($param)) {
            $OTP = rand(111111,999999);

            /*-- Send OTP Verify Message Start --*/
            $smsData = [
                "MobileNumber" => !empty($param['c_mobile']) ? $param['c_mobile'] : '',
                "otp"         => $OTP
            ];
            $sendOTPVerificationCode = $this->lib->sendSmsNew($smsData);
            //$response = sendSmsNew($smsData);
            /*-- Send OTP Verify Message Stop --*/
            // Client Insert ***************************************************
            $client                     = new TblClient;
            $client['c_name']           = !empty($param['c_name']) ? $param['c_name'] : '';
            $client['c_mobile']         = !empty($param['c_mobile']) ? $param['c_mobile'] : '';
            $client['c_email']          = !empty($param['c_email']) ? $param['c_email'] : '';
            $client['c_password']       = !empty($param['c_password']) ? Hash::make($param['c_password']) : '';
            $client['c_city_id']        = !empty($param['c_city_id']) ? $param['c_city_id'] : 0;
            $client['c_type']           = !empty($param['c_type']) ? $param['c_type'] : 'DO';
            $client['c_agt_ad1']        = !empty($param['c_agt_ad1']) ? $param['c_agt_ad1'] : '';
            $client['c_agt_ad2']        = !empty($param['c_agt_ad2']) ? $param['c_agt_ad2'] : '';
            $client['c_agt_ad3']        = !empty($param['c_agt_ad3']) ? $param['c_agt_ad3'] : '';
            $client['c_branch_id']      = !empty($param['c_branch_id']) ? $param['c_branch_id'] : 0;
            $client['c_country_id']     = !empty($param['c_country_id']) ? $param['c_country_id'] : 0;
            $client['c_state_id']       = !empty($param['c_state_id']) ? $param['c_state_id'] : 0;
            $client['c_pin']            = !empty($param['c_pin']) ? $param['c_pin'] : '';
            $client['c_phone_o']        = !empty($param['c_phone_o']) ? $param['c_phone_o'] : '';
            $client['c_phone_r']        = !empty($param['c_phone_r']) ? $param['c_phone_r'] : '';
            $client['c_do']             = !empty($param['c_do']) ? $param['c_do'] : '';
            $client['c_docode']         = !empty($param['c_docode']) ? $param['c_docode'] : 0;
            $client['c_birth_date']     = !empty($param['c_birth_date']) ? $param['c_birth_date'] : null;
            $client['c_marriagedt']     = !empty($param['c_marriagedt']) ? $param['c_marriagedt'] : null;
            $client['c_reference_id']   = !empty($param['c_reference_id']) ? $param['c_reference_id'] : 0;
            $client['c_is_verified']    = !empty($param['c_is_verified']) ? $param['c_is_verified'] : 0;
            $client['c_mail_group_id']  = !empty($param['c_mail_group_id']) ? $param['c_mail_group_id'] : 0;
            $client['c_remark']         = !empty($param['c_remark']) ? $param['c_remark'] : '';
            $client['roles_id']         = !empty($param['roles_id']) ? $param['roles_id'] : 3;
            $client['old_client_id']    = !empty($param['old_client_id']) ? $param['old_client_id'] : 0;
            $client['c_otp']    = $OTP;
            $client['c_is_otp_verified']    = 0;
            $client->save();
            return $client;
        }
    }

    //Client Product table insert
    public function addNewClientProductData($param) {
        if(!empty($param)) {
            // Client Product Insert ***************************************************
            $clientProduct                      = new TblClientProduct;
            $clientProduct['c_id']              = !empty($param['c_id']) ? $param['c_id'] : 0;
            $clientProduct['p_id']              = !empty($param['p_id']) ? $param['p_id'] : '';
            $clientProduct['cp_reg_dt']         = !empty($param['cp_reg_dt']) ? $param['cp_reg_dt'] : null;
            $clientProduct['cp_license_exp_dt'] = !empty($param['cp_license_exp_dt']) ? $param['cp_license_exp_dt'] : null;
            $clientProduct['cp_hddno']          = !empty($param['cp_hddno']) ? $param['cp_hddno'] : '';
            $clientProduct['cp_sitekey']        = !empty($param['cp_sitekey']) ? $param['cp_sitekey'] : '';
            $clientProduct['cp_licencekey']     = !empty($param['cp_licencekey']) ? $param['cp_licencekey'] : '';
            $clientProduct['cp_dealer_id']      = !empty($param['cp_dealer_id']) ? $param['cp_dealer_id'] : 0;
            $clientProduct['cp_dealer_name']    = !empty($param['cp_dealer_name']) ? $param['cp_dealer_name'] : '';
            $clientProduct['cp_uniqno']         = !empty($param['cp_uniqno']) ? $param['cp_uniqno'] : 0;
            $clientProduct['cp_password']       = !empty($param['cp_password']) ? Hash::make($param['cp_password']) : '';
            $clientProduct['cp_mobile_no']      = !empty($param['cp_mobile_no']) ? $param['cp_mobile_no'] : '';
            $clientProduct['cp_email']          = !empty($param['cp_email']) ? $param['cp_email'] : '';
            $clientProduct['cp_title']          = !empty($param['cp_title']) ? $param['cp_title'] : '';
            $clientProduct['cp_prch_dt']        = !empty($param['cp_prch_dt']) ? $param['cp_prch_dt'] : null;
            $clientProduct['cp_prch_price']     = !empty($param['cp_prch_price']) ? $param['cp_prch_price'] : '';
            $clientProduct['cp_surrender_date'] = !empty($param['cp_surrender_date']) ? $param['cp_surrender_date'] : null;
            $clientProduct['cp_is_surrender']   = !empty($param['cp_is_surrender']) ? $param['cp_is_surrender'] : 0;
            $clientProduct['cp_is_demo']        = !empty($param['cp_is_demo']) ? $param['cp_is_demo'] : 0;
            $clientProduct['cp_type']           = !empty($param['cp_type']) ? $param['cp_type'] : 'DO';
            $clientProduct['cp_user_type']      = !empty($param['cp_user_type']) ? $param['cp_user_type'] : 1;
            $clientProduct['cp_stopdt']         = !empty($param['cp_stopdt']) ? $param['cp_stopdt'] : null;
            $clientProduct['cp_payment']        = !empty($param['cp_payment']) ? $param['cp_payment'] : '';
            $clientProduct['cp_sales_amt']      = !empty($param['cp_sales_amt']) ? $param['cp_sales_amt'] : '';
            $clientProduct['cp_sales_mrp']      = !empty($param['cp_sales_mrp']) ? $param['cp_sales_mrp'] : '';
            $clientProduct['cp_reason']         = !empty($param['cp_reason']) ? $param['cp_reason'] : '';
            $clientProduct['cp_device_type']    = !empty($param['cp_device_type']) ? $param['cp_device_type'] : '';
            $clientProduct['cp_imei']           = !empty($param['cp_imei']) ? $param['cp_imei'] : '';
            $clientProduct['cp_features']       = !empty($param['cp_features']) ? $param['cp_features'] : 0;
            $clientProduct['old_client_id']     = !empty($param['old_client_id']) ? $param['old_client_id'] : 0;
            $clientProduct['roles_id']          = !empty($param['roles_id']) ? $param['roles_id'] : 3;
            $clientProduct->save();
            return $clientProduct;
        }
    }

    //Client Product License table insert
    public function addNewClientProductLicenseData($param) {
        if(!empty($param)) {
            // Client Product License Insert ***************************************************
            $clientProductLicense                    = new ClientProductLicense;
            $clientProductLicense['cp_id']           = !empty($param['cp_id']) ? $param['cp_id'] : 0;
            $clientProductLicense['cpl_license_dt']  = !empty($param['cpl_license_dt']) ? $param['cpl_license_dt'] : null;
            $clientProductLicense['cpl_exp_dt']      = !empty($param['cpl_exp_dt']) ? $param['cpl_exp_dt'] : null;
            $clientProductLicense['cpl_is_demo']     = !empty($param['cpl_is_demo']) ? $param['cpl_is_demo'] : 0;
            $clientProductLicense['cpl_renew_price'] = !empty($param['cpl_renew_price']) ? $param['cpl_renew_price'] : '';
            $clientProductLicense['cpl_sitekey']     = !empty($param['cpl_sitekey']) ? $param['cpl_sitekey'] : '';
            $clientProductLicense['cpl_licencekey']  = !empty($param['cpl_licencekey']) ? $param['cpl_licencekey'] : '';
            $clientProductLicense['cpl_remark']      = !empty($param['cpl_remark']) ? $param['cpl_remark'] : '';
            $clientProductLicense['cpl_licissuedt']  = !empty($param['cpl_licissuedt']) ? $param['cpl_licissuedt'] : null;
            $clientProductLicense->save();
            return $clientProductLicense;
        }
    }

    public function Encrypt($data) {
        $data     = trim($data);
        $add      = 100;
        $len_text = strlen($data);
        $ex       = '';
        $n        = 1;
        $n1       = 1;
        for ($i=0; $i < $len_text; $i++) {
            $ch=substr($data,$i,1);
            $ech=chr(ord($ch)+$n+$add);
            $ex=$ex.$ech;
            
            if($n+$n1 >= 20)
                $n = 1;
            else
                $n = $n+$n1;

            if($n1>=10)
                $n = 1;
            else
                $n = $n1+1;
        }
        return $ex;
    }

    public function Decrypt($data) {
        $data     = trim($data);
        $add      = 100;
        $len_text = strlen($data);
        $dx       = '';
        $n        = 1;
        $n1       = 1;
        for ($i=0; $i < $len_text; $i++) {
            $ch=substr($data,$i,1);
            $dch=chr(ord($ch)-$add-$n);
            $dx=$dx.$dch;
            
            if($n+$n1 >= 20)
                $n = 1;
            else
                $n = $n+$n1;

            if($n1>=10)
                $n = 1;
            else
                $n = $n1+1;
        }
        return $dx;
    }

    public function testAPI(Request $request) {
        return strtoupper($request['data']);
    }
}

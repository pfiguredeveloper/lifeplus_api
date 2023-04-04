<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellLic\CommPosting;
use App\Models\LifeCellLic\OldDataFile;
use App\Models\LifeCellLic\Ledger;
use App\Models\LifeCellLic\Policy;
use Smalot\PdfParser\Parser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Imports\ImportOldClientData;
use App\Imports\ImportOldClientProductData;
use App\Models\LifeCellUsers\TblClient;
use App\Models\LifeCellUsers\TblClientProduct;
use Excel;
use DB;
use \GuzzleHttp\Client as HttpClient;
use App\Models\LifeCellUsers\OldTblClient;
use App\Models\LifeCellUsers\OldTblClientProduct;
use App\Models\LifeCellUsers\ClientProductLicense;
use App\Exports\ExportCommPdfData;

class CommissionPostApiController extends Controller
{
    public function uploadPdf_BAC(Request $request) {
        
        $validation['FILE']  = 'required|mimes:pdf';
        $validation['client_id']  = 'required';
        //$validation['PATH']  = 'required';
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => $valid->errors(),"data"=>[]]);
        }

        $uploadFile = new CommPosting;

        if ($photo = $request->file('FILE')) {
            $root = base_path() . '/public/LICAG_'.$postData['client_id'].'/pdf/';
            $name = str_random(20) . "." . $photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            $image_path = "LICAG_".$postData['client_id']."/pdf/" . $name;
            $photo->move($root, $name);
            $uploadFile['FILE'] = $image_path;
        }

        if(!empty($postData['PATH'])) {
            $p    = str_replace('\\','/',trim($postData['PATH']));
            $path = (substr($p,-1)!='/') ? $p.='/' : $p;    
            $uploadFile['PATH'] = $path;
        }
        $uploadFile->save();

        // Create an instance of the PDFParser
        $PDFParser = new Parser();

        // Create an instance of the PDF with the parseFile method of the parser
        // this method expects as first argument the path to the PDF file
        $pdf = $PDFParser->parseFile($image_path);
        
        // Extract ALL text with the getText method
        $text = $pdf->getText();

        //$res = str_replace("Name", "word", $text);
        //echo "<pre>";print_r($res);echo "</pre>";exit();
        // Manually specify a file name...
        //Storage::putFileAs('photos', new File('resource/pdf/'), 'aa.txt');
       
        $branch_code=preg_match('/\b\w+\b/i',(trim(explode( "Branch:", $text)[1])),$result);
        //echo "<pre>";print_r($result);echo "</pre>";exit();
        $text_before = explode( "Page : 1", $text)[0];
        $text = $text_before.preg_replace("/\t/", "|", explode( "Page : 1", $text)[1]);
        $text=str_replace($result[0]."-00", "\n\n".$result[0]."-00", $text);
        //echo "<pre>";print_r($text);echo "</pre>";exit();
        // $array = explode("\n", $text);

        // echo "<pre>";print_r($array);echo "</pre>";exit();
        // foreach ($array as $key => $value) {
        //     echo "<pre>";print_r($value);echo "</pre>";exit();
        // }
        // echo "<pre>";print_r($new_array);echo "</pre>";exit();

        $file = time() .rand(). '_file.txt';
        $destinationPath=base_path() . '/public/LICAG_'.$postData['client_id'].'/txt/';
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$text);
        // $file = time() .rand(). '_file.txt';
        // File::put($path.$file,$text);
        // Send the text as response in the controller
        //return new Response($text);
        if(env('APP_ENV') != '' && env('APP_ENV') != 'local') {
            return new Response($text);
            return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>"http://moneycarts.in/lifeplus_api/public/resource/txt/".$file]);
        } else {
            return new Response($text);
        }
		//return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>$text]);
    }

    public function getuploadPdf(Request $request) {
        if(!empty($request['id'])) {
            $data = CommPosting::where('ID',$request['id'])->where('client_id',$request['client_id'])->first();
        } else {
            $data = CommPosting::where('client_id',$request['client_id'])->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function deleteuploadPdf(Request $request) {
        $postData    = $request->All();
        $CommPosting = CommPosting::where('ID',$postData['id'])->where('client_id',$request['client_id'])->first();
        
        if(!empty($CommPosting)) {
            $CommPosting->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }        
    }
    public function uploadPdf(Request $request) {
        
        $validation['file_name']  = 'required';
        $validation['client_id']  = 'required';
        //$validation['PATH']  = 'required';
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => $valid->errors(),"data"=>[]]);
        }

        if(!empty($request['id'])) {
            $uploadFile = CommPosting::where('ID',$request['id'])->first();
        } else {
            $uploadFile = new CommPosting;
        }

        $uploadFile['FILE']      = $postData['file_name'];
        $uploadFile['client_id'] = $postData['client_id'];
        // if(!empty($postData['PATH'])) {
        //     $p    = str_replace('\\','/',trim($postData['PATH']));
        //     $path = (substr($p,-1)!='/') ? $p.='/' : $p;    
        //     $uploadFile['PATH'] = $path;
        // }
        $uploadFile->save();

        // Create an instance of the PDFParser
        $PDFParser = new Parser();

        // Create an instance of the PDF with the parseFile method of the parser
        // this method expects as first argument the path to the PDF file
        $pdf = $PDFParser->parseFile($postData['file_name']);
        
        // Extract ALL text with the getText method
        $text = $pdf->getText();

        //$res = str_replace("Name", "word", $text);
        //echo "<pre>";print_r($res);echo "</pre>";exit();
        // Manually specify a file name...
        //Storage::putFileAs('photos', new File('resource/pdf/'), 'aa.txt');
       
        $branch_code=preg_match('/\b\w+\b/i',(trim(explode( "Branch:", $text)[1])),$result);
        //echo "<pre>";print_r($result);echo "</pre>";exit();
        $text_before = explode( "Page : 1", $text)[0];
        $text = $text_before.preg_replace("/\t/", "|", explode( "Page : 1", $text)[1]);
        $text=str_replace($result[0]."-00", "\n\n".$result[0]."-00", $text);
        //echo "<pre>";print_r($text);echo "</pre>";exit();
        $whatIWant = substr($text, strpos($text, "Agency Commission - Details"));
        $array     = explode("\n", $whatIWant);
        //list($a, $b) = explode('Agency Commission - Details', $text);
        //echo "<pre>";print_r($array);echo "</pre>";exit();
        $new_array = [];
        foreach ($array as $key => $value) {
            $value = rtrim($value,"|");
            if (strpos($value, 'Agency Commission') !== false || strpos($value, 'Page : ') !== false || strpos($value, '_____________') !== false || strpos($value, 'Risk Date') !== false || strpos($value, $result[0]."-00") !== false || strpos($value, 'Grand Totals') !== false) {
                continue;
            } else {
                if($value != '') {
                    $newArr = explode("|",$value);
                    $new_array[] = [
                        "name"      => !empty($newArr[0]) ? $newArr[0] : "",
                        "pono"      => !empty($newArr[1]) ? $newArr[1] : "",
                        "plan"      => !empty($newArr[2]) ? $newArr[2] : "",
                        "prem_due"  => !empty($newArr[3]) ? date('Y-m-d', strtotime(strtr($newArr[3], '/', '-'))) : null,
                        "risk_date" => !empty($newArr[4]) ? date('Y-m-d', strtotime(strtr($newArr[4], '/', '-'))) : null,
                        "cbo"       => !empty($newArr[5]) ? $newArr[5] : "",
                        "adj_date"  => !empty($newArr[6]) ? date('Y-m-d', strtotime(strtr($newArr[6], '/', '-'))) : null,
                        "prem"      => !empty($newArr[7]) ? $newArr[7] : "",
                        "comm"      => !empty($newArr[8]) ? $newArr[8] : "",
                        "comm_id"   => !empty($uploadFile['ID']) ? $uploadFile['ID'] : "",
                    ];
                }
            }
        }
        //echo "<pre>";print_r($new_array);echo "</pre>";exit();
        Excel::store(new ExportCommPdfData($new_array), 'CovertCommPDF/LICAG_'.$postData['client_id'].'.csv','local');
        if (!empty($new_array) && count($new_array) > 0) {
            foreach (array_chunk($new_array,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('comm_data')->insert($chunk);
            }
        }
        // echo "<pre>";print_r($new_array);echo "</pre>";exit();

        $file = time() .rand(). '_file.txt';
        $destinationPath=base_path() . '/public/LICAG_'.$postData['client_id'].'/txt/';
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$text);
        // $file = time() .rand(). '_file.txt';
        // File::put($path.$file,$text);
        // Send the text as response in the controller
        //return new Response($text);
        if(env('APP_ENV') != '' && env('APP_ENV') != 'local') {
            //return new Response($whatIWant);
            return new Response("https://moneycarts.in/lifeplus_api/public/CovertCommPDF/LICAG_".$postData['client_id'].".csv");
            //return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>"https://moneycarts.in/lifeplus_api/public/resource/txt/".$file]);
        } else {
            //return new Response($whatIWant);
            return new Response("http://localhost/lifeplus_api/public/CovertCommPDF/LICAG_".$postData['client_id'].".csv");
            //return new Response($text);
        }
        //return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>$text]);
    }

    public function uploadZipFile(Request $request) {
        // shell_exec('sudo chmod -R 777 /opt/bitnami/apache/htdocs/lifeplus_api/public');
        // shell_exec('sudo mkdir /opt/bitnami/apache/htdocs/lifeplus_api/public/se');
        // ini_set('memory_limit', '-1');
        $validation['client_id']  = 'required';
        
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => $valid->errors(),"data"=>[]]);
        }

        $uploadFile = OldDataFile::where('client_id',$postData['client_id'])->first();
        
        if(empty($uploadFile)) {
            $uploadFile = new OldDataFile;
        }
        $uploadFile['FILE']            = 'CL'.$postData['client_id'].'/'.$request->file('FILE')->getClientOriginalName();
        $uploadFile['client_id']       = $postData['client_id'];
        //$uploadFile['product_id']      = $postData['product_id'];
        $uploadFile['is_convert_data'] = 0;
        
        $uploadFile->save();
        $request->file('FILE')->move('/opt/bitnami/apache/htdocs/lifeplus_api/public/CL'.$postData['client_id'],$request->file('FILE')->getClientOriginalName());

        $zip = new \ZipArchive;
        if ($zip->open(base_path() . '/public/CL'.$postData['client_id'].'/'.$request->file('FILE')->getClientOriginalName()) === TRUE) {
            $zip->extractTo(base_path() . '/public/CL'.$postData['client_id']);
            $zip->close();
        }

        $tblClient = TblClient::where('old_client_id',$postData['client_id'])->first();
        if(empty($tblClient)) {
            $this->addOldClientToNewClient($postData['client_id'],1);

            $clientData = TblClient::where('old_client_id',$postData['client_id'])->first();


            // $api_key = '3603CB40158B48';
            // $contacts = '6352073225';
            // $from = 'PFIGER';
            // $template_id= '';
            // $sms_text = urlencode('Hello People, have a great day');

            // $api_url = "http://sms.hitechsms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id;

            // //Submit to server

            // $response = file_get_contents( $api_url);
            //echo "<pre>";print_r($response);echo "</pre>";exit();
            //================================

            if(!empty($clientData) && !empty($clientData['c_email'])) {
                $to       = $clientData['c_email'];
                $subject  = 'LifePlus Login Details';
                $data     = array('name'=>$clientData['c_name'],'newclientId'=>$clientData['c_id'],'oldclientId'=>$postData['client_id'],'email'=>$clientData['c_email'],'mobile'=>$clientData['c_mobile'],'password'=>$postData['client_id']);
                Mail::send('logindetailemail', $data, function($message) use ($to,$subject) {
                    $message->to($to)->subject($subject);
                    $message->from('moneycarts.pfiger@gmail.com','Pfiger Software Technolgoies');
                });
            } 
        }

        if(env('APP_ENV') != '' && env('APP_ENV') != 'local') {
            return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>"https://moneycarts.in/lifeplus_api/public/".$uploadFile['FILE']]);
        } else {
            return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>"http://localhost/lifeplus_api/public/".$uploadFile['FILE']]);
        }
        //return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>$text]);
    }

    public function addOldClientToNewClient($oldClientId,$productid) {
        $oldClient = OldTblClient::where('clientid',$oldClientId)->first();

        if(!empty($oldClient)) {
            //add new record in client table
            $setClientData = [
                'c_name'            => !empty($oldClient['client']) ? $oldClient['client'] : '',
                'c_mobile'          => !empty($oldClient['mobile']) ? $oldClient['mobile'] : '',
                'c_email'           => !empty($oldClient['e_mail']) ? $oldClient['e_mail'] : '',
                'c_password'        => !empty($oldClientId) ? app('hash')->make($oldClientId) : '',
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
            // Client Insert ***************************************************
            $client                     = new TblClient;
            $client['c_name']           = !empty($param['c_name']) ? $param['c_name'] : '';
            $client['c_mobile']         = !empty($param['c_mobile']) ? $param['c_mobile'] : '';
            $client['c_email']          = !empty($param['c_email']) ? $param['c_email'] : '';
            $client['c_password']       = !empty($param['c_password']) ? app('hash')->make($param['c_password']) : '';
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
            $clientProduct['cp_password']       = !empty($param['cp_password']) ? app('hash')->make($param['cp_password']) : '';
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

    public function autoCommission(Request $request) {
        //return response()->json(["success" => 1, "msg" => "Successfully Upload.","data"=>"dd"]);
        $postData    = $request->All();
        $commPosting = CommPosting::with('CommData')->where('client_id',$postData['client_id'])->where('post',0)->get();
        if(!empty($commPosting) && count($commPosting) > 0) {
            foreach($commPosting as $key => $value) {
                if (!empty($value['CommData'])) {
                    foreach($value['CommData'] as $k => $v) {
                        $ledger = Ledger::where('pono',$v['pono'])->where('client_id',$postData['client_id'])->get();
                        $policy = Policy::where('PONO',$v['pono'])->where('client_id',$postData['client_id'])->first();
                        if(!empty($ledger) && count($ledger) > 0) {
                            foreach($ledger as $ledk => $ledv) {
                                // if($v['prem'] < $ledv['prem']) {
                                //     continue;
                                // }
                                $ledv['comm'] = !empty($v['comm']) ? $v['comm'] : '';
                                $ledv->save();
                            }
                        } else {
                            $ledgerNew                         = new Ledger();
                            $ledgerNew['pono']                 = !empty($v['pono']) ? $v['pono'] : '';
                            $ledgerNew['duedt']                = !empty($v['prem_due']) ? $v['prem_due'] :null;
                            $ledgerNew['paiddt']               = !empty($v['adj_date']) ? $v['adj_date'] : null;
                            $ledgerNew['ecs_mode']             = '';
                            $ledgerNew['mode']                 = !empty($policy['MODE']) ? $policy['MODE'] : '';
                            $ledgerNew['rdt']                  = !empty($v['risk_date']) ? $v['risk_date'] : null;
                            $ledgerNew['prem']                 = !empty($v['prem']) ? $v['prem'] : '';
                            $ledgerNew['sprem']                = '';
                            $ledgerNew['remarks']              = '';
                            $ledgerNew['dedcode']              = '';
                            $ledgerNew['comm']                 = !empty($v['comm']) ? $v['comm'] : '';
                            $ledgerNew['bonus']                = '';
                            $ledgerNew['fpren']                = '';
                            $ledgerNew['commdt']               = !empty($v['commdt']) ? $v['commdt'] : '';
                            $ledgerNew['dedu_code']            = '';
                            $ledgerNew['branch']               = '';
                            $ledgerNew['chqno']                = '';
                            $ledgerNew['chqdt']                = '';
                            $ledgerNew['bank']                 = '';
                            $ledgerNew['advpr']                = '';
                            $ledgerNew['newfld']               = '';
                            $ledgerNew['client_id']            = !empty($postData['client_id']) ? $postData['client_id'] : '';
                            $ledgerNew['policy_insurance_id']  = !empty($policy['policy_insurance_id']) ? $policy['policy_insurance_id'] : 0;
                            $ledgerNew->save();
                        }
                        echo "<pre>";print_r($ledger);echo "</pre>";exit();
                    }
                }
                echo "<pre>";print_r($value['CommData']);echo "</pre>";exit();
            }
        }
    }

    public function checkDesktopProductVersion(Request $request) {

        $validation['product_id']      = 'required';
        
        $postData = $request->All();
        $valid    = Validator::make($postData, $validation);

        if (!empty($valid->fails())) {
            return response()->json(["success" => 0, "msg" => implode(',', $valid->errors()->all()),"data"=>[]]);
        }

        $client   = new HttpClient();
        $response = $client->request('GET', "https://pfiger.in/wp-json/acf/v3/software_versions");
        if ($response->getStatusCode() == 200) {
            $apiData =  (json_decode((string) $response->getBody(),true));
        }

        //lifeplus 3
        //gi 5
        //speed 4
        //bachat 1
        $productID  = 0;
        if($postData['product_id'] == 1) {
            $productID = 1126;
        } else if($postData['product_id'] == 2) {
            $productID = 1199;
        } else if($postData['product_id'] == 3) {
            $productID = 1198;
        } else if($postData['product_id'] == 4) {
            $productID = 1200;
        }

        if(!empty($apiData) && count($apiData) > 0) {
            $data = [];
            foreach($apiData as $key => $value) {
                if($productID == $value['id']) {
                    $data = [
                        'version_number' => $value['acf']['version_number'],
                        'download_path'  => $value['acf']['download_path'],
                        'date'           => $value['acf']['date'],
                    ];
                    break;
                }
            }
            
            if(!empty($data)) {
                return response()->json(["success" => 1, "msg" => "Successfully","data"=>$data]);
            } else {
                return response()->json(["success" => 0, "msg" => "data not found.","data"=>[]]);
            }
        }

        return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
    }
}
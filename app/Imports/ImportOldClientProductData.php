<?php

namespace App\Imports;

use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Product;
use App\Models\LifeCellUsers\TblClient;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldClientProductData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId)
    {
        $this->old_client_id = $clientId;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                if(!empty($row['clientid']) && $this->old_client_id == $row['clientid']) {
                    
                    $clientID = TblClient::where('old_client_id',$this->old_client_id)->first();

                    $tblProduct = Product::where('productname',$row['product'])->first();
                    $cpRegDt    = date("Y-m-d");
                    $cpLicenseExpDt = '';
                    if(!empty($tblProduct)) {
                        $cpLicenseExpDt = date('Y-m-d', strtotime($cpRegDt. ' + '.$tblProduct['demodays'].' days'));
                    }
                    
                    // Client Product ***************************************************
                    $clientProduct                      = new TblClientProduct;
                    $clientProduct['c_id']              = !empty($clientID) ? $clientID['c_id'] : 0;
                    $clientProduct['p_id']              = !empty($row['productid']) ? $row['productid'] : '';
                    $clientProduct['cp_reg_dt']         = (!empty($row['prch_dt']) && $row['prch_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['prch_dt'], '/', '-'))) : null;
                    $clientProduct['cp_license_exp_dt'] = (!empty($row['next_due']) && $row['next_due'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['next_due'], '/', '-'))) : null;
                    $clientProduct['cp_hddno']          = !empty($row['hddno1']) ? $row['hddno1'] : '';
                    $clientProduct['cp_sitekey']        = !empty($row['sitekey']) ? $row['sitekey'] : '';
                    $clientProduct['cp_licencekey']     = !empty($row['licencekey']) ? $row['licencekey'] : '';
                    $clientProduct['cp_dealer_id']      = !empty($row['dealerid']) ? $row['dealerid'] : 0;
                    $clientProduct['cp_dealer_name']    = !empty($row['dealer']) ? $row['dealer'] : '';
                    $clientProduct['cp_uniqno']         = !empty($row['uniqno']) ? $row['uniqno'] : 0;
                    $clientProduct['cp_password']       = !empty($clientID) ? $clientID['c_password'] : '';
                    $clientProduct['cp_mobile_no']      = !empty($clientID) ? $clientID['c_mobile'] : '';
                    $clientProduct['cp_email']          = !empty($clientID) ? $clientID['c_email'] : '';
                    $clientProduct['cp_title']          = !empty($row['ltitle']) ? $row['ltitle'] : '';
                    $clientProduct['cp_prch_dt']        = (!empty($row['prch_dt']) && $row['prch_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['prch_dt'], '/', '-'))) : null;
                    $clientProduct['cp_prch_price']     = !empty($row['yly_amt']) ? $row['yly_amt'] : '';
                    $clientProduct['cp_surrender_date'] = null;
                    $clientProduct['cp_is_surrender']   = 0;
                    $clientProduct['cp_is_demo']        = !empty($row['cp_is_demo']) ? $row['cp_is_demo'] : 0;
                    $clientProduct['cp_type']           = !empty($row['progfor']) ? $row['progfor'] : '';
                    $clientProduct['cp_stopdt']         = (!empty($row['stopdt']) && $row['stopdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['stopdt'], '/', '-'))) : null;
                    $clientProduct['cp_payment']        = !empty($row['payment']) ? $row['payment'] : '';
                    $clientProduct['cp_sales_amt']      = !empty($row['sales_amt']) ? $row['sales_amt'] : '';
                    $clientProduct['cp_sales_mrp']      = !empty($row['sales_mrp']) ? $row['sales_mrp'] : '';
                    $clientProduct['cp_reason']         = !empty($row['reason']) ? $row['reason'] : '';
                    $clientProduct['cp_device_type']    = !empty($row['mobmodel']) ? $row['mobmodel'] : '';
                    $clientProduct['cp_imei']           = !empty($row['cp_imei']) ? $row['cp_imei'] : '';
                    $clientProduct['roles_id']          = !empty($row['roles_id']) ? $row['roles_id'] : 3;
                    $clientProduct['old_client_id']     = $this->old_client_id;
                    $clientProduct->save();
                    
                    // Client Product License Insert ***************************************************
                    $clientProductLicense                    = new ClientProductLicense;
                    $clientProductLicense['cp_id']           = $clientProduct['cp_id'];
                    $clientProductLicense['cpl_license_dt']  = $clientProduct['cp_reg_dt'];
                    $clientProductLicense['cpl_exp_dt']      = $clientProduct['cp_license_exp_dt'];
                    $clientProductLicense['cpl_is_demo']     = $clientProduct['cp_is_demo'];
                    $clientProductLicense['cpl_renew_price'] = $clientProduct['cp_prch_price'];
                    $clientProductLicense['cpl_sitekey']     = $clientProduct['cp_sitekey'];
                    $clientProductLicense['cpl_licencekey']  = $clientProduct['cp_licencekey'];
                    $clientProductLicense['cpl_remark']      = !empty($row['remarks']) ? $row['remarks'] : '';
                    $clientProductLicense->save();
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1900;
    }
}

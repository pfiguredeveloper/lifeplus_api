<?php

namespace App\Imports;

use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Dolic;
use App\Models\LifeCellUsers\TblClient;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldClientData implements WithHeadingRow,ToCollection
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
                    $cityID = 0;
                    if(!empty($row['cityid'])) {
                        $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
                    }

                    $doID = 0;
                    if(!empty($row['docode'])) {
                        $doID = Dolic::where('old_client_id',$this->old_client_id)->where('old_id',$row['docode'])->first();
                    }

                    $client                     = new TblClient;
                    $client['c_name']           = !empty($row['client']) ? $row['client'] : '';
                    $client['c_mobile']         = !empty($row['mobile']) ? $row['mobile'] : '';
                    $client['c_email']          = !empty($row['e_mail']) ? $row['e_mail'] : '';
                    $client['c_password']       = !empty($row['e_mail']) ? app('hash')->make($row['e_mail']) : '';
                    $client['c_city_id']        = (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0;
                    $client['c_type']           = !empty($row['progfor']) ? $row['progfor'] : 'DO';
                    $client['c_agt_ad1']        = !empty($row['agt_ad1']) ? $row['agt_ad1'] : '';
                    $client['c_agt_ad2']        = !empty($row['agt_ad2']) ? $row['agt_ad2'] : '';
                    $client['c_agt_ad3']        = !empty($row['agt_ad3']) ? $row['agt_ad3'] : '';
                    $client['c_branch_id']      = !empty($row['branchid']) ? $row['branchid'] : 0;
                    $client['c_country_id']     = !empty($row['countryid']) ? $row['countryid'] : 0;
                    $client['c_state_id']       = !empty($row['stateid']) ? $row['stateid'] : 0;
                    $client['c_pin']            = !empty($row['pin']) ? $row['pin'] : '';
                    $client['c_phone_o']        = !empty($row['phone_o']) ? $row['phone_o'] : '';
                    $client['c_phone_r']        = !empty($row['phone_r']) ? $row['phone_r'] : '';
                    $client['c_do']             = !empty($row['do']) ? $row['do'] : '';
                    $client['c_docode']         = (!empty($doID) && !empty($doID['DOCODE'])) ? $doID['DOCODE'] : 0;
                    $client['c_birth_date']     = (!empty($row['birth_date']) && $row['birth_date'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['birth_date'], '/', '-'))) : null;
                    $client['c_marriagedt']     = (!empty($row['marriagedt']) && $row['marriagedt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['marriagedt'], '/', '-'))) : null;
                    $client['c_reference_id']   = !empty($row['reference_id']) ? $row['reference_id'] : 0;
                    $client['c_is_verified']    = !empty($row['c_is_verified']) ? $row['c_is_verified'] : 0;
                    $client['c_mail_group_id']  = !empty($row['c_mail_group_id']) ? $row['c_mail_group_id'] : 0;
                    $client['c_remark']         = !empty($row['remarks']) ? $row['remarks'] : '';
                    $client['roles_id']         = !empty($row['roles_id']) ? $row['roles_id'] : 3;
                    $client['old_client_id']    = $this->old_client_id;
                    $client->save();
                }
            }
        }
    }
}

<?php

namespace App\Imports;

use App\Models\LifeCellLic\Agency;
use App\Models\LifeCellLic\Contact;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Area;
use App\Models\LifeCellLic\Bank;
use App\Models\LifeCellLic\Branch;
use App\Models\LifeCellLic\Dolic;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldAgencyData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$city_list,$bank_list,$branch_list,$do_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->city_list = $city_list;
        $this->bank_list = $bank_list;
        $this->branch_list = $branch_list;
        $this->do_list = $do_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Agency::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$cityID = 0;
            if(!empty($row['cityid'])) {
                $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
            }
            $bankID = 0;
            if(!empty($row['bankcd'])) {
                $bankID = Bank::where('old_client_id',$this->old_client_id)->where('old_id',$row['bankcd'])->first();
            }
            $branchID = 0;
            if(!empty($row['branchcode'])) {
                $branchID = Branch::where('old_client_id',$this->old_client_id)->where('old_id',$row['branchcode'])->first();
            }
            $doID = 0;
            if(!empty($row['docode'])) {
                $doID = Dolic::where('old_client_id',$this->old_client_id)->where('old_id',$row['docode'])->first();
            }*/

            $cityID = $this->city_list[$row['cityid']] ?? 0;
            $bankID = $this->bank_list[$row['bankcd']] ?? 0;
            $branchID = $this->branch_list[$row['branchcode']] ?? 0;
            $doID = $this->do_list[$row['docode']] ?? 0;
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'AGNO'          => !empty($row['agno']) ? $row['agno'] : '',
                    'p_id'          => 7,
                    'ANAME'         => !empty($row['aname']) ? $row['aname'] : '',
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'BD'            => (!empty($row['bd']) && $row['bd'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['bd'], '/', '-'))) : null,
                    'WDT'           => (!empty($row['wdt']) && $row['wdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['wdt'], '/', '-'))) : null,
                    'APP_DT'        => (!empty($row['app_dt']) && $row['app_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['app_dt'], '/', '-'))) : null,
                    'RENEDT'        => (!empty($row['renedt']) && $row['renedt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['renedt'], '/', '-'))) : null,
                    'EXP_DT'        => (!empty($row['exp_dt']) && $row['exp_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['exp_dt'], '/', '-'))) : null,
                    'LICEXPDT'      => (!empty($row['licexpdt']) && $row['licexpdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['licexpdt'], '/', '-'))) : null,
                    'LICENCE'       => !empty($row['licence']) ? $row['licence'] : '',
                    'PHONE_O'       => !empty($row['phone_o']) ? $row['phone_o'] : '',
                    'PHONE_R'       => !empty($row['phone_r']) ? $row['phone_r'] : '',
                    'PAGER'         => !empty($row['pager']) ? $row['pager'] : '',
                    'MOBILE'        => !empty($row['mobile']) ? $row['mobile'] : '',
                    'ENDING'        => !empty($row['ending']) ? $row['ending'] : 0,
                    'CLUB'          => !empty($row['club']) ? $row['club'] : '',
                    'ADDRESS'       => !empty($row['address']) ? $row['address'] : '',
                    'AGCODE'        => !empty($row['agcode']) ? $row['agcode'] : '',
                    'TERMINATE'     => !empty($row['terminate']) ? $row['terminate'] : '',
                    'EMAIL'         => !empty($row['email']) ? $row['email'] : '',
                    'PIN'           => !empty($row['pin']) ? $row['pin'] : '',
                    'FAX'           => !empty($row['fax']) ? $row['fax'] : '',
                    'OWN_OTH'       => !empty($row['own_oth']) ? $row['own_oth'] : '',
                    'DOCODE'        => (!empty($doID) && !empty($doID['DOCODE'])) ? $doID['DOCODE'] : 0,
                    'SERVICING'     => !empty($row['servicing']) ? $row['servicing'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'AD1'           => !empty($row['ad1']) ? $row['ad1'] : '',
                    'AD2'           => !empty($row['ad2']) ? $row['ad2'] : '',
                    'AD3'           => !empty($row['ad3']) ? $row['ad3'] : '',
                    'BRANCHCODE'    => (!empty($branchID) && !empty($branchID['BCODE'])) ? $branchID['BCODE'] : 0,
                    'PAN'           => !empty($row['pan']) ? $row['pan'] : '',
                    'NOMINEE'       => !empty($row['nominee']) ? $row['nominee'] : '',
                    'TR_RENEWDT'    => (!empty($row['tr_renewdt']) && $row['tr_renewdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['tr_renewdt'], '/', '-'))) : null,
                    'BANKCD'        => (!empty($bankID) && !empty($bankID['BANKCD'])) ? $bankID['BANKCD'] : 0,
                    'BANKACNO'      => !empty($row['bankacno']) ? $row['bankacno'] : '',
                    'AGINIT'        => !empty($row['aginit']) ? $row['aginit'] : '',
                    'LIFEPLUSID'    => !empty($row['lifeplusid']) ? $row['lifeplusid'] : 0,
                    'AGMONTH'       => !empty($row['agmonth']) ? $row['agmonth'] : '',
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'DEMODATA'      => !empty($row['demodata']) ? $row['demodata'] : '',
                    'BCODE'         => !empty($row['bcode']) ? $row['bcode'] : 0,
                    'LICUSERID'     => !empty($row['licuserid']) ? $row['licuserid'] : '',
                    'LICPASS'       => !empty($row['licpass']) ? $row['licpass'] : '',
                    'CLOUD_D'       => !empty($row['cloud_d']) ? $row['cloud_d'] : '',
                    'LICCHECK'      => !empty($row['liccheck']) ? $row['liccheck'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['afile']) ? $row['afile'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('agency')->insert($chunk);
            }

            $agencyGet   = Agency::where('old_client_id',$this->old_client_id)->get();
            $saveConData = [];
            if(!empty($agencyGet) && count($agencyGet) > 0) {
                foreach ($agencyGet as $key => $value) {
                    $saveConData[] = [
                        'AD1'        => !empty($value['AD1']) ? $value['AD1'] : '',
                        'AD2'        => !empty($value['AD2']) ? $value['AD2'] : '',
                        'AD3'        => !empty($value['AD3']) ? $value['AD3'] : '',
                        'CITY'       => !empty($value['CITY']) ? $value['CITY'] : '',
                        'CITYID'     => !empty($value['CITYID']) ? $value['CITYID'] : 0,
                        'PIN'        => !empty($value['PIN']) ? $value['PIN'] : '',
                        'ARECD'      => 0,
                        'PHONE_O'    => !empty($value['PHONE_O']) ? $value['PHONE_O'] : '',
                        'PHONE_R'    => !empty($value['PHONE_R']) ? $value['PHONE_R'] : '',
                        'MOBILE'     => !empty($value['MOBILE']) ? $value['MOBILE'] : '',
                        'PAGER_FAX'  => !empty($value['FAX']) ? $value['FAX'] : '',
                        'EMAIL'      => !empty($value['EMAIL']) ? $value['EMAIL'] : '',
                        'tableName'  => 'agency',
                        'tableID'    => !empty($value['AFILE']) ? $value['AFILE'] : 0,
                    ];
                }
            }

            if (!empty($saveConData) && count($saveConData)) {
                foreach (array_chunk($saveConData,1500) as $chunk1) {
                    DB::connection('lifecell_lic')->table('contact')->insert($chunk1);
                }
            }
        }
    }
}

<?php

namespace App\Imports;

use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Contact;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Area;
use App\Models\LifeCellLic\Family_group;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class ImportOldPartyData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId,$oldClientID,$city_list,$area_list,$family_group_list)
    {
        $this->client_id = $clientId;
        $this->city_list = $city_list;
        $this->old_client_id = $oldClientID;
        $this->area_list = $area_list;
        $this->family_group_list = $family_group_list;
    }

    public function chunkSize(): int {
        return 1900;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Party::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$cityID = 0;
            if(!empty($row['cityid'])) {
                $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
            }
            $birthID = 0;
            if(!empty($row['birthplace'])) {
                $birthID = City::where('old_client_id',$this->old_client_id)->where('CITY','like','%'.$row['birthplace'].'%')->first();
            }
            $areaID = 0;
            if(!empty($row['arecd'])) {
                $areaID = Area::where('old_client_id',$this->old_client_id)->where('old_id',$row['arecd'])->first();
            }
            $fNameID = 0;
            if(!empty($row['gcode'])) {
                $fNameID = Family_group::where('old_client_id',$this->old_client_id)->where('old_id',$row['gcode'])->first();
            }*/

            $birthID = 0;
            if(!empty($row['birthplace'])) {
                $birthID = City::where('old_client_id',$this->old_client_id)->where('CITY','like','%'.$row['birthplace'].'%')->first();
            }
            $cityID = $this->city_list[$row['cityid']] ?? 0;
            $areaID = $this->area_list[$row['arecd']] ?? 0;
            $fNameID = $this->family_group_list[$row['gcode']] ?? 0;

            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'PCODE'         => !empty($row['gcode']) ? $row['gcode'] : 0,
                    'ARECD'         => (!empty($areaID) && !empty($areaID['ARECD'])) ? $areaID['ARECD'] : 0,
                    'NAME'          => !empty($row['name']) ? $row['name'] : '',
                    'LNM'           => !empty($row['lnm']) ? $row['lnm'] : '',
                    'FNM'           => !empty($row['fname']) ? $row['fname'] : '',
                    'SNM'           => !empty($row['snm']) ? $row['snm'] : '',
                    'FNAME'         => (!empty($fNameID) && !empty($fNameID['GCODE'])) ? $fNameID['GCODE'] : 0,
                    'AD'            => !empty($row['ad']) ? $row['ad'] : '',
                    'AD1'           => !empty($row['ad1']) ? $row['ad1'] : '',
                    'AD2'           => !empty($row['ad2']) ? $row['ad2'] : '',
                    'AD3'           => !empty($row['ad3']) ? $row['ad3'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'PIN'           => !empty($row['pin']) ? $row['pin'] : 0,
                    'ADT'           => !empty($row['adt']) ? $row['adt'] : '',
                    'AD1T'          => !empty($row['ad1t']) ? $row['ad1t'] : '',
                    'AD2T'          => !empty($row['ad2t']) ? $row['ad2t'] : '',
                    'AD3T'          => !empty($row['ad3t']) ? $row['ad3t'] : '',
                    'CITYIDT'       => !empty($row['cityidt']) ? $row['cityidt'] : 0,
                    'CITYT'         => !empty($row['cityt']) ? $row['cityt'] : '',
                    'PINT'          => !empty($row['pint']) ? $row['pint'] : 0,
                    'BD'            => (!empty($row['bd']) && $row['bd'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['bd'], '/', '-'))) : null,
                    'ABD'           => (!empty($row['abd']) && $row['abd'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['abd'], '/', '-'))) : null,
                    'SEX'           => !empty($row['sex']) ? $row['sex'] : '',
                    'STATUS'        => !empty($row['status']) ? $row['status'] : '',
                    'MARK'          => !empty($row['mark']) ? $row['mark'] : '',
                    'WDT'           => (!empty($row['wdt']) && $row['wdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['wdt'], '/', '-'))) : null,
                    'NOMINEE'       => !empty($row['nominee']) ? $row['nominee'] : '',
                    'RELATION'      => !empty($row['relation']) ? $row['relation'] : '',
                    'INCOME'        => !empty($row['income']) ? $row['income'] : '',
                    'QUALI'         => !empty($row['quali']) ? $row['quali'] : '',
                    'BIRTHPLACE'    => (!empty($birthID) && !empty($birthID['CITYID'])) ? $birthID['CITYID'] : 0,
                    'PHONE_O'       => !empty($row['phone_o']) ? $row['phone_o'] : '',
                    'PHONE_R'       => !empty($row['phone_r']) ? $row['phone_r'] : '',
                    'PAGER_FAX'     => !empty($row['pager_fax']) ? $row['pager_fax'] : '',
                    'MOBILE'        => !empty($row['mobile']) ? $row['mobile'] : '',
                    'EMAIL'         => !empty($row['email']) ? $row['email'] : '',
                    'LAST_DEL'      => (!empty($row['last_del']) && $row['last_del'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['last_del'], '/', '-'))) : null,
                    'PANGIRNO'      => !empty($row['pangirno']) ? $row['pangirno'] : '',
                    'OCCUPATION'    => !empty($row['occupation']) ? $row['occupation'] : '',
                    'DOCCU'         => !empty($row['doccu']) ? $row['doccu'] : '',
                    'DURATION'      => !empty($row['duration']) ? $row['duration'] : 0,
                    'SELECT'        => !empty($row['select']) ? $row['select'] : '',
                    'EMPNO'         => !empty($row['empno']) ? $row['empno'] : '',
                    'BLOOD'         => !empty($row['blood']) ? $row['blood'] : '',
                    'ARECDT'        => !empty($row['arecdt']) ? $row['arecdt'] : 0,
                    'EXPDT'         => !empty($row['expdt']) ? $row['expdt'] : '',
                    'LIC_CUSID'     => !empty($row['lic_cusid']) ? $row['lic_cusid'] : '',
                    'LIFEPLUSID'    => !empty($row['lifeplusid']) ? $row['lifeplusid'] : 0,
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'DEMODATA'      => !empty($row['demodata']) ? $row['demodata'] : '',
                    'CUSID'         => !empty($row['cusid']) ? $row['cusid'] : '',
                    'AG_REL'        => !empty($row['ag_rel']) ? $row['ag_rel'] : '',
                    'AG_W_REL'      => !empty($row['ag_w_rel']) ? $row['ag_w_rel'] : '',
                    'KNOWN_DT'      => (!empty($row['known_dt']) && $row['known_dt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['known_dt'], '/', '-'))) : null,
                    'IS_NRI'        => !empty($row['is_nri']) ? $row['is_nri'] : '',
                    'ADHARNO'       => !empty($row['adharno']) ? $row['adharno'] : '',
                    'C_GST'         => !empty($row['c_gst']) ? $row['c_gst'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['pcode']) ? $row['pcode'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1000) as $chunk) {
                DB::connection('lifecell_lic')->table('party')->insert($chunk);
            }

            $partyGet   = Party::where('old_client_id',$this->old_client_id)->get();
            $saveConData = [];
            if(!empty($partyGet) && count($partyGet) > 0) {
                foreach ($partyGet as $key => $value) {
                    $saveConData[] = [
                        'AD1'        => !empty($value['AD1']) ? $value['AD1'] : '',
                        'AD2'        => !empty($value['AD2']) ? $value['AD2'] : '',
                        'AD3'        => !empty($value['AD3']) ? $value['AD3'] : '',
                        'CITY'       => !empty($value['CITY']) ? $value['CITY'] : '',
                        'CITYID'     => !empty($value['CITYID']) ? $value['CITYID'] : 0,
                        'PIN'        => !empty($value['PIN']) ? $value['PIN'] : '',
                        'ARECD'      => !empty($value['ARECD']) ? $value['ARECD'] : 0,
                        'PHONE_O'    => !empty($value['PHONE_O']) ? $value['PHONE_O'] : '',
                        'PHONE_R'    => !empty($value['PHONE_R']) ? $value['PHONE_R'] : '',
                        'MOBILE'     => !empty($value['MOBILE']) ? $value['MOBILE'] : '',
                        'PAGER_FAX'  => !empty($value['PAGER_FAX']) ? $value['PAGER_FAX'] : '',
                        'EMAIL'      => !empty($value['EMAIL']) ? $value['EMAIL'] : '',
                        'tableName'  => 'party',
                        'tableID'    => !empty($value['GCODE']) ? $value['GCODE'] : 0,
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

<?php

namespace App\Imports;

use App\Models\LifeCellLic\Doctor;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Area;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldDoctorData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$city_list,$area_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->city_list = $city_list;
        $this->area_list = $area_list;
        
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Doctor::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$cityID = 0;
            if(!empty($row['cityid'])) {
                $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
            }
            $areaID = 0;
            if(!empty($row['arecd'])) {
                $areaID = Area::where('old_client_id',$this->old_client_id)->where('old_id',$row['arecd'])->first();
            }*/
            $cityID = $this->city_list[$row['cityid']] ?? 0;
            $areaID = $this->area_list[$row['arecd']] ?? 0;

            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'DOCTOR'        => !empty($row['doctor']) ? $row['doctor'] : '',
                    'SHRTNM'        => !empty($row['shrtnm']) ? $row['shrtnm'] : '',
                    'DOC_CODE'      => !empty($row['doc_code']) ? $row['doc_code'] : '',
                    'ADDRESS'       => !empty($row['address']) ? $row['address'] : '',
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'PIN'           => !empty($row['pin']) ? $row['pin'] : '',
                    'SPECIALIST'    => !empty($row['specialist']) ? $row['specialist'] : '',
                    'PHONE_O'       => !empty($row['phone_o']) ? $row['phone_o'] : '',
                    'PHONE_R'       => !empty($row['phone_r']) ? $row['phone_r'] : '',
                    'LIMIT_DATA'    => !empty($row['limit']) ? $row['limit'] : '',
                    'ARECD'         => (!empty($areaID) && !empty($areaID['ARECD'])) ? $areaID['ARECD'] : 0,
                    'MOBILE'        => !empty($row['mobile']) ? $row['mobile'] : '',
                    'EMAIL'         => !empty($row['email']) ? $row['email'] : '',
                    'APP_DATE'      => !empty($row['app_date']) ? $row['app_date'] : '',
                    'RET_DATE'      => !empty($row['ret_date']) ? $row['ret_date'] : '',
                    'STATUS'        => !empty($row['status']) ? $row['status'] : '',
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['dcode']) ? $row['dcode'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('doctor')->insert($chunk);
            }
        }
    }
}

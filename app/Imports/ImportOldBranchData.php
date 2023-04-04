<?php

namespace App\Imports;

use App\Models\LifeCellLic\Branch;
use App\Models\LifeCellLic\City;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldBranchData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$city_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->city_list = $city_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Branch::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$cityID = 0;
            if(!empty($row['cityid'])) {
                $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
            }*/
            $cityID = $this->city_list[$row['cityid']] ?? 0;
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'BRANCH'        => !empty($row['branch']) ? $row['branch'] : '',
                    'BRANCHNM'      => !empty($row['branchnm']) ? $row['branchnm'] : '',
                    'BR_MGR_NM'     => !empty($row['br_mgr_nm']) ? $row['br_mgr_nm'] : '',
                    'AD1'           => !empty($row['ad1']) ? $row['ad1'] : '',
                    'AD2'           => !empty($row['ad2']) ? $row['ad2'] : '',
                    'AD3'           => !empty($row['ad3']) ? $row['ad3'] : '',
                    'ADDRESS'       => !empty($row['address']) ? $row['address'] : '',
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'PIN'           => !empty($row['pin']) ? $row['pin'] : '',
                    'DIVISION'      => !empty($row['division']) ? $row['division'] : '',
                    'PHONE_O'       => !empty($row['phone_o']) ? $row['phone_o'] : '',
                    'ZONE'          => !empty($row['zone']) ? $row['zone'] : '',
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['bcode']) ? $row['bcode'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('branch')->insert($chunk);
            }
        }
    }
}

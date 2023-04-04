<?php

namespace App\Imports;

use App\Models\LifeCellLic\Bank;
use App\Models\LifeCellLic\City;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldBankData implements WithHeadingRow,ToCollection
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
        Bank::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$cityID = 0;
            if(!empty($row['cityid'])) {
                $cityID = City::where('old_client_id',$this->old_client_id)->where('old_id',$row['cityid'])->first();
            }*/
            $cityID = $this->city_list[$row['cityid']] ?? 0;
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'BANK'          => !empty($row['bank']) ? $row['bank'] : '',
                    'BANKBR'        => !empty($row['bankbr']) ? $row['bankbr'] : '',
                    'BANKMICR'      => !empty($row['bankmicr']) ? $row['bankmicr'] : '',
                    'BANKIFS'       => !empty($row['bankifs']) ? $row['bankifs'] : '',
                    'AD1'           => !empty($row['ad1']) ? $row['ad1'] : '',
                    'AD2'           => !empty($row['ad2']) ? $row['ad2'] : '',
                    'AD3'           => !empty($row['ad3']) ? $row['ad3'] : '',
                    'ADDRESS'       => !empty($row['address']) ? $row['address'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'PIN'           => !empty($row['pin']) ? $row['pin'] : '',
                    'PHONE'         => !empty($row['phone']) ? $row['phone'] : '',
                    'FAX'           => !empty($row['fax']) ? $row['fax'] : '',
                    'EMAIL'         => !empty($row['email']) ? $row['email'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['bankcd']) ? $row['bankcd'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('bank')->insert($chunk);
            }
        }
    }
}

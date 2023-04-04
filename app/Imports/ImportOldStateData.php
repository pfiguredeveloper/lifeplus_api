<?php

namespace App\Imports;

use App\Models\LifeCellLic\State;
use App\Models\LifeCellLic\Country;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldStateData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$country_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->country_list = $country_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        State::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$countryID = 0;
            if(!empty($row['countryid'])) {
                $countryID = Country::where('old_client_id',$this->old_client_id)->where('old_id',$row['countryid'])->first();
            }*/
            $countryID = $this->country_list[$row['countryid']] ?? 0;
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'STATE'         => !empty($row['state']) ? $row['state'] : '',
                    'COUNTRY'       => !empty($row['country']) ? $row['country'] : '',
                    'COUNTRYID'     => (!empty($countryID) && !empty($countryID['COUNTRYID'])) ? $countryID['COUNTRYID'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['stateid']) ? $row['stateid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('state')->insert($chunk);
            }
        }
    }
}

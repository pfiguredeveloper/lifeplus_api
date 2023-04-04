<?php

namespace App\Imports;

use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\State;
use App\Models\LifeCellLic\District;
use App\Models\LifeCellLic\Country;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldCityData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$country_list,$state_list,$districe_list)
    {
        $this->client_id   = $clientId;
        $this->old_client_id = $oldClientID;
        $this->country_list = $country_list;
        $this->state_list = $state_list;
        $this->districe_list = $districe_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        City::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];

        foreach ($rows as $row) {
            /*$stateID = 0;
            if(!empty($row['stateid'])) {
                $stateID = State::where('old_client_id',$this->old_client_id)->where('old_id',$row['stateid'])->first();
            }
            $countryID = 0;
            if(!empty($row['countryid'])) {
                $countryID = Country::where('old_client_id',$this->old_client_id)->where('old_id',$row['countryid'])->first();
            }
            $districtID = 0;
            if(!empty($row['districtid'])) {
                $districtID = District::where('old_client_id',$this->old_client_id)->where('old_id',$row['districtid'])->first();
            }*/
            $stateID = $this->state_list[$row['stateid']] ?? 0;
            $countryID = $this->country_list[$row['countryid']] ?? 0;
            $districtID = $this->districe_list[$row['districtid']] ?? 0;
            
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'STD'           => !empty($row['std']) ? $row['std'] : '',
                    'CAPITAL'       => !empty($row['capital']) ? $row['capital'] : '',
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'DISTRICT'      => !empty($row['district']) ? $row['district'] : '',
                    'DISTRICTID'    => (!empty($districtID) && !empty($districtID['DISTRICTID'])) ? $districtID['DISTRICTID'] : 0,
                    'STATE'         => !empty($row['state']) ? $row['state'] : '',
                    'STATEID'       => (!empty($stateID) && !empty($stateID['STATEID'])) ? $stateID['STATEID'] : 0,
                    'COUNTRY'       => !empty($row['country']) ? $row['country'] : '',
                    'COUNTRYID'     => (!empty($countryID) && !empty($countryID['COUNTRYID'])) ? $countryID['COUNTRYID'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['cityid']) ? $row['cityid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('city')->insert($chunk);
            }
        }
    }
}

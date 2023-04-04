<?php

namespace App\Imports;

use App\Models\LifeCellLic\Family_group;
use App\Models\LifeCellLic\City;
use App\Models\LifeCellLic\Area;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldGroupData implements WithHeadingRow,ToCollection
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
        Family_group::where('old_client_id',$this->old_client_id)->delete();
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
                    'GNM'           => !empty($row['gnm']) ? $row['gnm'] : '',
                    'GADDRESS'      => !empty($row['gaddress']) ? $row['gaddress'] : '',
                    'GAD1'          => !empty($row['gad1']) ? $row['gad1'] : '',
                    'GAD2'          => !empty($row['gad2']) ? $row['gad2'] : '',
                    'GAD3'          => !empty($row['gad3']) ? $row['gad3'] : '',
                    'GPIN'          => !empty($row['gpin']) ? $row['gpin'] : '',
                    'GPHON_R'       => !empty($row['gphon_r']) ? $row['gphon_r'] : '',
                    'GPHON_O'       => !empty($row['gphon_o']) ? $row['gphon_o'] : '',
                    'CITYID'        => (!empty($cityID) && !empty($cityID['CITYID'])) ? $cityID['CITYID'] : 0,
                    'CITY'          => !empty($row['city']) ? $row['city'] : '',
                    'SELECT'        => !empty($row['select']) ? $row['select'] : '',
                    'GMOBILE'       => !empty($row['gmobile']) ? $row['gmobile'] : '',
                    'GEMAIL'        => !empty($row['gemail']) ? $row['gemail'] : '',
                    'LIFEPLUSID'    => !empty($row['lifeplusid']) ? $row['lifeplusid'] : '',
                    'DEMODATA'      => !empty($row['demodata']) ? $row['demodata'] : '',
                    'ARECD'         => (!empty($areaID) && !empty($areaID['ARECD'])) ? $areaID['ARECD'] : 0,
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['gcode']) ? $row['gcode'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('family_group')->insert($chunk);
            }
        }
    }
}

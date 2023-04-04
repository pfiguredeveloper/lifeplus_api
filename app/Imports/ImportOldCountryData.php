<?php

namespace App\Imports;

use App\Models\LifeCellLic\Country;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldCountryData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Country::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'COUNTRY'       => !empty($row['country']) ? $row['country'] : '',
                    'ISD'           => !empty($row['isd']) ? $row['isd'] : '',
                    'ISO'           => !empty($row['ISO']) ? $row['ISO'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['countryid']) ? $row['countryid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('country')->insert($chunk);
            }
        }
    }
}

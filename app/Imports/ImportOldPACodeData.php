<?php

namespace App\Imports;

use App\Models\LifeCellLic\Pacode;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldPACodeData implements WithHeadingRow,ToCollection
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
        Pacode::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'PACODE'        => !empty($row['pacode']) ? $row['pacode'] : '',
                    'PACODENM'      => !empty($row['pacodenm']) ? $row['pacodenm'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['paid']) ? $row['paid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('pacode')->insert($chunk);
            }
        }
    }
}

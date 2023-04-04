<?php

namespace App\Imports;

use App\Models\LifeCellLic\Dolic;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldDOData implements WithHeadingRow,ToCollection
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
        Dolic::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'DONAME'        => !empty($row['doname']) ? $row['doname'] : '',
                    'DO_CODE'       => !empty($row['do_code']) ? $row['do_code'] : '',
                    'APP_MONTH'     => !empty($row['app_month']) ? lcfirst($row['app_month']) : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['docode']) ? $row['docode'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('do')->insert($chunk);
            }
        }
    }
}

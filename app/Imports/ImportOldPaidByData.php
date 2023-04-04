<?php

namespace App\Imports;

use App\Models\LifeCellLic\Paidby;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldPaidByData implements WithHeadingRow,ToCollection
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
        Paidby::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'PAIDBY'        => !empty($row['paidby']) ? $row['paidby'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['paidbyid']) ? $row['paidbyid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('paidby')->insert($chunk);
            }
        }
    }
}

<?php

namespace App\Imports;

use App\Models\LifeCellLic\Status;
use App\Models\LifeCellLic\Gender;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldStatusData implements WithHeadingRow,ToCollection
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
        Status::where('old_client_id',$this->old_client_id)->delete();
        Gender::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'STATUS'        => !empty($row['status']) ? $row['status'] : '',
                    'GENDER'        => !empty($row['gender']) ? $row['gender'] : '',
                    'OCODE'         => !empty($row['ocode']) ? $row['ocode'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['statusid']) ? $row['statusid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('status')->insert($chunk);
            }
        }

        $saveDate1[] = [
            'NAME'          => '---',
            'client_id'     => $this->client_id,
            'old_id'        => 0,
            'old_client_id' => $this->old_client_id,
        ];
        $saveDate1[] = [
            'NAME'          => 'Male',
            'client_id'     => $this->client_id,
            'old_id'        => 0,
            'old_client_id' => $this->old_client_id,
        ];
        $saveDate1[] = [
            'NAME'          => 'Female',
            'client_id'     => $this->client_id,
            'old_id'        => 0,
            'old_client_id' => $this->old_client_id,
        ];
        Gender::insert($saveDate1);
    }
}

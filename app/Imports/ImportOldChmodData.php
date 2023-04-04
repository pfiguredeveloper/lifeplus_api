<?php

namespace App\Imports;

use App\Models\LifeCellLic\Chmod;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldChmodData implements WithHeadingRow,ToCollection
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
        Chmod::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'pono'          => !empty($row['pono']) ? $row['pono'] : '',
                    'appdate'       => !empty($row['appdate']) ? $row['appdate'] : '',
                    'omode'         => !empty($row['omode']) ? $row['omode'] : '',
                    'oprem'         => !empty($row['oprem']) ? $row['oprem'] : '',
                    'nmode'         => !empty($row['nmode']) ? $row['nmode'] : '',
                    'nprem'         => !empty($row['nprem']) ? $row['nprem'] : '',
                    'edate'         => !empty($row['edate']) ? $row['edate'] : '',
                    'done'          => !empty($row['done']) ? $row['done'] : '',
                    'duedate'       => !empty($row['duedate']) ? $row['duedate'] : '',
                    'paiddate'      => !empty($row['paiddate']) ? $row['paiddate'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('chmod')->insert($chunk);
            }
        }
    }
}

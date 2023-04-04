<?php

namespace App\Imports;

use App\Models\LifeCellLic\Articals;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldArticalsData implements WithHeadingRow,ToCollection
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
        Articals::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'DESC1'         => !empty($row['desc1']) ? $row['desc1'] : '',
                    'DESC2'         => !empty($row['desc2']) ? $row['desc2'] : '',
                    'DOCU'          => !empty($row['DOCU']) ? $row['DOCU'] : '',
                    'FILENAME'      => !empty($row['filename']) ? $row['filename'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['uniqid']) ? $row['uniqid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('articals')->insert($chunk);
            }
        }
    }
}

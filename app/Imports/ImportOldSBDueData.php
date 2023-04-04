<?php

namespace App\Imports;

use App\Models\LifeCellLic\SBDue;
use App\Models\LifeCellLic\Policy;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class ImportOldSBDueData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId,$oldClientID,$policy_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->policy_list = $policy_list;
    }
    
    public function chunkSize(): int {
        return 1900;
    }

    public function collection(Collection $rows)
    {
        SBDue::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                /*$policyID = 0;
                if(!empty($row['puniqid'])) {
                    $policyID = Policy::where('old_client_id',$this->old_client_id)->where('old_id',$row['puniqid'])->first();
                }*/
                $policyID = $this->policy_list[$row["puniqid"]] ?? 0;
                $saveDate[] = [
                    'puniqid'       => (!empty($policyID) && !empty($policyID['PUNIQID'])) ? $policyID['PUNIQID'] : 0,
                    'no_of_inst'    => !empty($row['no_of_inst']) ? $row['no_of_inst'] : '',
                    'duedate'       => (!empty($row['duedate']) && $row['duedate'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['duedate'], '/', '-'))) : null,
                    'amount'        => !empty($row['amount']) ? $row['amount'] : '',
                    'duemonthyr'    => !empty($row['duemonthyr']) ? $row['duemonthyr'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('sb_due')->insert($chunk);
            }
        }
    }
}

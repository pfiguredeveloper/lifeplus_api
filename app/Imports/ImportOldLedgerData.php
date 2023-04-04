<?php

namespace App\Imports;

use App\Models\LifeCellLic\Ledger;
use App\Models\LifeCellLic\Policy;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class ImportOldLedgerData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId,$oldClientID,$policy_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->policy_list = $policy_list;
    }

     public function chunkSize(): int
    {
        return 1900;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Ledger::where('old_client_id',$this->old_client_id)->delete();
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
                    'pono'          => !empty($row['pono']) ? $row['pono'] : '',
                    'duedt'         => (!empty($row['duedt']) && $row['duedt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['duedt'], '/', '-'))) : null,
                    'paiddt'        => (!empty($row['paiddt']) && $row['paiddt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['paiddt'], '/', '-'))) : null,
                    'ecs_mode'      => !empty($row['ecs_mode']) ? $row['ecs_mode'] : 'No',
                    'mode'          => !empty($row['mode']) ? $row['mode'] : '',
                    'rdt'           => (!empty($row['rdt']) && $row['rdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['rdt'], '/', '-'))) : null,
                    'prem'          => !empty($row['prem']) ? $row['prem'] : '',
                    'sprem'         => !empty($row['sprem']) ? $row['sprem'] : 0,
                    'remarks'       => !empty($row['remarks']) ? $row['remarks'] : '',
                    'dedcode'       => !empty($row['dedcode']) ? $row['dedcode'] : 0,
                    'comm'          => !empty($row['comm']) ? $row['comm'] : 0,
                    'bonus'         => !empty($row['bonus']) ? $row['bonus'] : 0,
                    'fpren'         => !empty($row['fpren']) ? $row['fpren'] : '',
                    'commdt'        => (!empty($row['commdt']) && $row['commdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['commdt'], '/', '-'))) : null,
                    'dedu_code'     => !empty($row['dedu_code']) ? $row['dedu_code'] : '',
                    'branch'        => !empty($row['branch']) ? $row['branch'] : '',
                    'chqno'         => !empty($row['chqno']) ? $row['chqno'] : '',
                    'chqdt'         => (!empty($row['chqdt']) && $row['chqdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['chqdt'], '/', '-'))) : null,
                    'bank'          => !empty($row['bank']) ? $row['bank'] : '',
                    'advpr'         => !empty($row['advpr']) ? $row['advpr'] : '',
                    'newfld'        => !empty($row['newfld']) ? $row['newfld'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('ledger')->insert($chunk);
            }
        }
    }
}

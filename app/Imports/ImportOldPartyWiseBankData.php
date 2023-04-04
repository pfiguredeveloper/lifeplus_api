<?php

namespace App\Imports;

use App\Models\LifeCellLic\PartyWiseBank;
use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Bank;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldPartyWiseBankData implements WithHeadingRow,ToCollection
{
    public function  __construct($clientId,$oldClientID,$party_list,$bank_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->party_list = $party_list;
        $this->bank_list = $bank_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        PartyWiseBank::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            /*$partyID = 0;
            if(!empty($row['pcode'])) {
                $partyID = Party::where('old_client_id',$this->old_client_id)->where('old_id',$row['pcode'])->first();
            }
            $bankID = 0;
            if(!empty($row['bcode'])) {
                $bankID = Bank::where('old_client_id',$this->old_client_id)->where('old_id',$row['bcode'])->first();
            }*/
            $partyID = $this->party_list[$row["pcode"]] ?? 0;
            $bankID = $this->bank_list[$row["bcode"]] ?? 0;
            if($row->filter()->isNotEmpty()) {
                $saveDate[] = [
                    'pcode'         => (!empty($partyID) && !empty($partyID['GCODE'])) ? $partyID['GCODE'] : 0,
                    'name'          => (!empty($partyID) && !empty($partyID['NAME'])) ? $partyID['NAME'] : '',
                    'bcode'         => (!empty($bankID) && !empty($bankID['BANKCD'])) ? $bankID['BANKCD'] : 0,
                    'bank'          => (!empty($bankID) && !empty($bankID['BANK'])) ? $bankID['BANK'] : '',
                    'acno'          => !empty($row['acno']) ? $row['acno'] : '',
                    'actype'        => !empty($row['actype']) ? $row['actype'] : '',
                    'elec_no'       => !empty($row['elec_no']) ? $row['elec_no'] : '',
                    'ifscode'       => !empty($row['ifscode']) ? $row['ifscode'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['pwbid']) ? $row['pwbid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500) as $chunk) {
                DB::connection('lifecell_lic')->table('party_wise_bank')->insert($chunk);
            }
        }
    }
}

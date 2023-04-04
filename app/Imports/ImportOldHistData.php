<?php

namespace App\Imports;

use App\Models\LifeCellLic\Policy;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class ImportOldHistData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId,$oldClientID,$policy_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->policy_list = $policy_list;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $saveDate = [];
        $count    = 1;
        $lastPolicyID = 0;
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                /*$policyID = 0;
                if(!empty($row['puniqid'])) {
                    $policyID = Policy::where('old_client_id',$this->old_client_id)->where('old_id',$row['puniqid'])->first();
                }*/
                $policyID = $this->policy_list[$row['puniqid']] ?? 0;
                if (!empty($policyID)) {
                    if($count == 7) {
                        $lastPolicyID = $policyID['PUNIQID'];
                    }
                    if($count > 7 && $lastPolicyID != $policyID['PUNIQID']) {
                        $count = 1;
                    }
                    if($count == $row['myindx']) {
                        if($count == 1) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'FCAGE'     => !empty($row['cage']) ? $row['cage'] : 0,
                                'FHEALTH'   => !empty($row['health']) ? $row['health'] : '',
                                'FDAGE'     => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'FDYEAR'    => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'FDCAUSE'   => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 2) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'MCAGE'     => !empty($row['cage']) ? $row['cage'] : 0,
                                'MHEALTH'   => !empty($row['health']) ? $row['health'] : '',
                                'MDAGE'     => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'MDYEAR'    => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'MDCAUSE'   => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 3) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'BCAGE'     => !empty($row['cage']) ? $row['cage'] : 0,
                                'BHEALTH'   => !empty($row['health']) ? $row['health'] : '',
                                'BDAGE'     => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'BDYEAR'    => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'BDCAUSE'   => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 4) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'SISCAGE'   => !empty($row['cage']) ? $row['cage'] : 0,
                                'SISHEALTH' => !empty($row['health']) ? $row['health'] : '',
                                'SISDAGE'   => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'SISDYEAR'  => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'SISDCAUSE' => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 5) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'SPCAGE'    => !empty($row['cage']) ? $row['cage'] : 0,
                                'SPHEALTH'  => !empty($row['health']) ? $row['health'] : '',
                                'SPDAGE'    => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'SPDYEAR'   => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'SPDCAUSE'  => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 6) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'CMCAGE'    => !empty($row['cage']) ? $row['cage'] : 0,
                                'CMHEALTH'  => !empty($row['health']) ? $row['health'] : '',
                                'CMDAGE'    => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'CMDYEAR'   => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'CMDCAUSE'  => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        } elseif ($count == 7) {
                            $saveDate[$policyID['PUNIQID']][] = [
                                'CFCAGE'    => !empty($row['cage']) ? $row['cage'] : 0,
                                'CFHEALTH'  => !empty($row['health']) ? $row['health'] : '',
                                'CFDAGE'    => !empty($row['deathage']) ? $row['deathage'] : 0,
                                'CFDYEAR'   => !empty($row['deathyr']) ? $row['deathyr'] : '',
                                'CFDCAUSE'  => !empty($row['deathcau']) ? $row['deathcau'] : '',
                            ];
                        }
                    }
                    $count++;
                }
            }
        }

        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,1500,true) as $key => $chunk) {
                foreach ($chunk as $key1 => $value1) {
                    foreach ($value1 as $data) {
                        Policy::where('PUNIQID', $key1)->update($data);
                    }
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1900;
    }
}

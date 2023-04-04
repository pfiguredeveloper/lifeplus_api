<?php

namespace App\Imports;

use App\Models\LifeCellLic\Policy;
use App\Models\LifeCellLic\PolBoc;
use App\Models\LifeCellLic\Agency;
use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Doctor;
use App\Models\LifeCellLic\Bank;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportOldPolicyData implements WithHeadingRow,ToCollection,WithChunkReading
{
    public function  __construct($clientId,$oldClientID,$agency_list,$party_list,$doctor_list,$bank_list)
    {
        $this->client_id     = $clientId;
        $this->old_client_id = $oldClientID;
        $this->agency_list = $agency_list;
        $this->party_list = $party_list;
        $this->doctor_list = $doctor_list;
        $this->bank_list = $bank_list;
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
        Policy::where('old_client_id',$this->old_client_id)->delete();
        $saveDate = [];
        foreach ($rows as $row) {
            
            if($row->filter()->isNotEmpty()) {
                // $agencyID = 0;
                // if(!empty($row['afile'])) {
                //     $agencyID = Agency::where('old_client_id',$this->old_client_id)->where('old_id',$row['afile'])->first();
                // }

                // $party1ID = 0;
                // if(!empty($row['pcode1'])) {
                //     $party1ID = Party::where('old_client_id',$this->old_client_id)->where('old_id',$row['pcode1'])->first();
                // }

                // $party2ID = 0;
                // if(!empty($row['pcode2'])) {
                //     $party2ID = Party::where('old_client_id',$this->old_client_id)->where('old_id',$row['pcode2'])->first();
                // }

                // $refcodeID = 0;
                // if(!empty($row['refcode'])) {
                //     $refcodeID = Party::where('old_client_id',$this->old_client_id)->where('old_id',$row['refcode'])->first();
                // }

                // $doc1ID = 0;
                // if(!empty($row['dcode1'])) {
                //     $doc1ID = Doctor::where('old_client_id',$this->old_client_id)->where('old_id',$row['dcode1'])->first();
                // }

                // $doc2ID = 0;
                // if(!empty($row['dcode2'])) {
                //     $doc2ID = Doctor::where('old_client_id',$this->old_client_id)->where('old_id',$row['dcode2'])->first();
                // }

                // $bankID = 0;
                // if(!empty($row['e_bank_id'])) {
                //     $bankID = Bank::where('old_client_id',$this->old_client_id)->where('old_id',$row['e_bank_id'])->first();
                // }
                $agencyID = $this->agency_list[$row["afile"]] ?? 0;
                $party1ID = $this->party_list[$row["pcode1"]] ?? 0;
                $party2ID = $this->party_list[$row["pcode2"]] ?? 0;
                $refcodeID = $this->party_list[$row["refcode"]] ?? 0;
                $doc1ID = $this->doctor_list[$row["dcode1"]] ?? 0;
                $doc2ID = $this->doctor_list[$row["dcode2"]] ?? 0;
                $bankID = $this->doctor_list[$row["e_bank_id"]] ?? 0;

                $saveDate[] = [
                    'PNAME'         => !empty($row['pname']) ? $row['pname'] : '',
                    'NAME1'         => (!empty($party1ID) && !empty($party1ID['GCODE'])) ? $party1ID['GCODE'] : 0,
                    'BIRTH1'        => (!empty($party1ID) && !empty($party1ID['BD'])) ? $party1ID['BD'] : '',
                    'NAME2'         => (!empty($party2ID) && !empty($party2ID['GCODE'])) ? $party2ID['GCODE'] : 0,
                    'BIRTH2'        => (!empty($party2ID) && !empty($party2ID['BD'])) ? $party2ID['BD'] : '',
                    'REFCODE'       => (!empty($refcodeID) && !empty($refcodeID['GCODE'])) ? $refcodeID['GCODE'] : 0,
                    'PROPNO'        => !empty($row['propno']) ? $row['propno'] : '',
                    'PROPDT'        => !empty($row['propdt']) ? $row['propdt'] : '',
                    'PONO'          => !empty($row['pono']) ? $row['pono'] : '',
                    'RDT'           => (!empty($row['rdt']) && $row['rdt'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['rdt'], '/', '-'))) : null,
                    'CDT'           => !empty($row['cdt']) ? $row['cdt'] : '',
                    'SA'            => !empty($row['sa']) ? $row['sa'] : '',
                    'DEATH_SA'      => !empty($row['death_sa']) ? $row['death_sa'] : '',
                    'MLY_PREM'      => !empty($row['mly_prem']) ? $row['mly_prem'] : '',
                    'BASIC_PREM'    => !empty($row['basic_prem']) ? $row['basic_prem'] : '',
                    'DAB_PREM'      => !empty($row['dab_prem']) ? $row['dab_prem'] : '',
                    'PWB'           => !empty($row['premwaiver']) ? $row['premwaiver'] : 'No',
                    'PWB_PREM'      => !empty($row['pwb_prem']) ? $row['pwb_prem'] : '',
                    'EXTRAPREM'     => !empty($row['extraprem']) ? $row['extraprem'] : '',
                    'TR_SA'         => !empty($row['tr_sa']) ? $row['tr_sa'] : '',
                    'PREM'          => !empty($row['prem']) ? $row['prem'] : '',
                    'TR_PREM'       => !empty($row['tr_prem']) ? $row['tr_prem'] : '',
                    'CIR_SA'        => !empty($row['cir_sa']) ? $row['cir_sa'] : '',
                    'CIR_PREM'      => !empty($row['cir_prem']) ? $row['cir_prem'] : '',
                    'CDB_SA'        => !empty($row['cdb_sa']) ? $row['cdb_sa'] : '',
                    'CDB_PREM'      => !empty($row['cdb_prem']) ? $row['cdb_prem'] : '',
                    'ST_PREM'       => !empty($row['st_prem']) ? $row['st_prem'] : '',
                    'ST_PREM2'      => !empty($row['st_prem2']) ? $row['st_prem2'] : '',
                    'PAIDBY'        => !empty($row['paidby']) ? $row['paidby'] : '',
                    'PLAN'          => !empty($row['plan']) ? $row['plan'] : '',
                    'TERM'          => !empty($row['term']) ? $row['term'] : '',
                    'MTERM'         => !empty($row['mterm']) ? $row['mterm'] : '',
                    'ACCTERM'       => !empty($row['accterm']) ? $row['accterm'] : '',
                    'MODE'          => !empty($row['mode']) ? $row['mode'] : '',
                    'AGE'           => !empty($row['age']) ? $row['age'] : '',
                    // 'fhealth'       => !empty($row['fhealth']) ? $row['fhealth'] : '',
                    'nomi'          => !empty($row['nomi']) ? $row['nomi'] : '',
                    'rela'          => !empty($row['rela']) ? $row['rela'] : '',
                    'appointee'     => !empty($row['appointee']) ? $row['appointee'] : '',
                    'trustee'       => !empty($row['trustee']) ? $row['trustee'] : '',
                    'DELIDT'        => !empty($row['delidt']) ? $row['delidt'] : '',
                    'MCDT'          => !empty($row['mcdt']) ? $row['mcdt'] : '',
                    'PREG'          => !empty($row['preg']) ? $row['preg'] : '',
                    'LPP'           => !empty($row['lpp']) ? $row['lpp'] : '',
                    'FUP'           => !empty($row['fup']) ? $row['fup'] : '',
                    'BCODE'         => !empty($row['bcode']) ? $row['bcode'] : '',
                    'BRANCH'        => !empty($row['branch']) ? $row['branch'] : '',
                    'PACODE'        => !empty($row['pacode']) ? $row['pacode'] : '',
                    'POL_STATUS'    => !empty($row['pol_status']) ? $row['pol_status'] : '',
                    'AGCODE'        => !empty($row['agcode']) ? $row['agcode'] : '',
                    'DAB'           => !empty($row['dab']) ? $row['dab'] : '',
                    'DABSA'         => !empty($row['dabsa']) ? $row['dabsa'] : '',
                    // 'dm1'           => !empty($row['dm1']) ? $row['dm1'] : '',
                    // 'dm2'           => !empty($row['dm2']) ? $row['dm2'] : '',
                    // 'dm3'           => !empty($row['dm3']) ? $row['dm3'] : '',
                    // 'dm4'           => !empty($row['dm4']) ? $row['dm4'] : '',
                    // 'lmonth'        => !empty($row['lmonth']) ? $row['lmonth'] : '',
                    'DOC_M'         => (!empty($doc1ID) && !empty($doc1ID['DCODE'])) ? $doc1ID['DCODE'] : 0,
                    'MEDI_DT_M'     => !empty($row['medi_dt_m']) ? $row['medi_dt_m'] : '',
                    'HEIGHT_M'      => !empty($row['height_m']) ? $row['height_m'] : '',
                    'WEIGHT_M'      => !empty($row['weight_m']) ? $row['weight_m'] : '',
                    'ABD_M'         => !empty($row['abd_m']) ? $row['abd_m'] : '',
                    'CHEST_EX_M'    => !empty($row['chest_ex_m']) ? $row['chest_ex_m'] : '',
                    'CHEST_IN_M'    => !empty($row['chest_in_m']) ? $row['chest_in_m'] : '',
                    'BP_HI_M'       => !empty($row['bp_hi_m']) ? $row['bp_hi_m'] : '',
                    'BP_LOW_M'      => !empty($row['bp_low_m']) ? $row['bp_low_m'] : '',
                    'PULSE_M'       => !empty($row['pulse_m']) ? $row['pulse_m'] : '',
                    'DOC_F'         => (!empty($doc2ID) && !empty($doc2ID['DCODE'])) ? $doc2ID['DCODE'] : 0,
                    'MEDI_DT_F'     => !empty($row['medi_dt_f']) ? $row['medi_dt_f'] : '',
                    'HEIGHT_F'      => !empty($row['height_f']) ? $row['height_f'] : '',
                    'WEIGHT_F'      => !empty($row['weight_f']) ? $row['weight_f'] : '',
                    'ABD_F'         => !empty($row['abd_f']) ? $row['abd_f'] : '',
                    'CHEST_EX_F'    => !empty($row['chest_ex_f']) ? $row['chest_ex_f'] : '',
                    'CHEST_IN_F'    => !empty($row['chest_in_f']) ? $row['chest_in_f'] : '',
                    'BP_HI_F'       => !empty($row['bp_hi_f']) ? $row['bp_hi_f'] : '',
                    'BP_LOW_F'      => !empty($row['bp_low_f']) ? $row['bp_low_f'] : '',
                    'PULSE_F'       => !empty($row['pulse_f']) ? $row['pulse_f'] : '',
                    'NOTE'          => !empty($row['note']) ? $row['note'] : '',
                    'REMARKS'       => !empty($row['remarks']) ? $row['remarks'] : '',
                    'FUPDATE'       => (!empty($row['fupdate']) && $row['fupdate'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['fupdate'], '/', '-'))) : null,
                    'LPPDATE'       => (!empty($row['lppdate']) && $row['lppdate'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['lppdate'], '/', '-'))) : null,
                    'MATDATE'       => (!empty($row['matdate']) && $row['matdate'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['matdate'], '/', '-'))) : null,
                    'LASTPREM'      => (!empty($row['lastprem']) && $row['lastprem'] != '/  /') ? date('Y-m-d', strtotime(strtr($row['lastprem'], '/', '-'))) : null,
                    'SERVICE'       => !empty($row['service']) ? $row['service'] : '',
                    'OPT_122'       => !empty($row['opt_122']) ? $row['opt_122'] : '',
                    'TYPE_122'      => !empty($row['type_122']) ? $row['type_122'] : '',
                    'LIFE_COVER'    => !empty($row['life_cover']) ? $row['life_cover'] : '',
                    'NCO'           => !empty($row['nco']) ? $row['nco'] : '',
                    'PENSION'       => !empty($row['pension']) ? $row['pension'] : '',
                    // 'termrider'     => !empty($row['termrider']) ? $row['termrider'] : '',
                    // 'ci_rider'      => !empty($row['ci_rider']) ? $row['ci_rider'] : '',
                    // 'tr_date'       => !empty($row['tr_date']) ? $row['tr_date'] : '',
                    'PROP_AGE'      => !empty($row['prop_age']) ? $row['prop_age'] : '',
                    'AGNO'          => !empty($row['agno']) ? $row['agno'] : '',
                    'AFILE'         => (!empty($agencyID) && !empty($agencyID['AFILE'])) ? $agencyID['AFILE'] : 0,
                    // 'eff_date'      => !empty($row['eff_date']) ? $row['eff_date'] : '',
                    // 'loanamt'       => !empty($row['loanamt']) ? $row['loanamt'] : '',
                    // 'loandt'        => !empty($row['loandt']) ? $row['loandt'] : '',
                    // 'loanfupdt'     => !empty($row['loanfupdt']) ? $row['loanfupdt'] : '',
                    // 'loanint'       => !empty($row['loanint']) ? $row['loanint'] : '',
                    // 'intpaiddt'     => !empty($row['intpaiddt']) ? $row['intpaiddt'] : '',
                    'AG_HANDI'      => !empty($row['ag_handi']) ? $row['ag_handi'] : '',
                    'ANN_MODE'      => !empty($row['ann_mode']) ? $row['ann_mode'] : '',
                    'boc_no1'       => !empty($row['boc_no1']) ? $row['boc_no1'] : '',
                    'boc_no2'       => !empty($row['boc_no2']) ? $row['boc_no2'] : '',
                    'boc_no3'       => !empty($row['boc_no3']) ? $row['boc_no3'] : '',
                    'boc_no4'       => !empty($row['boc_no4']) ? $row['boc_no4'] : '',
                    'boc_dt1'       => !empty($row['boc_dt1']) ? date('m/d/Y', strtotime(strtr($row['boc_dt1'], '/', '-'))) : '',
                    'boc_dt2'       => !empty($row['boc_dt2']) ? date('m/d/Y', strtotime(strtr($row['boc_dt2'], '/', '-'))) : '',
                    'boc_dt3'       => !empty($row['boc_dt3']) ? date('m/d/Y', strtotime(strtr($row['boc_dt3'], '/', '-'))) : '',
                    'boc_dt4'       => !empty($row['boc_dt4']) ? date('m/d/Y', strtotime(strtr($row['boc_dt4'], '/', '-'))) : '',
                    'boc_amt1'      => !empty($row['boc_amt1']) ? $row['boc_amt1'] : '',
                    'boc_amt2'      => !empty($row['boc_amt2']) ? $row['boc_amt2'] : '',
                    'boc_amt3'      => !empty($row['boc_amt3']) ? $row['boc_amt3'] : '',
                    'boc_amt4'      => !empty($row['boc_amt4']) ? $row['boc_amt4'] : '',
                    // 'mhr_auth'      => !empty($row['mhr_auth']) ? $row['mhr_auth'] : '',
                    'SPL_REPORT'    => !empty($row['spl_report']) ? $row['spl_report'] : '',
                    // 'tasa'          => !empty($row['tasa']) ? $row['tasa'] : '',
                    // 'suc'           => !empty($row['suc']) ? $row['suc'] : '',
                    // 'mod_suc'       => !empty($row['mod_suc']) ? $row['mod_suc'] : '',
                    // 'conv_type'     => !empty($row['conv_type']) ? $row['conv_type'] : '',
                    // 'new_term'      => !empty($row['new_term']) ? $row['new_term'] : '',
                    // 'new_prem'      => !empty($row['new_prem']) ? $row['new_prem'] : '',
                    // 'newfupdate'    => !empty($row['newfupdate']) ? $row['newfupdate'] : '',
                    // 'newmode'       => !empty($row['newmode']) ? $row['newmode'] : '',
                    // 'claim_amt'     => !empty($row['claim_amt']) ? $row['claim_amt'] : '',
                    // 'surr_amt'      => !empty($row['surr_amt']) ? $row['surr_amt'] : '',
                    'NAV'           => !empty($row['nav']) ? $row['nav'] : '',
                    'NAVGR'         => !empty($row['navgr']) ? $row['navgr'] : '',
                    'FUNDTYPE'      => !empty($row['fundtype']) ? $row['fundtype'] : '',
                    'BANKNAME'      => !empty($row['bankname']) ? $row['bankname'] : '',
                    'EXPDT'         => !empty($row['expdt']) ? $row['expdt'] : '',
                    //'brate186'      => !empty($row['brate186']) ? $row['brate186'] : '',
                    //'settle'        => !empty($row['settle']) ? $row['settle'] : '',
                    //'sett_type'     => !empty($row['sett_type']) ? $row['sett_type'] : '',
                    //'sett_yr'       => !empty($row['sett_yr']) ? $row['sett_yr'] : '',
                    'LOYAL_RATE'    => !empty($row['loyal_rate']) ? $row['loyal_rate'] : '',
                    'LOYAL_STEP'    => !empty($row['loyal_step']) ? $row['loyal_step'] : '',
                    'ECS_MODE'      => !empty($row['ecs_mode']) ? $row['ecs_mode'] : '',
                    'E_BANK_ID'     => (!empty($bankID) && !empty($bankID['BANKCD'])) ? $bankID['BANKCD'] : 0,
                    'E_BANK'        => (!empty($bankID) && !empty($bankID['BANKCD'])) ? $bankID['BANKCD'] : 0,
                    'E_BRANCH'      => !empty($row['e_branch']) ? $row['e_branch'] : '',
                    'E_ADD'         => !empty($row['e_add']) ? $row['e_add'] : '',
                    'E_ACTYPE'      => !empty($row['e_actype']) ? $row['e_actype'] : '',
                    'E_ACNO'        => !empty($row['e_acno']) ? $row['e_acno'] : '',
                    'E_MICR'        => !empty($row['e_micr']) ? $row['e_micr'] : '',
                    'E_ACNAME'      => !empty($row['e_acname']) ? $row['e_acname'] : '',
                    'LIFEPLUSID'    => !empty($row['lifeplusid']) ? $row['lifeplusid'] : '',
                    'ALLOWCOMM'     => !empty($row['allowcomm']) ? $row['allowcomm'] : '',
                    'DEMODATA'      => !empty($row['demodata']) ? $row['demodata'] : '',
                    'CNTLIVES'      => !empty($row['cntlives']) ? $row['cntlives'] : '',
                    'CNTPOL'        => !empty($row['cntpol']) ? $row['cntpol'] : '',
                    'POLTYPE'       => !empty($row['poltype']) ? $row['poltype'] : '',
                    //'fab'           => !empty($row['fab']) ? $row['fab'] : '',
                    //'ocode'         => !empty($row['ocode']) ? $row['ocode'] : '',
                    'CLOUD_D'       => !empty($row['cloud_d']) ? $row['cloud_d'] : '',
                    'NRI'           => !empty($row['nri']) ? $row['nri'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => !empty($row['puniqid']) ? $row['puniqid'] : 0,
                    'old_client_id' => $this->old_client_id,
                ];
            }
        }
        if (!empty($saveDate) && count($saveDate) > 0) {
            foreach (array_chunk($saveDate,500) as $chunk) {
                DB::connection('lifecell_lic')->table('pol')->insert($chunk);
            }

            $policyGet    = Policy::where('old_client_id',$this->old_client_id)->get();
            $saveBOCData1 = [];
            $saveBOCData2 = [];
            $saveBOCData3 = [];
            $saveBOCData4 = [];
            $saveNOMIData = [];

            if(!empty($policyGet) && count($policyGet) > 0) {
                foreach ($policyGet as $key => $value) {
                    if(!empty($value['boc_no1'])) {
                        $saveBOCData1[] = [
                            'BRANCHNO'    => !empty($value['boc_no1']) ? $value['boc_no1'] : 0,
                            'BRANCHDT'    => !empty($value['boc_dt1']) ? $value['boc_dt1'] : '',
                            'BRANCHAMT'   => !empty($value['boc_amt1']) ? $value['boc_amt1'] : '',
                            'POLID'       => !empty($value['PUNIQID']) ? $value['PUNIQID'] : 0,
                        ];
                    }
                    
                    if(!empty($value['boc_no2'])) {
                        $saveBOCData2[] = [
                            'BRANCHNO'    => !empty($value['boc_no2']) ? $value['boc_no2'] : 0,
                            'BRANCHDT'    => !empty($value['boc_dt2']) ? $value['boc_dt2'] : '',
                            'BRANCHAMT'   => !empty($value['boc_amt2']) ? $value['boc_amt2'] : '',
                            'POLID'       => !empty($value['PUNIQID']) ? $value['PUNIQID'] : 0,
                        ];
                    }

                    if(!empty($value['boc_no3'])) {
                        $saveBOCData3[] = [
                            'BRANCHNO'    => !empty($value['boc_no3']) ? $value['boc_no3'] : 0,
                            'BRANCHDT'    => !empty($value['boc_dt3']) ? $value['boc_dt3'] : '',
                            'BRANCHAMT'   => !empty($value['boc_amt3']) ? $value['boc_amt3'] : '',
                            'POLID'       => !empty($value['PUNIQID']) ? $value['PUNIQID'] : 0,
                        ];
                    }

                    if(!empty($value['boc_no4'])) {
                        $saveBOCData4[] = [
                            'BRANCHNO'    => !empty($value['boc_no4']) ? $value['boc_no4'] : 0,
                            'BRANCHDT'    => !empty($value['boc_dt4']) ? $value['boc_dt4'] : '',
                            'BRANCHAMT'   => !empty($value['boc_amt4']) ? $value['boc_amt4'] : '',
                            'POLID'       => !empty($value['PUNIQID']) ? $value['PUNIQID'] : 0,
                        ];
                    }

                    if(!empty($value['nomi'])) {
                        $saveNOMIData[] = [
                            'NOMINEE'     => !empty($value['nomi']) ? $value['nomi'] : '',
                            'AGE'         => !empty($value['AGE']) ? $value['AGE'] : '',
                            'RELATION'    => !empty($value['rela']) ? ucFirst(strtolower($value['rela'])) : '',
                            'SHARE'       => !empty($value['trustee']) ? $value['trustee'] : '',
                            'APPOINTEE'   => 'Appointee',
                            'POLID'       => !empty($value['PUNIQID']) ? $value['PUNIQID'] : 0,
                        ];
                    }
                }
            }

            if (!empty($saveBOCData1) && count($saveBOCData1)) {
                foreach (array_chunk($saveBOCData1,1500) as $chunk1) {
                    DB::connection('lifecell_lic')->table('pol_boc')->insert($chunk1);
                }
            }
            if (!empty($saveBOCData2) && count($saveBOCData2)) {
                foreach (array_chunk($saveBOCData2,1500) as $chunk2) {
                    DB::connection('lifecell_lic')->table('pol_boc')->insert($chunk2);
                }
            }
            if (!empty($saveBOCData3) && count($saveBOCData3)) {
                foreach (array_chunk($saveBOCData3,1500) as $chunk3) {
                    DB::connection('lifecell_lic')->table('pol_boc')->insert($chunk3);
                }
            }
            if (!empty($saveBOCData4) && count($saveBOCData4)) {
                foreach (array_chunk($saveBOCData4,1500) as $chunk4) {
                    DB::connection('lifecell_lic')->table('pol_boc')->insert($chunk4);
                }
            }
            if (!empty($saveNOMIData) && count($saveNOMIData)) {
                foreach (array_chunk($saveNOMIData,1500) as $chunk5) {
                    DB::connection('lifecell_lic')->table('pol_nominee')->insert($chunk5);
                }
            }
        }
    }
}

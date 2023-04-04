<?php

namespace App\Imports;

use App\Models\LifeCellLic\SetupServicingReports;
use App\Models\LifeCellLic\SetupGSTRate;
use App\Models\LifeCellLic\SetupPlan;
use App\Models\LifeCellLic\SetupReminder;
use App\Models\LifeCellLic\Caption;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportOldControlData implements WithHeadingRow,ToCollection
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
        SetupServicingReports::where('old_client_id',$this->old_client_id)->delete();
        SetupGSTRate::where('old_client_id',$this->old_client_id)->delete();
        SetupPlan::where('old_client_id',$this->old_client_id)->delete();
        SetupReminder::where('old_client_id',$this->old_client_id)->delete();

        $saveDate  = [];
        $saveDate2 = [];
        $saveDate3 = [];
        $saveDate4 = [];

        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()) {
                $cap1 = 0;
                if(!empty($row['cap1'])) {
                    $cap1 = Caption::where('old_client_id',$this->old_client_id)->where('CAP1','like','%' .$row['cap1']. '%')->first();
                }
                $cap2 = 0;
                if(!empty($row['cap2'])) {
                    $cap2 = Caption::where('old_client_id',$this->old_client_id)->where('CAP1','like','%' .$row['cap2']. '%')->first();
                }

                $saveDate[] = [
                    'title'         => 'Pfiger Software Technologies',
                    'address1'      => !empty($row['aad1']) ? $row['aad1'] : '',
                    'address2'      => !empty($row['aad2']) ? $row['aad2'] : '',
                    'address3'      => !empty($row['aad3']) ? $row['aad3'] : '',
                    'address4'      => !empty($row['aad4']) ? $row['aad4'] : '',
                    'address5'      => !empty($row['aad5']) ? $row['aad5'] : '',
                    'warning'       => !empty($row['warning']) ? $row['warning'] : '',
                    'cap1'          => (!empty($cap1) && !empty($cap1['CAPCD'])) ? $cap1['CAPCD'] : 0,
                    'cap2'          => (!empty($cap2) && !empty($cap2['CAPCD'])) ? $cap2['CAPCD'] : 0,
                    'client_id'     => $this->client_id,
                    'old_id'        => 0,
                    'old_client_id' => $this->old_client_id,
                ];

                $saveDate2[] = [
                    'gst_in_report' => !empty($row['st_yn']) ? $row['st_yn'] : '',
                    'gst_ann'       => !empty($row['st_surp']) ? $row['st_surp'].'%' : '',
                    'tax_ann_1'     => !empty($row['st_surps']) ? $row['st_surps'] : '',
                    'tax_ann_2'     => !empty($row['st_surpk']) ? $row['st_surpk'] : '',
                    'gst_term'      => !empty($row['st_sur']) ? $row['st_sur'].'%' : '',
                    'tax_term_1'    => !empty($row['st_surs']) ? $row['st_surs'] : '',
                    'tax_term_2'    => !empty($row['st_surk']) ? $row['st_surk'] : '',
                    'gst_risk_1'    => !empty($row['st_risk']) ? $row['st_risk'] : '',
                    'gst_risk_2'    => !empty($row['st_risk2']) ? $row['st_risk2'] : '',
                    'tax_risk_1'    => !empty($row['st_risks']) ? $row['st_risks'] : '',
                    'tax_risk_2'    => !empty($row['st_riskk']) ? $row['st_riskk'] : '',
                    'client_id'     => $this->client_id,
                    'old_id'        => 0,
                    'old_client_id' => $this->old_client_id,
                ];

                $saveDate3[] = [
                    'loan_relnv_rate'     => !empty($row['defa_rate']) ? $row['defa_rate'] : '',
                    'mb_relnv_rate'       => !empty($row['mb_roi_rei']) ? $row['mb_roi_rei'] : '',
                    'yield'               => !empty($row['cal_yield']) ? $row['cal_yield'] : '',
                    'other_interest_rate' => !empty($row['oinv_roi']) ? $row['oinv_roi'] : '',
                    'db_invest_rate'      => !empty($row['b_datert']) ? $row['b_datert'] : '',
                    'client_id'           => $this->client_id,
                    'old_id'              => 0,
                    'old_client_id'       => $this->old_client_id,
                ];

                $saveDate4[] = [
                    'is_disable_reminder'   => 'No',
                    'birthday_rm'           => !empty($row['bd_rem']) ? $row['bd_rem'] : '',
                    'birthday_rm_bf'        => !empty($row['bd_day']) ? $row['bd_day'] : 0,
                    'birthday_rm_af'        => !empty($row['bd_daya']) ? $row['bd_daya'] : 0,
                    'agent_birthday_rm'     => !empty($row['agbd_rem']) ? $row['agbd_rem'] : '',
                    'agent_birthday_rm_bf'  => !empty($row['agbd_day']) ? $row['agbd_day'] : 0,
                    'agent_birthday_rm_af'  => !empty($row['agbd_daya']) ? $row['agbd_daya'] : 0,
                    'marriage_ann_rm'       => !empty($row['ma_rem']) ? $row['ma_rem'] : '',
                    'marriage_ann_rm_bf'    => !empty($row['ma_day']) ? $row['ma_day'] : 0,
                    'marriage_ann_rm_af'    => !empty($row['ma_daya']) ? $row['ma_daya'] : 0,
                    'fup_rm'                => !empty($row['fup_rem']) ? $row['fup_rem'] : '',
                    'fup_rm_bf'             => !empty($row['fup_day']) ? $row['fup_day'] : 0,
                    'fup_rm_af'             => !empty($row['fup_daya']) ? $row['fup_daya'] : 0,
                    'term_insurance_rm'     => !empty($row['term_rem']) ? $row['term_rem'] : '',
                    'term_insurance_rm_bf'  => !empty($row['term_day']) ? $row['term_day'] : 0,
                    'term_insurance_rm_af'  => !empty($row['term_daya']) ? $row['term_daya'] : 0,
                    'ulip_plan_rm'          => !empty($row['ulip_rem']) ? $row['ulip_rem'] : '',
                    'ulip_plan_rm_bf'       => !empty($row['ulip_day']) ? $row['ulip_day'] : 0,
                    'ulip_plan_rm_af'       => !empty($row['ulip_daya']) ? $row['ulip_daya'] : 0,
                    'agency_expiry_rm'      => !empty($row['agexp_rem']) ? $row['agexp_rem'] : '',
                    'agency_expiry_rm_bf'   => !empty($row['agexp_day']) ? $row['agexp_day'] : 0,
                    'agency_expiry_rm_af'   => !empty($row['agexp_daya']) ? $row['agexp_daya'] : 0,
                    'licence_expiry_rm'     => !empty($row['lcexp_rem']) ? $row['lcexp_rem'] : '',
                    'licence_expiry_rm_bf'  => !empty($row['lcexp_day']) ? $row['lcexp_day'] : 0,
                    'licence_expiry_rm_af'  => !empty($row['lcexp_daya']) ? $row['lcexp_daya'] : 0,
                    'last_renew_rm'         => !empty($row['arexp_rem']) ? $row['arexp_rem'] : '',
                    'last_renew_rm_bf'      => !empty($row['arexp_day']) ? $row['arexp_day'] : 0,
                    'last_renew_rm_af'      => !empty($row['arexp_daya']) ? $row['arexp_daya'] : 0,
                    'to_do_rm'              => !empty($row['todo_rem']) ? $row['todo_rem'] : '',
                    'to_do_rm_bf'           => !empty($row['todo_day']) ? $row['todo_day'] : 0,
                    'to_do_rm_af'           => !empty($row['todo_daya']) ? $row['todo_daya'] : 0,
                    'health_plan_rm'        => !empty($row['hlth_rem']) ? $row['hlth_rem'] : '',
                    'health_plan_rm_bf'     => !empty($row['hlth_day']) ? $row['hlth_day'] : 0,
                    'health_plan_rm_af'     => !empty($row['hlth_daya']) ? $row['hlth_daya'] : 0,
                    'maturity_rm'           => !empty($row['mat_rem']) ? $row['mat_rem'] : '',
                    'maturity_rm_bf'        => !empty($row['mat_day']) ? $row['mat_day'] : 0,
                    'maturity_rm_af'        => !empty($row['mat_daya']) ? $row['mat_daya'] : 0,
                    'money_back_rm'         => !empty($row['mb_rem']) ? $row['mb_rem'] : '',
                    'money_back_rm_bf'      => !empty($row['mb_day']) ? $row['mb_day'] : 0,
                    'money_back_rm_af'      => !empty($row['mb_daya']) ? $row['mb_daya'] : 0,
                    'client_id'             => $this->client_id,
                    'old_id'                => 0,
                    'old_client_id'         => $this->old_client_id,
                ];
            }
        }

        if (!empty($saveDate) && count($saveDate) > 0) {
            SetupServicingReports::insert($saveDate);
        }
        if (!empty($saveDate2) && count($saveDate2) > 0) {
            SetupGSTRate::insert($saveDate2);
        }
        if (!empty($saveDate3) && count($saveDate3) > 0) {
            SetupPlan::insert($saveDate3);
        }
        if (!empty($saveDate4) && count($saveDate4) > 0) {
            SetupReminder::insert($saveDate4);
        }

    }
}

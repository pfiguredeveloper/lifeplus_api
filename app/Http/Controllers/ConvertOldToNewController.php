<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\LifeCell\Plan;
use App\Models\LifeCell\OldPlan;

class ConvertOldToNewController extends Controller
{
    public function converOldToNew(Request $request) {
        try {

            $saveDate = [];
            
            $oldPlan = OldPlan::get();
            
            foreach ($oldPlan as $row) {
                $newPlan = Plan::where('plno',$row['plno'])->first();
                if(empty($newPlan)) {
                    $saveDate[] = [
                        'plannm'                    => !empty($row['plannm']) ? $row['plannm'] : '',
                        'planid'                    => !empty($row['planid']) ? $row['planid'] : '',
                        'plangrpid'                 => !empty($row['plangrpid']) ? $row['plangrpid'] : '',
                        'plno'                      => !empty($row['plno']) ? $row['plno'] : '',
                        'effe_from'                 => !empty($row['effe_from']) ? $row['effe_from'] : '',
                        'effe_to'                   => !empty($row['effe_to']) ? $row['effe_to'] : '',
                        'po_term'                   => !empty($row['po_term']) ? $row['po_term'] : '',
                        'pr_term'                   => !empty($row['pr_term']) ? $row['pr_term'] : '',
                        'po_pr_same'                => !empty($row['po_pr_same']) ? $row['po_pr_same'] : '',
                        'sp_po_pr'                  => !empty($row['sp_po_pr']) ? $row['sp_po_pr'] : '',
                        'sp_po_term'                => !empty($row['sp_po_term']) ? $row['sp_po_term'] : '',
                        'sp_pr_term'                => !empty($row['sp_pr_term']) ? $row['sp_pr_term'] : '',
                        'name2'                     => !empty($row['name2']) ? $row['name2'] : '',
                        'mb'                        => !empty($row['mb']) ? $row['mb'] : '',
                        'commission'                => !empty($row['commission']) ? $row['commission'] : '',
                        'year1'                     => !empty($row['year1']) ? $row['year1'] : '',
                        'a_year'                    => !empty($row['a_year']) ? $row['a_year'] : '',
                        'year2'                     => !empty($row['year2']) ? $row['year2'] : '',
                        'per1'                      => !empty($row['per1']) ? $row['per1'] : '',
                        'per2'                      => !empty($row['per2']) ? $row['per2'] : '',
                        'valmod'                    => !empty($row['valmod']) ? $row['valmod'] : '',
                        'per_single'                => !empty($row['per_single']) ? $row['per_single'] : '',
                        'per_a1'                    => !empty($row['per_a1']) ? $row['per_a1'] : '',
                        'per_a2'                    => !empty($row['per_a2']) ? $row['per_a2'] : '',
                        'per_a3'                    => !empty($row['per_a3']) ? $row['per_a3'] : '',
                        'per_b1'                    => !empty($row['per_b1']) ? $row['per_b1'] : '',
                        'per_b2'                    => !empty($row['per_b2']) ? $row['per_b2'] : '',
                        'per_b3'                    => !empty($row['per_b3']) ? $row['per_b3'] : '',
                        'per_c1'                    => !empty($row['per_c1']) ? $row['per_c1'] : '',
                        'per_c2'                    => !empty($row['per_c2']) ? $row['per_c2'] : '',
                        'per_c3'                    => !empty($row['per_c3']) ? $row['per_c3'] : '',
                        'per_d1'                    => !empty($row['per_d1']) ? $row['per_d1'] : '',
                        'per_d2'                    => !empty($row['per_d2']) ? $row['per_d2'] : '',
                        'per_d3'                    => !empty($row['per_d3']) ? $row['per_d3'] : '',
                        'agemin'                    => !empty($row['agemin']) ? $row['agemin'] : '',
                        'agemax'                    => !empty($row['agemax']) ? $row['agemax'] : '',
                        'termmin'                   => !empty($row['termmin']) ? $row['termmin'] : '',
                        'termmax'                   => !empty($row['termmax']) ? $row['termmax'] : '',
                        'rtermmin'                  => !empty($row['rtermmin']) ? $row['rtermmin'] : '',
                        'rtermmax'                  => !empty($row['rtermmax']) ? $row['rtermmax'] : '',
                        'rprmceas'                  => !empty($row['rprmceas']) ? $row['rprmceas'] : '',
                        'samin'                     => !empty($row['samin']) ? $row['samin'] : '',
                        'samax'                     => !empty($row['samax']) ? $row['samax'] : '',
                        'sa_multi'                  => !empty($row['sa_multi']) ? $row['sa_multi'] : '',
                        'reb_y'                     => !empty($row['reb_y']) ? $row['reb_y'] : '',
                        'reb_h'                     => !empty($row['reb_h']) ? $row['reb_h'] : '',
                        'reb_q'                     => !empty($row['reb_q']) ? $row['reb_q'] : '',
                        'reb_m'                     => !empty($row['reb_m']) ? $row['reb_m'] : '',
                        'reb_i'                     => !empty($row['reb_i']) ? $row['reb_i'] : '',
                        'r25_49'                    => !empty($row['r25_49']) ? $row['r25_49'] : '',
                        'r50000'                    => !empty($row['r50000']) ? $row['r50000'] : '',
                        'loangen'                   => !empty($row['loangen']) ? $row['loangen'] : '',
                        'loanhouse'                 => !empty($row['loanhouse']) ? $row['loanhouse'] : '',
                        'loan_quot'                 => !empty($row['loan_quot']) ? $row['loan_quot'] : '',
                        'loan'                      => !empty($row['loan']) ? $row['loan'] : '',
                        'status'                    => !empty($row['status']) ? $row['status'] : '',
                        'pltype'                    => !empty($row['pltype']) ? $row['pltype'] : '',
                        'profit'                    => !empty($row['profit']) ? $row['profit'] : '',
                        'matage'                    => !empty($row['matage']) ? $row['matage'] : '',
                        'compare'                   => !empty($row['compare']) ? $row['compare'] : '',
                        'quot'                      => !empty($row['quot']) ? $row['quot'] : '',
                        'single'                    => !empty($row['single']) ? $row['single'] : '',
                        'salient'                   => !empty($row['salient']) ? $row['salient'] : '',
                        'salient1'                  => !empty($row['salient1']) ? $row['salient1'] : '',
                        'plandet1'                  => !empty($row['plandet1']) ? $row['plandet1'] : '',
                        'plandet2'                  => !empty($row['plandet2']) ? $row['plandet2'] : '',
                        'plandet3'                  => !empty($row['plandet3']) ? $row['plandet3'] : '',
                        'planpic1'                  => !empty($row['planpic1']) ? $row['planpic1'] : '',
                        'planpic2'                  => !empty($row['planpic2']) ? $row['planpic2'] : '',
                        'planpic3'                  => !empty($row['planpic3']) ? $row['planpic3'] : '',
                        'wdab'                      => !empty($row['wdab']) ? $row['wdab'] : '',
                        'cr_15'                     => !empty($row['cr_15']) ? $row['cr_15'] : '',
                        'cr_10_14'                  => !empty($row['cr_10_14']) ? $row['cr_10_14'] : '',
                        'cr_6_9'                    => !empty($row['cr_6_9']) ? $row['cr_6_9'] : '',
                        'cr_5'                      => !empty($row['cr_5']) ? $row['cr_5'] : '',
                        'cr_single'                 => !empty($row['cr_single']) ? $row['cr_single'] : '',
                        'term_rider'                => !empty($row['term_rider']) ? $row['term_rider'] : '',
                        'tr_effe_dt'                => !empty($row['tr_effe_dt']) ? $row['tr_effe_dt'] : '',
                        'min_trsa'                  => !empty($row['min_trsa']) ? $row['min_trsa'] : '',
                        'min_bsa_tr'                => !empty($row['min_bsa_tr']) ? $row['min_bsa_tr'] : '',
                        'ci_rider'                  => !empty($row['ci_rider']) ? $row['ci_rider'] : '',
                        'ci_effe_dt'                => !empty($row['ci_effe_dt']) ? $row['ci_effe_dt'] : '',
                        'min_cirsa'                 => !empty($row['min_cirsa']) ? $row['min_cirsa'] : '',
                        'max_cirsa'                 => !empty($row['max_cirsa']) ? $row['max_cirsa'] : '',
                        'min_bsa_ci'                => !empty($row['min_bsa_ci']) ? $row['min_bsa_ci'] : '',
                        'min_cir_ag'                => !empty($row['min_cir_ag']) ? $row['min_cir_ag'] : '',
                        'max_cir_ag'                => !empty($row['max_cir_ag']) ? $row['max_cir_ag'] : '',
                        'mat_cir_ag'                => !empty($row['mat_cir_ag']) ? $row['mat_cir_ag'] : '',
                        'pw_benefit'                => !empty($row['pw_benefit']) ? $row['pw_benefit'] : '',
                        'pwb_plan'                  => !empty($row['pwb_plan']) ? $row['pwb_plan'] : '',
                        'pwb_eff_dt'                => !empty($row['pwb_eff_dt']) ? $row['pwb_eff_dt'] : '',
                        'reckoner'                  => !empty($row['reckoner']) ? $row['reckoner'] : '',
                        'suggest'                   => !empty($row['suggest']) ? $row['suggest'] : '',
                        'ispuregadd'                => !empty($row['ispuregadd']) ? $row['ispuregadd'] : '',
                        'g_addition'                => !empty($row['g_addition']) ? $row['g_addition'] : '',
                        'isloyalty'                 => !empty($row['isloyalty']) ? $row['isloyalty'] : '',
                        'loyalstep'                 => !empty($row['loyalstep']) ? $row['loyalstep'] : '',
                        'recsa1'                    => !empty($row['recsa1']) ? $row['recsa1'] : '',
                        'recdabsa1'                 => !empty($row['recdabsa1']) ? $row['recdabsa1'] : '',
                        'recsa2'                    => !empty($row['recsa2']) ? $row['recsa2'] : '',
                        'recdabsa2'                 => !empty($row['recdabsa2']) ? $row['recdabsa2'] : '',
                        'recsa3'                    => !empty($row['recsa3']) ? $row['recsa3'] : '',
                        'recdabsa3'                 => !empty($row['recdabsa3']) ? $row['recdabsa3'] : '',
                        'recsa4'                    => !empty($row['recsa4']) ? $row['recsa4'] : '',
                        'recdabsa4'                 => !empty($row['recdabsa4']) ? $row['recdabsa4'] : '',
                        'keyman'                    => !empty($row['keyman']) ? $row['keyman'] : '',
                        'agec_min'                  => !empty($row['agec_min']) ? $row['agec_min'] : '',
                        'agec_max'                  => !empty($row['agec_max']) ? $row['agec_max'] : '',
                        'agec_mat'                  => !empty($row['agec_mat']) ? $row['agec_mat'] : '',
                        'mktg'                      => !empty($row['mktg']) ? $row['mktg'] : '',
                        'mobile'                    => !empty($row['mobile']) ? $row['mobile'] : '',
                        'grace_day'                 => !empty($row['grace_day']) ? $row['grace_day'] : '',
                        'uin'                       => !empty($row['uin']) ? $row['uin'] : '',
                        'plnoname'                  => !empty($row['plnoname']) ? $row['plnoname'] : '',
                        'medical'                   => !empty($row['medical']) ? $row['medical'] : '',
                        'groupent'                  => !empty($row['groupent']) ? $row['groupent'] : '',
                        'planpurchase'              => !empty($row['planpurchase']) ? $row['planpurchase'] : '',
                        'rate_table_name'           => !empty($row['rate_table_name']) ? $row['rate_table_name'] : '',
                        'isGST'                     => !empty($row['isGST']) ? $row['isGST'] : '',
                        'mode_dis_y'                => !empty($row['mode_dis_y']) ? $row['mode_dis_y'] : '',
                        'mode_dis_h'                => !empty($row['mode_dis_h']) ? $row['mode_dis_h'] : '',
                        'mode_dis_q'                => !empty($row['mode_dis_q']) ? $row['mode_dis_q'] : '',
                        'mode_dis_m'                => !empty($row['mode_dis_m']) ? $row['mode_dis_m'] : '',
                        'mode_dis_s'                => !empty($row['mode_dis_s']) ? $row['mode_dis_s'] : '',
                        'mode_dis_g'                => !empty($row['mode_dis_g']) ? $row['mode_dis_g'] : '',
                        'mode_dis_wave_y'           => !empty($row['mode_dis_wave_y']) ? $row['mode_dis_wave_y'] : '',
                        'mode_dis_wave_h'           => !empty($row['mode_dis_wave_h']) ? $row['mode_dis_wave_h'] : '',
                        'mode_dis_wave_m'           => !empty($row['mode_dis_wave_m']) ? $row['mode_dis_wave_m'] : '',
                        'mode_dis_wave_q'           => !empty($row['mode_dis_wave_q']) ? $row['mode_dis_wave_q'] : '',
                        'mode_dis_wave_s'           => !empty($row['mode_dis_wave_s']) ? $row['mode_dis_wave_s'] : '',
                        'mode_dis_wave_g'           => !empty($row['mode_dis_wave_g']) ? $row['mode_dis_wave_g'] : '',
                        'max_dab_sa'                => !empty($row['max_dab_sa']) ? $row['max_dab_sa'] : '',
                        'dab_rate_table_name'       => !empty($row['dab_rate_table_name']) ? $row['dab_rate_table_name'] : '',
                        'trsa_table_name'           => !empty($row['trsa_table_name']) ? $row['trsa_table_name'] : '',
                        'cirsa_table_name'          => !empty($row['cirsa_table_name']) ? $row['cirsa_table_name'] : '',
                        'prem_waiver_table_name'    => !empty($row['prem_waiver_table_name']) ? $row['prem_waiver_table_name'] : '',
                        'rate_condition'            => !empty($row['rate_condition']) ? $row['rate_condition'] : '',
                        'sv_table_name'             => !empty($row['sv_table_name']) ? $row['sv_table_name'] : '',
                        'sv_rate_field_name'        => !empty($row['sv_rate_field_name']) ? $row['sv_rate_field_name'] : '',
                        'gsv_table_name'            => !empty($row['gsv_table_name']) ? $row['gsv_table_name'] : '',
                        'gsv_rate_field_name'       => !empty($row['gsv_rate_field_name']) ? $row['gsv_rate_field_name'] : '',
                        'yield_claim'               => !empty($row['yield_claim']) ? $row['yield_claim'] : '',
                        'yield_summary'             => !empty($row['yield_summary']) ? $row['yield_summary'] : '',
                        'cash_value'                => !empty($row['cash_value']) ? $row['cash_value'] : '',
                        'settlement_option'         => !empty($row['settlement_option']) ? $row['settlement_option'] : '',
                        'assumed_age'               => !empty($row['assumed_age']) ? $row['assumed_age'] : '',
                        'assumed_paidup_age'        => !empty($row['assumed_paidup_age']) ? $row['assumed_paidup_age'] : '',
                        'prop_age'                  => !empty($row['prop_age']) ? $row['prop_age'] : '',
                        'loan_int_rate'             => !empty($row['loan_int_rate']) ? $row['loan_int_rate'] : '',
                    ];
                }
            }
            
            if (!empty($saveDate) && count($saveDate) > 0) {
                foreach ($saveDate as $chunk) {
                    DB::connection('lifecell')->table('plan')->insert($chunk);
                }
            }

            return response()->json(["success" => 1, "msg" => "login Successfully.","data"=>[]]);

        } catch (Exception $e) {
            return response()->json(["success" => 0, "msg" => "Oops, something went wrong","data"=>[]]);
        }
    }
}

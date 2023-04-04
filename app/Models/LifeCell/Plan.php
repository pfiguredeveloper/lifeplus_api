<?php
namespace App\Models\LifeCell;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $connection = 'lifecell';
    protected $table      = 'plan';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','plannm', 'planid', 'plangrpid','plno','effe_from','effe_to','po_term','pr_term','po_pr_same','sp_po_pr','sp_po_term','sp_pr_term','name2','mb','year1','a_year',
        'year2','per1','per2','valmod','per_single','per_a1','per_a2','per_a3','per_b1','per_b2',
        'per_b3','per_c1','per_c2','per_c3','per_d1','per_d2','per_d3','agemin','agemax','termmin',
        'termmax','rtermmin','rtermmax','rprmceas','samin','samax','sa_multi','reb_y','reb_h','reb_q',
        'reb_m','reb_i','r25_49','r50000','loangen','loanhouse','loan_quot','loan','status','pltype',
        'profit','matage','compare','quot','single','salient','salient1','plandet1','plandet2','plandet3',
        'planpic1','planpic2','planpic3','wdab','cr_15','cr_10_14','cr_6_9','cr_5','cr_single','term_rider',
        'tr_effe_dt','min_trsa','min_bsa_tr','ci_rider','ci_effe_dt','min_cirsa','max_cirsa','min_bsa_ci','min_cir_ag','max_cir_ag',
        'mat_cir_ag','pw_benefit','pwb_plan','pwb_eff_dt','reckoner','suggest','ispuregadd','g_addition','isloyalty','loyalstep',
        'recsa1','recdabsa1','recsa2','recdabsa2','recsa3','recdabsa3','recsa4','recdabsa4','keyman','agec_min',
        'agec_max','agec_mat','mktg','mobile','grace_day','uin','plnoname','medical','groupent','planpurchase',
        'rate_table_name','isGST','mode_dis_y','mode_dis_h','mode_dis_q','mode_dis_m','mode_dis_s','mode_dis_g','mode_dis_wave_y','mode_dis_wave_h',
        'mode_dis_wave_m','mode_dis_wave_q','mode_dis_wave_s','mode_dis_wave_g','max_dab_sa',
        'dab_rate_table_name','trsa_table_name','cirsa_table_name','prem_waiver_table_name','rate_condition','commission','yield_claim','yield_summary','cash_value','settlement_option','assumed_age','assumed_paidup_age','prop_age','loan_int_rate',
    ];
}


<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SetupReminder extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'setup_reminder';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','is_disable_reminder','birthday_rm','birthday_rm_bf','birthday_rm_af','agent_birthday_rm','agent_birthday_rm_bf','agent_birthday_rm_af','marriage_ann_rm','marriage_ann_rm_bf','marriage_ann_rm_af','fup_rm','fup_rm_bf','fup_rm_af','term_insurance_rm','term_insurance_rm_bf','term_insurance_rm_af','ulip_plan_rm','ulip_plan_rm_bf','ulip_plan_rm_af','agency_expiry_rm','agency_expiry_rm_bf','agency_expiry_rm_af','licence_expiry_rm','licence_expiry_rm_bf','licence_expiry_rm_af','last_renew_rm','last_renew_rm_bf','last_renew_rm_af','to_do_rm','to_do_rm_bf','to_do_rm_af','health_plan_rm','health_plan_rm_bf','health_plan_rm_af','maturity_rm','maturity_rm_bf','maturity_rm_af','money_back_rm','money_back_rm_bf','money_back_rm_af','client_id','old_id','old_client_id',
    ];

    public static function saveReminderSetupData($postData)
    {
    	if(!empty($postData['id'])) {
    		$reminderInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$reminderInfo = new self();
    	}
        $reminderInfo['is_disable_reminder']    = !empty($postData['is_disable_reminder']) ? $postData['is_disable_reminder'] : '';
        $reminderInfo['birthday_rm']            = !empty($postData['birthday_rm']) ? $postData['birthday_rm'] : '';
        $reminderInfo['birthday_rm_bf']         = !empty($postData['birthday_rm_bf']) ? $postData['birthday_rm_bf'] : 0;
        $reminderInfo['birthday_rm_af']         = !empty($postData['birthday_rm_af']) ? $postData['birthday_rm_af'] : 0;
        $reminderInfo['agent_birthday_rm']      = !empty($postData['agent_birthday_rm']) ? $postData['agent_birthday_rm'] : '';
        $reminderInfo['agent_birthday_rm_bf']   = !empty($postData['agent_birthday_rm_bf']) ? $postData['agent_birthday_rm_bf'] : 0;
        $reminderInfo['agent_birthday_rm_af']   = !empty($postData['agent_birthday_rm_af']) ? $postData['agent_birthday_rm_af'] : 0;
        $reminderInfo['marriage_ann_rm']        = !empty($postData['marriage_ann_rm']) ? $postData['marriage_ann_rm'] : '';
        $reminderInfo['marriage_ann_rm_bf']     = !empty($postData['marriage_ann_rm_bf']) ? $postData['marriage_ann_rm_bf'] : 0;
        $reminderInfo['marriage_ann_rm_af']     = !empty($postData['marriage_ann_rm_af']) ? $postData['marriage_ann_rm_af'] : 0;
        $reminderInfo['fup_rm']                 = !empty($postData['fup_rm']) ? $postData['fup_rm'] : '';
        $reminderInfo['fup_rm_bf']              = !empty($postData['fup_rm_bf']) ? $postData['fup_rm_bf'] : 0;
        $reminderInfo['fup_rm_af']              = !empty($postData['fup_rm_af']) ? $postData['fup_rm_af'] : 0;
        $reminderInfo['term_insurance_rm']      = !empty($postData['term_insurance_rm']) ? $postData['term_insurance_rm'] : '';
        $reminderInfo['term_insurance_rm_bf']   = !empty($postData['term_insurance_rm_bf']) ? $postData['term_insurance_rm_bf'] : 0;
        $reminderInfo['term_insurance_rm_af']   = !empty($postData['term_insurance_rm_af']) ? $postData['term_insurance_rm_af'] : 0;
        $reminderInfo['ulip_plan_rm']           = !empty($postData['ulip_plan_rm']) ? $postData['ulip_plan_rm'] : '';
        $reminderInfo['ulip_plan_rm_bf']        = !empty($postData['ulip_plan_rm_bf']) ? $postData['ulip_plan_rm_bf'] : 0;
        $reminderInfo['ulip_plan_rm_af']        = !empty($postData['ulip_plan_rm_af']) ? $postData['ulip_plan_rm_af'] : 0;
        $reminderInfo['agency_expiry_rm']       = !empty($postData['agency_expiry_rm']) ? $postData['agency_expiry_rm'] : '';
        $reminderInfo['agency_expiry_rm_bf']    = !empty($postData['agency_expiry_rm_bf']) ? $postData['agency_expiry_rm_bf'] : 0;
        $reminderInfo['agency_expiry_rm_af']    = !empty($postData['agency_expiry_rm_af']) ? $postData['agency_expiry_rm_af'] : 0;
        $reminderInfo['licence_expiry_rm']      = !empty($postData['licence_expiry_rm']) ? $postData['licence_expiry_rm'] : '';
        $reminderInfo['licence_expiry_rm_bf']   = !empty($postData['licence_expiry_rm_bf']) ? $postData['licence_expiry_rm_bf'] : 0;
        $reminderInfo['licence_expiry_rm_af']   = !empty($postData['licence_expiry_rm_af']) ? $postData['licence_expiry_rm_af'] : 0;
        $reminderInfo['last_renew_rm']          = !empty($postData['last_renew_rm']) ? $postData['last_renew_rm'] : '';
        $reminderInfo['last_renew_rm_bf']       = !empty($postData['last_renew_rm_bf']) ? $postData['last_renew_rm_bf'] : 0;
        $reminderInfo['last_renew_rm_af']       = !empty($postData['last_renew_rm_af']) ? $postData['last_renew_rm_af'] : 0;
        $reminderInfo['to_do_rm']               = !empty($postData['to_do_rm']) ? $postData['to_do_rm'] : '';
        $reminderInfo['to_do_rm_bf']            = !empty($postData['to_do_rm_bf']) ? $postData['to_do_rm_bf'] : 0;
        $reminderInfo['to_do_rm_af']            = !empty($postData['to_do_rm_af']) ? $postData['to_do_rm_af'] : 0;
        $reminderInfo['health_plan_rm']         = !empty($postData['health_plan_rm']) ? $postData['health_plan_rm'] : '';
        $reminderInfo['health_plan_rm_bf']      = !empty($postData['health_plan_rm_bf']) ? $postData['health_plan_rm_bf'] : 0;
        $reminderInfo['health_plan_rm_af']      = !empty($postData['health_plan_rm_af']) ? $postData['health_plan_rm_af'] : 0;
        $reminderInfo['maturity_rm']            = !empty($postData['maturity_rm']) ? $postData['maturity_rm'] : '';
        $reminderInfo['maturity_rm_bf']         = !empty($postData['maturity_rm_bf']) ? $postData['maturity_rm_bf'] : 0;
        $reminderInfo['maturity_rm_af']         = !empty($postData['maturity_rm_af']) ? $postData['maturity_rm_af'] : 0;
        $reminderInfo['money_back_rm']          = !empty($postData['money_back_rm']) ? $postData['money_back_rm'] : '';
        $reminderInfo['money_back_rm_bf']       = !empty($postData['money_back_rm_bf']) ? $postData['money_back_rm_bf'] : 0;
        $reminderInfo['money_back_rm_af']       = !empty($postData['money_back_rm_af']) ? $postData['money_back_rm_af'] : 0;
        $reminderInfo['client_id']              = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $reminderInfo->save();
        return $reminderInfo;
    }
}
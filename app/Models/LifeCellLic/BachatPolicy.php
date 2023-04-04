<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;

class BachatPolicy extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bachat_policy';
    protected $primaryKey = 'POLICYID';
    public $timestamps    = true;

    protected $fillable = [
        'Scheme','productid','schemeid','regno','lfno','POLICYID', 'ACCOUNT_NO', 'TRANS_DATE', 'AC_OPENING_DATE', 'AC_TYPE', 'CARD_NO', 'OLD_NEW_SERIES', 'AGENCY', 'POST_OFFICE', 'PARTY_NAME', 'BIRTH_DATE', 'AC_STATUS', 'HOLDER_2', 'DURATION', 'NEXT_DUE', 'LAST_TRANS_DATE', 'DENOMINATION', 'OPEN_BAL', 'LOAN_AMT', 'LOAN_REPAY', 'SCHED_AMT', 'CLOSING', 'MAT_DATE', 'MAT_AMOUNT', 'NOMINEE_1', 'NOMINEE_2', 'NOMINEE_3', 'REG_NO', 'MINOR', 'RELATION', 'GUARDIAN', 'GUARD_ADD', 'REMARK', 'SIGNATURE', 'client_id', 'old_id', 'old_client_id','depositamount','cash_check_type','month_income','deposit_interst_to','depost_ac_no','check_no','chq_date','bank_name','duration_month','certificate','birthdate','comision','tdsamount','surchrge_amount','netcomision','commision_recedate','cin','HOLDER_3','certificateamount'
    ];

    public static function saveBachatPolicyData($postData)
    {
        if (!empty($postData['id'])) {
            $polInfo = self::where('POLICYID', $postData['id'])->first();
        } else {
            $polInfo = new self();
        }

        
        
        $polInfo['Scheme']      = !empty($postData['Scheme']) ? $postData['Scheme'] : '0';
        $polInfo['ACCOUNT_NO']      = !empty($postData['ACCOUNT_NO']) ? $postData['ACCOUNT_NO'] : '0';
        $polInfo['TRANS_DATE']        = !empty($postData['TRANS_DATE']) ? date('Y-m-d', strtotime($postData['TRANS_DATE'])) : null;
        $polInfo['AC_OPENING_DATE']        = !empty($postData['AC_OPENING_DATE']) ? date('Y-m-d', strtotime($postData['AC_OPENING_DATE'])) : null;
        $polInfo['AC_TYPE']        = !empty($postData['AC_TYPE']) ? $postData['AC_TYPE'] : 0;
        $polInfo['CARD_NO']         = !empty($postData['CARD_NO']) ? $postData['CARD_NO'] : 0;
        $polInfo['OLD_NEW_SERIES']   = !empty($postData['OLD_NEW_SERIES']) ? $postData['OLD_NEW_SERIES'] : '';
        $polInfo['AGENCY']   = !empty($postData['AGENCY']) ? $postData['AGENCY'] : '';
        $polInfo['POST_OFFICE'] = !empty($postData['POST_OFFICE']) ? $postData['POST_OFFICE'] : '';
        $polInfo['PARTY_NAME']   = !empty($postData['PARTY_NAME']) ? $postData['PARTY_NAME'] : '';
        $polInfo['BIRTH_DATE']        = !empty($postData['BIRTH_DATE']) ? date('Y-m-d', strtotime($postData['BIRTH_DATE'])) : null;
        $polInfo['AC_STATUS']   = !empty($postData['AC_STATUS']) ? $postData['AC_STATUS'] : 0;
        $polInfo['HOLDER_2']  = !empty($postData['HOLDER_2']) ? $postData['HOLDER_2'] : '';
        $polInfo['DURATION']      = !empty($postData['DURATION']) ? $postData['DURATION'] : 0;
        $polInfo['NEXT_DUE']        = !empty($postData['NEXT_DUE']) ? date('Y-m-d', strtotime($postData['NEXT_DUE'])) : null;
        $polInfo['LAST_TRANS_DATE']        = !empty($postData['LAST_TRANS_DATE']) ? date('Y-m-d', strtotime($postData['LAST_TRANS_DATE'])) : null;
        $polInfo['MAT_DATE']        = !empty($postData['MAT_DATE']) ? date('Y-m-d', strtotime($postData['MAT_DATE'])) : null;
        $polInfo['MAT_AMOUNT']    = !empty($postData['MAT_AMOUNT']) ? $postData['MAT_AMOUNT'] : 0;
        $polInfo['DENOMINATION']    = !empty($postData['DENOMINATION']) ? $postData['DENOMINATION'] : 0;
        $polInfo['OPEN_BAL']    = !empty($postData['OPEN_BAL']) ? $postData['OPEN_BAL'] : 0;
        $polInfo['LOAN_AMT']    = !empty($postData['LOAN_AMT']) ? $postData['LOAN_AMT'] : 0;
        $polInfo['LOAN_REPAY']    = !empty($postData['LOAN_REPAY']) ? $postData['LOAN_REPAY'] : 0;
        $polInfo['SCHED_AMT']    = !empty($postData['SCHED_AMT']) ? $postData['SCHED_AMT'] : 0;
        $polInfo['CLOSING']    = !empty($postData['CLOSING']) ? $postData['CLOSING'] : 0;
        $polInfo['NOMINEE_1']     = !empty($postData['NOMINEE_1']) ? $postData['NOMINEE_1'] : '';
        $polInfo['NOMINEE_2']   = !empty($postData['NOMINEE_2']) ? $postData['NOMINEE_2'] : '';
        $polInfo['NOMINEE_3']     = !empty($postData['NOMINEE_3']) ? $postData['NOMINEE_3'] : '';
        $polInfo['REG_NO']   = !empty($postData['REG_NO']) ? $postData['REG_NO'] : '';
        $polInfo['MINOR']    = !empty($postData['MINOR']) ? $postData['MINOR'] : '';
        $polInfo['RELATION']   = !empty($postData['RELATION']) ? $postData['RELATION'] : '';
        $polInfo['GUARDIAN']       = !empty($postData['GUARDIAN']) ? $postData['GUARDIAN'] : '';
        $polInfo['GUARD_ADD']       = !empty($postData['GUARD_ADD']) ? $postData['GUARD_ADD'] : '';
        $polInfo['REMARK']      = !empty($postData['REMARK']) ? $postData['REMARK'] : '';
        $polInfo['SIGNATURE']    = !empty($postData['SIGNATURE']) ? $postData['SIGNATURE'] : '';
        $polInfo['client_id']       = !empty($postData['client_id']) ? $postData['client_id'] : 0;
        $polInfo['old_id']        = !empty($postData['old_id']) ? $postData['old_id'] : 0;
        $polInfo['old_client_id']     = !empty($postData['old_client_id']) ? $postData['old_client_id'] : 0;


        $polInfo['depositamount']     = !empty($postData['depositamount']) ? $postData['depositamount'] : 0;
        $polInfo['cash_check_type']     = !empty($postData['cash_check_type']) ? $postData['cash_check_type'] : 0;
        $polInfo['month_income']     = !empty($postData['month_income']) ? $postData['month_income'] : 0;
        $polInfo['deposit_interst_to']     = !empty($postData['deposit_interst_to']) ? $postData['deposit_interst_to'] : 0;
        $polInfo['depost_ac_no']     = !empty($postData['depost_ac_no']) ? $postData['depost_ac_no'] : 0;
        $polInfo['check_no']     = !empty($postData['check_no']) ? $postData['check_no'] : 0;
        $polInfo['chq_date']     = !empty($postData['chq_date']) ? $postData['chq_date'] : 0;
        $polInfo['bank_name']     = !empty($postData['bank_name']) ? $postData['bank_name'] : 0;
        $polInfo['duration_month']     = !empty($postData['duration_month']) ? $postData['duration_month'] : 0;
        $polInfo['certificate']     = !empty($postData['certificate']) ? $postData['certificate'] : 0;
        $polInfo['certificateamount']     = !empty($postData['certificateamount']) ? $postData['certificateamount'] : 0;
        $polInfo['birthdate']     = !empty($postData['birthdate']) ? $postData['birthdate'] : 0;
        $polInfo['comision']     = !empty($postData['comision']) ? $postData['comision'] : 0;
        $polInfo['tdsamount']     = !empty($postData['tdsamount']) ? $postData['tdsamount'] : 0;
        $polInfo['surchrge_amount']     = !empty($postData['surchrge_amount']) ? $postData['surchrge_amount'] : 0;
        $polInfo['netcomision']     = !empty($postData['netcomision']) ? $postData['netcomision'] : 0;
        $polInfo['commision_recedate']     = !empty($postData['commision_recedate']) ? $postData['commision_recedate'] : 0;
        $polInfo['regno']      = !empty($postData['regno']) ? $postData['regno'] : '0';
        $polInfo['lfno']      = !empty($postData['lfno']) ? $postData['lfno'] : '0';
        $polInfo['cin']      = !empty($postData['cin']) ? $postData['cin'] : '0';
        $polInfo['HOLDER_3']      = !empty($postData['HOLDER_3']) ? $postData['HOLDER_3'] : '0';

        $polInfo['schemeid']      = !empty($postData['schemeid']) ? $postData['schemeid'] : '0';
        $polInfo['productid']      = !empty($postData['productid']) ? $postData['productid'] : '0';
        

        $polInfo->save();

        return $polInfo;
    }
}

<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SetupPlan extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'setup_plan';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','loan_relnv_rate','mb_relnv_rate','yield','other_interest_rate','db_invest_rate','client_id','old_id','old_client_id',
    ];

    public static function savePlanSetup($postData)
    {
    	if(!empty($postData['id'])) {
    		$planInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$planInfo = new self();
    	}
        $planInfo['loan_relnv_rate']      = !empty($postData['loan_relnv_rate']) ? $postData['loan_relnv_rate'] : '';
        $planInfo['mb_relnv_rate']        = !empty($postData['mb_relnv_rate']) ? $postData['mb_relnv_rate'] : '';
        $planInfo['yield']                = !empty($postData['yield']) ? $postData['yield'] : '';
        $planInfo['other_interest_rate']  = !empty($postData['other_interest_rate']) ? $postData['other_interest_rate'] : '';
        $planInfo['db_invest_rate']       = !empty($postData['db_invest_rate']) ? $postData['db_invest_rate'] : '';
        $planInfo['client_id']            = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $planInfo->save();
        return $planInfo;
    }
}
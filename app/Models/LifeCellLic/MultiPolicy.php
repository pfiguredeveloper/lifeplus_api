<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellLic\MultiPolicyRiders;

class MultiPolicy extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'multipol';
    protected $primaryKey = 'PUNIQID';
    public $timestamps    = false;

    protected $fillable = [
        'PUNIQID','QUOTNO','QUOTDT','QUOTREF','AGCODE','AFILE','NAME1','BIRTH1','DEMODATA','client_id','policy_insurance_id',
    ];

    public function multiPolicyRiders()
    {
        return $this->hasMany('App\Models\LifeCellLic\MultiPolicyRiders','POLID','PUNIQID');
    }

    public static function saveMultiPolicyData($postData)
    {
    	if(!empty($postData['id'])) {
    		$multiPolInfo = self::where('PUNIQID', $postData['id'])->first();
    	} else {
    		$multiPolInfo = new self();
    	}
        $multiPolInfo['QUOTNO']      = !empty($postData['QUOTNO']) ? $postData['QUOTNO'] : '';
        $multiPolInfo['QUOTDT']      = !empty($postData['QUOTDT']) ? $postData['QUOTDT'] : '';
        $multiPolInfo['QUOTREF']     = !empty($postData['QUOTREF']) ? $postData['QUOTREF'] : '';
        $multiPolInfo['AGCODE']      = !empty($postData['AGCODE']) ? $postData['AGCODE'] : '';
        $multiPolInfo['AFILE']       = !empty($postData['AFILE']) ? $postData['AFILE'] : '';
        $multiPolInfo['NAME1']       = !empty($postData['NAME1']) ? $postData['NAME1'] : '';
        $multiPolInfo['BIRTH1']      = !empty($postData['BIRTH1']) ? $postData['BIRTH1'] : '';
        $multiPolInfo['DEMODATA']    = !empty($postData['DEMODATA']) ? $postData['DEMODATA'] : '';
        $multiPolInfo['client_id']   = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $multiPolInfo['policy_insurance_id']   = !empty($postData['policy_insurance_id']) ? $postData['policy_insurance_id'] : 0;
        $multiPolInfo->save();

        if(!empty($postData['RIDERS'])) {
            $polRiders = MultiPolicyRiders::where('POLID',$multiPolInfo['PUNIQID'])->get();
            if(!empty($polRiders) && count($polRiders) > 0) {
                foreach ($polRiders as $key => $value) {
                    $value->delete();
                }
            }
            foreach ($postData['RIDERS'] as $key => $value) {
                MultiPolicyRiders::saveMultiPolicyRidersData($value,$multiPolInfo['PUNIQID']);
            }
        }

        return $multiPolInfo;
    }
}
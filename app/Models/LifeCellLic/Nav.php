<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'nav';
    protected $primaryKey = 'QNO';
    public $timestamps    = false;

    protected $fillable = [
        'QNO','YR','YEAR','AGE','FULL_PREM','PREM','EXP','NET_AMT','NAV','NAV_PUR','TOT_NAVPUR','LIFEEXP','DABEXP','CIREXP','STEXP','FLATEXP','ADMEXP','POLEXP','ALLOEXP','LIFEEXPRT','DABEXPRT','CIREXPRT','ALLOEXPRT','NAV_COST','PRCH_RT','DEATH','DEATH_DAB','SV','TAX_AMT','WITH_AMT','COLTOTFLAG','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$navInfo = self::where('QNO', $postData['id'])->first();
    	} else {
    		$navInfo = new self();
    	}
        $navInfo['YR']          = !empty($postData['YR']) ? $postData['YR'] : 0;
        $navInfo['YEAR']        = !empty($postData['YEAR']) ? $postData['YEAR'] : 0;
        $navInfo['AGE']         = !empty($postData['AGE']) ? $postData['AGE'] : 0;
        $navInfo['FULL_PREM']   = !empty($postData['FULL_PREM']) ? $postData['FULL_PREM'] : 0;
        $navInfo['PREM']        = !empty($postData['PREM']) ? $postData['PREM'] : 0;
        $navInfo['EXP']         = !empty($postData['EXP']) ? $postData['EXP'] : 0;
        $navInfo['NET_AMT']     = !empty($postData['NET_AMT']) ? $postData['NET_AMT'] : 0;
        $navInfo['NAV']         = !empty($postData['NAV']) ? $postData['NAV'] : 0;
        $navInfo['NAV_PUR']     = !empty($postData['NAV_PUR']) ? $postData['NAV_PUR'] : 0;
        $navInfo['TOT_NAVPUR']  = !empty($postData['TOT_NAVPUR']) ? $postData['TOT_NAVPUR'] : 0;
        $navInfo['LIFEEXP']     = !empty($postData['LIFEEXP']) ? $postData['LIFEEXP'] : 0;
        $navInfo['DABEXP']      = !empty($postData['DABEXP']) ? $postData['DABEXP'] : 0;
        $navInfo['CIREXP']      = !empty($postData['CIREXP']) ? $postData['CIREXP'] : 0;
        $navInfo['STEXP']       = !empty($postData['STEXP']) ? $postData['STEXP'] : 0;
        $navInfo['FLATEXP']     = !empty($postData['FLATEXP']) ? $postData['FLATEXP'] : 0;
        $navInfo['ADMEXP']      = !empty($postData['ADMEXP']) ? $postData['ADMEXP'] : 0;
        $navInfo['POLEXP']      = !empty($postData['POLEXP']) ? $postData['POLEXP'] : 0;
        $navInfo['ALLOEXP']     = !empty($postData['ALLOEXP']) ? $postData['ALLOEXP'] : 0;
        $navInfo['LIFEEXPRT']   = !empty($postData['LIFEEXPRT']) ? $postData['LIFEEXPRT'] : 0;
        $navInfo['DABEXPRT']    = !empty($postData['DABEXPRT']) ? $postData['DABEXPRT'] : 0;
        $navInfo['CIREXPRT']    = !empty($postData['CIREXPRT']) ? $postData['CIREXPRT'] : 0;
        $navInfo['ALLOEXPRT']   = !empty($postData['ALLOEXPRT']) ? $postData['ALLOEXPRT'] : 0;
        $navInfo['NAV_COST']    = !empty($postData['NAV_COST']) ? $postData['NAV_COST'] : 0;
        $navInfo['PRCH_RT']     = !empty($postData['PRCH_RT']) ? $postData['PRCH_RT'] : 0;
        $navInfo['DEATH']       = !empty($postData['DEATH']) ? $postData['DEATH'] : 0;
        $navInfo['DEATH_DAB']   = !empty($postData['DEATH_DAB']) ? $postData['DEATH_DAB'] : 0;
        $navInfo['SV']          = !empty($postData['SV']) ? $postData['SV'] : 0;
        $navInfo['TAX_AMT']     = !empty($postData['TAX_AMT']) ? $postData['TAX_AMT'] : 0;
        $navInfo['WITH_AMT']    = !empty($postData['WITH_AMT']) ? $postData['WITH_AMT'] : 0;
        $navInfo['COLTOTFLAG']  = !empty($postData['COLTOTFLAG']) ? $postData['COLTOTFLAG'] : '';
        $navInfo['client_id']   = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $navInfo->save();
        return $navInfo;
    }
}
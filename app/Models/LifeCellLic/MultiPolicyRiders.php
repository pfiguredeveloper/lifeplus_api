<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellLic\PolNominee;

class MultiPolicyRiders extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'multipol_riders';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','POLID','RDT','CDT','PLAN','AGE','MTERM','PTERM','TTERM','MODE','PROP_AGE','NACH','PWB','MEDICAL','SETT','BONUS_RATE','BONUS_STEP','LOYAL_RATE','LOYAL_STEP','GADD','ADVPR','FUP','MATURITY_AMT','BASIC_SA','BASIC_PREM','DAB_SA','DAB_PREM','CIR_SA','CIR_PREM','TR_SA','TR_PREM','PWB_PREM','SETT_PREM','SAOPTION','DAB_OPTION','EXTRAPREM','PREM','GST1','GST2','TOTPREM1','TOTPREM2','NAME2','BIRTH2','is_auto_prem','ANN_TYPE','NCO','ANN_OPTION','ANN_MODE','ANN_AMT','DAB_CHECK','TR_CHECK','CIR_CHECK','PWB_CHECK','SETT_CHECK',
    ];

    public static function saveMultiPolicyRidersData($postData,$polID = 0)
    {
    	$multiPolRidersInfo                 = new self();
        $multiPolRidersInfo['RDT']          = !empty($postData['RDT']) ? $postData['RDT'] : '';
        $multiPolRidersInfo['CDT']          = !empty($postData['CDT']) ? $postData['CDT'] : '';
        $multiPolRidersInfo['PLAN']         = !empty($postData['PLAN']) ? $postData['PLAN'] : '';
        $multiPolRidersInfo['AGE']          = !empty($postData['AGE']) ? $postData['AGE'] : '';
        $multiPolRidersInfo['MTERM']        = !empty($postData['MTERM']) ? $postData['MTERM'] : '';
        $multiPolRidersInfo['PTERM']        = !empty($postData['PTERM']) ? $postData['PTERM'] : '';
        $multiPolRidersInfo['TTERM']        = !empty($postData['TTERM']) ? $postData['TTERM'] : '';
        $multiPolRidersInfo['MODE']         = !empty($postData['MODE']) ? $postData['MODE'] : '';
        $multiPolRidersInfo['PROP_AGE']     = !empty($postData['PROP_AGE']) ? $postData['PROP_AGE'] : '';
        $multiPolRidersInfo['NACH']         = !empty($postData['NACH']) ? $postData['NACH'] : '';
        $multiPolRidersInfo['PWB']          = !empty($postData['PWB']) ? $postData['PWB'] : '';
        $multiPolRidersInfo['PWB_PREM']     = !empty($postData['PWB_PREM']) ? $postData['PWB_PREM'] : '';
        $multiPolRidersInfo['MEDICAL']      = !empty($postData['MEDICAL']) ? $postData['MEDICAL'] : '';
        $multiPolRidersInfo['SETT']         = !empty($postData['SETT']) ? $postData['SETT'] : '';
        $multiPolRidersInfo['SETT_PREM']    = !empty($postData['SETT_PREM']) ? $postData['SETT_PREM'] : '';
        $multiPolRidersInfo['BONUS_RATE']   = !empty($postData['BONUS_RATE']) ? $postData['BONUS_RATE'] : '';
        $multiPolRidersInfo['BONUS_STEP']   = !empty($postData['BONUS_STEP']) ? $postData['BONUS_STEP'] : '';
        $multiPolRidersInfo['LOYAL_RATE']   = !empty($postData['LOYAL_RATE']) ? $postData['LOYAL_RATE'] : '';
        $multiPolRidersInfo['LOYAL_STEP']   = !empty($postData['LOYAL_STEP']) ? $postData['LOYAL_STEP'] : '';
        $multiPolRidersInfo['GADD']         = !empty($postData['GADD']) ? $postData['GADD'] : '';
        $multiPolRidersInfo['ADVPR']        = !empty($postData['ADVPR']) ? $postData['ADVPR'] : '';
        $multiPolRidersInfo['FUP']          = !empty($postData['FUP']) ? $postData['FUP'] : '';
        $multiPolRidersInfo['MATURITY_AMT'] = !empty($postData['MATURITY_AMT']) ? $postData['MATURITY_AMT'] : '';
        $multiPolRidersInfo['BASIC_SA']     = !empty($postData['BASIC_SA']) ? $postData['BASIC_SA'] : '';
        $multiPolRidersInfo['BASIC_PREM']   = !empty($postData['BASIC_PREM']) ? $postData['BASIC_PREM'] : '';
        $multiPolRidersInfo['SAOPTION']     = !empty($postData['SAOPTION']) ? $postData['SAOPTION'] : '';
        $multiPolRidersInfo['DAB_SA']       = !empty($postData['DAB_SA']) ? $postData['DAB_SA'] : '';
        $multiPolRidersInfo['DAB_PREM']     = !empty($postData['DAB_PREM']) ? $postData['DAB_PREM'] : '';
        $multiPolRidersInfo['DAB_OPTION']   = !empty($postData['DAB_OPTION']) ? $postData['DAB_OPTION'] : 0;
        $multiPolRidersInfo['CIR_SA']       = !empty($postData['CIR_SA']) ? $postData['CIR_SA'] : '';
        $multiPolRidersInfo['CIR_PREM']     = !empty($postData['CIR_PREM']) ? $postData['CIR_PREM'] : '';
        $multiPolRidersInfo['TR_SA']        = !empty($postData['TR_SA']) ? $postData['TR_SA'] : '';
        $multiPolRidersInfo['TR_PREM']      = !empty($postData['TR_PREM']) ? $postData['TR_PREM'] : '';
        $multiPolRidersInfo['EXTRAPREM']    = !empty($postData['EXTRAPREM']) ? $postData['EXTRAPREM'] : '';
        $multiPolRidersInfo['PREM']         = !empty($postData['PREM']) ? $postData['PREM'] : '';
        $multiPolRidersInfo['GST1']         = !empty($postData['GST1']) ? $postData['GST1'] : '';
        $multiPolRidersInfo['GST2']         = !empty($postData['GST2']) ? $postData['GST2'] : '';
        $multiPolRidersInfo['TOTPREM1']     = !empty($postData['TOTPREM1']) ? $postData['TOTPREM1'] : '';
        $multiPolRidersInfo['TOTPREM2']     = !empty($postData['TOTPREM2']) ? $postData['TOTPREM2'] : '';
        $multiPolRidersInfo['NAME2']        = !empty($postData['NAME2']) ? $postData['NAME2'] : '';
        $multiPolRidersInfo['BIRTH2']       = !empty($postData['BIRTH2']) ? $postData['BIRTH2'] : '';
        $multiPolRidersInfo['is_auto_prem'] = !empty($postData['is_auto_prem']) ? $postData['is_auto_prem'] : 0;
        $multiPolRidersInfo['ANN_TYPE']     = !empty($postData['ANN_TYPE']) ? $postData['ANN_TYPE'] : '';
        $multiPolRidersInfo['NCO']          = !empty($postData['NCO']) ? $postData['NCO'] : '';
        $multiPolRidersInfo['ANN_OPTION']   = !empty($postData['ANN_OPTION']) ? $postData['ANN_OPTION'] : '';
        $multiPolRidersInfo['ANN_MODE']     = !empty($postData['ANN_MODE']) ? $postData['ANN_MODE'] : '';
        $multiPolRidersInfo['ANN_AMT']      = !empty($postData['ANN_AMT']) ? $postData['ANN_AMT'] : '';
        $multiPolRidersInfo['DAB_CHECK']    = !empty($postData['DAB_CHECK']) ? $postData['DAB_CHECK'] : 0;
        $multiPolRidersInfo['TR_CHECK']     = !empty($postData['TR_CHECK']) ? $postData['TR_CHECK'] : 0;
        $multiPolRidersInfo['CIR_CHECK']    = !empty($postData['CIR_CHECK']) ? $postData['CIR_CHECK'] : 0;
        $multiPolRidersInfo['PWB_CHECK']    = !empty($postData['PWB_CHECK']) ? $postData['PWB_CHECK'] : 0;
        $multiPolRidersInfo['SETT_CHECK']   = !empty($postData['SETT_CHECK']) ? $postData['SETT_CHECK'] : 0;
        $multiPolRidersInfo['POLID']        = $polID;
        $multiPolRidersInfo->save();
        return $multiPolRidersInfo;
    }
}
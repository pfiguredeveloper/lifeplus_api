<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'address';
    protected $primaryKey = 'PCODE';
    public $timestamps    = false;

    protected $fillable = [
        'PCODE','FAMILYID','ADDGROUPID','NAME','PAT_NAME','EDUID','CASTEID','RELIGIONID','LANGUAGE','NATIVE','PAN_NO','OFF_AD1','OFF_AD2','OFF_AD3','OFF_CITYID','OFF_CITY','OFF_STATE','OFF_COUNTR','OFF_PIN','OFF_AREAID','RES_AD1','RES_AD2','RES_AD3','RES_CITYID','RES_CITY','RES_STATE','RES_COUNTR','RES_PIN','RES_AREAID','PHONE_O','PHONE_R','MOBILE','FAX','EMAIL','BD_ACTUAL','BD_RECORD','WDT','DEATH_ANN','CASTE_ID','CASTE','RELG_ID','RELIGIOUS','START_TALK','BIRTH_TIME','BIRTH_CID','BIRTH_CITY','BIRTH_STAT','BIRTH_DIST','BIRTH_COUN','CITIZENSHI','SIGN','SELECT','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$addressInfo = self::where('PCODE', $postData['id'])->first();
    	} else {
    		$addressInfo = new self();
    	}
        $addressInfo['FAMILYID']   = !empty($postData['FAMILYID']) ? $postData['FAMILYID'] : 0;
        $addressInfo['ADDGROUPID'] = !empty($postData['ADDGROUPID']) ? $postData['ADDGROUPID'] : 0;
        $addressInfo['NAME']       = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $addressInfo['PAT_NAME']   = !empty($postData['PAT_NAME']) ? $postData['PAT_NAME'] : '';
        $addressInfo['EDUID']      = !empty($postData['EDUID']) ? $postData['EDUID'] : 0;
        $addressInfo['CASTEID']    = !empty($postData['CASTEID']) ? $postData['CASTEID'] : 0;
        $addressInfo['RELIGIONID'] = !empty($postData['RELIGIONID']) ? $postData['RELIGIONID'] : 0;
        $addressInfo['LANGUAGE']   = !empty($postData['LANGUAGE']) ? $postData['LANGUAGE'] : '';
        $addressInfo['NATIVE']     = !empty($postData['NATIVE']) ? $postData['NATIVE'] : '';
        $addressInfo['PAN_NO']     = !empty($postData['PAN_NO']) ? $postData['PAN_NO'] : '';
        $addressInfo['OFF_AD1']    = !empty($postData['OFF_AD1']) ? $postData['OFF_AD1'] : '';
        $addressInfo['OFF_AD2']    = !empty($postData['OFF_AD2']) ? $postData['OFF_AD2'] : '';
        $addressInfo['OFF_AD3']    = !empty($postData['OFF_AD3']) ? $postData['OFF_AD3'] : '';
        $addressInfo['OFF_CITYID'] = !empty($postData['OFF_CITYID']) ? $postData['OFF_CITYID'] : 0;
        $addressInfo['OFF_CITY']   = !empty($postData['OFF_CITY']) ? $postData['OFF_CITY'] : '';
        $addressInfo['OFF_STATE']  = !empty($postData['OFF_STATE']) ? $postData['OFF_STATE'] : '';
        $addressInfo['OFF_COUNTR'] = !empty($postData['OFF_COUNTR']) ? $postData['OFF_COUNTR'] : '';
        $addressInfo['OFF_PIN']    = !empty($postData['OFF_PIN']) ? $postData['OFF_PIN'] : '';
        $addressInfo['OFF_AREAID'] = !empty($postData['OFF_AREAID']) ? $postData['OFF_AREAID'] : 0;
        $addressInfo['RES_AD1']    = !empty($postData['RES_AD1']) ? $postData['RES_AD1'] : '';
        $addressInfo['RES_AD2']    = !empty($postData['RES_AD2']) ? $postData['RES_AD2'] : '';
        $addressInfo['RES_AD3']    = !empty($postData['RES_AD3']) ? $postData['RES_AD3'] : '';
        $addressInfo['RES_CITYID'] = !empty($postData['RES_CITYID']) ? $postData['RES_CITYID'] : 0;
        $addressInfo['RES_CITY']   = !empty($postData['RES_CITY']) ? $postData['RES_CITY'] : '';
        $addressInfo['RES_STATE']  = !empty($postData['RES_STATE']) ? $postData['RES_STATE'] : '';
        $addressInfo['RES_COUNTR'] = !empty($postData['RES_COUNTR']) ? $postData['RES_COUNTR'] : '';
        $addressInfo['RES_PIN']    = !empty($postData['RES_PIN']) ? $postData['RES_PIN'] : '';
        $addressInfo['RES_AREAID'] = !empty($postData['RES_AREAID']) ? $postData['RES_AREAID'] : 0;
        $addressInfo['PHONE_O']    = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $addressInfo['PHONE_R']    = !empty($postData['PHONE_R']) ? $postData['PHONE_R'] : '';
        $addressInfo['MOBILE']     = !empty($postData['MOBILE']) ? $postData['MOBILE'] : '';
        $addressInfo['FAX']        = !empty($postData['FAX']) ? $postData['FAX'] : '';
        $addressInfo['EMAIL']      = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $addressInfo['BD_ACTUAL']  = !empty($postData['BD_ACTUAL']) ? $postData['BD_ACTUAL'] : '';
        $addressInfo['BD_RECORD']  = !empty($postData['BD_RECORD']) ? $postData['BD_RECORD'] : '';
        $addressInfo['WDT']        = !empty($postData['WDT']) ? $postData['WDT'] : '';
        $addressInfo['DEATH_ANN']  = !empty($postData['DEATH_ANN']) ? $postData['DEATH_ANN'] : '';
        $addressInfo['CASTE_ID']   = !empty($postData['CASTE_ID']) ? $postData['CASTE_ID'] : 0;
        $addressInfo['CASTE']      = !empty($postData['CASTE']) ? $postData['CASTE'] : '';
        $addressInfo['RELG_ID']    = !empty($postData['RELG_ID']) ? $postData['RELG_ID'] : 0;
        $addressInfo['RELIGIOUS']  = !empty($postData['RELIGIOUS']) ? $postData['RELIGIOUS'] : '';
        $addressInfo['START_TALK'] = !empty($postData['START_TALK']) ? $postData['START_TALK'] : '';
        $addressInfo['BIRTH_TIME'] = !empty($postData['BIRTH_TIME']) ? $postData['BIRTH_TIME'] : '';
        $addressInfo['BIRTH_CID']  = !empty($postData['BIRTH_CID']) ? $postData['BIRTH_CID'] : 0;
        $addressInfo['BIRTH_CITY'] = !empty($postData['BIRTH_CITY']) ? $postData['BIRTH_CITY'] : '';
        $addressInfo['BIRTH_STAT'] = !empty($postData['BIRTH_STAT']) ? $postData['BIRTH_STAT'] : '';
        $addressInfo['BIRTH_DIST'] = !empty($postData['BIRTH_DIST']) ? $postData['BIRTH_DIST'] : '';
        $addressInfo['BIRTH_COUN'] = !empty($postData['BIRTH_COUN']) ? $postData['BIRTH_COUN'] : '';
        $addressInfo['CITIZENSHI'] = !empty($postData['CITIZENSHI']) ? $postData['CITIZENSHI'] : '';
        $addressInfo['SIGN']       = !empty($postData['SIGN']) ? $postData['SIGN'] : '';
        $addressInfo['SELECT']     = !empty($postData['SELECT']) ? $postData['SELECT'] : '';
        $addressInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $addressInfo->save();
        return $addressInfo;
    }
}
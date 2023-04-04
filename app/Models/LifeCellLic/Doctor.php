<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'doctor';
    protected $primaryKey = 'DCODE';
    public $timestamps    = false;

    protected $fillable = [
        'DCODE','DOCTOR','SHRTNM','DOC_CODE','ADDRESS','CITY','CITYID','PIN','SPECIALIST','PHONE_O','PHONE_R','LIMIT_DATA','ARECD','MOBILE','EMAIL','APP_DATE','RET_DATE','STATUS','PHOTO','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$doctorInfo = self::where('DCODE', $postData['id'])->first();
    	} else {
    		$doctorInfo = new self();
    	}
        $doctorInfo['DOCTOR']     = !empty($postData['DOCTOR']) ? $postData['DOCTOR'] : '';
        $doctorInfo['SHRTNM']     = !empty($postData['SHRTNM']) ? $postData['SHRTNM'] : '';
        $doctorInfo['DOC_CODE']   = !empty($postData['DOC_CODE']) ? $postData['DOC_CODE'] : '';
        $doctorInfo['ADDRESS']    = !empty($postData['ADDRESS']) ? $postData['ADDRESS'] : '';
        $doctorInfo['CITY']       = !empty($postData['CITY']) ? $postData['CITY'] : '';
        $doctorInfo['CITYID']     = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $doctorInfo['PIN']        = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $doctorInfo['SPECIALIST'] = !empty($postData['SPECIALIST']) ? $postData['SPECIALIST'] : '';
        $doctorInfo['PHONE_O']    = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $doctorInfo['PHONE_R']    = !empty($postData['PHONE_R']) ? $postData['PHONE_R'] : '';
        $doctorInfo['LIMIT_DATA'] = !empty($postData['LIMIT_DATA']) ? $postData['LIMIT_DATA'] : '';
        $doctorInfo['ARECD']      = !empty($postData['ARECD']) ? $postData['ARECD'] : 0;
        $doctorInfo['MOBILE']     = !empty($postData['MOBILE']) ? $postData['MOBILE'] : '';
        $doctorInfo['EMAIL']      = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $doctorInfo['APP_DATE']   = !empty($postData['APP_DATE']) ? $postData['APP_DATE'] : '';
        $doctorInfo['RET_DATE']   = !empty($postData['RET_DATE']) ? $postData['RET_DATE'] : '';
        $doctorInfo['STATUS']     = !empty($postData['STATUS']) ? $postData['STATUS'] : '';
        $doctorInfo['PHOTO']      = !empty($postData['PHOTO']) ? $postData['PHOTO'] : '';
        $doctorInfo['OCODE']      = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $doctorInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $doctorInfo->save();
        return $doctorInfo;
    }
}
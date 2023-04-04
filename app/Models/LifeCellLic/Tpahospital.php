<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Tpahospital extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'tpahospital';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','NAME','AD1','AD2','AD3','CITYID','PIN','PHONE_O','FAX','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$tpahospitalInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$tpahospitalInfo = new self();
    	}
        $tpahospitalInfo['NAME']      = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $tpahospitalInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $tpahospitalInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $tpahospitalInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $tpahospitalInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $tpahospitalInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $tpahospitalInfo['PHONE_O']   = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $tpahospitalInfo['FAX']       = !empty($postData['FAX']) ? $postData['FAX'] : '';
        $tpahospitalInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $tpahospitalInfo->save();
        return $tpahospitalInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class TPA extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'tpa';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','NAME','AD1','AD2','AD3','CITYID','PIN','PHONE_O','FAX','EMAIL','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$tpaInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$tpaInfo = new self();
    	}
        $tpaInfo['NAME']      = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $tpaInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $tpaInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $tpaInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $tpaInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $tpaInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $tpaInfo['PHONE_O']   = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $tpaInfo['FAX']       = !empty($postData['FAX']) ? $postData['FAX'] : '';
        $tpaInfo['EMAIL']     = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $tpaInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $tpaInfo->save();
        return $tpaInfo;
    }
}
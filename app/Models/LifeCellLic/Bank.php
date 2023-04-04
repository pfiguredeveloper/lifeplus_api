<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bank';
    protected $primaryKey = 'BANKCD';
    public $timestamps    = false;

    protected $fillable = [
        'BANKCD','BANK','BANKBR','BANKMICR','BANKIFS','AD1','AD2','AD3','ADDRESS','CITYID','PIN','PHONE','FAX','EMAIL','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$bankInfo = self::where('BANKCD', $postData['id'])->first();
    	} else {
    		$bankInfo = new self();
    	}
        $bankInfo['BANK']      = !empty($postData['BANK']) ? $postData['BANK'] : '';
        $bankInfo['BANKBR']    = !empty($postData['BANKBR']) ? $postData['BANKBR'] : '';
        $bankInfo['BANKMICR']  = !empty($postData['BANKMICR']) ? $postData['BANKMICR'] : '';
        $bankInfo['BANKIFS']   = !empty($postData['BANKIFS']) ? $postData['BANKIFS'] : '';
        $bankInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $bankInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $bankInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $bankInfo['ADDRESS']   = !empty($postData['ADDRESS']) ? $postData['ADDRESS'] : '';
        $bankInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $bankInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $bankInfo['PHONE']     = !empty($postData['PHONE']) ? $postData['PHONE'] : '';
        $bankInfo['FAX']       = !empty($postData['FAX']) ? $postData['FAX'] : '';
        $bankInfo['EMAIL']     = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $bankInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $bankInfo->save();
        return $bankInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Franchisee extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'franchise';
    protected $primaryKey = 'franchid';
    public $timestamps    = false;

    protected $fillable = [
        'franchid','franchnm','sortname','contactper','workarea','add1','add2','add3','city','cityid','pin','phone_o','phone_r','mobile','email','remark','fr_status','sms_outmob','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$franchiseInfo = self::where('franchid', $postData['id'])->first();
    	} else {
    		$franchiseInfo = new self();
    	}
        $franchiseInfo['franchnm']   = !empty($postData['franchnm']) ? $postData['franchnm'] : '';
        $franchiseInfo['sortname']   = !empty($postData['sortname']) ? $postData['sortname'] : '';
        $franchiseInfo['contactper'] = !empty($postData['contactper']) ? $postData['contactper'] : '';
        $franchiseInfo['workarea']   = !empty($postData['workarea']) ? $postData['workarea'] : '';
        $franchiseInfo['add1']       = !empty($postData['add1']) ? $postData['add1'] : '';
        $franchiseInfo['add2']       = !empty($postData['add2']) ? $postData['add2'] : '';
        $franchiseInfo['add3']       = !empty($postData['add3']) ? $postData['add3'] : '';
        $franchiseInfo['city']       = !empty($postData['city']) ? $postData['city'] : '';
        $franchiseInfo['cityid']     = !empty($postData['cityid']) ? $postData['cityid'] : 0;
        $franchiseInfo['pin']        = !empty($postData['pin']) ? $postData['pin'] : '';
        $franchiseInfo['phone_o']    = !empty($postData['phone_o']) ? $postData['phone_o'] : '';
        $franchiseInfo['phone_r']    = !empty($postData['phone_r']) ? $postData['phone_r'] : '';
        $franchiseInfo['mobile']     = !empty($postData['mobile']) ? $postData['mobile'] : '';
        $franchiseInfo['email']      = !empty($postData['email']) ? $postData['email'] : '';
        $franchiseInfo['remark']     = !empty($postData['remark']) ? $postData['remark'] : '';
        $franchiseInfo['fr_status']  = !empty($postData['fr_status']) ? $postData['fr_status'] : '';
        $franchiseInfo['sms_outmob'] = !empty($postData['sms_outmob']) ? $postData['sms_outmob'] : '';
        $franchiseInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $franchiseInfo->save();
        return $franchiseInfo;
    }
}
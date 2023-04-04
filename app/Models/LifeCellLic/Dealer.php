<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'dealer';
    protected $primaryKey = 'dealerid';
    public $timestamps    = false;

    protected $fillable = [
        'dealerid','parentid','franchid','sortname','dealer','add1','add2','add3','city','cityid','pin','phone_o','phone_r','mobile','show_mob','email','remark','dlr_status','bankname','acno','bill','show_rpt','dlr_due','r_limit','c_limit','mob_chg','f27','postdate','rid','isdefault','due_chg','old_cli','upd_fup','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$dealerInfo = self::where('dealerid', $postData['id'])->first();
    	} else {
    		$dealerInfo = new self();
    	}
        $dealerInfo['parentid']   = !empty($postData['parentid']) ? $postData['parentid'] : 0;
        $dealerInfo['franchid']   = !empty($postData['franchid']) ? $postData['franchid'] : 0;
        $dealerInfo['sortname']   = !empty($postData['sortname']) ? $postData['sortname'] : '';
        $dealerInfo['dealer']     = !empty($postData['dealer']) ? $postData['dealer'] : '';
        $dealerInfo['add1']       = !empty($postData['add1']) ? $postData['add1'] : '';
        $dealerInfo['add2']       = !empty($postData['add2']) ? $postData['add2'] : '';
        $dealerInfo['add3']       = !empty($postData['add3']) ? $postData['add3'] : '';
        $dealerInfo['city']       = !empty($postData['city']) ? $postData['city'] : '';
        $dealerInfo['cityid']     = !empty($postData['cityid']) ? $postData['cityid'] : 0;
        $dealerInfo['pin']        = !empty($postData['pin']) ? $postData['pin'] : '';
        $dealerInfo['phone_o']    = !empty($postData['phone_o']) ? $postData['phone_o'] : '';
        $dealerInfo['phone_r']    = !empty($postData['phone_r']) ? $postData['phone_r'] : '';
        $dealerInfo['mobile']     = !empty($postData['mobile']) ? $postData['mobile'] : '';
        $dealerInfo['show_mob']   = !empty($postData['show_mob']) ? $postData['show_mob'] : '';
        $dealerInfo['email']      = !empty($postData['email']) ? $postData['email'] : '';
        $dealerInfo['remark']     = !empty($postData['remark']) ? $postData['remark'] : '';
        $dealerInfo['dlr_status'] = !empty($postData['dlr_status']) ? $postData['dlr_status'] : '';
        $dealerInfo['bankname']   = !empty($postData['bankname']) ? $postData['bankname'] : '';
        $dealerInfo['acno']       = !empty($postData['acno']) ? $postData['acno'] : '';
        $dealerInfo['bill']       = !empty($postData['bill']) ? $postData['bill'] : '';
        $dealerInfo['show_rpt']   = !empty($postData['show_rpt']) ? $postData['show_rpt'] : '';
        $dealerInfo['dlr_due']    = !empty($postData['dlr_due']) ? $postData['dlr_due'] : '';
        $dealerInfo['r_limit']    = !empty($postData['r_limit']) ? $postData['r_limit'] : 0;
        $dealerInfo['c_limit']    = !empty($postData['c_limit']) ? $postData['c_limit'] : 0;
        $dealerInfo['mob_chg']    = !empty($postData['mob_chg']) ? $postData['mob_chg'] : '';
        $dealerInfo['f27']        = !empty($postData['f27']) ? $postData['f27'] : '';
        $dealerInfo['postdate']   = !empty($postData['postdate']) ? $postData['postdate'] : '';
        $dealerInfo['rid']        = !empty($postData['rid']) ? $postData['rid'] : 0;
        $dealerInfo['isdefault']  = !empty($postData['isdefault']) ? $postData['isdefault'] : '';
        $dealerInfo['due_chg']    = !empty($postData['due_chg']) ? $postData['due_chg'] : '';
        $dealerInfo['old_cli']    = !empty($postData['old_cli']) ? $postData['old_cli'] : '';
        $dealerInfo['upd_fup']    = !empty($postData['upd_fup']) ? $postData['upd_fup'] : '';
        $dealerInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $dealerInfo->save();
        return $dealerInfo;
    }
}
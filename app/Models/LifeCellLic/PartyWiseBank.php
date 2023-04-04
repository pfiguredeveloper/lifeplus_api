<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class PartyWiseBank extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'party_wise_bank';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','pcode','name','bcode','bank','acno','actype','elec_no','ifscode','old_id','old_client_id','client_id',
    ];

    public static function saveMaster($postData)
    {
    	$prtwbnkInfo = new self();
    	$prtwbnkInfo['pcode']      = !empty($postData['pcode']) ? $postData['pcode'] : '';
        $prtwbnkInfo['name']       = !empty($postData['name']) ? $postData['name'] : '';
        $prtwbnkInfo['bcode']      = !empty($postData['bcode']) ? $postData['bcode'] : '';
        $prtwbnkInfo['bank']       = !empty($postData['bank']) ? $postData['bank'] : '';
        $prtwbnkInfo['acno']       = !empty($postData['acno']) ? $postData['acno'] : '';
        $prtwbnkInfo['actype']     = !empty($postData['actype']) ? $postData['actype'] : '';
        $prtwbnkInfo['elec_no']    = !empty($postData['elec_no']) ? $postData['elec_no'] : '';
        $prtwbnkInfo['ifscode']    = !empty($postData['ifscode']) ? $postData['ifscode'] : '';
        $prtwbnkInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $prtwbnkInfo->save();
        return $prtwbnkInfo;
    }
}
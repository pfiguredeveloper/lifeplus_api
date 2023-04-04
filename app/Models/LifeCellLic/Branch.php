<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'branch';
    protected $primaryKey = 'BCODE';
    public $timestamps    = false;

    protected $fillable = [
        'BCODE','BRANCH','BRANCHNM','BR_MGR_NM','AD1','AD2','AD3','ADDRESS','CITY','CITYID','PIN','DIVISION','PHONE_O','ZONE','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$branchInfo = self::where('BCODE', $postData['id'])->first();
    	} else {
    		$branchInfo = new self();
    	}
        $branchInfo['BRANCH']    = !empty($postData['BRANCH']) ? $postData['BRANCH'] : '';
        $branchInfo['BRANCHNM']  = !empty($postData['BRANCHNM']) ? $postData['BRANCHNM'] : '';
        $branchInfo['BR_MGR_NM'] = !empty($postData['BR_MGR_NM']) ? $postData['BR_MGR_NM'] : '';
        $branchInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $branchInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $branchInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $branchInfo['ADDRESS']   = !empty($postData['ADDRESS']) ? $postData['ADDRESS'] : '';
        $branchInfo['CITY']      = !empty($postData['CITY']) ? $postData['CITY'] : '';
        $branchInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $branchInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $branchInfo['DIVISION']  = !empty($postData['DIVISION']) ? $postData['DIVISION'] : '';
        $branchInfo['PHONE_O']   = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $branchInfo['ZONE']      = !empty($postData['ZONE']) ? $postData['ZONE'] : '';
        $branchInfo['OCODE']     = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $branchInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $branchInfo->save();
        return $branchInfo;
    }
}
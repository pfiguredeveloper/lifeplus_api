<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Surveryors extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'surveryors';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','NAME','AD1','AD2','AD3','CITYID','PIN','PHONE_O','FAX','EMAIL','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$surveryorsInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$surveryorsInfo = new self();
    	}
        $surveryorsInfo['NAME']      = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $surveryorsInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $surveryorsInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $surveryorsInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $surveryorsInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $surveryorsInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $surveryorsInfo['PHONE_O']   = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $surveryorsInfo['FAX']       = !empty($postData['FAX']) ? $postData['FAX'] : '';
        $surveryorsInfo['EMAIL']     = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $surveryorsInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $surveryorsInfo->save();
        return $surveryorsInfo;
    }
}
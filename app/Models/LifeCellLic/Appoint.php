<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Appoint extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'appoint';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','PCODE','NAME','DATE','HRS','MNT','NARA','RESULT','NEXTMEET','SELECT','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$appointInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$appointInfo = new self();
    	}
        $appointInfo['PCODE']    = !empty($postData['PCODE']) ? $postData['PCODE'] : 0;
        $appointInfo['NAME']     = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $appointInfo['DATE']     = !empty($postData['DATE']) ? $postData['DATE'] : '';
        $appointInfo['HRS']      = !empty($postData['HRS']) ? $postData['HRS'] : 0;
        $appointInfo['MNT']      = !empty($postData['MNT']) ? $postData['MNT'] : 0;
        $appointInfo['NARA']     = !empty($postData['NARA']) ? $postData['NARA'] : '';
        $appointInfo['RESULT']   = !empty($postData['RESULT']) ? $postData['RESULT'] : '';
        $appointInfo['NEXTMEET'] = !empty($postData['NEXTMEET']) ? $postData['NEXTMEET'] : '';
        $appointInfo['SELECT']   = !empty($postData['SELECT']) ? $postData['SELECT'] : '';
        $appointInfo['client_id']= !empty($postData['client_id']) ? $postData['client_id'] : '';
        $appointInfo->save();
        return $appointInfo;
    }
}
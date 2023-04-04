<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'status';
    protected $primaryKey = 'STATUSID';
    public $timestamps    = false;

    protected $fillable = [
        'STATUSID','STATUS','GENDER','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$statusInfo = self::where('STATUSID', $postData['id'])->first();
    	} else {
    		$statusInfo = new self();
    	}
        $statusInfo['STATUS'] = !empty($postData['STATUS']) ? $postData['STATUS'] : '';
        $statusInfo['GENDER'] = !empty($postData['GENDER']) ? $postData['GENDER'] : '';
        $statusInfo['OCODE']  = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $statusInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $statusInfo->save();
        return $statusInfo;
    }
}
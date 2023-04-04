<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Smsformat extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'smsformat';
    protected $primaryKey = 'SMSID';
    public $timestamps    = false;

    protected $fillable = [
        'SMSID','MESSAGE','MESSAGETYPE','MESSAGETITLE','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$smsformatInfo = self::where('SMSID', $postData['id'])->first();
    	} else {
    		$smsformatInfo = new self();
    	}
        $smsformatInfo['MESSAGE']      = !empty($postData['MESSAGE']) ? $postData['MESSAGE'] : '';
        $smsformatInfo['MESSAGETYPE']  = !empty($postData['MESSAGETYPE']) ? $postData['MESSAGETYPE'] : 0;
        $smsformatInfo['MESSAGETITLE'] = !empty($postData['MESSAGETITLE']) ? $postData['MESSAGETITLE'] : 0;
        $smsformatInfo['client_id']    = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $smsformatInfo->save();
        return $smsformatInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'courier';
    protected $primaryKey = 'COURIERID';
    public $timestamps    = false;

    protected $fillable = [
        'COURIERID','COURIER_NAME','COURIER_PERSON','AD1','AD2','AD3','CITYID','PIN','PHONE','MOBILE','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$courierInfo = self::where('COURIERID', $postData['id'])->first();
    	} else {
    		$courierInfo = new self();
    	}
        $courierInfo['COURIER_NAME']    = !empty($postData['COURIER_NAME']) ? $postData['COURIER_NAME'] : '';
        $courierInfo['COURIER_PERSON']  = !empty($postData['COURIER_PERSON']) ? $postData['COURIER_PERSON'] : '';
        $courierInfo['AD1']             = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $courierInfo['AD2']             = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $courierInfo['AD3']             = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $courierInfo['CITYID']          = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $courierInfo['PIN']             = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $courierInfo['PHONE']           = !empty($postData['PHONE']) ? $postData['PHONE'] : '';
        $courierInfo['MOBILE']          = !empty($postData['MOBILE']) ? $postData['MOBILE'] : '';
        $courierInfo['client_id']       = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $courierInfo->save();
        return $courierInfo;
    }
}
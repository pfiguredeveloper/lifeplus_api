<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'state';
    protected $primaryKey = 'STATEID';
    public $timestamps    = false;

    protected $fillable = [
        'STATEID','STATE','COUNTRY','COUNTRYID','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$stateInfo = self::where('STATEID', $postData['id'])->first();
    	} else {
    		$stateInfo = new self();
    	}
        $stateInfo['STATE']      = !empty($postData['STATE']) ? $postData['STATE'] : '';
        $stateInfo['COUNTRY']    = !empty($postData['COUNTRY']) ? $postData['COUNTRY'] : '';
        $stateInfo['COUNTRYID']  = !empty($postData['COUNTRYID']) ? $postData['COUNTRYID'] : 0;
        $stateInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $stateInfo->save();
        return $stateInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'city';
    protected $primaryKey = 'CITYID';
    public $timestamps    = false;

    protected $fillable = [
        'CITYID','CITY','STD','DISTRICT','STATE','COUNTRY','DISTRICTID','STATEID','COUNTRYID','CAPITAL','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
        if(!empty($postData['id'])) {
    		$cityInfo = self::where('CITYID', $postData['id'])->first();
    	} else {
    		$cityInfo = new self();
    	}
        $cityInfo['CITY']       = !empty($postData['CITY']) ? $postData['CITY'] : '';
        $cityInfo['STD']        = !empty($postData['STD']) ? $postData['STD'] : '';
        $cityInfo['DISTRICT']   = !empty($postData['DISTRICT']) ? $postData['DISTRICT'] : '';
        $cityInfo['DISTRICTID'] = !empty($postData['DISTRICTID']) ? $postData['DISTRICTID'] : 0;
        $cityInfo['STATE']      = !empty($postData['STATE']) ? $postData['STATE'] : '';
        $cityInfo['STATEID']    = !empty($postData['STATEID']) ? $postData['STATEID'] : 0;
        $cityInfo['COUNTRY']    = !empty($postData['COUNTRY']) ? $postData['COUNTRY'] : '';
        $cityInfo['COUNTRYID']  = !empty($postData['COUNTRYID']) ? $postData['COUNTRYID'] : 0;
        $cityInfo['CAPITAL']    = !empty($postData['CAPITAL']) ? $postData['CAPITAL'] : '';
        $cityInfo['OCODE']      = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $cityInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $cityInfo->save();
        return $cityInfo;
    }
}
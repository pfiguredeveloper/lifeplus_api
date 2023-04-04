<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'district';
    protected $primaryKey = 'DISTRICTID';
    public $timestamps    = false;

    protected $fillable = [
        'DISTRICTID','DISTRICT','STATE','STATEID','COUNTRYID','COUNTRY','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$districtInfo = self::where('DISTRICTID', $postData['id'])->first();
    	} else {
    		$districtInfo = new self();
    	}
        $districtInfo['DISTRICT']  = !empty($postData['DISTRICT']) ? $postData['DISTRICT'] : '';
        $districtInfo['STATE']     = !empty($postData['STATE']) ? $postData['STATE'] : '';
        $districtInfo['STATEID']   = !empty($postData['STATEID']) ? $postData['STATEID'] : 0;
        $districtInfo['COUNTRY']   = !empty($postData['COUNTRY']) ? $postData['COUNTRY'] : '';
        $districtInfo['COUNTRYID'] = !empty($postData['COUNTRYID']) ? $postData['COUNTRYID'] : 0;
        $districtInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $districtInfo->save();
        return $districtInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'country';
    protected $primaryKey = 'COUNTRYID';
    public $timestamps    = false;

    protected $fillable = [
        'COUNTRYID','COUNTRY','ISD','ISO','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$countryInfo = self::where('COUNTRYID', $postData['id'])->first();
    	} else {
    		$countryInfo = new self();
    	}
        $countryInfo['COUNTRY'] = !empty($postData['COUNTRY']) ? $postData['COUNTRY'] : '';
        $countryInfo['ISD'] 	= !empty($postData['ISD']) ? $postData['ISD'] : '';
        $countryInfo['ISO'] 	= !empty($postData['ISO']) ? $postData['ISO'] : '';
        $countryInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $countryInfo->save();
        return $countryInfo;
    }
}
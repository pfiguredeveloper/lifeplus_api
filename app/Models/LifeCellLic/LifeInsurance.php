<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class LifeInsurance extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'life_insurance';
    protected $primaryKey = 'policy_insurance_id';
    public $timestamps    = false;

    protected $fillable = [
        'policy_insurance_id','company_name'
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$insuranceInfo = self::where('policy_insurance_id', $postData['id'])->first();
    	} else {
    		$insuranceInfo = new self();
    	}
        $insuranceInfo['company_name']  = !empty($postData['company_name']) ? $postData['company_name'] : '';
        $insuranceInfo->save();
        return $insuranceInfo;
    }
}
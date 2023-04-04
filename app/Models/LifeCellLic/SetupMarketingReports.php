<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SetupMarketingReports extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'setup_marketing_reports';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','address1','address2','address3','email','web','mobile','client_id','title',
    ];

    public static function saveMarketingReport($postData)
    {
    	if(!empty($postData['id'])) {
    		$marketingInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$marketingInfo = new self();
    	}
        $marketingInfo['title']     = !empty($postData['title']) ? $postData['title'] : '';
        $marketingInfo['address1']  = !empty($postData['address1']) ? $postData['address1'] : '';
        $marketingInfo['address2']  = !empty($postData['address2']) ? $postData['address2'] : '';
        $marketingInfo['address3']  = !empty($postData['address3']) ? $postData['address3'] : '';
        $marketingInfo['email']     = !empty($postData['email']) ? $postData['email'] : '';
        $marketingInfo['web']       = !empty($postData['web']) ? $postData['web'] : '';
        $marketingInfo['mobile']    = !empty($postData['mobile']) ? $postData['mobile'] : '';
        $marketingInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $marketingInfo->save();
        return $marketingInfo;
    }
}
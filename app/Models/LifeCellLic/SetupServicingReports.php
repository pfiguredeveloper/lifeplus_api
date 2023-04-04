<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SetupServicingReports extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'setup_servicing_reports';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','address1','address2','address3','address4','address5','warning','cap1','cap2','client_id','title','old_id','old_client_id',
    ];

    public static function saveServicingReport($postData)
    {
    	if(!empty($postData['id'])) {
    		$servicingInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$servicingInfo = new self();
    	}
        $servicingInfo['title']     = !empty($postData['title']) ? $postData['title'] : '';
        $servicingInfo['address1']  = !empty($postData['address1']) ? $postData['address1'] : '';
        $servicingInfo['address2']  = !empty($postData['address2']) ? $postData['address2'] : '';
        $servicingInfo['address3']  = !empty($postData['address3']) ? $postData['address3'] : '';
        $servicingInfo['address4']  = !empty($postData['address4']) ? $postData['address4'] : '';
        $servicingInfo['address5']  = !empty($postData['address5']) ? $postData['address5'] : '';
        $servicingInfo['warning']   = !empty($postData['warning']) ? $postData['warning'] : '';
        $servicingInfo['cap1']      = !empty($postData['cap1']) ? $postData['cap1'] : '';
        $servicingInfo['cap2']      = !empty($postData['cap2']) ? $postData['cap2'] : '';
        $servicingInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $servicingInfo->save();
        return $servicingInfo;
    }
}
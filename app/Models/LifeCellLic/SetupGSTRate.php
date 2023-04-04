<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SetupGSTRate extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'setup_gst_rate';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','from_date','to_date','gst_in_report','gst_ann','tax_ann_1','tax_ann_2','gst_term','tax_term_1','tax_term_2','gst_risk_1','gst_risk_2','tax_risk_1','tax_risk_2','client_id','old_id','old_client_id',
    ];

    public static function saveGSTRateSetup($postData)
    {
    	if(!empty($postData['id'])) {
    		$GSTInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$GSTInfo = new self();
    	}
        $GSTInfo['from_date']       = !empty($postData['from_date']) ? $postData['from_date'] : '';
        $GSTInfo['to_date']         = !empty($postData['to_date']) ? $postData['to_date'] : '';
        $GSTInfo['gst_in_report']   = !empty($postData['gst_in_report']) ? $postData['gst_in_report'] : '';
        $GSTInfo['gst_ann']         = !empty($postData['gst_ann']) ? $postData['gst_ann'] : '';
        $GSTInfo['tax_ann_1']       = !empty($postData['tax_ann_1']) ? $postData['tax_ann_1'] : '';
        $GSTInfo['tax_ann_2']       = !empty($postData['tax_ann_2']) ? $postData['tax_ann_2'] : '';
        $GSTInfo['gst_term']        = !empty($postData['gst_term']) ? $postData['gst_term'] : '';
        $GSTInfo['tax_term_1']      = !empty($postData['tax_term_1']) ? $postData['tax_term_1'] : '';
        $GSTInfo['tax_term_2']      = !empty($postData['tax_term_2']) ? $postData['tax_term_2'] : '';
        $GSTInfo['gst_risk_1']      = !empty($postData['gst_risk_1']) ? $postData['gst_risk_1'] : '';
        $GSTInfo['gst_risk_2']      = !empty($postData['gst_risk_2']) ? $postData['gst_risk_2'] : '';
        $GSTInfo['tax_risk_1']      = !empty($postData['tax_risk_1']) ? $postData['tax_risk_1'] : '';
        $GSTInfo['tax_risk_2']      = !empty($postData['tax_risk_2']) ? $postData['tax_risk_2'] : '';
        $GSTInfo['client_id']       = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $GSTInfo->save();
        return $GSTInfo;
    }
}
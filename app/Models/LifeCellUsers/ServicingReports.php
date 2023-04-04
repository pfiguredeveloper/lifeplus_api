<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;

class ServicingReports extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'servicing_reports';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','title','icon','redio_option','filter','report_type','grouping_option','ordering_option','select_option','date_display',
    ];

    public static function saveServicingReportsData($postData)
    {
    	if(!empty($postData['id'])) {
    		$reportsInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$reportsInfo = new self();
    	}
        $reportsInfo['title']           = !empty($postData['title']) ? $postData['title'] : '';
        $reportsInfo['date_display']    = !empty($postData['date_display']) ? $postData['date_display'] : '';
        $reportsInfo['icon']            = !empty($postData['icon']) ? $postData['icon'] : '';
        $reportsInfo['select_option']   = (!empty($postData['select_option']) && count($postData['select_option']) > 0) ? json_encode($postData['select_option']) : '';
        $reportsInfo['redio_option']    = (!empty($postData['redio_option']) && count($postData['redio_option']) > 0) ? json_encode($postData['redio_option']) : '';
        $reportsInfo['filter']          = (!empty($postData['filter']) && count($postData['filter']) > 0) ? json_encode($postData['filter']) : '';
        $reportsInfo['report_type']     = (!empty($postData['report_type']) && count($postData['report_type']) > 0) ? json_encode($postData['report_type']) : '';
        $reportsInfo['grouping_option'] = (!empty($postData['grouping_option']) && count($postData['grouping_option']) > 0) ? json_encode($postData['grouping_option']) : '';
        $reportsInfo['ordering_option'] = (!empty($postData['ordering_option']) && count($postData['ordering_option']) > 0) ? json_encode($postData['ordering_option']) : '';
        $reportsInfo->save();
        return $reportsInfo;
    }
}
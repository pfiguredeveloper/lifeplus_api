<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class SBDue extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'sb_due';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','puniqid','no_of_inst','duedate','amount','duemonthyr','client_id','old_id','old_client_id',
    ];

    public static function saveSBDue($postData)
    {
    	if(!empty($postData['id'])) {
    		$sbdueInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$sbdueInfo = new self();
    	}
        $sbdueInfo['puniqid']       = !empty($postData['puniqid']) ? $postData['puniqid'] : '';
        $sbdueInfo['no_of_inst']    = !empty($postData['no_of_inst']) ? $postData['no_of_inst'] : '';
        $sbdueInfo['duedate']       = !empty($postData['duedate']) ? $postData['duedate'] : '';
        $sbdueInfo['amount']        = !empty($postData['amount']) ? $postData['amount'] : '';
        $sbdueInfo['duemonthyr']    = !empty($postData['duemonthyr']) ? $postData['duemonthyr'] : '';
        $sbdueInfo['client_id']     = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $sbdueInfo->save();
        return $sbdueInfo;
    }
}
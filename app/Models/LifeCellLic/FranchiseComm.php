<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class FranchiseComm extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'franchise_commision';
    protected $primaryKey = 'franchcommid';
    public $timestamps    = false;

    protected $fillable = [
        'franchcommid','franchid','dealerid','productid','from_date','to_date','from_amount','to_amount','comm_rate','tds','remark','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$franchisecommInfo = self::where('franchcommid', $postData['id'])->first();
    	} else {
    		$franchisecommInfo = new self();
    	}
        $franchisecommInfo['franchid']    = !empty($postData['franchid']) ? $postData['franchid'] : 0;
        $franchisecommInfo['dealerid']    = !empty($postData['dealerid']) ? $postData['dealerid'] : 0;
        $franchisecommInfo['productid']   = !empty($postData['productid']) ? $postData['productid'] : 0;
        $franchisecommInfo['from_date']   = !empty($postData['from_date']) ? $postData['from_date'] : '';
        $franchisecommInfo['to_date']     = !empty($postData['to_date']) ? $postData['to_date'] : '';
        $franchisecommInfo['from_amount'] = !empty($postData['from_amount']) ? $postData['from_amount'] : '';
        $franchisecommInfo['to_amount']   = !empty($postData['to_amount']) ? $postData['to_amount'] : '';
        $franchisecommInfo['comm_rate']   = !empty($postData['comm_rate']) ? $postData['comm_rate'] : '';
        $franchisecommInfo['tds']         = !empty($postData['tds']) ? $postData['tds'] : '';
        $franchisecommInfo['remark']      = !empty($postData['remark']) ? $postData['remark'] : '';
        $franchisecommInfo['client_id']   = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $franchisecommInfo->save();
        return $franchisecommInfo;
    }
}
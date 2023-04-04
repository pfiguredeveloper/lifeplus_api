<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'sales';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','productid','client_id','prog_for','purchase_dt','b_payment','stop_date','next_due','language','e_demo','main_amt','dealerid','mrp','reg_type','order_form','sales_amt','rcv_form','mobile_mode','other_product','no_service_reason','title','remarks','updated_by',
    ];

    public static function saveSales($postData)
    {
    	if(!empty($postData['id'])) {
    		$salesInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$salesInfo = new self();
    	}
        $salesInfo['productid']          = !empty($postData['productid']) ? $postData['productid'] : '';
        $salesInfo['client_id']          = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $salesInfo['prog_for']           = !empty($postData['prog_for']) ? $postData['prog_for'] : '';
        $salesInfo['purchase_dt']        = !empty($postData['purchase_dt']) ? $postData['purchase_dt'] : '';
        $salesInfo['b_payment']          = !empty($postData['b_payment']) ? $postData['b_payment'] : '';
        $salesInfo['stop_date']          = !empty($postData['stop_date']) ? $postData['stop_date'] : '';
        $salesInfo['next_due']           = !empty($postData['next_due']) ? $postData['next_due'] : '';
        $salesInfo['language']           = !empty($postData['language']) ? $postData['language'] : '';
        $salesInfo['e_demo']             = !empty($postData['e_demo']) ? $postData['e_demo'] : '';
        $salesInfo['main_amt']           = !empty($postData['main_amt']) ? $postData['main_amt'] : '';
        $salesInfo['dealerid']           = !empty($postData['dealerid']) ? $postData['dealerid'] : '';
        $salesInfo['mrp']                = !empty($postData['mrp']) ? $postData['mrp'] : '';
        $salesInfo['reg_type']           = !empty($postData['reg_type']) ? $postData['reg_type'] : '';
        $salesInfo['order_form']         = !empty($postData['order_form']) ? $postData['order_form'] : '';
        $salesInfo['sales_amt']          = !empty($postData['sales_amt']) ? $postData['sales_amt'] : '';
        $salesInfo['rcv_form']           = !empty($postData['rcv_form']) ? $postData['rcv_form'] : '';
        $salesInfo['mobile_mode']        = !empty($postData['mobile_mode']) ? $postData['mobile_mode'] : '';
        $salesInfo['other_product']      = !empty($postData['other_product']) ? $postData['other_product'] : '';
        $salesInfo['no_service_reason']  = !empty($postData['no_service_reason']) ? $postData['no_service_reason'] : '';
        $salesInfo['title']              = !empty($postData['title']) ? $postData['title'] : '';
        $salesInfo['remarks']            = !empty($postData['remarks']) ? $postData['remarks'] : '';
        $salesInfo['updated_by']         = !empty($postData['updated_by']) ? $postData['updated_by'] : '';
        $salesInfo->save();
        return $salesInfo;
    }
}
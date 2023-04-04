<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
class BachatReceipt extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bachat_receipt';
    protected $primaryKey = 'RECEIPTID';
    public $timestamps    = true;

    protected $fillable = [
        'RECEIPTID', 'RECEIPT_NO', 'RECEIPT_DATE', 'ACCOUNT_NO', 'PARTY_NAME', 'COLLECTED_BY', 'AMOUNT', 'PAYMENT_MODE', 'BANK_NAME', 'CHEQUE_NO', 'REMARK', 'client_id', 'old_id', 'old_client_id'
    ];

    public static function saveBachatReceiptData($postData)
    {
    	if(!empty($postData['id'])) {
    		$recInfo = self::where('RECEIPTID', $postData['id'])->first();
    	} else {
    		$recInfo = new self();
        }
        
        $recInfo['RECEIPT_NO']        = !empty($postData['RECEIPT_NO']) ? $postData['RECEIPT_NO'] : 0;
        $recInfo['ACCOUNT_NO']      = !empty($postData['ACCOUNT_NO']) ? $postData['ACCOUNT_NO'] : 0;
        $recInfo['RECEIPT_DATE']        = !empty($postData['RECEIPT_DATE']) ? date('Y-m-d', strtotime($postData['RECEIPT_DATE'])) : null;
        $recInfo['PARTY_NAME']         = !empty($postData['PARTY_NAME']) ? $postData['PARTY_NAME'] : '';
        $recInfo['COLLECTED_BY']   = !empty($postData['COLLECTED_BY']) ? $postData['COLLECTED_BY'] : 0;
        $recInfo['AMOUNT']   = !empty($postData['AMOUNT']) ? $postData['AMOUNT'] : 0;
        $recInfo['PAYMENT_MODE'] = !empty($postData['PAYMENT_MODE']) ? $postData['PAYMENT_MODE'] : '';
        $recInfo['BANK_NAME']   = !empty($postData['BANK_NAME']) ? $postData['BANK_NAME'] : '';
        $recInfo['CHEQUE_NO']   = !empty($postData['CHEQUE_NO']) ? $postData['CHEQUE_NO'] : 0;
        $recInfo['REMARK']  = !empty($postData['REMARK']) ? $postData['REMARK'] : '';
        $recInfo['client_id']       = !empty($postData['client_id']) ? $postData['client_id'] : 0;
        $recInfo['old_id']        = !empty($postData['old_id']) ? $postData['old_id'] : 0;
        $recInfo['old_client_id']     = !empty($postData['old_client_id']) ? $postData['old_client_id'] : 0;
        $recInfo->save();
        return $recInfo;
    }
}
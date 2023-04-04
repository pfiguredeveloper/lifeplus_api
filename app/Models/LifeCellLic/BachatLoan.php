<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;

class BachatLoan extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bachat_loan';
    protected $primaryKey = 'loan_id';
    public $timestamps    = true;

    protected $fillable = [
        'loan_id', 'account_no', 'party_id', 'loan_date', 'amount', 'loan_type', 'productid', 'uid', 'next_due'
    ];

    public static function saveBachatLoanData($postData)
    {
        if (!empty($postData['id'])) {
            $polInfo = self::where('loan_id', $postData['id'])->first();
        } else {
            $polInfo = new self();
        }

        $polInfo['account_no']      = !empty($postData['account_no']) ? $postData['account_no'] : '';
        $polInfo['party_id']      = !empty($postData['party_id']) ? $postData['party_id'] : '';
        $polInfo['loan_date']        = !empty($postData['loan_date']) ? date('Y-m-d', strtotime($postData['loan_date'])) : null;
        $polInfo['amount']      = !empty($postData['amount']) ? $postData['amount'] : '';
        $polInfo['loan_type']      = !empty($postData['loan_type']) ? $postData['loan_type'] : '';
        $polInfo['productid']      = !empty($postData['productid']) ? $postData['productid'] : '';
        $polInfo['uid']      =         !empty($postData['uid']) ? $postData['uid'] : '';
        $polInfo['next_due']      = !empty($postData['next_due']) ? date('Y-m-d', strtotime($postData['next_due'])) : null;
        $polInfo['client_id']      = !empty($postData['client_id']) ? $postData['client_id'] : '';



        
        $polInfo->save();

        return $polInfo;
    }



}



?>



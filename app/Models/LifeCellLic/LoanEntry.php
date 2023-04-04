<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class LoanEntry extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'loan_entry';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','pono','loan_amt','loan_taken_dt','loan_int','next_due','client_id',
    ];

    public static function saveLoanEntry($postData)
    {
    	if(!empty($postData['id'])) {
    		$loanInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$loanInfo = new self();
    	}
        $loanInfo['pono']          = !empty($postData['pono']) ? $postData['pono'] : '';
        $loanInfo['loan_amt']      = !empty($postData['loan_amt']) ? $postData['loan_amt'] : '';
        $loanInfo['loan_taken_dt'] = !empty($postData['loan_taken_dt']) ? $postData['loan_taken_dt'] : '';
        $loanInfo['loan_int']      = !empty($postData['loan_int']) ? $postData['loan_int'] : '';
        $loanInfo['next_due']      = !empty($postData['next_due']) ? $postData['next_due'] : '';
        $loanInfo['client_id']     = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $loanInfo->save();
        return $loanInfo;
    }
}
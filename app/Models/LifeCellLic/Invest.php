<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Invest extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'invest';
    protected $primaryKey = 'ICODE';
    public $timestamps    = false;

    protected $fillable = [
        'ICODE','INVESTMENT','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$investInfo = self::where('ICODE', $postData['id'])->first();
    	} else {
    		$investInfo = new self();
    	}
        $investInfo['INVESTMENT']  = !empty($postData['INVESTMENT']) ? $postData['INVESTMENT'] : '';
        $investInfo['client_id']   = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $investInfo->save();
        return $investInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Paidby extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'paidby';
    protected $primaryKey = 'PAIDBYID';
    public $timestamps    = false;

    protected $fillable = [
        'PAIDBYID','PAIDBY','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$paidbyInfo = self::where('PAIDBYID', $postData['id'])->first();
    	} else {
    		$paidbyInfo = new self();
    	}
        $paidbyInfo['PAIDBY']    = !empty($postData['PAIDBY']) ? $postData['PAIDBY'] : '';
        $paidbyInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $paidbyInfo->save();
        return $paidbyInfo;
    }
}
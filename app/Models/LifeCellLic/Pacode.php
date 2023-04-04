<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Pacode extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'pacode';
    protected $primaryKey = 'PAID';
    public $timestamps    = false;

    protected $fillable = [
        'PAID','PACODE','PACODENM','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$pacodeInfo = self::where('PAID', $postData['id'])->first();
    	} else {
    		$pacodeInfo = new self();
    	}
        $pacodeInfo['PACODE']    = !empty($postData['PACODE']) ? $postData['PACODE'] : '';
        $pacodeInfo['PACODENM']  = !empty($postData['PACODENM']) ? $postData['PACODENM'] : '';
        $pacodeInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $pacodeInfo->save();
        return $pacodeInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Dolic extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'do';
    protected $primaryKey = 'DOCODE';
    public $timestamps    = false;

    protected $fillable = [
        'DOCODE','DONAME','DO_CODE','APP_MONTH','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$doInfo = self::where('DOCODE', $postData['id'])->first();
    	} else {
    		$doInfo = new self();
    	}
        $doInfo['DONAME']    = !empty($postData['DONAME']) ? $postData['DONAME'] : '';
        $doInfo['DO_CODE']   = !empty($postData['DO_CODE']) ? $postData['DO_CODE'] : '';
        $doInfo['APP_MONTH'] = !empty($postData['APP_MONTH']) ? $postData['APP_MONTH'] : '';
        $doInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $doInfo->save();
        return $doInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'area';
    protected $primaryKey = 'ARECD';
    public $timestamps    = false;

    protected $fillable = [
        'ARECD','ARE1','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$areaInfo = self::where('ARECD', $postData['id'])->first();
    	} else {
    		$areaInfo = new self();
    	}
        $areaInfo['ARE1']  = !empty($postData['ARE1']) ? $postData['ARE1'] : '';
        $areaInfo['OCODE'] = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $areaInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $areaInfo->save();
        return $areaInfo;
    }
}
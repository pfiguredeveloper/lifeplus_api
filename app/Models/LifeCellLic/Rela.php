<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Rela extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'rela';
    protected $primaryKey = 'RELAID';
    public $timestamps    = false;

    protected $fillable = [
        'RELAID','RELA','OCODE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$relaInfo = self::where('RELAID', $postData['id'])->first();
    	} else {
    		$relaInfo = new self();
    	}
        $relaInfo['RELA']    = !empty($postData['RELA']) ? $postData['RELA'] : '';
        $relaInfo['OCODE']   = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $relaInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $relaInfo->save();
        return $relaInfo;
    }
}
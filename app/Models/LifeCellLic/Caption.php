<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'caption';
    protected $primaryKey = 'CAPCD';
    public $timestamps    = false;

    protected $fillable = [
        'CAPCD','CAP1','CAP2','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$captionInfo = self::where('CAPCD', $postData['id'])->first();
    	} else {
    		$captionInfo = new self();
    	}
        $captionInfo['CAP1']    = !empty($postData['CAP1']) ? $postData['CAP1'] : '';
        $captionInfo['CAP2']    = !empty($postData['CAP2']) ? $postData['CAP2'] : '';
        $captionInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $captionInfo->save();
        return $captionInfo;
    }
}
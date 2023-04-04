<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'receiver';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'recivername','client_id','old_id','old_client_id'
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$receiverInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$receiverInfo = new self();
    	}
        $receiverInfo['recivername']    = !empty($postData['recivername']) ? $postData['recivername'] : '';
        $receiverInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : 0;
        $receiverInfo['old_id'] = !empty($postData['old_id']) ? $postData['old_id'] : 0;
        $receiverInfo['old_client_id'] = !empty($postData['old_client_id']) ? $postData['old_client_id'] : 0;
        $receiverInfo->save();
        return $receiverInfo;
    }
}
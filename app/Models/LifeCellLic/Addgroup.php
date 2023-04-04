<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Addgroup extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'addgroup';
    protected $primaryKey = 'ADDGROUPID';
    public $timestamps    = false;

    protected $fillable = [
        'ADDGROUPID','ADDGROUP','client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$addgroupInfo = self::where('ADDGROUPID', $postData['id'])->first();
    	} else {
    		$addgroupInfo = new self();
    	}
        $addgroupInfo['ADDGROUP']    = !empty($postData['ADDGROUP']) ? $postData['ADDGROUP'] : '';
        $addgroupInfo['client_id']   = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $addgroupInfo->save();
        return $addgroupInfo;
    }
}
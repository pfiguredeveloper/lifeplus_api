<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Articals extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'articals';
    protected $primaryKey = 'UNIQID';
    public $timestamps    = false;

    protected $fillable = [
        'UNIQID','DESC1','DESC2','DOCU','FILENAME','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$articalsInfo = self::where('UNIQID', $postData['id'])->first();
    	} else {
    		$articalsInfo = new self();
    	}
        $articalsInfo['DESC1']     = !empty($postData['DESC1']) ? $postData['DESC1'] : '';
        $articalsInfo['DESC2']     = !empty($postData['DESC2']) ? $postData['DESC2'] : '';
        $articalsInfo['DOCU']      = !empty($postData['DOCU']) ? $postData['DOCU'] : '';
        $articalsInfo['FILENAME']  = !empty($postData['FILENAME']) ? $postData['FILENAME'] : '';
        $articalsInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $articalsInfo->save();
        return $articalsInfo;
    }
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Caste extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'caste';
    protected $primaryKey = 'CASTEID';
    public $timestamps    = false;

    protected $fillable = [
        'CASTEID','CASTE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$casteInfo = self::where('CASTEID', $postData['id'])->first();
    	} else {
    		$casteInfo = new self();
    	}
        $casteInfo['CASTE']  = !empty($postData['CASTE']) ? $postData['CASTE'] : '';
        $casteInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $casteInfo->save();
        return $casteInfo;
    }
}
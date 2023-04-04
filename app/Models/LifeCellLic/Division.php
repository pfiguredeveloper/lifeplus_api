<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'division';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','division','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$divisionInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$divisionInfo = new self();
    	}
        $divisionInfo['division']  = !empty($postData['division']) ? $postData['division'] : '';
        $divisionInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $divisionInfo->save();
        return $divisionInfo;
    }
}
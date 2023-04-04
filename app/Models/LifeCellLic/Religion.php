<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'religion';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','religion','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$religionInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$religionInfo = new self();
    	}
        $religionInfo['religion']  = !empty($postData['religion']) ? $postData['religion'] : '';
        $religionInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $religionInfo->save();
        return $religionInfo;
    }
}
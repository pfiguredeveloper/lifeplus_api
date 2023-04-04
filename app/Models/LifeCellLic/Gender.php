<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'gender';
    protected $primaryKey = 'GENDERID';
    public $timestamps    = false;

    protected $fillable = [
        'GENDERID','NAME','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$genderInfo = self::where('GENDERID', $postData['id'])->first();
    	} else {
    		$genderInfo = new self();
    	}
        $genderInfo['NAME']  = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $genderInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $genderInfo->save();
        return $genderInfo;
    }
}
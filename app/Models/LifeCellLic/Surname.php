<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Surname extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'surname';
    protected $primaryKey = 'SURNAMEID';
    public $timestamps    = false;

    protected $fillable = [
        'SURNAMEID','SURNAME','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$surnameInfo = self::where('SURNAMEID', $postData['id'])->first();
    	} else {
    		$surnameInfo = new self();
    	}
        $surnameInfo['SURNAME'] = !empty($postData['SURNAME']) ? $postData['SURNAME'] : '';
        $surnameInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $surnameInfo->save();
        return $surnameInfo;
    }
}
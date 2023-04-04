<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class TypeOfBody extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'type_of_body';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','TYPE_BODY','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$type_of_bodyInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$type_of_bodyInfo = new self();
    	}
        $type_of_bodyInfo['TYPE_BODY']  = !empty($postData['TYPE_BODY']) ? $postData['TYPE_BODY'] : '';
        $type_of_bodyInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $type_of_bodyInfo->save();
        return $type_of_bodyInfo;
    }
}
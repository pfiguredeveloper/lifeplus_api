<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class ClientWiseMenuSetup extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'client_wise_menu_setup';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','font_color','back_color','ordering','menu_id','client_id','quick_menu','quick_menu_ordering',
    ];

    public static function saveClientWiseMenuSetup($postData)
    {
    	if(!empty($postData['id'])) {
    		$clientInfo = self::where('id', $postData['id'])->first();
    	} else {
    		$clientInfo = new self();
    	}
        $clientInfo['font_color']           = !empty($postData['font_color']) ? $postData['font_color'] : '';
        $clientInfo['back_color']           = !empty($postData['back_color']) ? $postData['back_color'] : '';
        $clientInfo['ordering']             = !empty($postData['ordering']) ? $postData['ordering'] : '';
        $clientInfo['quick_menu']           = !empty($postData['quick_menu']) ? $postData['quick_menu'] : 0;
        $clientInfo['quick_menu_ordering']  = !empty($postData['quick_menu_ordering']) ? $postData['quick_menu_ordering'] : '';
        $clientInfo['menu_id']              = !empty($postData['menu_id']) ? $postData['menu_id'] : '';
        $clientInfo['client_id']            = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $clientInfo->save();
        return $clientInfo;
    }
}
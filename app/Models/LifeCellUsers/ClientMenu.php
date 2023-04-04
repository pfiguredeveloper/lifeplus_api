<?php
namespace App\Models\LifeCellUsers;
use Illuminate\Database\Eloquent\Model;

class ClientMenu extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'main_menus';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','menu_name','menu_url','font_color','back_color','icon','parent_id','menu_enabled','ordering','product_id','quick_menu','quick_menu_ordering',
    ];

    public static function saveClientMenu($postData)
    {
    	if(!empty($postData['id'])) {
    		$clientMenu = self::where('id', $postData['id'])->first();
    	} else {
    		$clientMenu = new self();
    	}
        $clientMenu['menu_name']            = !empty($postData['menu_name']) ? $postData['menu_name'] : '';
        $clientMenu['menu_url']             = !empty($postData['menu_url']) ? $postData['menu_url'] : '';
        $clientMenu['font_color']           = !empty($postData['font_color']) ? $postData['font_color'] : '';
        $clientMenu['back_color']           = !empty($postData['back_color']) ? $postData['back_color'] : '';
        $clientMenu['ordering']             = !empty($postData['ordering']) ? $postData['ordering'] : '';
        $clientMenu['product_id']           = !empty($postData['product_id']) ? $postData['product_id'] : '';
        $clientMenu['icon']                 = !empty($postData['icon']) ? $postData['icon'] : '';
        $clientMenu['parent_id']            = !empty($postData['parent_id']) ? $postData['parent_id'] : 0;
        $clientMenu['quick_menu']           = !empty($postData['quick_menu']) ? $postData['quick_menu'] : 0;
        $clientMenu['quick_menu_ordering']  = !empty($postData['quick_menu_ordering']) ? $postData['quick_menu_ordering'] : '';
        $clientMenu['menu_enabled']         = !empty($postData['menu_enabled']) ? $postData['menu_enabled'] : 0;
        $clientMenu->save();
        return $clientMenu;
    }
}
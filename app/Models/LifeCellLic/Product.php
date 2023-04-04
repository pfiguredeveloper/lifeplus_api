<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'product';
    protected $primaryKey = 'productid';
    public $timestamps    = false;

    protected $fillable = [
        'productid','productname','productpath','demodays','price','renew','version_number','version_date',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$productInfo = self::where('productid', $postData['id'])->first();
    	} else {
    		$productInfo = new self();
    	}
        $productInfo['productname']     = !empty($postData['productname']) ? $postData['productname'] : '';
        $productInfo['productpath']     = !empty($postData['productpath']) ? $postData['productpath'] : '';
        $productInfo['demodays']        = !empty($postData['demodays']) ? $postData['demodays'] : 0;
        $productInfo['price']           = !empty($postData['price']) ? $postData['price'] : 0;
        $productInfo['renew']           = !empty($postData['renew']) ? $postData['renew'] : 0;
        $productInfo['version_number']  = !empty($postData['version_number']) ? $postData['version_number'] : '';
        $productInfo['version_date']    = !empty($postData['version_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['version_date'])->format('Y-m-d') : null;
        $productInfo->save();
        return $productInfo;
    }
}
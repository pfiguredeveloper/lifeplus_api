<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class AssetsType extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'assetstype';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','NAME','client_id'
    ];

    public static function saveMaster($postData)
    {
        if(!empty($postData['id'])) {
            $assetstype = self::where('id', $postData['id'])->first();
        } else {
            $assetstype = new self();
        }
        $assetstype['NAME']     = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $assetstype['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $assetstype->save();
        return $assetstype;
    }
}
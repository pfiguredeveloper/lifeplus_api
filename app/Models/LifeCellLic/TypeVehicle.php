<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class TypeVehicle extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'type_vehicle';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','TYPE_VEHICLE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$type_vehicleInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$type_vehicleInfo = new self();
    	}
        $type_vehicleInfo['TYPE_VEHICLE']  = !empty($postData['TYPE_VEHICLE']) ? $postData['TYPE_VEHICLE'] : '';
        $type_vehicleInfo['client_id']     = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $type_vehicleInfo->save();
        return $type_vehicleInfo;
    }
}
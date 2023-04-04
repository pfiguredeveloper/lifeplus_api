<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'vehicle_make';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','VEHICLE_MAKE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$vehicle_makeInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$vehicle_makeInfo = new self();
    	}
        $vehicle_makeInfo['VEHICLE_MAKE']  = !empty($postData['VEHICLE_MAKE']) ? $postData['VEHICLE_MAKE'] : '';
        $vehicle_makeInfo['client_id']     = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $vehicle_makeInfo->save();
        return $vehicle_makeInfo;
    }
}
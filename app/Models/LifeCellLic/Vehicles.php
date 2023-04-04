<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'vehicles';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','NAME','TYPE_BODY','TYPE_VEHICLE','NO_CYLINDER','HORSE_POWER','SITTING_CAPICITY','VEHICLE_MAKE','CUBIC_CAPICITY','GROSS_WEIGHT','UNLOADED_WEIGHT','PAY_LOAD','FRONT_WEIGHT','REAER_WEIGHT','TYRE_SIZE_FRONT','TYRE_SIZE_REAE','client_id','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$vehiclesInfo = self::where('ID', $postData['id'])->first();
    	} else {
    		$vehiclesInfo = new self();
    	}
        $vehiclesInfo['NAME']               = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $vehiclesInfo['TYPE_BODY']          = !empty($postData['TYPE_BODY']) ? $postData['TYPE_BODY'] : '';
        $vehiclesInfo['TYPE_VEHICLE']       = !empty($postData['TYPE_VEHICLE']) ? $postData['TYPE_VEHICLE'] : '';
        $vehiclesInfo['NO_CYLINDER']        = !empty($postData['NO_CYLINDER']) ? $postData['NO_CYLINDER'] : 0;
        $vehiclesInfo['HORSE_POWER']        = !empty($postData['HORSE_POWER']) ? $postData['HORSE_POWER'] : '';
        $vehiclesInfo['SITTING_CAPICITY']   = !empty($postData['SITTING_CAPICITY']) ? $postData['SITTING_CAPICITY'] : '';
        $vehiclesInfo['VEHICLE_MAKE']       = !empty($postData['VEHICLE_MAKE']) ? $postData['VEHICLE_MAKE'] : '';
        $vehiclesInfo['CUBIC_CAPICITY']     = !empty($postData['CUBIC_CAPICITY']) ? $postData['CUBIC_CAPICITY'] : '';
        $vehiclesInfo['GROSS_WEIGHT']       = !empty($postData['GROSS_WEIGHT']) ? $postData['GROSS_WEIGHT'] : 0;
        $vehiclesInfo['UNLOADED_WEIGHT']    = !empty($postData['UNLOADED_WEIGHT']) ? $postData['UNLOADED_WEIGHT'] : 0;
        $vehiclesInfo['PAY_LOAD']           = !empty($postData['PAY_LOAD']) ? $postData['PAY_LOAD'] : 0;
        $vehiclesInfo['FRONT_WEIGHT']       = !empty($postData['FRONT_WEIGHT']) ? $postData['FRONT_WEIGHT'] : 0;
        $vehiclesInfo['REAER_WEIGHT']       = !empty($postData['REAER_WEIGHT']) ? $postData['REAER_WEIGHT'] : 0;
        $vehiclesInfo['TYRE_SIZE_FRONT']    = !empty($postData['TYRE_SIZE_FRONT']) ? $postData['TYRE_SIZE_FRONT'] : '';
        $vehiclesInfo['TYRE_SIZE_REAE']     = !empty($postData['TYRE_SIZE_REAE']) ? $postData['TYRE_SIZE_REAE'] : '';
        $vehiclesInfo['client_id']          = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $vehiclesInfo->save();
        return $vehiclesInfo;
    }
}
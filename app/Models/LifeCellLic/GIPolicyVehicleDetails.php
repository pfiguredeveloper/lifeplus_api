<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GIPolicyVehicleDetails extends Model
{
    use SoftDeletes;
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Policy_Vehicle_Details';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','PolicyId','VehicalId','VehicalName','VehicalRegDate','RegistrationNo','EngineNo','YearOfMFG','RegAuthLocation','ChasisNo','AgeOfVehicle','ValueOfVehicle','NonElecAcce','ElecAcce','SideCarTrailor','CngLpgKit','TotalValue','is_active'
    ];
}
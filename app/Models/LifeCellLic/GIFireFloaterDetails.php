<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
class GIFireFloaterDetails extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Fire_Floater_Details';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable = [
        'id','PolicyId','LocationName','SituationAddress','Section','BuildingIncludingPlinthFoundation','PlinthFoundation','FurnitureFixtureSettings','PlantMachineryAccessories','TotalPremiumAmount','BlockName','RiskDescription','FEATypes','Stock','StockInProcess','AnyOther','TotalSumAssured', 'is_active',
    ];
}
<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
class GIPolicyMediClaimDetails extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Policy_Medi_Claim_Details';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable = [
        'id','PolicyId','PartyId','Dob','Age','Relation','SumAssured','NoClaimBouns','Premium', 'is_active',
    ];
}
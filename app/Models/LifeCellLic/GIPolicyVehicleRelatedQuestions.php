<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GIPolicyVehicleRelatedQuestions extends Model
{
    use SoftDeletes;
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Policy_Vehicle_Related_Questions';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','PolicyId','VehicalQuestionId','VehicalQuestion','Answer','is_active'
    ];
}
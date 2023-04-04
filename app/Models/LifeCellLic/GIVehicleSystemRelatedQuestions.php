<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GIVehicleSystemRelatedQuestions extends Model
{
    use SoftDeletes;
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Vehicle_System_Related_Questions';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    
    protected $fillable = [
        'id','Question','ClientId','is_active'
    ];
}
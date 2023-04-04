<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GIInsurer extends Model
{
       use SoftDeletes;
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Insurer';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','InsurerCompany','is_active'
    ];

}
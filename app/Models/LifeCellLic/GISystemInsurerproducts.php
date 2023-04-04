<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GISystemInsurerproducts extends Model
{
       use SoftDeletes;
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_System_Insurer_products';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','Productname','IsurerId','Form_id','is_active'
    ];

   
}
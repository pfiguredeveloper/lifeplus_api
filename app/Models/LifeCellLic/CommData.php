<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class CommData extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'comm_data';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','name','pono','plan','prem_due','risk_date','cbo','adj_date','prem','comm','comm_id',
    ];
}
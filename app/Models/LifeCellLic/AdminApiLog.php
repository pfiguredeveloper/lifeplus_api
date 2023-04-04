<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class AdminApiLog extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'admin_api_log';
    protected $primaryKey = 'admin_api_log_id';
    public $timestamps    = false;

    protected $fillable = [
        'admin_api_log_id','start_time','end_time','url','method','request','response','ip_address','status','user_id'
    ];
}
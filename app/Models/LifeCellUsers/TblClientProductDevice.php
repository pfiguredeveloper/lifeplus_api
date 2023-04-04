<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class TblClientProductDevice extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'tbl_client_product_device';
    protected $primaryKey = 'cpd_id';
    public $timestamps    = false;

    protected $fillable = [
        'cpd_id','cp_id', 'cp_imei', 'cp_device_name','cp_hddno','cp_last_login',
    ];
    
    protected $guarded    = [];
}

<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class ClientProductLicense extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'client_product_license';
    protected $primaryKey = 'cpl_id';
    public $timestamps    = false;

    protected $fillable = [
        'cpl_id','cp_id', 'cpl_license_dt', 'cpl_exp_dt','cpl_is_demo','cpl_renew_price','cpl_sitekey','cpl_licencekey','cpl_remark','cpl_licissuedt',
    ];
    
    protected $guarded    = [];
}

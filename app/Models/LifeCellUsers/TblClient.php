<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class TblClient extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'tbl_client';
    protected $primaryKey = 'c_id';
    public $timestamps    = false;

    protected $fillable = [
        'c_id','c_name', 'c_mobile', 'c_email','c_password','c_city_id','c_type','c_agt_ad1','c_agt_ad2','c_agt_ad3','c_branch_id','c_country_id','c_state_id','c_pin','c_phone_o','c_phone_r','c_do','c_docode','c_birth_date','c_marriagedt','c_reference_id','c_is_verified','c_mail_group_id','c_remark','roles_id','policy_insurance_id','is_first_login','old_client_id'
    ];

    public function tblClientProduct()
    {
        return $this->hasMany('App\Models\LifeCellUsers\TblClientProduct','c_id','c_id');
    }
    
    protected $guarded    = [];
}

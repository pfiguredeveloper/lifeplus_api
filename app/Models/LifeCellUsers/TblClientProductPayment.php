<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class TblClientProductPayment extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'client_product_payment';
    protected $primaryKey = 'cpp_id';
    public $timestamps    = false;

    protected $fillable = [
        'cpp_id','c_id','cp_id','p_id','device_id','new_licence','renew_licence','amount','tr_dt','sales_dt','dealer_id','old_due_dt','new_due_dt',
    ];
    
    protected $guarded    = [];
}
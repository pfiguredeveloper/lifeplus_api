<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class TblProduct extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'tbl_product';
    protected $primaryKey = 'p_id';
    public $timestamps    = false;

    protected $fillable = [
        'p_id','p_name', 'p_code', 'p_demodays','p_type'
    ];
    
    protected $guarded    = [];
}

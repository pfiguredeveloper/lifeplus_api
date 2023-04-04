<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class OldTblClientProduct extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'old_client_product';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    
    protected $guarded    = [];
}

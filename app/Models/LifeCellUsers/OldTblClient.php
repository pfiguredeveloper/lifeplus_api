<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class OldTblClient extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'old_client';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    
    protected $guarded    = [];
}

<?php

namespace App\Models\LifeCellUsers;

use Illuminate\Database\Eloquent\Model;

class TblApi extends Model
{
    protected $connection = 'lifecell_users';
    protected $table      = 'tbl_api';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','fieldName', 'alias', 'isKey','isOnSearch','validate','title','tableid','tableName','tag','giveInResponse','isInRequest'
    ];
    
    protected $guarded    = [];
}

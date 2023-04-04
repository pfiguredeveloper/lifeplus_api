<?php

namespace App\Models\LifeCell;

use Illuminate\Database\Eloquent\Model;

class SaOption extends Model
{
    protected $connection = 'lifecell';
    protected $table      = 'sa_option';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id', 'option_name'
    ];
}

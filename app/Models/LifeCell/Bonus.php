<?php
namespace App\Models\LifeCell;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $connection = 'lifecell';
    protected $table      = 'bonus';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','field1', 'field2', 'field3','field4','field5','field6','field7','field8','field9','field10','field11','field12','name2','field13','field14',
    ];
}


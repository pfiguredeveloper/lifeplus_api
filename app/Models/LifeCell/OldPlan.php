<?php
namespace App\Models\LifeCell;
use Illuminate\Database\Eloquent\Model;

class OldPlan extends Model
{
    protected $connection = 'lifecell';
    protected $table      = 'old_plan';
    protected $primaryKey = 'id';
    public $timestamps    = false;
}


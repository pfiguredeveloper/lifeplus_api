<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class CommPosting extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'commposting';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','FILE','comm_date','post','post_date','client_id',
    ];

    public function CommData() {
        return $this->hasMany('App\Models\LifeCellLic\CommData','comm_id','ID');
    }
}
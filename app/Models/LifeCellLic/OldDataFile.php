<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class OldDataFile extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'old_data_file';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','FILE','client_id','is_convert_data',
    ];
}
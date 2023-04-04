<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class PolBoc extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'pol_boc';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','BRANCHNO','BRANCHDT','BRANCHAMT','POLID',
    ];

    public static function savePolBOC($postData,$polID = 0)
    {
    	$polbocInfo              = new self();
        $polbocInfo['BRANCHNO']  = !empty($postData['BRANCHNO']) ? $postData['BRANCHNO'] : 0;
        $polbocInfo['BRANCHDT']  = !empty($postData['BRANCHDT']) ? $postData['BRANCHDT'] : '';
        $polbocInfo['BRANCHAMT'] = !empty($postData['BRANCHAMT']) ? $postData['BRANCHAMT'] : '';
        $polbocInfo['POLID']     = $polID;
        $polbocInfo->save();
        return $polbocInfo;
    }
}
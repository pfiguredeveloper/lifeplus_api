<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Chmod extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'chmod';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','pono','appdate','omode','oprem','nmode','nprem','edate','done','duedate','paiddate','client_id','old_id','old_client_id',
    ];

    public static function saveChmod($postData)
    {
    	$chmodInfo = new self();
        $chmodInfo['pono']       = !empty($postData['pono']) ? $postData['pono'] : '';
        $chmodInfo['appdate']    = !empty($postData['appdate']) ? $postData['appdate'] : '';
        $chmodInfo['omode']      = !empty($postData['omode']) ? $postData['omode'] : '';
        $chmodInfo['oprem']      = !empty($postData['oprem']) ? $postData['oprem'] : '';
        $chmodInfo['nmode']      = !empty($postData['nmode']) ? $postData['nmode'] : '';
        $chmodInfo['nprem']      = !empty($postData['nprem']) ? $postData['nprem'] : '';
        $chmodInfo['edate']      = !empty($postData['edate']) ? $postData['edate'] : '';
        $chmodInfo['done']       = !empty($postData['done']) ? $postData['done'] : '';
        $chmodInfo['duedate']    = !empty($postData['duedate']) ? $postData['duedate'] : '';
        $chmodInfo['paiddate']   = !empty($postData['paiddate']) ? $postData['paiddate'] : '';
        $chmodInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $chmodInfo->save();
        return $chmodInfo;
    }
}
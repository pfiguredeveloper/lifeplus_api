<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class PolNominee extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'pol_nominee';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','NOMINEE','AGE','RELATION','SHARE','APPOINTEE','POLID',
    ];

    public static function savePolNominee($postData,$polID = 0)
    {
    	$polnomineeInfo              = new self();
    	$polnomineeInfo['NOMINEE']   = !empty($postData['NOMINEE']) ? $postData['NOMINEE'] : '';
        $polnomineeInfo['AGE']       = !empty($postData['AGE']) ? $postData['AGE'] : '';
        $polnomineeInfo['RELATION']  = !empty($postData['RELATION']) ? $postData['RELATION'] : '';
        $polnomineeInfo['SHARE']     = !empty($postData['SHARE']) ? $postData['SHARE'] : '';
        $polnomineeInfo['APPOINTEE'] = !empty($postData['APPOINTEE']) ? $postData['APPOINTEE'] : '';
        $polnomineeInfo['POLID']     = $polID;
        $polnomineeInfo->save();
        return $polnomineeInfo;
    }
}
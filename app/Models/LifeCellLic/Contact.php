<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'contact';
    protected $primaryKey = 'ID';
    public $timestamps    = false;

    protected $fillable = [
        'ID','AD1','AD2','AD3','CITY','CITYID','PIN','ARECD','PHONE_O','PHONE_R','MOBILE','PAGER_FAX','EMAIL','tableName','tableID',
    ];

    public static function saveMaster($postData)
    {
        $contactInfo = new self();
        $contactInfo['AD1']       = !empty($postData['AD1']) ? $postData['AD1'] : '';
        $contactInfo['AD2']       = !empty($postData['AD2']) ? $postData['AD2'] : '';
        $contactInfo['AD3']       = !empty($postData['AD3']) ? $postData['AD3'] : '';
        $contactInfo['CITY']      = !empty($postData['CITY']) ? $postData['CITY'] : '';
        $contactInfo['CITYID']    = !empty($postData['CITYID']) ? $postData['CITYID'] : 0;
        $contactInfo['PIN']       = !empty($postData['PIN']) ? $postData['PIN'] : '';
        $contactInfo['ARECD']     = !empty($postData['ARECD']) ? $postData['ARECD'] : 0;
        $contactInfo['PHONE_O']   = !empty($postData['PHONE_O']) ? $postData['PHONE_O'] : '';
        $contactInfo['PHONE_R']   = !empty($postData['PHONE_R']) ? $postData['PHONE_R'] : '';
        $contactInfo['MOBILE']    = !empty($postData['MOBILE']) ? $postData['MOBILE'] : '';
        $contactInfo['PAGER_FAX'] = !empty($postData['PAGER_FAX']) ? $postData['PAGER_FAX'] : '';
        $contactInfo['EMAIL']     = !empty($postData['EMAIL']) ? $postData['EMAIL'] : '';
        $contactInfo['tableName'] = !empty($postData['tableName']) ? $postData['tableName'] : '';
        $contactInfo['tableID']   = !empty($postData['tableID']) ? $postData['tableID'] : 0;
        $contactInfo->save();
        return $contactInfo;
    }
}
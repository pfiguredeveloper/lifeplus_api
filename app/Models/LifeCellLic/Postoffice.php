<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;

class Postoffice extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'postoffice';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'PostOffice', 'Address', 'City_Id', 'PinCode', 'Phone', 'Mobile', 'AdharCard', 'client_id', 'old_id', 'old_client_id'
    ];

    public static function saveMaster($postData)
    {
        if (!empty($postData['id'])) {
            $postofficeInfo = self::where('id', $postData['id'])->first();
        } else {
            $postofficeInfo = new self();
        }
        $postofficeInfo['PostOffice']    = !empty($postData['PostOffice']) ? $postData['PostOffice'] : '';
        $postofficeInfo['Address']  = !empty($postData['Address']) ? $postData['Address'] : '';
        $postofficeInfo['PinCode']  = !empty($postData['PinCode']) ? $postData['PinCode'] : '';
        $postofficeInfo['Phone']  = !empty($postData['Phone']) ? $postData['Phone'] : '';
        $postofficeInfo['Mobile']  = !empty($postData['Mobile']) ? $postData['Mobile'] : '';
        $postofficeInfo['AdharCard']  = !empty($postData['AdharCard']) ? $postData['AdharCard'] : '';
        $postofficeInfo['City_Id'] = !empty($postData['City_Id']) ? $postData['City_Id'] : 0;
        $postofficeInfo['client_id'] = !empty($postData['client_id']) ? $postData['client_id'] : 0;
        $postofficeInfo['old_id'] = !empty($postData['old_id']) ? $postData['old_id'] : 0;
        $postofficeInfo['old_client_id'] = !empty($postData['old_client_id']) ? $postData['old_client_id'] : 0;
        $postofficeInfo->save();
        return $postofficeInfo;
    }
}

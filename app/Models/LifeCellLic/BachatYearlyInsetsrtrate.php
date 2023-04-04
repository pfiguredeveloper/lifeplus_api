<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;

class BachatYearlyInsetsrtrate extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bachat_yerly_interst_rate';
    protected $primaryKey = 'interst_id';
    public $timestamps    = true;

    protected $fillable = [
        'interst_id','interst_year', 'interst_name', 'intesrt_rate','productid','clientid','schemeid'
    ];


       public static function saveBachatinsterstData($postData)
    {
        if (!empty($postData['id'])) {
            $polInfo = self::where('interst_id', $postData['id'])->first();
        } else {
            $polInfo = new self();
        }

        $polInfo['interst_year']      = !empty($postData['interst_year']) ? $postData['interst_year'] : '';
        $polInfo['interst_name']      = !empty($postData['interst_name']) ? $postData['interst_name'] : '';
        $polInfo['intesrt_rate']      = !empty($postData['intesrt_rate']) ? $postData['intesrt_rate'] : '';
        $polInfo['clientid']      = !empty($postData['clientid']) ? $postData['clientid'] : '';
        $polInfo['productid']      = !empty($postData['productid']) ? $postData['productid'] : '';
        $polInfo['schemeid']      = !empty($postData['schemeid']) ? $postData['schemeid'] : '';
        
        $polInfo->save();
        return $polInfo;
    }

}

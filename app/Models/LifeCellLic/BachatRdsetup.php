<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;

class BachatRdsetup extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'bachat_rdsetup';
    protected $primaryKey = 'Rdsetupid';
    public $timestamps    = true;

    protected $fillable = [
        'Rdsetupid','irfpcoa', 'laaotb', 'yirol','dc', 'rrf6m', 'tdsrate', 'rrf12m', 'secr', 'comisionrate','msa','scheuletype','amountinroundfigure','letterhoep','signatureuyn','oldnsa','birthdayremminder','before','minsurcharge','scheduleno','defulatfor15days','clientid','productid','schemeid',
    ];

    public static function saveBachatLoanData($postData)
    {
        if (!empty($postData['id'])) {
            $polInfo = self::where('Rdsetupid', $postData['id'])->first();
        } else {
            $polInfo = new self();
        }

        $polInfo['irfpcoa']      = !empty($postData['irfpcoa']) ? $postData['irfpcoa'] : '';
        $polInfo['laaotb']      = !empty($postData['laaotb']) ? $postData['laaotb'] : '';
        $polInfo['yirol']      = !empty($postData['yirol']) ? $postData['yirol'] : '';
        $polInfo['dc']      = !empty($postData['dc']) ? $postData['dc'] : '';
        $polInfo['rrf6m']      = !empty($postData['rrf6m']) ? $postData['rrf6m'] : '';
        $polInfo['tdsrate']      =         !empty($postData['tdsrate']) ? $postData['tdsrate'] : '';
        $polInfo['rrf12m']      = !empty($postData['rrf12m']) ? $postData['rrf12m'] : '';
        $polInfo['secr']      = !empty($postData['secr']) ? $postData['secr'] : '';
        $polInfo['comisionrate']      = !empty($postData['comisionrate']) ? $postData['comisionrate'] : '';
        $polInfo['msa']      = !empty($postData['msa']) ? $postData['msa'] : '';
        $polInfo['scheuletype']      = !empty($postData['scheuletype']) ? $postData['scheuletype'] : '';
        $polInfo['amountinroundfigure']      = !empty($postData['amountinroundfigure']) ? $postData['amountinroundfigure'] : '';
        $polInfo['letterhoep']      = !empty($postData['letterhoep']) ? $postData['letterhoep'] : '';
        $polInfo['signatureuyn']      = !empty($postData['signatureuyn']) ? $postData['signatureuyn'] : '';
        $polInfo['oldnsa']      = !empty($postData['oldnsa']) ? $postData['oldnsa'] : '';
        $polInfo['birthdayremminder']      = !empty($postData['birthdayremminder']) ? $postData['birthdayremminder'] : '';
        $polInfo['before']      = !empty($postData['before']) ? $postData['before'] : '';
        $polInfo['minsurcharge']      = !empty($postData['minsurcharge']) ? $postData['minsurcharge'] : '';
        $polInfo['scheduleno']      = !empty($postData['scheduleno']) ? $postData['scheduleno'] : '';
        $polInfo['defulatfor15days']      = !empty($postData['defulatfor15days']) ? $postData['defulatfor15days'] : '';
        $polInfo['clientid']      = !empty($postData['clientid']) ? $postData['clientid'] : '';
        $polInfo['productid']      = !empty($postData['productid']) ? $postData['productid'] : '';
        $polInfo['schemeid']      = !empty($postData['schemeid']) ? $postData['schemeid'] : '';



        
        $polInfo->save();

        return $polInfo;
    }



}



?>



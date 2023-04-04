<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellLic\Contact;

class Agency extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'agency';
    protected $primaryKey = 'AFILE';
    public $timestamps    = false;

    protected $fillable = [
        'AFILE','AGNO','ANAME','CITY','BD','WDT','APP_DT','RENEDT','EXP_DT','LICEXPDT','LICENCE','PHONE_O','PHONE_R','PAGER','MOBILE','ENDING','CLUB','ADDRESS','AGCODE','TERMINATE','EMAIL','PIN','FAX','OWN_OTH','DOCODE','SERVICING','CITYID','PHOTO','AD1','AD2','AD3','BRANCHCODE','PAN','NOMINEE','TR_RENEWDT','BANKCD','BANKACNO','AGINIT','AGTPHOTO','AGTINTRO','AGTABOUT','LIFEPLUSID','AGMONTH','OCODE','DEMODATA','BCODE','LICUSERID','LICPASS','CLOUD_D','LICCHECK','client_id','old_id','old_client_id','policy_insurance_id','p_id',
    ];

    public static function saveMaster($postData)
    {
        info($postData);
    	if(!empty($postData['id'])) {
    		$agencyInfo = self::where('AFILE', $postData['id'])->first();
    	} else {
    		$agencyInfo = new self();
    	}
        $agencyInfo['AGNO']       = !empty($postData['AGNO']) ? $postData['AGNO'] : '';
        $agencyInfo['p_id']       = !empty($postData['p_id']) ? $postData['p_id'] : '';
        $agencyInfo['ANAME']      = !empty($postData['ANAME']) ? $postData['ANAME'] : '';
        $agencyInfo['BD']         = !empty($postData['BD']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['BD'])->format('Y-m-d') : null;
        $agencyInfo['WDT']        = !empty($postData['WDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['WDT'])->format('Y-m-d') : null;
        $agencyInfo['APP_DT']     = !empty($postData['APP_DT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['APP_DT'])->format('Y-m-d') : null;
        $agencyInfo['RENEDT']     = !empty($postData['RENEDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['RENEDT'])->format('Y-m-d') : null;
        $agencyInfo['EXP_DT']     = !empty($postData['EXP_DT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['EXP_DT'])->format('Y-m-d') : null;
        $agencyInfo['LICEXPDT']   = !empty($postData['LICEXPDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['LICEXPDT'])->format('Y-m-d') : null;
        $agencyInfo['LICENCE']    = !empty($postData['LICENCE']) ? $postData['LICENCE'] : '';
        $agencyInfo['PAGER']      = !empty($postData['PAGER']) ? $postData['PAGER'] : '';
        $agencyInfo['ENDING']     = !empty($postData['ENDING']) ? $postData['ENDING'] : 0;
        $agencyInfo['CLUB']       = !empty($postData['CLUB']) ? $postData['CLUB'] : '';
        $agencyInfo['ADDRESS']    = !empty($postData['ADDRESS']) ? $postData['ADDRESS'] : '';
        $agencyInfo['AGCODE']     = !empty($postData['AGCODE']) ? $postData['AGCODE'] : '';
        $agencyInfo['TERMINATE']  = !empty($postData['TERMINATE']) ? $postData['TERMINATE'] : '';
        $agencyInfo['OWN_OTH']    = !empty($postData['OWN_OTH']) ? $postData['OWN_OTH'] : '';
        $agencyInfo['DOCODE']     = !empty($postData['DOCODE']) ? $postData['DOCODE'] : 0;
        $agencyInfo['SERVICING']  = !empty($postData['SERVICING']) ? $postData['SERVICING'] : '';
        $agencyInfo['PHOTO']      = !empty($postData['PHOTO']) ? $postData['PHOTO'] : '';
        $agencyInfo['BRANCHCODE'] = !empty($postData['BRANCHCODE']) ? $postData['BRANCHCODE'] : 0;
        $agencyInfo['PAN']        = !empty($postData['PAN']) ? $postData['PAN'] : '';
        $agencyInfo['NOMINEE']    = !empty($postData['NOMINEE']) ? $postData['NOMINEE'] : '';
        $agencyInfo['TR_RENEWDT'] = !empty($postData['TR_RENEWDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['TR_RENEWDT'])->format('Y-m-d') : null;
        $agencyInfo['BANKCD']     = !empty($postData['BANKCD']) ? $postData['BANKCD'] : 0;
        $agencyInfo['BANKACNO']   = !empty($postData['BANKACNO']) ? $postData['BANKACNO'] : '';
        $agencyInfo['AGINIT']     = !empty($postData['AGINIT']) ? $postData['AGINIT'] : '';
        $agencyInfo['AGTPHOTO']   = !empty($postData['AGTPHOTO']) ? $postData['AGTPHOTO'] : '';
        $agencyInfo['AGTINTRO']   = !empty($postData['AGTINTRO']) ? $postData['AGTINTRO'] : '';
        $agencyInfo['AGTABOUT']   = !empty($postData['AGTABOUT']) ? $postData['AGTABOUT'] : '';
        $agencyInfo['LIFEPLUSID'] = !empty($postData['LIFEPLUSID']) ? $postData['LIFEPLUSID'] : 0;
        $agencyInfo['AGMONTH']    = !empty($postData['AGMONTH']) ? $postData['AGMONTH'] : '';
        $agencyInfo['OCODE']      = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $agencyInfo['DEMODATA']   = !empty($postData['DEMODATA']) ? $postData['DEMODATA'] : '';
        $agencyInfo['BCODE']      = !empty($postData['BCODE']) ? $postData['BCODE'] : 0;
        $agencyInfo['LICUSERID']  = !empty($postData['LICUSERID']) ? $postData['LICUSERID'] : '';
        $agencyInfo['LICPASS']    = !empty($postData['LICPASS']) ? $postData['LICPASS'] : '';
        $agencyInfo['CLOUD_D']    = !empty($postData['CLOUD_D']) ? $postData['CLOUD_D'] : '';
        $agencyInfo['LICCHECK']   = !empty($postData['LICCHECK']) ? $postData['LICCHECK'] : '';
        $agencyInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $agencyInfo['policy_insurance_id']  = !empty($postData['policy_insurance_id']) ? $postData['policy_insurance_id'] : 0;

        $agencyInfo['AD1']        = !empty($postData['address_group'][0]['AD1']) ? $postData['address_group'][0]['AD1'] : '';
        $agencyInfo['AD2']        = !empty($postData['address_group'][0]['AD2']) ? $postData['address_group'][0]['AD2'] : '';
        $agencyInfo['AD3']        = !empty($postData['address_group'][0]['AD3']) ? $postData['address_group'][0]['AD3'] : '';
        $agencyInfo['CITY']       = !empty($postData['address_group'][0]['CITY']) ? $postData['address_group'][0]['CITY'] : '';
        $agencyInfo['CITYID']     = !empty($postData['address_group'][0]['CITYID']) ? $postData['address_group'][0]['CITYID'] : 0;
        $agencyInfo['PIN']        = !empty($postData['address_group'][0]['PIN']) ? $postData['address_group'][0]['PIN'] : '';
        $agencyInfo['PHONE_O']    = !empty($postData['address_group'][0]['PHONE_O']) ? $postData['address_group'][0]['PHONE_O'] : '';
        $agencyInfo['PHONE_R']    = !empty($postData['address_group'][0]['PHONE_R']) ? $postData['address_group'][0]['PHONE_R'] : '';
        $agencyInfo['MOBILE']     = !empty($postData['address_group'][0]['MOBILE']) ? $postData['address_group'][0]['MOBILE'] : '';
        $agencyInfo['FAX']        = !empty($postData['address_group'][0]['PAGER_FAX']) ? $postData['address_group'][0]['PAGER_FAX'] : '';
        $agencyInfo['EMAIL']      = !empty($postData['address_group'][0]['EMAIL']) ? $postData['address_group'][0]['EMAIL'] : '';

        $agencyInfo->save();

        if (!empty($postData['address_group']) && count($postData['address_group']) > 0) {
            
            $getContactData = Contact::where('tableName', 'agency')->where('tableID',$agencyInfo['AFILE'])->get();
            if(!empty($getContactData) && count($getContactData) > 0) {
                foreach ($getContactData as $key1 => $value1) {
                    $value1->delete();
                }
            }

            foreach ($postData['address_group'] as $key => $value) {
                $value['tableName'] = 'agency';
                $value['tableID']   = $agencyInfo['AFILE'];
                Contact::saveMaster($value);
            }
        }
        return $agencyInfo;
    }
}
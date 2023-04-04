<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellLic\Contact;
use App\Models\LifeCellLic\PartyWiseBank;

class Party extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'party';
    protected $primaryKey = 'GCODE';
    public $timestamps    = false;

    protected $fillable = [
        'GCODE','PCODE','ARECD','NAME','LNM','FNM','SNM','FNAME','AD','AD1','AD2','AD3','CITYID','CITY','PIN','ADT','AD1T','AD2T','AD3T','CITYIDT','CITYT','PINT','BD','ABD','SEX','STATUS','MARK','WDT','NOMINEE','RELATION','INCOME','QUALI','BIRTHPLACE','PHONE_O','PHONE_R','PAGER_FAX','MOBILE','EMAIL','LAST_DEL','PANGIRNO','OCCUPATION','DOCCU','DURATION','SELECT','EMPNO','BLOOD','PHOTO','ARECDT','NOTES','EXPDT','LIC_CUSID','LIFEPLUSID','OCODE','DEMODATA','CUSID','AG_REL','AG_W_REL','KNOWN_DT','IS_NRI','ADHARNO','C_GST','client_id','EDUCATION','old_id','old_client_id',
    ];

    public static function saveMaster($postData)
    {
    	if(!empty($postData['id'])) {
    		$partyInfo = self::where('GCODE', $postData['id'])->first();
    	} else {
    		$partyInfo = new self();
    	}
        $partyInfo['PCODE']      = !empty($postData['PCODE']) ? $postData['PCODE'] : 0;
        $partyInfo['NAME']       = !empty($postData['NAME']) ? $postData['NAME'] : '';
        $partyInfo['LNM']        = !empty($postData['LNM']) ? $postData['LNM'] : '';
        $partyInfo['FNM']        = !empty($postData['FNM']) ? $postData['FNM'] : '';
        $partyInfo['SNM']        = !empty($postData['SNM']) ? $postData['SNM'] : '';
        $partyInfo['FNAME']      = !empty($postData['FNAME']) ? $postData['FNAME'] : 0;
        $partyInfo['AD']         = !empty($postData['AD']) ? $postData['AD'] : '';
        $partyInfo['ADT']        = !empty($postData['ADT']) ? $postData['ADT'] : '';
        $partyInfo['AD1T']       = !empty($postData['AD1T']) ? $postData['AD1T'] : '';
        $partyInfo['AD2T']       = !empty($postData['AD2T']) ? $postData['AD2T'] : '';
        $partyInfo['AD3T']       = !empty($postData['AD3T']) ? $postData['AD3T'] : '';
        $partyInfo['CITYIDT']    = !empty($postData['CITYIDT']) ? $postData['CITYIDT'] : 0;
        $partyInfo['CITYT']      = !empty($postData['CITYT']) ? $postData['CITYT'] : '';
        $partyInfo['PINT']       = !empty($postData['PINT']) ? $postData['PINT'] : 0;
        $partyInfo['BD']         = !empty($postData['BD']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['BD'])->format('Y-m-d') : null;
        $partyInfo['ABD']        = !empty($postData['ABD']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['ABD'])->format('Y-m-d') : null;
        $partyInfo['SEX']        = !empty($postData['SEX']) ? $postData['SEX'] : '';
        $partyInfo['STATUS']     = !empty($postData['STATUS']) ? $postData['STATUS'] : '';
        $partyInfo['MARK']       = !empty($postData['MARK']) ? $postData['MARK'] : '';
        $partyInfo['WDT']        = !empty($postData['WDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['WDT'])->format('Y-m-d') : null;
        $partyInfo['NOMINEE']    = !empty($postData['NOMINEE']) ? $postData['NOMINEE'] : '';
        $partyInfo['RELATION']   = !empty($postData['RELATION']) ? $postData['RELATION'] : '';
        $partyInfo['INCOME']     = !empty($postData['INCOME']) ? $postData['INCOME'] : '';
        $partyInfo['QUALI']      = !empty($postData['QUALI']) ? $postData['QUALI'] : '';
        $partyInfo['BIRTHPLACE'] = !empty($postData['BIRTHPLACE']) ? $postData['BIRTHPLACE'] : '';
        $partyInfo['LAST_DEL']   = !empty($postData['LAST_DEL']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['LAST_DEL'])->format('Y-m-d') : null;
        $partyInfo['PANGIRNO']   = !empty($postData['PANGIRNO']) ? $postData['PANGIRNO'] : '';
        $partyInfo['OCCUPATION'] = !empty($postData['OCCUPATION']) ? $postData['OCCUPATION'] : '';
        $partyInfo['DOCCU']      = !empty($postData['DOCCU']) ? $postData['DOCCU'] : '';
        $partyInfo['DURATION']   = !empty($postData['DURATION']) ? $postData['DURATION'] : 0;
        $partyInfo['SELECT']     = !empty($postData['SELECT']) ? $postData['SELECT'] : '';
        $partyInfo['EMPNO']      = !empty($postData['EMPNO']) ? $postData['EMPNO'] : '';
        $partyInfo['BLOOD']      = !empty($postData['BLOOD']) ? $postData['BLOOD'] : '';
        $partyInfo['PHOTO']      = !empty($postData['PHOTO']) ? $postData['PHOTO'] : '';
        $partyInfo['ARECDT']     = !empty($postData['ARECDT']) ? $postData['ARECDT'] : 0;
        $partyInfo['NOTES']      = !empty($postData['NOTES']) ? $postData['NOTES'] : '';
        $partyInfo['EXPDT']      = !empty($postData['EXPDT']) ? $postData['EXPDT'] : '';
        $partyInfo['LIC_CUSID']  = !empty($postData['LIC_CUSID']) ? $postData['LIC_CUSID'] : '';
        $partyInfo['LIFEPLUSID'] = !empty($postData['LIFEPLUSID']) ? $postData['LIFEPLUSID'] : 0;
        $partyInfo['OCODE']      = !empty($postData['OCODE']) ? $postData['OCODE'] : 0;
        $partyInfo['DEMODATA']   = !empty($postData['DEMODATA']) ? $postData['DEMODATA'] : '';
        $partyInfo['CUSID']      = !empty($postData['CUSID']) ? $postData['CUSID'] : '';
        $partyInfo['AG_REL']     = !empty($postData['AG_REL']) ? $postData['AG_REL'] : '';
        $partyInfo['AG_W_REL']   = !empty($postData['AG_W_REL']) ? $postData['AG_W_REL'] : '';
        $partyInfo['KNOWN_DT']   = !empty($postData['KNOWN_DT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['KNOWN_DT'])->format('Y-m-d') : null;
        $partyInfo['IS_NRI']     = !empty($postData['IS_NRI']) ? $postData['IS_NRI'] : '';
        $partyInfo['ADHARNO']    = !empty($postData['ADHARNO']) ? $postData['ADHARNO'] : '';
        $partyInfo['C_GST']      = !empty($postData['C_GST']) ? $postData['C_GST'] : '';
        $partyInfo['EDUCATION']  = !empty($postData['EDUCATION']) ? $postData['EDUCATION'] : '';
        $partyInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';

        $partyInfo['AD1']        = !empty($postData['address_group'][0]['AD1']) ? $postData['address_group'][0]['AD1'] : '';
        $partyInfo['AD2']        = !empty($postData['address_group'][0]['AD2']) ? $postData['address_group'][0]['AD2'] : '';
        $partyInfo['AD3']        = !empty($postData['address_group'][0]['AD3']) ? $postData['address_group'][0]['AD3'] : '';
        $partyInfo['CITY']       = !empty($postData['address_group'][0]['CITY']) ? $postData['address_group'][0]['CITY'] : '';
        $partyInfo['CITYID']     = !empty($postData['address_group'][0]['CITYID']) ? $postData['address_group'][0]['CITYID'] : 0;
        $partyInfo['PIN']        = !empty($postData['address_group'][0]['PIN']) ? $postData['address_group'][0]['PIN'] : 0;
        $partyInfo['ARECD']      = !empty($postData['address_group'][0]['ARECD']) ? $postData['address_group'][0]['ARECD'] : 0;
        $partyInfo['PHONE_O']    = !empty($postData['address_group'][0]['PHONE_O']) ? $postData['address_group'][0]['PHONE_O'] : '';
        $partyInfo['PHONE_R']    = !empty($postData['address_group'][0]['PHONE_R']) ? $postData['address_group'][0]['PHONE_R'] : '';
        $partyInfo['MOBILE']     = !empty($postData['address_group'][0]['MOBILE']) ? $postData['address_group'][0]['MOBILE'] : '';
        $partyInfo['PAGER_FAX']  = !empty($postData['address_group'][0]['PAGER_FAX']) ? $postData['address_group'][0]['PAGER_FAX'] : '';
        $partyInfo['EMAIL']      = !empty($postData['address_group'][0]['EMAIL']) ? $postData['address_group'][0]['EMAIL'] : '';

        $partyInfo->save();

        if (!empty($postData['address_group']) && count($postData['address_group']) > 0) {
            
            $getContactData = Contact::where('tableName', 'party')->where('tableID',$partyInfo['GCODE'])->get();
            if(!empty($getContactData) && count($getContactData) > 0) {
                foreach ($getContactData as $key1 => $value1) {
                    $value1->delete();
                }
            }

            foreach ($postData['address_group'] as $key => $value) {
                $value['tableName'] = 'party';
                $value['tableID']   = $partyInfo['GCODE'];
                Contact::saveMaster($value);
            }
        }

        if(!empty($postData['PARTYWISEBANK']) && count($postData['PARTYWISEBANK']) > 0) {
            $getPrtWBnkData = PartyWiseBank::where('pcode',$partyInfo['GCODE'])->get();
            if(!empty($getPrtWBnkData) && count($getPrtWBnkData) > 0) {
                foreach ($getPrtWBnkData as $key1 => $value1) {
                    $value1->delete();
                }
            }

            foreach ($postData['PARTYWISEBANK'] as $key => $value) {
                $value['pcode']   = $partyInfo['GCODE'];
                $value['name']    = $partyInfo['NAME'];
                PartyWiseBank::saveMaster($value);
            }
        }
        return $partyInfo;
    }
}
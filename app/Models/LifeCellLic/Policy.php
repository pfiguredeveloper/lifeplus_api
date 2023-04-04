<?php

namespace App\Models\LifeCellLic;

use Illuminate\Database\Eloquent\Model;
use App\Models\LifeCellLic\PolNominee;
use App\Models\LifeCellLic\PolBoc;
use App\Models\LifeCellLic\Ledger;
use App\Models\LifeCellLic\SBDue;
use App\Models\LifeCell\Plan;

class Policy extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'pol';
    protected $primaryKey = 'PUNIQID';
    public $timestamps    = false;

    protected $fillable = [
        'PUNIQID', 'PNAME', 'REFCODE', 'PROPNO', 'PROPDT', 'PONO', 'RDT', 'CDT', 'SA', 'DEATH_SA', 'MLY_PREM', 'BASIC_PREM', 'DAB_PREM', 'PWB', 'PWB_PREM', 'EXTRAPREM', 'TR_SA', 'PREM', 'TR_PREM', 'CIR_SA', 'CIR_PREM', 'CDB_SA', 'CDB_PREM', 'ST_PREM', 'ST_PREM2', 'PLAN', 'TERM', 'MTERM', 'ACCTERM', 'MODE', 'AGE', 'DELIDT', 'MCDT', 'PREG', 'FEMALEDTL', 'FUP', 'BRANCH', 'PACODE', 'POL_STATUS', 'AGCODE', 'DAB', 'DABSA', 'DOC_M', 'MEDI_DT_M', 'HEIGHT_M', 'WEIGHT_M', 'ABD_M', 'CHEST_EX_M', 'CHEST_IN_M', 'BP_HI_M', 'BP_LOW_M', 'PULSE_M', 'DOC_F', 'MEDI_DT_F', 'HEIGHT_F', 'WEIGHT_F', 'ABD_F', 'CHEST_EX_F', 'CHEST_IN_F', 'BP_HI_F', 'BP_LOW_F', 'PULSE_F', 'NOTE', 'REMARKS', 'FUPDATE', 'PROP_AGE', 'AGNO', 'AFILE', 'SPL_REPORT', 'SIGN', 'BANKNAME', 'EXPDT', 'LOYAL_RATE', 'LOYAL_STEP', 'ECS_MODE', 'E_BANK_ID', 'E_BANK', 'E_BRANCH', 'E_ADD', 'E_ACTYPE', 'E_ACNO', 'E_MICR', 'E_ACNAME', 'LIFEPLUSID', 'DEMODATA', 'NRI', 'NAME1', 'NAME2', 'BIRTH1', 'BIRTH2', 'FCAGE', 'FHEALTH', 'FDAGE', 'FDYEAR', 'FDCAUSE', 'MCAGE', 'MHEALTH', 'MDAGE', 'MDYEAR', 'MDCAUSE', 'BCAGE', 'BHEALTH', 'BDAGE', 'BDYEAR', 'BDCAUSE', 'SISCAGE', 'SISHEALTH', 'SISDAGE', 'SISDYEAR', 'SISDCAUSE', 'SPCAGE', 'SPHEALTH', 'SPDAGE', 'SPDYEAR', 'SPDCAUSE', 'CMCAGE', 'CMHEALTH', 'CMDAGE', 'CMDYEAR', 'CMDCAUSE', 'CFCAGE', 'CFHEALTH', 'CFDAGE', 'CFDYEAR', 'CFDCAUSE', 'NACH', 'MEDICAL', 'client_id', 'is_auto_prem', 'old_id', 'old_client_id', 'boc_no1', 'boc_no2', 'boc_no3', 'boc_no4', 'boc_dt1', 'boc_dt2', 'boc_dt3', 'boc_dt4', 'boc_amt1', 'boc_amt2', 'boc_amt3', 'boc_amt4', 'nomi', 'rela', 'appointee', 'trustee', 'policy_insurance_id', 'PAIDBY', 'LPP', 'BCODE', 'LPPDATE', 'MATDATE', 'LASTPREM', 'SERVICE', 'OPT_122', 'TYPE_122', 'LIFE_COVER', 'NCO', 'PENSION', 'AG_HANDI', 'ANN_MODE', 'NAV', 'NAVGR', 'FUNDTYPE', 'ALLOWCOMM', 'CNTLIVES', 'CNTPOL', 'POLTYPE', 'CLOUD_D', 'SAOPTION', 'DAB_OPTION', 'SETT', 'SETT_PREM', 'GST1', 'GST2', 'TOTPREM1', 'TOTPREM2', 'DAB_CHECK', 'TR_CHECK', 'CIR_CHECK', 'PWB_CHECK', 'SETT_CHECK',
    ];

    public function polNominee()
    {
        return $this->hasMany('App\Models\LifeCellLic\PolNominee', 'POLID', 'PUNIQID');
    }

    public function polBoc()
    {
        return $this->hasMany('App\Models\LifeCellLic\PolBoc', 'POLID', 'PUNIQID');
    }

    public static function savePolicyData($postData)
    {
        if (!empty($postData['id'])) {
            $polInfo = self::where('PUNIQID', $postData['id'])->first();
        } else {
            $polInfo = new self();
        }

        $polInfo['PNAME']      = !empty($postData['PNAME']) ? $postData['PNAME'] : '';
        $polInfo['REFCODE']    = !empty($postData['REFCODE']) ? $postData['REFCODE'] : '';
        $polInfo['PROPNO']     = !empty($postData['PROPNO']) ? $postData['PROPNO'] : '';
        $polInfo['PROPDT']     = !empty($postData['PROPDT']) ? $postData['PROPDT'] : '';
        $polInfo['PONO']       = !empty($postData['PONO']) ? $postData['PONO'] : '';
        $polInfo['RDT']        = !empty($postData['RDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['RDT'])->format('Y-m-d') : null;
        $polInfo['CDT']        = !empty($postData['CDT']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['CDT'])->format('Y-m-d') : null;
        $polInfo['SA']         = !empty($postData['BASIC_SA']) ? $postData['BASIC_SA'] : '';
        $polInfo['DEATH_SA']   = !empty($postData['DEATH_SA']) ? $postData['DEATH_SA'] : '';
        $polInfo['MLY_PREM']   = !empty($postData['MLY_PREM']) ? $postData['MLY_PREM'] : '';
        $polInfo['BASIC_PREM'] = !empty($postData['BASIC_PREM']) ? $postData['BASIC_PREM'] : '';
        $polInfo['DAB_PREM']   = !empty($postData['DAB_PREM']) ? $postData['DAB_PREM'] : '';
        $polInfo['PWB']        = !empty($postData['PWB']) ? $postData['PWB'] : 'No';
        $polInfo['PWB_PREM']   = !empty($postData['PWB_PREM']) ? $postData['PWB_PREM'] : '';
        $polInfo['EXTRAPREM']  = !empty($postData['EXTRAPREM']) ? $postData['EXTRAPREM'] : '';
        $polInfo['TR_SA']      = !empty($postData['TR_SA']) ? $postData['TR_SA'] : '';
        $polInfo['PREM']       = !empty($postData['PREM']) ? $postData['PREM'] : '';
        $polInfo['TR_PREM']    = !empty($postData['TR_PREM']) ? $postData['TR_PREM'] : '';
        $polInfo['CIR_SA']     = !empty($postData['CIR_SA']) ? $postData['CIR_SA'] : '';
        $polInfo['CIR_PREM']   = !empty($postData['CIR_PREM']) ? $postData['CIR_PREM'] : '';
        $polInfo['CDB_SA']     = !empty($postData['CDB_SA']) ? $postData['CDB_SA'] : '';
        $polInfo['CDB_PREM']   = !empty($postData['CDB_PREM']) ? $postData['CDB_PREM'] : '';
        $polInfo['ST_PREM']    = !empty($postData['ST_PREM']) ? $postData['ST_PREM'] : '';
        $polInfo['ST_PREM2']   = !empty($postData['ST_PREM2']) ? $postData['ST_PREM2'] : '';
        $polInfo['PLAN']       = !empty($postData['PLAN']) ? $postData['PLAN'] : '';
        $polInfo['TERM']       = !empty($postData['PTERM']) ? $postData['PTERM'] : '';
        $polInfo['MTERM']      = !empty($postData['MTERM']) ? $postData['MTERM'] : '';
        $polInfo['ACCTERM']    = !empty($postData['ACCTERM']) ? $postData['ACCTERM'] : '';
        $polInfo['MODE']       = !empty($postData['MODE']) ? $postData['MODE'] : '';
        $polInfo['AGE']        = !empty($postData['AGE']) ? $postData['AGE'] : '';
        $polInfo['DELIDT']     = !empty($postData['DELIDT']) ? $postData['DELIDT'] : '';
        $polInfo['MCDT']       = !empty($postData['MCDT']) ? $postData['MCDT'] : '';
        $polInfo['PREG']       = !empty($postData['PREG']) ? $postData['PREG'] : '';
        $polInfo['FEMALEDTL']  = !empty($postData['FEMALEDTL']) ? $postData['FEMALEDTL'] : '';
        $polInfo['FUP']        = !empty($postData['FUP']) ? $postData['FUP'] : '';
        $polInfo['BRANCH']     = !empty($postData['BRANCH']) ? $postData['BRANCH'] : '';
        $polInfo['PACODE']     = !empty($postData['PACODE']) ? $postData['PACODE'] : '';
        $polInfo['POL_STATUS'] = !empty($postData['POL_STATUS']) ? $postData['POL_STATUS'] : '';
        $polInfo['AGCODE']     = !empty($postData['AGCODE']) ? $postData['AGCODE'] : '';
        $polInfo['DAB']        = !empty($postData['DAB']) ? $postData['DAB'] : '';
        $polInfo['DABSA']      = !empty($postData['DAB_SA']) ? $postData['DAB_SA'] : '';
        $polInfo['DOC_M']      = !empty($postData['DOC_M']) ? $postData['DOC_M'] : '';
        $polInfo['MEDI_DT_M']  = !empty($postData['MEDI_DT_M']) ? $postData['MEDI_DT_M'] : '';
        $polInfo['HEIGHT_M']   = !empty($postData['HEIGHT_M']) ? $postData['HEIGHT_M'] : '';
        $polInfo['WEIGHT_M']   = !empty($postData['WEIGHT_M']) ? $postData['WEIGHT_M'] : '';
        $polInfo['ABD_M']      = !empty($postData['ABD_M']) ? $postData['ABD_M'] : '';
        $polInfo['CHEST_EX_M'] = !empty($postData['CHEST_EX_M']) ? $postData['CHEST_EX_M'] : '';
        $polInfo['CHEST_IN_M'] = !empty($postData['CHEST_IN_M']) ? $postData['CHEST_IN_M'] : '';
        $polInfo['BP_HI_M']    = !empty($postData['BP_HI_M']) ? $postData['BP_HI_M'] : '';
        $polInfo['BP_LOW_M']   = !empty($postData['BP_LOW_M']) ? $postData['BP_LOW_M'] : '';
        $polInfo['PULSE_M']    = !empty($postData['PULSE_M']) ? $postData['PULSE_M'] : '';
        $polInfo['DOC_F']      = !empty($postData['DOC_F']) ? $postData['DOC_F'] : '';
        $polInfo['MEDI_DT_F']  = !empty($postData['MEDI_DT_F']) ? $postData['MEDI_DT_F'] : '';
        $polInfo['HEIGHT_F']   = !empty($postData['HEIGHT_F']) ? $postData['HEIGHT_F'] : '';
        $polInfo['WEIGHT_F']   = !empty($postData['WEIGHT_F']) ? $postData['WEIGHT_F'] : '';
        $polInfo['ABD_F']      = !empty($postData['ABD_F']) ? $postData['ABD_F'] : '';
        $polInfo['CHEST_EX_F'] = !empty($postData['CHEST_EX_F']) ? $postData['CHEST_EX_F'] : '';
        $polInfo['CHEST_IN_F'] = !empty($postData['CHEST_IN_F']) ? $postData['CHEST_IN_F'] : '';
        $polInfo['BP_HI_F']    = !empty($postData['BP_HI_F']) ? $postData['BP_HI_F'] : '';
        $polInfo['BP_LOW_F']   = !empty($postData['BP_LOW_F']) ? $postData['BP_LOW_F'] : '';
        $polInfo['PULSE_F']    = !empty($postData['PULSE_F']) ? $postData['PULSE_F'] : '';
        $polInfo['NOTE']       = !empty($postData['NOTE']) ? $postData['NOTE'] : '';
        $polInfo['REMARKS']    = !empty($postData['REMARKS']) ? $postData['REMARKS'] : '';
        $polInfo['FUPDATE']    = !empty($postData['FUPDATE']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['FUPDATE'])->format('Y-m-d') : null;
        $polInfo['PROP_AGE']   = !empty($postData['PROP_AGE']) ? $postData['PROP_AGE'] : '';
        $polInfo['AGNO']       = !empty($postData['AGNO']) ? $postData['AGNO'] : '';
        $polInfo['AFILE']      = !empty($postData['AFILE']) ? $postData['AFILE'] : '';
        $polInfo['SPL_REPORT'] = !empty($postData['SPL_REPORT']) ? $postData['SPL_REPORT'] : '';
        $polInfo['SIGN']       = !empty($postData['SIGN']) ? $postData['SIGN'] : '';
        $polInfo['BANKNAME']   = !empty($postData['BANKNAME']) ? $postData['BANKNAME'] : '';
        $polInfo['EXPDT']      = !empty($postData['EXPDT']) ? $postData['EXPDT'] : '';
        $polInfo['LOYAL_RATE'] = !empty($postData['LOYAL_RATE']) ? $postData['LOYAL_RATE'] : '';
        $polInfo['LOYAL_STEP'] = !empty($postData['LOYAL_STEP']) ? $postData['LOYAL_STEP'] : '';
        $polInfo['ECS_MODE']   = !empty($postData['ECS_MODE']) ? $postData['ECS_MODE'] : '';
        $polInfo['E_BANK_ID']  = !empty($postData['E_BANK_ID']) ? $postData['E_BANK_ID'] : '';
        $polInfo['E_BANK']     = !empty($postData['E_BANK']) ? $postData['E_BANK'] : '';
        $polInfo['E_BRANCH']   = !empty($postData['E_BRANCH']) ? $postData['E_BRANCH'] : '';
        $polInfo['E_ADD']      = !empty($postData['E_ADD']) ? $postData['E_ADD'] : '';
        $polInfo['E_ACTYPE']   = !empty($postData['E_ACTYPE']) ? $postData['E_ACTYPE'] : '';
        $polInfo['E_ACNO']     = !empty($postData['E_ACNO']) ? $postData['E_ACNO'] : '';
        $polInfo['E_MICR']     = !empty($postData['E_MICR']) ? $postData['E_MICR'] : '';
        $polInfo['E_ACNAME']   = !empty($postData['E_ACNAME']) ? $postData['E_ACNAME'] : '';
        $polInfo['LIFEPLUSID'] = !empty($postData['LIFEPLUSID']) ? $postData['LIFEPLUSID'] : '';
        $polInfo['DEMODATA']   = !empty($postData['DEMODATA']) ? $postData['DEMODATA'] : '';
        $polInfo['NRI']        = !empty($postData['NRI']) ? $postData['NRI'] : '';
        $polInfo['NAME1']      = !empty($postData['NAME1']) ? $postData['NAME1'] : '';
        $polInfo['NAME2']      = !empty($postData['NAME2']) ? $postData['NAME2'] : '';
        $polInfo['BIRTH1']     = !empty($postData['BIRTH1']) ? $postData['BIRTH1'] : '';
        $polInfo['BIRTH2']     = !empty($postData['BIRTH2']) ? $postData['BIRTH2'] : '';
        $polInfo['FCAGE']      = !empty($postData['FCAGE']) ? $postData['FCAGE'] : '';
        $polInfo['FHEALTH']    = !empty($postData['FHEALTH']) ? $postData['FHEALTH'] : '';
        $polInfo['FDAGE']      = !empty($postData['FDAGE']) ? $postData['FDAGE'] : '';
        $polInfo['FDYEAR']     = !empty($postData['FDYEAR']) ? $postData['FDYEAR'] : '';
        $polInfo['FDCAUSE']    = !empty($postData['FDCAUSE']) ? $postData['FDCAUSE'] : '';
        $polInfo['MCAGE']      = !empty($postData['MCAGE']) ? $postData['MCAGE'] : '';
        $polInfo['MHEALTH']    = !empty($postData['MHEALTH']) ? $postData['MHEALTH'] : '';
        $polInfo['MDAGE']      = !empty($postData['MDAGE']) ? $postData['MDAGE'] : '';
        $polInfo['MDYEAR']     = !empty($postData['MDYEAR']) ? $postData['MDYEAR'] : '';
        $polInfo['MDCAUSE']    = !empty($postData['MDCAUSE']) ? $postData['MDCAUSE'] : '';
        $polInfo['BCAGE']      = !empty($postData['BCAGE']) ? $postData['BCAGE'] : '';
        $polInfo['BHEALTH']    = !empty($postData['BHEALTH']) ? $postData['BHEALTH'] : '';
        $polInfo['BDAGE']      = !empty($postData['BDAGE']) ? $postData['BDAGE'] : '';
        $polInfo['BDYEAR']     = !empty($postData['BDYEAR']) ? $postData['BDYEAR'] : '';
        $polInfo['BDCAUSE']    = !empty($postData['BDCAUSE']) ? $postData['BDCAUSE'] : '';
        $polInfo['SISCAGE']    = !empty($postData['SISCAGE']) ? $postData['SISCAGE'] : '';
        $polInfo['SISHEALTH']  = !empty($postData['SISHEALTH']) ? $postData['SISHEALTH'] : '';
        $polInfo['SISDAGE']    = !empty($postData['SISDAGE']) ? $postData['SISDAGE'] : '';
        $polInfo['SISDYEAR']   = !empty($postData['SISDYEAR']) ? $postData['SISDYEAR'] : '';
        $polInfo['SISDCAUSE']  = !empty($postData['SISDCAUSE']) ? $postData['SISDCAUSE'] : '';
        $polInfo['SPCAGE']     = !empty($postData['SPCAGE']) ? $postData['SPCAGE'] : '';
        $polInfo['SPHEALTH']   = !empty($postData['SPHEALTH']) ? $postData['SPHEALTH'] : '';
        $polInfo['SPDAGE']     = !empty($postData['SPDAGE']) ? $postData['SPDAGE'] : '';
        $polInfo['SPDYEAR']    = !empty($postData['SPDYEAR']) ? $postData['SPDYEAR'] : '';
        $polInfo['SPDCAUSE']   = !empty($postData['SPDCAUSE']) ? $postData['SPDCAUSE'] : '';
        $polInfo['CMCAGE']     = !empty($postData['CMCAGE']) ? $postData['CMCAGE'] : '';
        $polInfo['CMHEALTH']   = !empty($postData['CMHEALTH']) ? $postData['CMHEALTH'] : '';
        $polInfo['CMDAGE']     = !empty($postData['CMDAGE']) ? $postData['CMDAGE'] : '';
        $polInfo['CMDYEAR']    = !empty($postData['CMDYEAR']) ? $postData['CMDYEAR'] : '';
        $polInfo['CMDCAUSE']   = !empty($postData['CMDCAUSE']) ? $postData['CMDCAUSE'] : '';
        $polInfo['CFCAGE']     = !empty($postData['CFCAGE']) ? $postData['CFCAGE'] : '';
        $polInfo['CFHEALTH']   = !empty($postData['CFHEALTH']) ? $postData['CFHEALTH'] : '';
        $polInfo['CFDAGE']     = !empty($postData['CFDAGE']) ? $postData['CFDAGE'] : '';
        $polInfo['CFDYEAR']    = !empty($postData['CFDYEAR']) ? $postData['CFDYEAR'] : '';
        $polInfo['CFDCAUSE']   = !empty($postData['CFDCAUSE']) ? $postData['CFDCAUSE'] : '';
        $polInfo['NACH']       = !empty($postData['NACH']) ? $postData['NACH'] : '';
        $polInfo['MEDICAL']    = !empty($postData['MEDICAL']) ? $postData['MEDICAL'] : '';
        $polInfo['PAIDBY']     = !empty($postData['PAIDBY']) ? $postData['PAIDBY'] : '';
        $polInfo['LPP']        = !empty($postData['LPP']) ? $postData['LPP'] : '';
        $polInfo['BCODE']      = !empty($postData['BCODE']) ? $postData['BCODE'] : '';
        $polInfo['LPPDATE']    = !empty($postData['LPPDATE']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['LPPDATE'])->format('Y-m-d') : null;
        $polInfo['MATDATE']    = !empty($postData['MATDATE']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['MATDATE'])->format('Y-m-d') : null;
        $polInfo['LASTPREM']   = !empty($postData['LASTPREM']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $postData['LASTPREM'])->format('Y-m-d') : null;
        $polInfo['SERVICE']    = !empty($postData['SERVICE']) ? $postData['SERVICE'] : '';
        $polInfo['OPT_122']    = !empty($postData['ANN_OPTION']) ? $postData['ANN_OPTION'] : '';
        $polInfo['TYPE_122']   = !empty($postData['ANN_TYPE']) ? $postData['ANN_TYPE'] : '';
        $polInfo['LIFE_COVER'] = !empty($postData['LIFE_COVER']) ? $postData['LIFE_COVER'] : '';
        $polInfo['NCO']        = !empty($postData['NCO']) ? $postData['NCO'] : '';
        $polInfo['PENSION']    = !empty($postData['ANN_AMT']) ? $postData['ANN_AMT'] : '';
        $polInfo['AG_HANDI']   = !empty($postData['AG_HANDI']) ? $postData['AG_HANDI'] : '';
        $polInfo['ANN_MODE']   = !empty($postData['ANN_MODE']) ? $postData['ANN_MODE'] : '';
        $polInfo['NAV']        = !empty($postData['NAV']) ? $postData['NAV'] : '';
        $polInfo['NAVGR']      = !empty($postData['NAVGR']) ? $postData['NAVGR'] : '';
        $polInfo['FUNDTYPE']   = !empty($postData['FUNDTYPE']) ? $postData['FUNDTYPE'] : '';
        $polInfo['ALLOWCOMM']  = !empty($postData['ALLOWCOMM']) ? $postData['ALLOWCOMM'] : '';
        $polInfo['CNTLIVES']   = !empty($postData['CNTLIVES']) ? $postData['CNTLIVES'] : '';
        $polInfo['CNTPOL']     = !empty($postData['CNTPOL']) ? $postData['CNTPOL'] : '';
        $polInfo['POLTYPE']    = !empty($postData['POLTYPE']) ? $postData['POLTYPE'] : '';
        $polInfo['CLOUD_D']    = !empty($postData['CLOUD_D']) ? $postData['CLOUD_D'] : '';
        $polInfo['SAOPTION']   = !empty($postData['SAOPTION']) ? $postData['SAOPTION'] : '';
        $polInfo['DAB_OPTION'] = !empty($postData['DAB_OPTION']) ? $postData['DAB_OPTION'] : 0;
        $polInfo['SETT']       = !empty($postData['SETT']) ? $postData['SETT'] : '';
        $polInfo['SETT_PREM']  = !empty($postData['SETT_PREM']) ? $postData['SETT_PREM'] : '';
        $polInfo['GST1']       = !empty($postData['GST1']) ? $postData['GST1'] : '';
        $polInfo['GST2']       = !empty($postData['GST2']) ? $postData['GST2'] : '';
        $polInfo['TOTPREM1']   = !empty($postData['TOTPREM1']) ? $postData['TOTPREM1'] : '';
        $polInfo['TOTPREM2']   = !empty($postData['TOTPREM2']) ? $postData['TOTPREM2'] : '';
        $polInfo['DAB_CHECK']  = !empty($postData['DAB_CHECK']) ? $postData['DAB_CHECK'] : 0;
        $polInfo['TR_CHECK']   = !empty($postData['TR_CHECK']) ? $postData['TR_CHECK'] : 0;
        $polInfo['CIR_CHECK']  = !empty($postData['CIR_CHECK']) ? $postData['CIR_CHECK'] : 0;
        $polInfo['PWB_CHECK']  = !empty($postData['PWB_CHECK']) ? $postData['PWB_CHECK'] : 0;
        $polInfo['SETT_CHECK'] = !empty($postData['SETT_CHECK']) ? $postData['SETT_CHECK'] : 0;
        $polInfo['is_auto_prem'] = !empty($postData['is_auto_prem']) ? $postData['is_auto_prem'] : 0;
        $polInfo['client_id']  = !empty($postData['client_id']) ? $postData['client_id'] : '';
        $polInfo['policy_insurance_id']  = !empty($postData['policy_insurance_id']) ? $postData['policy_insurance_id'] : 0;
        $polInfo->save();
        \Log::info($postData);
        \Log::info($polInfo);
        if (!empty($postData['NOMINEE'])) {

            $polNominee = PolNominee::where('POLID', $polInfo['PUNIQID'])->get();

            if (!empty($polNominee) && count($polNominee) > 0) {
                foreach ($polNominee as $key => $value) {
                    $value->delete();
                }
            }
            foreach ($postData['NOMINEE'] as $key => $value) {
                PolNominee::savePolNominee($value, $polInfo['PUNIQID']);
            }
        }

        if (!empty($postData['BOC'])) {
            $polBoc = PolBoc::where('POLID', $polInfo['PUNIQID'])->get();
            if (!empty($polBoc) && count($polBoc) > 0) {
                foreach ($polBoc as $key => $value) {
                    $value->delete();
                }
            }
            foreach ($postData['BOC'] as $key => $value) {
                PolBoc::savePolBOC($value, $polInfo['PUNIQID']);
            }
        }

        if (empty($postData['id'])) {
            $ledgerData = [
                'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
                'duedt'      => !empty($polInfo['FUPDATE']) ? $polInfo['FUPDATE'] : null,
                'paiddt'     => null,
                'ecs_mode'   => !empty($polInfo['ECS_MODE']) ? $polInfo['ECS_MODE'] : 'No',
                'mode'       => !empty($polInfo['MODE']) ? $polInfo['MODE'] : '',
                'rdt'        => !empty($polInfo['RDT']) ? $polInfo['RDT'] : null,
                'prem'       => !empty($polInfo['PREM']) ? $polInfo['PREM'] : '',
                'PTERM'       => !empty($polInfo['TERM']) ? $polInfo['TERM'] : '',
                'sprem'      => 0,
                'remarks'    => !empty($polInfo['REMARKS']) ? $polInfo['REMARKS'] : '',
                'FUP'    =>     !empty($postData['FUP']) ? $postData['FUP'] : '',
                'dedcode'    => 0,
                'comm'       => 0,
                'bonus'      => 0,
                'fpren'      => '',
                'commdt'     => null,
                'dedu_code'  => 0,
                'branch'     => !empty($polInfo['E_BRANCH']) ? $polInfo['E_BRANCH'] : '',
                'chqno'      => '',
                'chqdt'      => null,
                'bank'       => !empty($polInfo['BANKNAME']) ? $polInfo['BANKNAME'] : '',
                'advpr'      => '',
                'newfld'     => '',
                'client_id'  => !empty($polInfo['client_id']) ? $polInfo['client_id'] : '',
                'policy_insurance_id'  => !empty($polInfo['policy_insurance_id']) ? $polInfo['policy_insurance_id'] : 0,
            ];

                // $this->checkfup($riskdt,$mode,$terms,$fupdate,$pono);
            $pono=$polInfo['PUNIQID'];//$postData2['pono'];
            $fupdate=$polInfo['FUPDATE'];//$postData['duedt'];
            $type='first';
            $paymentdate='';
            Ledger::saveLedger($fupdate,$pono,$type,$paymentdate);
        }

        else
        {


            $ledger   = Ledger::where('puniqid', $postData['id'])->delete();
            

            $pono=$polInfo['PUNIQID'];//$postData2['pono'];
            $fupdate=$polInfo['FUPDATE'];//$postData['duedt'];
            $type='first';
            $paymentdate='';
            Ledger::saveLedger($fupdate,$pono,$type,$paymentdate);




            // $ledgerData = [
            //     'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
            //     'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
            //     'duedt'      => !empty($polInfo['FUPDATE']) ? $polInfo['FUPDATE'] : null,
            //     'paiddt'     => null,
            //     'ecs_mode'   => !empty($polInfo['ECS_MODE']) ? $polInfo['ECS_MODE'] : 'No',
            //     'mode'       => !empty($polInfo['MODE']) ? $polInfo['MODE'] : '',
            //     'rdt'        => !empty($polInfo['RDT']) ? $polInfo['RDT'] : null,
            //     'prem'       => !empty($polInfo['PREM']) ? $polInfo['PREM'] : '',
            //     'PTERM'       => !empty($polInfo['TERM']) ? $polInfo['TERM'] : '',
            //     'sprem'      => 0,
            //     'remarks'    => !empty($polInfo['REMARKS']) ? $polInfo['REMARKS'] : '',
            //     'FUP'    =>     !empty($postData['FUP']) ? $postData['FUP'] : '',
            //     'dedcode'    => 0,
            //     'comm'       => 0,
            //     'bonus'      => 0,
            //     'fpren'      => '',
            //     'commdt'     => null,
            //     'dedu_code'  => 0,
            //     'branch'     => !empty($polInfo['E_BRANCH']) ? $polInfo['E_BRANCH'] : '',
            //     'chqno'      => '',
            //     'chqdt'      => null,
            //     'bank'       => !empty($polInfo['BANKNAME']) ? $polInfo['BANKNAME'] : '',
            //     'advpr'      => '',
            //     'newfld'     => '',
            //     'client_id'  => !empty($polInfo['client_id']) ? $polInfo['client_id'] : '',
            //     'policy_insurance_id'  => !empty($polInfo['policy_insurance_id']) ? $polInfo['policy_insurance_id'] : 0,
            // ];

                
            // Ledger::saveLedger($ledgerData);

        }

        if (empty($postData['id'])) {
            $planCheck = Plan::where('plno', $polInfo['PLAN'])->where('mb', 'Yes')->first();
            if (!empty($planCheck) && !empty($planCheck['year1']) && !empty($planCheck['year2']) && !empty($planCheck['per1'])) {
                $current_year  = date("Y");
                $maturity_year = $current_year + $polInfo['MTERM'];
                $cnt           = 0;
                $cnt2          = 0;
                for ($year = $current_year; $year < ($maturity_year + 1); $year++) {
                    if ($cnt == 0) {
                        $licYearCheck  = $planCheck['year1'] + $current_year;
                        $licreturnYear = $planCheck['year1'];
                    }
                    if ($year > $licYearCheck) {
                        $licYearCheck  = $licYearCheck + $planCheck['year2'];
                        $licreturnYear = $licreturnYear + $planCheck['year2'];
                    }
                    if ($licYearCheck == $year && $planCheck['a_year'] >= $licreturnYear) {
                        $dateString   = $polInfo['RDT'];
                        if (!empty($dateString)) {
                            $t            = strtotime($dateString);
                            $t2           = strtotime('+' . $licreturnYear . 'years', $t);
                            $dueDate      = date('Y-m-d', $t2);
                            $duemonthyear = date('Ym', $t2);
                        }
                        $cnt2++;
                        $licReturn = $polInfo['SA'] * $planCheck['per1'] / 100;
                        $sbdueData = [
                            'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                            'no_of_inst' => $cnt2,
                            'duedate'    => !empty($dueDate) ? $dueDate : null,
                            'amount'     => $licReturn,
                            'duemonthyr' => !empty($duemonthyear) ? $duemonthyear : '',
                            'client_id'  => !empty($polInfo['client_id']) ? $polInfo['client_id'] : '',
                        ];
                        SBDue::saveSBDue($sbdueData);
                    }
                    $cnt++;
                }
            }
        }
    
    return $polInfo;
    }
}

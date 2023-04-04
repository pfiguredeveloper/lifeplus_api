<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
class GiPolicy extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'GI_Policy';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $fillable = [
        'id','IsurerId', 'IsurerName', 'IsurerProductId', 'IsurerProductName', 'Form_id', 'PolicyNo', 'PreviousPolicyNo', 'AgancyId', 'AgancyName', 'RiskDate', 'RiskExpDate', 'PartyId', 'PartyName', 'RefPerson', 'SumAssured', 'Premium', 'DiscountPer', 'DiscountAmount', 'TaxPer', 'TaxAmount', 'NetPremium', 'ModePayment', 'ModePaymentId', 'BankName', 'ChequeNo', 'Nominee', 'Relation', 'ReferancePersonId', 'ReferancePersonName', 'Remarks', 'Notes', 'CommisionableAmount', 'CommisionableAmountPer', 'CommisionAmount', 'TDSPer', 'TDSAmount', 'NetCommisionAmount', 'ProposalNo', 'ProposalDate', 'CoverNote', 'HypothecatedTo','HypothecatedToCheckbox','PolicyType','TerrorismSurrcharge','AddOnePremium','LoadingFor','VehicalId', 'VehicalName','VehicalRegNo','VehicalRegYear','VehicalEngineNo', 'VehicalYearOfMFG', 'VehicalRegAuthLocation', 'VehicalChasisNo', 'VehicalAgeOfVehical', 'VehicalValueOfVehical', 'VehicalNonElectAcce', 'VehicalElectAcce', 'VehicalSideCarTrailer', 'VehicalCngLpgKit', 'VehicalTotalValue', 'VehicalTPPremium', 'VehicalDrivePremium', 'VehicalOtherPremium', 'DiscountCheckedOptions', 'LoadingsCheckedOptions', 'MarineFromPlace', 'MarineToPlace', 'MarineClaimLocation', 'MarineRR_LR_BL_No', 'MarineRR_Date', 'MarineClauseId', 'MarineClauseName', 'MarineUnseaworthinessUniFitness', 'MarineWar', 'MarineStrike', 'MarineAdditionsOptions', 'TAPId', 'TAPName','TPPremium','PADriverPremium','OtherPremium','is_active',
     ];

     public const ALL_RISK_FORM = 1;
     public const FIRE_FORM = 2;
     public const HEALTH_CARE_FORM = 3;
     public const MOTOR_FORM = 4;

     public static function saveGiPolicyData($postData)
    {
         if(!empty($postData['id'])) {
            $polInfo = self::where('id', $postData['id'])->first();
         } else {
            $polInfo = new self();
         }
        $polInfo['IsurerId'] = !empty($postData['IsurerId']) ? $postData['IsurerId'] : NULL;
        $polInfo['IsurerName'] =  GIInsurer::where("id",$polInfo["IsurerId"])->value("InsurerCompany") ?? NULL;
        $polInfo['IsurerProductId'] = !empty($postData['IsurerProductId']) ? $postData['IsurerProductId'] : NULL;
        $polInfo['IsurerProductName'] = GISystemInsurerproducts::where("id",$polInfo["IsurerProductId"])->value("Productname") ?? NULL;
        $polInfo['Form_id'] = GISystemInsurerproducts::where("id",$polInfo["IsurerProductId"])->value("Form_id") ?? 1;;
        $polInfo['PolicyNo'] = !empty($postData['PolicyNo']) ? $postData['PolicyNo'] : NULL;
        $polInfo['PreviousPolicyNo'] = !empty($postData['PreviousPolicyNo']) ? $postData['PreviousPolicyNo'] : NULL;
        $polInfo['AgancyId'] = !empty($postData['AgancyId']) ? $postData['AgancyId'] : NULL;
        $polInfo['AgancyName'] = Agency::where("AFILE",$polInfo["AgancyId"])->value("ANAME") ?? NULL;
        $polInfo['RiskDate'] = !empty($postData['RiskDate']) ? date("Y-m-d",strtotime($postData['RiskDate'])) : NULL;
        $polInfo['RiskExpDate'] = !empty($postData['RiskExpDate']) ?  date("Y-m-d",strtotime($postData['RiskExpDate'])) : NULL;
        $polInfo['PartyId']  = !empty($postData['PartyId']) ? $postData['PartyId'] : NULL;
        $polInfo['PartyName']    = Party::where("GCODE",$polInfo["PartyId"])->value("NAME") ?? NULL;
        //$polInfo['RefPerson']        = !empty($postData['RefPerson']) ? $postData['RefPerson'] : NULL;
        $polInfo['SumAssured']        = !empty($postData['SumAssured']) ? $postData['SumAssured'] : NULL;
        $polInfo['Premium']        = !empty($postData['Premium']) ? $postData['Premium'] : NULL;
        $polInfo['DiscountPer']        = !empty($postData['DiscountPer']) ? $postData['DiscountPer'] : NULL;
        $polInfo['DiscountAmount']        = !empty($postData['DiscountAmount']) ? $postData['DiscountAmount'] : NULL;
        $polInfo['TaxPer']        = !empty($postData['TaxPer']) ? $postData['TaxPer'] : NULL;
        $polInfo['TaxAmount']        = !empty($postData['TaxAmount']) ? $postData['TaxAmount'] : NULL;
        $polInfo['NetPremium']        = !empty($postData['NetPremium']) ? $postData['NetPremium'] : NULL;
        $polInfo['ModePayment']        = !empty($postData['ModePayment']) ? $postData['ModePayment'] : NULL;
        $polInfo['ModePaymentId']        = !empty($postData['ModePaymentId']) ? $postData['ModePaymentId'] : NULL;
        $polInfo['BankName']        = !empty($postData['BankName']) ? $postData['BankName'] : NULL;
        $polInfo['ChequeNo']        = !empty($postData['ChequeNo']) ? $postData['ChequeNo'] : NULL;
        $polInfo['Nominee']        = !empty($postData['Nominee']) ? $postData['Nominee'] : NULL;
        $polInfo['Relation']        = !empty($postData['Relation']) ? $postData['Relation'] : NULL;
        $polInfo['ReferancePersonId']        = !empty($postData['ReferancePersonId']) ? $postData['ReferancePersonId'] : NULL;
        $polInfo['ReferancePersonName']        = Party::where("GCODE",$polInfo["ReferancePersonId"])->value("NAME") ?? NULL;
        $polInfo['Remarks']        = !empty($postData['Remarks']) ? $postData['Remarks'] : NULL;
        $polInfo['Notes']        = !empty($postData['Notes']) ? $postData['Notes'] : NULL;
        $polInfo['CommisionableAmount']        = !empty($postData['CommisionableAmount']) ? $postData['CommisionableAmount'] : NULL;
        $polInfo['CommisionableAmountPer']        = !empty($postData['CommisionableAmountPer']) ? $postData['CommisionableAmountPer'] : NULL;
        $polInfo['CommisionAmount']        = !empty($postData['CommisionAmount']) ? $postData['CommisionAmount'] : NULL;
        $polInfo['TDSPer']        = !empty($postData['TDSPer']) ? $postData['TDSPer'] : NULL;
        $polInfo['TDSAmount']        = !empty($postData['TDSAmount']) ? $postData['TDSAmount'] : NULL;
        $polInfo['NetCommisionAmount']        = !empty($postData['NetCommisionAmount']) ? $postData['NetCommisionAmount'] : NULL;
        $polInfo['ProposalNo']        = !empty($postData['ProposalNo']) ? $postData['ProposalNo'] : NULL;
        $polInfo['ProposalDate']        = !empty($postData['ProposalDate']) ? date("Y-m-d",strtotime($postData['ProposalDate'])) : NULL;
        $polInfo['CoverNote']        = !empty($postData['CoverNote']) ? $postData['CoverNote'] : NULL;
        $polInfo['HypothecatedTo']        = !empty($postData['HypothecatedTo']) ? $postData['HypothecatedTo'] : NULL;
        
        $polInfo['PolicyType'] = !empty($postData['PolicyType']) ? $postData['PolicyType'] : NULL;
        $polInfo['LoadingFor'] = !empty($postData['LoadingFor']) ? $postData['LoadingFor'] : NULL;
        $polInfo['AddOnePremium'] = !empty($postData['AddOnePremium']) ? $postData['AddOnePremium'] : NULL;
        $polInfo['TerrorismSurrcharge'] = !empty($postData['TerrorismSurrcharge']) ? $postData['TerrorismSurrcharge'] : NULL;
        $polInfo['HypothecatedToCheckbox'] = !empty($postData['HypothecatedToCheckbox']) ? $postData['HypothecatedToCheckbox'] : 0;

        $polInfo['VehicalId']        = !empty($postData['VehicalId']) ? $postData['VehicalId'] : NULL;
        $polInfo['VehicalName']        = !empty($postData['VehicalName']) ? $postData['VehicalName'] : NULL;
        $polInfo['VehicalRegNo']        = !empty($postData['VehicalRegNo']) ? $postData['VehicalRegNo'] : NULL;
        $polInfo['VehicalRegYear']        = !empty($postData['VehicalRegYear']) ? $postData['VehicalRegYear'] : NULL;
        $polInfo['VehicalEngineNo']        = !empty($postData['VehicalEngineNo']) ? $postData['VehicalEngineNo'] : NULL;
        $polInfo['VehicalYearOfMFG']        = !empty($postData['VehicalYearOfMFG']) ? $postData['VehicalYearOfMFG'] : NULL;
        $polInfo['VehicalRegAuthLocation']        = !empty($postData['VehicalRegAuthLocation']) ? $postData['VehicalRegAuthLocation'] : NULL;
        $polInfo['VehicalChasisNo']        = !empty($postData['VehicalChasisNo']) ? $postData['VehicalChasisNo'] : NULL;
        $polInfo['VehicalAgeOfVehical']        = !empty($postData['VehicalAgeOfVehical']) ? $postData['VehicalAgeOfVehical'] : NULL;
        $polInfo['VehicalValueOfVehical']        = !empty($postData['VehicalValueOfVehical']) ? $postData['VehicalValueOfVehical'] : NULL;
        $polInfo['VehicalNonElectAcce']        = !empty($postData['VehicalNonElectAcce']) ? $postData['VehicalNonElectAcce'] : NULL;
        $polInfo['VehicalElectAcce']        = !empty($postData['VehicalElectAcce']) ? $postData['VehicalElectAcce'] : NULL;
        $polInfo['VehicalSideCarTrailer']        = !empty($postData['VehicalSideCarTrailer']) ? $postData['VehicalSideCarTrailer'] : NULL;
        $polInfo['VehicalCngLpgKit']        = !empty($postData['VehicalCngLpgKit']) ? $postData['VehicalCngLpgKit'] : NULL;
        $polInfo['VehicalTotalValue']        = !empty($postData['VehicalTotalValue']) ? $postData['VehicalTotalValue'] : NULL;
        $polInfo['VehicalTPPremium']        = !empty($postData['VehicalTPPremium']) ? $postData['VehicalTPPremium'] : NULL;

        $polInfo['VehicalDrivePremium']        = !empty($postData['VehicalDrivePremium']) ? $postData['VehicalDrivePremium'] : NULL;
        $polInfo['VehicalOtherPremium']        = !empty($postData['VehicalOtherPremium']) ? $postData['VehicalOtherPremium'] : NULL;
        $polInfo['DiscountCheckedOptions']        = !empty($postData['DiscountCheckedOptions']) ? $postData['DiscountCheckedOptions'] : NULL;
        $polInfo['LoadingsCheckedOptions']        = !empty($postData['LoadingsCheckedOptions']) ? $postData['LoadingsCheckedOptions'] : NULL;
        $polInfo['MarineFromPlace']        = !empty($postData['MarineFromPlace']) ? $postData['MarineFromPlace'] : NULL;
        $polInfo['MarineToPlace']        = !empty($postData['MarineToPlace']) ? $postData['MarineToPlace'] : NULL;


        $polInfo['MarineClaimLocation']        = !empty($postData['MarineClaimLocation']) ? $postData['MarineClaimLocation'] : NULL;
        $polInfo['MarineRR_LR_BL_No']        = !empty($postData['MarineRR_LR_BL_No']) ? $postData['MarineRR_LR_BL_No'] : NULL;
        $polInfo['MarineRR_Date']        = !empty($postData['MarineRR_Date']) ? $postData['MarineRR_Date'] : NULL;
        $polInfo['MarineClauseId']        = !empty($postData['MarineClauseId']) ? $postData['MarineClauseId'] : NULL;
        $polInfo['MarineClauseName']        = !empty($postData['MarineClauseName']) ? $postData['MarineClauseName'] : NULL;
        $polInfo['MarineUnseaworthinessUniFitness']        = !empty($postData['MarineUnseaworthinessUniFitness']) ? $postData['MarineUnseaworthinessUniFitness'] : NULL;
        $polInfo['MarineWar'] = !empty($postData['MarineWar']) ? $postData['MarineWar'] : NULL;
        $polInfo['MarineStrike'] = !empty($postData['MarineStrike']) ? $postData['MarineStrike'] : NULL;
        $polInfo['MarineAdditionsOptions'] = !empty($postData['MarineAdditionsOptions']) ? $postData['MarineAdditionsOptions'] : NULL;
        $polInfo['TPAId'] = !empty($postData['TPAId']) ? $postData['TPAId'] : NULL;
        $polInfo['TPAName'] = TPA::where("ID",$polInfo['TPAId'])->value("NAME") ?? NULL;

        $polInfo['TPPremium'] = !empty($postData['TPPremium']) ? $postData['TPPremium'] : NULL;
        $polInfo['OtherPremium'] = !empty($postData['OtherPremium']) ? $postData['OtherPremium'] : NULL;
        $polInfo['PADriverPremium'] = !empty($postData['PADriverPremium']) ? $postData['PADriverPremium'] : NULL;
        $polInfo->save();

        if($polInfo['Form_id']==self::FIRE_FORM) {
            $firmFormIds = [];
            foreach ($postData["fire_floater"] ?? [] as $key => $value) {
                $firmForm = GIFireFloaterDetails::where('id', $value['updateId'] ?? 0)->first();
                if(empty($firmForm)) {
                    $firmForm = new GIFireFloaterDetails();
                }
                $firmForm["PolicyId"] = $polInfo["id"];
                $firmForm['LocationName'] = !empty($value['LocationName']) ? $value['LocationName'] : NULL;
                $firmForm['SituationAddress'] = !empty($value['SituationAddress']) ? $value['SituationAddress'] : NULL;
                $firmForm['Section'] = !empty($value['Section']) ? $value['Section'] : NULL;
                $firmForm['BuildingIncludingPlinthFoundation'] = !empty($value['BuildingIncludingPlinthFoundation']) ? $value['BuildingIncludingPlinthFoundation'] : NULL;
                $firmForm['PlinthFoundation'] = !empty($value['PlinthFoundation']) ? $value['PlinthFoundation'] : NULL;
                $firmForm['FurnitureFixtureSettings'] = !empty($value['FurnitureFixtureSettings']) ? $value['FurnitureFixtureSettings'] : NULL;
                $firmForm['PlantMachineryAccessories'] = !empty($value['PlantMachineryAccessories']) ? $value['PlantMachineryAccessories'] : NULL;
                $firmForm['TotalPremiumAmount'] = !empty($value['TotalPremiumAmount']) ? $value['TotalPremiumAmount'] : NULL;
                $firmForm['BlockName'] = !empty($value['BlockName']) ? $value['BlockName'] : NULL;
                $firmForm['RiskDescription'] = !empty($value['RiskDescription']) ? $value['RiskDescription'] : NULL;
                $firmForm['FEATypes'] = !empty($value['FEATypes']) ? $value['FEATypes'] : NULL;
                $firmForm['Stock'] = !empty($value['Stock']) ? $value['Stock'] : NULL;
                $firmForm['StockInProcess'] = !empty($value['StockInProcess']) ? $value['StockInProcess'] : NULL;
                $firmForm['AnyOther'] = !empty($value['AnyOther']) ? $value['AnyOther'] : NULL;
                $firmForm['TotalSumAssured'] = !empty($value['TotalSumAssured']) ? $value['TotalSumAssured'] : NULL;
                $firmForm->save();
                $firmFormIds[] = $firmForm->id;
            }
            GIFireFloaterDetails::whereNotIn("id",$firmFormIds)->where("PolicyId",$polInfo["id"])->update(["is_active"=>0]);
        }
        if($polInfo['Form_id']==self::HEALTH_CARE_FORM) {
            $claimFormIds = [];
            foreach ($postData["address_group"] ?? [] as $key => $value) {
                $claimForm = GIPolicyMediClaimDetails::where('id', $value['updateId'] ?? 0)->first();
                if(empty($claimForm)) {
                    $claimForm = new GIPolicyMediClaimDetails();
                }
                $claimForm["PolicyId"] = $polInfo["id"];
                $claimForm['PartyId'] = !empty($value['PartyId']) ? $value['PartyId'] : NULL;
                $claimForm['Dob'] = !empty($value['Dob']) ? date("Y-m-d",strtotime($value['Dob'])) : NULL;
                $claimForm['Age'] = !empty($value['Age']) ? $value['Age'] : NULL;
                $claimForm['Relation'] = !empty($value['Relation']) ? $value['Relation'] : NULL;
                $claimForm['SumAssured'] = !empty($value['SumAssured']) ? $value['SumAssured'] : NULL;
                $claimForm['NoClaimBouns'] = !empty($value['NoClaimBouns']) ? $value['NoClaimBouns'] : NULL;
                $claimForm['Premium'] = !empty($value['Premium']) ? $value['Premium'] : NULL;                
                $claimForm->save();
                $claimFormIds[] = $claimForm->id;
            }
            GIPolicyMediClaimDetails::whereNotIn("id",$claimFormIds)->where("PolicyId",$polInfo["id"])->update(["is_active"=>0]);
        }
        if($polInfo['Form_id']==self::MOTOR_FORM) {
            $vehicleForm = GIPolicyVehicleDetails::where('PolicyId', $polInfo["id"])->first();
            if(empty($vehicleForm)) {
                $vehicleForm = new GIPolicyVehicleDetails();
            }
            $vehicleForm["PolicyId"] = $polInfo["id"];
            $vehicleForm['VehicalId'] = !empty($postData['VehicalId']) ? $postData['VehicalId'] : NULL;
            $vehicleForm['VehicalName'] = Vehicles::where("id",$vehicleForm['VehicalId'])->value("NAME") ?? NULL;
            $vehicleForm['VehicalRegDate']=!empty($postData['VehicalRegDate']) ? date("Y-m-d",strtotime($postData['VehicalRegDate'])) : NULL;
            $vehicleForm['RegistrationNo'] = !empty($postData['RegistrationNo']) ? $postData['RegistrationNo'] : NULL;
            $vehicleForm['EngineNo'] = !empty($postData['EngineNo']) ? $postData['EngineNo'] : NULL;
            $vehicleForm['YearOfMFG'] = !empty($postData['YearOfMFG']) ? $postData['YearOfMFG'] : NULL;
            $vehicleForm['RegAuthLocation'] = !empty($postData['RegAuthLocation']) ? $postData['RegAuthLocation'] : NULL;
            $vehicleForm['ChasisNo'] = !empty($postData['ChasisNo']) ? $postData['ChasisNo'] : NULL; 
            $vehicleForm['AgeOfVehicle'] = !empty($postData['AgeOfVehicle']) ? $postData['AgeOfVehicle'] : NULL;
            $vehicleForm['ValueOfVehicle'] = !empty($postData['ValueOfVehicle']) ? $postData['ValueOfVehicle'] : NULL;
            $vehicleForm['NonElecAcce'] = !empty($postData['NonElecAcce']) ? $postData['NonElecAcce'] : NULL;
            $vehicleForm['ElecAcce'] = !empty($postData['ElecAcce']) ? $postData['ElecAcce'] : NULL;
            $vehicleForm['SideCarTrailor'] = !empty($postData['SideCarTrailor']) ? $postData['SideCarTrailor'] : NULL; 
            $vehicleForm['CngLpgKit'] = !empty($postData['CngLpgKit']) ? $postData['CngLpgKit'] : NULL; 
            $vehicleForm['TotalValue'] = !empty($postData['TotalValue']) ? $postData['TotalValue'] : NULL; 
            $vehicleForm->save();

            $vehicleAnsList = [];
            $question_list =  GIVehicleSystemRelatedQuestions::where(["is_active"=>1])->pluck("Question","id");
            foreach($postData["question"] ?? [] as $key=>$value) {
                $vehicleRelatedQuestions = GIPolicyVehicleRelatedQuestions::create([
                    "PolicyId"=>$polInfo["id"],
                    "VehicalQuestionId"=>$key,
                    "VehicalQuestion"=>$question_list[$key] ?? NULL,
                    "Answer"=>1,
                ]);
                $vehicleAnsList[] = $vehicleRelatedQuestions->id;
            }
            GIPolicyVehicleRelatedQuestions::whereNotIn("id",$vehicleAnsList)->where("PolicyId",$polInfo["id"])->update(["is_active"=>0]);  
        }
        return $polInfo;
    }

    // protected $fillable = [
    //     'POLICYID', 'INSURER_NAME', 'PRODUCT_NAME', 'POLICY_NO', 'PREVIOUS_POLICY_NO', 'AGENCY_NAME', 'RISK_DATE', 'RISK_EXPIRY_DATE', 'PARTY_NAME', 'REF_PERSON', 'SUM_ASSURED', 'PREMIUM', 'DISCOUNT_PER', 'DISCOUNT_AMOUNT', 'SERVICE_TAX_PER', 'SERVICE_TAX_AMOUNT', 'NET_PREMIUM', 'MODE_OF_PAYMENT', 'BANK_NAME', 'CHEQUE_NO', 'NOMINEE', 'RELATION', 'COMMISSIONABLE', 'COMM_PER', 'COMM_AMOUNT', 'TDS_PER', 'TDS_AMOUNT', 'NET_COMMISSION', 'REMARKS', 'NOTES', 'PROP_NO', 'PROP_DATE', 'client_id', 'old_id', 'old_client_id'
    // ];

    // public static function saveGiPolicyData($postData)
    // {
    // 	if(!empty($postData['id'])) {
    // 		$polInfo = self::where('POLICYID', $postData['id'])->first();
    // 	} else {
    // 		$polInfo = new self();
    //     }
        
    //     $polInfo['INSURER_NAME']      = !empty($postData['INSURER_NAME']) ? $postData['INSURER_NAME'] : 0;
    //     $polInfo['PRODUCT_NAME']        = !empty($postData['PRODUCT_NAME']) ? $postData['PRODUCT_NAME'] : 0;
    //     $polInfo['RISK_DATE']        = !empty($postData['RISK_DATE']) ? date('Y-m-d', strtotime($postData['RISK_DATE'])) : null;
    //     $polInfo['RISK_EXPIRY_DATE']        = !empty($postData['RISK_EXPIRY_DATE']) ? date('Y-m-d', strtotime($postData['RISK_EXPIRY_DATE'])) : null;
    //     $polInfo['POLICY_NO']         = !empty($postData['POLICY_NO']) ? $postData['POLICY_NO'] : '';
    //     $polInfo['PREVIOUS_POLICY_NO']   = !empty($postData['PREVIOUS_POLICY_NO']) ? $postData['PREVIOUS_POLICY_NO'] : '';
    //     $polInfo['AGENCY_NAME']   = !empty($postData['AGENCY_NAME']) ? $postData['AGENCY_NAME'] : 0;
    //     $polInfo['PARTY_NAME'] = !empty($postData['PARTY_NAME']) ? $postData['PARTY_NAME'] : 0;
    //     $polInfo['REF_PERSON']   = !empty($postData['REF_PERSON']) ? $postData['REF_PERSON'] : 0;
    //     $polInfo['SUM_ASSURED']   = !empty($postData['SUM_ASSURED']) ? $postData['SUM_ASSURED'] : 0;
    //     $polInfo['PREMIUM']  = !empty($postData['PREMIUM']) ? $postData['PREMIUM'] : 0;
    //     $polInfo['DISCOUNT_PER']      = !empty($postData['DISCOUNT_PER']) ? $postData['DISCOUNT_PER'] : 0;
    //     $polInfo['DISCOUNT_AMOUNT']    = !empty($postData['DISCOUNT_AMOUNT']) ? $postData['DISCOUNT_AMOUNT'] : 0;
    //     $polInfo['SERVICE_TAX_PER']     = !empty($postData['SERVICE_TAX_PER']) ? $postData['SERVICE_TAX_PER'] : 0;
    //     $polInfo['SERVICE_TAX_AMOUNT']   = !empty($postData['SERVICE_TAX_AMOUNT']) ? $postData['SERVICE_TAX_AMOUNT'] : 0;
    //     $polInfo['NET_PREMIUM']     = !empty($postData['NET_PREMIUM']) ? $postData['NET_PREMIUM'] : 0;
    //     $polInfo['MODE_OF_PAYMENT']   = !empty($postData['MODE_OF_PAYMENT']) ? $postData['MODE_OF_PAYMENT'] : '';
    //     $polInfo['BANK_NAME']    = !empty($postData['BANK_NAME']) ? $postData['BANK_NAME'] : '';
    //     $polInfo['CHEQUE_NO']   = !empty($postData['CHEQUE_NO']) ? $postData['CHEQUE_NO'] : '';
    //     $polInfo['NOMINEE']       = !empty($postData['NOMINEE']) ? $postData['NOMINEE'] : '';
    //     $polInfo['RELATION']       = !empty($postData['RELATION']) ? $postData['RELATION'] : '';
    //     $polInfo['REMARKS']      = !empty($postData['REMARKS']) ? $postData['REMARKS'] : '';
    //     $polInfo['COMMISSIONABLE']    = !empty($postData['COMMISSIONABLE']) ? $postData['COMMISSIONABLE'] : 0;
    //     $polInfo['COMM_PER']    = !empty($postData['COMM_PER']) ? $postData['COMM_PER'] : 0;
    //     $polInfo['COMM_AMOUNT']    = !empty($postData['COMM_AMOUNT']) ? $postData['COMM_AMOUNT'] : 0;
    //     $polInfo['TDS_PER']    = !empty($postData['TDS_PER']) ? $postData['TDS_PER'] : 0;
    //     $polInfo['TDS_AMOUNT']    = !empty($postData['TDS_AMOUNT']) ? $postData['TDS_AMOUNT'] : 0;
    //     $polInfo['NET_COMMISSION']    = !empty($postData['NET_COMMISSION']) ? $postData['NET_COMMISSION'] : 0;
    //     $polInfo['NOTES']       = !empty($postData['NOTES']) ? $postData['NOTES'] : '';
    //     $polInfo['PROP_NO']       = !empty($postData['PROP_NO']) ? $postData['PROP_NO'] : '';
    //     $polInfo['PROP_DATE']        = !empty($postData['PROP_DATE']) ? date('Y-m-d', strtotime($postData['PROP_DATE'])) : null;
    //     $polInfo['client_id']       = !empty($postData['client_id']) ? $postData['client_id'] : 0;
    //     $polInfo['old_id']        = !empty($postData['old_id']) ? $postData['old_id'] : 0;
    //     $polInfo['old_client_id']     = !empty($postData['old_client_id']) ? $postData['old_client_id'] : 0;
    //     $polInfo->save();
    //     return $polInfo;
    // }
}
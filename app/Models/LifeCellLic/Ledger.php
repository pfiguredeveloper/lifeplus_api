<?php
namespace App\Models\LifeCellLic;
use Illuminate\Database\Eloquent\Model;
use DB;
class Ledger extends Model
{
    protected $connection = 'lifecell_lic';
    protected $table      = 'ledger';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id','puniqid','pono','duedt','paiddt','ecs_mode','mode','rdt','prem','sprem','remarks','dedcode','comm','bonus','fpren','commdt','dedu_code','branch','chqno','chqdt','bank','advpr','newfld','client_id','old_id','old_client_id','policy_insurance_id',
    ];



    
    public static function saveLedgerss($paymentdate,$pono,$riskdate,$fupdate)
    {
        

            $id=$pono;
            $polInfo2 = DB::connection('lifecell_lic')->select("SELECT * FROM pol where PUNIQID = '$id'");
            $polInfo1  = !empty($polInfo2) ? $polInfo2['0'] : "";
            $polInfo = json_decode(json_encode($polInfo1), true);


        $riskdt=!empty($riskdate) ? Date("d/m/Y", strtotime($riskdate)) : '01/01/2000';
        $mode=!empty($polInfo['MODE']) ? $polInfo['MODE'] : 'Yearly';
        $terms=!empty($polInfo['TERM']) ? $polInfo['TERM'] : '5';



    $ar_month_year=explode("/",$riskdt);
    $day=$ar_month_year[0];
    $month=$ar_month_year[1];
    $year=$ar_month_year[2];
    $comination=[];
    $current_month=$month;
    $current_year=$year;
    $full_date=[];
    $test_full_date=array();
    $count=0;
    $count_days=0;
    $yearexist=[];

     if($mode=="Monthly"){
        $max_value=12;
        $append_month=1;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Quaterly"){
        $max_value=4;
        $append_month=3;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Half Yearly"){
        $max_value=2;
        $append_month=6;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Yearly"){
        $max_value=1;
        $append_month=12;
        $decide = $max_value * $terms - 1;
    }
    $count=0;
    $e='';

    $checkmonth='13';
    $fullyear=$year;
    $appenmonth=$month;
    $d = date('Y-m-d',strtotime((($year)."-".$month."-".$day)));
    // new Date($year, $month, $day);
    // echo $d;die();



    for($i=1;$i<=$decide;$i++)
    {
            if($mode == "Monthly" || $mode == "Half Yearly" || $mode == "Quaterly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
            }
            $count=$count + 1;
            $d=$d;
            $months=date('m',strtotime((($year+$terms)."-".$month."-".$day)));
            
            $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
            if($months == 0 && $mode != "Yearly")
            {
                $months='12';
                $fullyear=Date("Y",strtotime($d."+1 Month -1 Year"));
                date('Y',strtotime((($year+$terms)."-".$month."-".$day))) - 1;
                
            }
            if($mode == "Yearly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
                $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
               
            }

            if($months <= 9)
            {
                $months="0"+$months;
            }

            array_push($test_full_date,$d);
            
            $lastdatefup=$d;
            

    }
       $fupdate=!empty($fupdate) ? Date("Y-m-d", strtotime($fupdate)) : '01/01/2000';
        foreach ($test_full_date as $key => $value) {
            $paymentdate=$value;
            
            if($lastdatefup > $paymentdate)
            {
                $dates=$polInfo['FUPDATE'];

                $ledgerlist1 = DB::connection('lifecell_lic')->select("SELECT * FROM ledger where puniqid = '$id' and duedt= '$dates'");
                

                if(empty($ledgerlist1))
                {

                

          Ledger::create([
                'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
                'duedt'      => !empty($polInfo['FUPDATE']) ? $polInfo['FUPDATE'] : null,
                'paiddt'     => !empty($polInfo['paiddt']) ? Date("Y-m-d", strtotime($polInfo['paiddt'])) : null,
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
            
            ]);


              


            }

        }



              $d = $fupdate;
            $ar_month_year=explode("-",$polInfo['FUPDATE']);
            $day=$ar_month_year[2];
            $month=$ar_month_year[1];
            $year=$ar_month_year[0];
            $mode=$polInfo['MODE'];
            $terms=$polInfo['TERM'];

        if($mode=="Monthly"){
        $max_value=12;
        $append_month=1;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Quaterly"){
        $max_value=4;
        $append_month=3;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Half Yearly"){
        $max_value=2;
        $append_month=6;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Yearly"){
        $max_value=1;
        $append_month=12;
        $decide = $max_value * $terms - 1;
    }


           $count=0;
            if($mode == "Monthly" || $mode == "Half Yearly" || $mode == "Quaterly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
            }
            $count=$count + 1;
            $d=$d;
            $months=date('m',strtotime((($year+$terms)."-".$month."-".$day)));
            
            $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
            if($months == 0 && $mode != "Yearly")
            {
                $months='12';
                $fullyear=Date("Y",strtotime($d."+1 Month -1 Year"));
                date('Y',strtotime((($year+$terms)."-".$month."-".$day))) - 1;
                
            }
            if($mode == "Yearly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
                $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
               
            }

              $FUPDATE=$d;
              $FUP=!empty($d) ? Date("m/Y", strtotime($d)) : '01/01/2000';
              $polInfo2 = DB::connection('lifecell_lic')->select("update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PONO = $id");
              $a="update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PONO = $id";



              $FUPDATE=$d;
              $FUP=!empty($dates) ? Date("m/Y", strtotime($FUPDATE)) : '01/01/2000';
              $polInfo2 = DB::connection('lifecell_lic')->select("update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PUNIQID = '$id'");
              $a="update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PONO = $id";
            


        
    }
             

    return $a;








    }
    public static function saveLedgers($postData2)
    {
           $ledgerInfo = new self();


           $id=$postData2['pono'];
           $polInfo2 = DB::connection('lifecell_lic')->select("SELECT * FROM pol where PONO = $id");
            $polInfo1  = !empty($polInfo2) ? $polInfo2['0'] : "";
            $polInfo = json_decode(json_encode($polInfo1), true);
            



         Ledger::create([
                'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
                'duedt'      => !empty($polInfo['FUPDATE']) ? $polInfo['FUPDATE'] : null,
                'paiddt'     => !empty($polInfo['paiddt']) ? Date("Y-m-d", strtotime($polInfo['paiddt'])) : null,
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
                'chqno'      => json_encode($postData2),
                'chqdt'      => null,
                'bank'       => !empty($polInfo['BANKNAME']) ? $polInfo['BANKNAME'] : '',
                'advpr'      => '',
                'newfld'     => '',
                'client_id'  => !empty($polInfo['client_id']) ? $polInfo['client_id'] : '',
                'policy_insurance_id'  => !empty($polInfo['policy_insurance_id']) ? $polInfo['policy_insurance_id'] : 0,
            
        ]);

              


              
            $d = date('Y-m-d',strtotime($polInfo['FUPDATE']));
            $ar_month_year=explode("-",$polInfo['FUPDATE']);
            $day=$ar_month_year[2];
            $month=$ar_month_year[1];
            $year=$ar_month_year[0];
            $mode=$polInfo['MODE'];
            $terms=$polInfo['TERM'];

        if($mode=="Monthly"){
        $max_value=12;
        $append_month=1;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Quaterly"){
        $max_value=4;
        $append_month=3;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Half Yearly"){
        $max_value=2;
        $append_month=6;
        $decide = $max_value * $terms - 1;
    }else if($mode=="Yearly"){
        $max_value=1;
        $append_month=12;
        $decide = $max_value * $terms - 1;
    }


           $count=0;
            if($mode == "Monthly" || $mode == "Half Yearly" || $mode == "Quaterly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
            }
            $count=$count + 1;
            $d=$d;
            $months=date('m',strtotime((($year+$terms)."-".$month."-".$day)));
            
            $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
            if($months == 0 && $mode != "Yearly")
            {
                $months='12';
                $fullyear=Date("Y",strtotime($d."+1 Month -1 Year"));
                date('Y',strtotime((($year+$terms)."-".$month."-".$day))) - 1;
                
            }
            if($mode == "Yearly")
            {
                
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
                $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
               
            }

              $FUPDATE=$d;
              $FUP=!empty($d) ? Date("m/Y", strtotime($d)) : '01/01/2000';
              $polInfo2 = DB::connection('lifecell_lic')->select("update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PONO = $id");
              $a="update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PONO = $id";
              return $polInfo;




    }

    public static function saveLedger($fupdate,$pono,$type,$paymentdate)
    {
        $id=$pono;
        $paymentdates=$paymentdate;
        $polInfo2 = DB::connection('lifecell_lic')->select("SELECT * FROM pol where PUNIQID = '$id'");
        $polInfo1 = !empty($polInfo2) ? $polInfo2['0'] : "";
        $polInfo = json_decode(json_encode($polInfo1), true);
        if($type == 'first') {
            Ledger::create([
                'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
                'duedt'      => !empty($polInfo['RDT']) ? $polInfo['RDT'] : null,
                'paiddt'     => !empty($polInfo['RDT']) ? $polInfo['RDT'] : null,
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
                'policy_insurance_id'  => !empty($polInfo['policy_insurance_id']) ? $polInfo['policy_insurance_id'] : 0
            ]);
        }
        $yes="yes";
        $riskdt=!empty($polInfo['RDT']) ? Date("d/m/Y", strtotime($polInfo['RDT'])) : '01/01/2000';
        $mode=!empty($polInfo['MODE']) ? $polInfo['MODE'] : 'Yearly';
        $terms=!empty($polInfo['TERM']) ? $polInfo['TERM'] : '5';
        $decide=0;
        $ar_month_year=explode("/",$riskdt);
        $day=$ar_month_year[0];
        $month=$ar_month_year[1];
        $year=$ar_month_year[2];
        $comination=[];
        $current_month=$month;
        $current_year=$year;
        $full_date=[];
        $test_full_date=array();
        $count=0;
        $count_days=0;
        $yearexist=[];
        

        array_push($yearexist,$year);
        $mat_date_object = (($year+$terms)."-".$month."-".$day);
        if($mode=="Monthly") {
            $max_value=12;
            $append_month=1;
            $decide = $max_value * $terms - 1;
        }else if($mode=="Quarterly"){
            $max_value=4;
            $append_month=3;
            $decide = $max_value * $terms - 1;
        }else if($mode=="Half Yearly"){
            $max_value=2;
            $append_month=6;
            $decide = $max_value * $terms - 1;
        }else if($mode=="Yearly"){
            $max_value=1;
            $append_month=12;
            $decide = $max_value * $terms - 1;
        }
        $e='';
        $count=0;
        $checkmonth='13';
        $fullyear=$year;
        $appenmonth=$month;
        $d = date('Y-m-d',strtotime((($year)."-".$month."-".$day)));
        for($i=1;$i<=$decide;$i++) {
            if($mode == "Monthly" || $mode == "Half Yearly" || $mode == "Quarterly") {
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
            }
            $count=$count + 1;
            $d=$d;
            $months=date('m',strtotime((($year+$terms)."-".$month."-".$day)));
            $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
            if($months == 0 && $mode != "Yearly")  {
                $months='12';
                $fullyear=Date("Y",strtotime($d."+1 Month -1 Year"));
                date('Y',strtotime((($year+$terms)."-".$month."-".$day))) - 1;
            }
            if($mode == "Yearly") {
                $d=Date("Y-m-d", strtotime($d."+".$append_month." Month"));
                $fullyear=date('Y',strtotime((($year+$terms)."-".$month."-".$day)));
            }
            if($months <= 9) {
                $months="0"+$months;
            }
            array_push($test_full_date,$d);
        }
        foreach ($test_full_date as $key => $value) {
            $paymentdate=$value;
            info("paymentdate===".$paymentdate);
            info("fupdate===".$fupdate);
            if($paymentdate < $fupdate) {
                info("DDDDDDDDDDDDDDDD");
                $dates=Date("Y-m-d", strtotime($polInfo['FUPDATE']));
                $ledgerlist1 = DB::connection('lifecell_lic')->select("SELECT * FROM ledger where puniqid = '$id' and duedt= '$paymentdate'");
                info($ledgerlist1);
                $paymentdates=!empty($paymentdates) ? $paymentdates : '';
                if(empty($ledgerlist1)) {
                        Ledger::create([
                        'puniqid'    => !empty($polInfo['PUNIQID']) ? $polInfo['PUNIQID'] : '',
                        'pono'       => !empty($polInfo['PONO']) ? $polInfo['PONO'] : '',
                        'duedt'      => !empty($paymentdate) ? $paymentdate : null,
                        'paiddt'     => !empty($paymentdates) ? $paymentdates : null,
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
                        'newfld'     => json_encode($test_full_date),
                        'client_id'  => !empty($polInfo['client_id']) ? $polInfo['client_id'] : '',
                        'policy_insurance_id'  => !empty($polInfo['policy_insurance_id']) ? $polInfo['policy_insurance_id'] : 0
                    ]);
                }
            }
            else if($yes == "yes") {
                $yes="no";
                $FUPDATE=$paymentdate;
                $FUP=!empty($paymentdate) ? Date("m/Y", strtotime($paymentdate)) : '01/01/2000';
                $polInfo2 = DB::connection('lifecell_lic')->select("update pol set FUPDATE='$FUPDATE',FUP='$FUP' where PUNIQID = $id");
                break;
            }
        }
    }
}
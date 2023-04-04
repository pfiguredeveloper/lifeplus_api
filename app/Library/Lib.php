<?php

namespace App\Library;
use DB;

class Lib
{
    public $GST             = "0.0450";
    public $GSTText         = "4.5";
    public $GST2            = "0.02250";
    public $GST2Text        = "2.25";
    public $GST_pension     = "0.0180";
    public $GST_pensionText = "1.80";
    public $GSTTermInsu     = "0.1800";
    public $GSTTermInsuText = "18.00";
    public $ConstMaxTabSlab = "150000";

    public function getPremium($mterm,$pterm,$age,$sa,$dabsa,$trsa,$cirsa,$option,$plno,$waive='No',$PropAge=0,$curr_year=2000,$tax_benifit,$bonus,$daboption,$dabcheck,$trcheck,$circheck,$pwbcheck,$settcheck,$saoption) {
        if($curr_year == 2000) {
            $curr_year = date("Y");
        }
        // get variables based on plan 
        $ReturnValues = $this->getValues("*","plan","plno=$plno");
        $ReturnValues = (array) $ReturnValues[0];
        //******************************* Procedure start here
        
        //GET RATE FROM RATE TABLE
        $premium = $this->calcPrem($sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$plno,$ReturnValues,$age,$waive,$PropAge,$curr_year,$tax_benifit,$bonus,$daboption,$dabcheck,$trcheck,$circheck,$pwbcheck,$settcheck,$saoption);
        return $premium;
    }
    
    // Main Calling End
    public function calcPrem($sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$plno,$ReturnValues,$age,$waive,$PropAge,$curr_year,$tax_benifit,$bonus,$daboption,$dabcheck,$trcheck,$circheck,$pwbcheck,$settcheck,$saoption) {
        $valmod = array_map('str_split', str_split($ReturnValues['valmod']));
        $prem   = [1,2];
        $cnt    = 0;
        $rtn;
        $all_prem_in_array = array();
        foreach($prem as $year_wise) {
            foreach($valmod as $perticular_mode) {
                $mode = strtolower($perticular_mode[0]);
                $rtn  = $this->calBasicPrem($ReturnValues,$mterm,$pterm,$age,$plno,$sa,$mode,$year_wise,$saoption);
                
                //*********** SAVE PREMIUM IN ARRAY
                $all_prem_in_array = $this->save_in_array($all_prem_in_array,$rtn,$cnt,$mode,"basic_prem",$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$rtn);
                
                // CALCULATE Premium waiver START HERE --------------------------
                if($waive == 'Yes' && !empty($ReturnValues['prem_waiver_table_name'])) {
                    $waiveprem = $this->PremWaiver($age,$PropAge,$pterm,$plno,$ReturnValues,$all_prem_in_array[0]['y']['basic_prem'],$mode);
                    //$rtn = $rtn + $waiveprem;
                    if(!empty($pwbcheck) && $pwbcheck == 1) {
                        $rtn = $rtn + $waiveprem;
                    } else {
                        $rtn = $rtn;
                    }
                    
                    //*********** SAVE PREMIUM IN ARRAY
                    $all_prem_in_array = $this->save_in_array($all_prem_in_array,$rtn,$cnt,$mode,"waive_prem",$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$waiveprem);
                }
                // CALCULATE Premium waiver END HERE --------------------------
                
                // CALCULATE DAB SA START HERE --------------------------
                if($dabsa > 0 && !empty($ReturnValues['dab_rate_table_name'])) {
                    $dabprem = $this->Prem_After_DAB($ReturnValues,$plno,$dabsa,$mterm,$pterm,$age,$plno,$mode,$year_wise,$daboption,$saoption);
                    //$rtn     = $rtn + $dabprem;
                    if(!empty($dabcheck) && $dabcheck == 1) {
                        $rtn = $rtn + $dabprem;
                    } else {
                        $rtn = $rtn;
                    }
                    
                    //*********** SAVE PREMIUM IN ARRAY
                    $all_prem_in_array = $this->save_in_array($all_prem_in_array,$rtn,$cnt,$mode,"dab_prem",$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$dabprem);
                }
                // CALCULATE DAB SA END HERE --------------------------
                
                // CALCULATE TR SA START HERE --------------------------
                if($trsa > 0 && !empty($ReturnValues['trsa_table_name'])) {
                    $trprem = $this->caltrPrem($ReturnValues,$mterm,$pterm,$age,$plno,$trsa,$mode,$year_wise,$saoption);
                    //$rtn    = $rtn+$trprem;
                    if(!empty($trcheck) && $trcheck == 1) {
                        $rtn = $rtn + $trprem;
                    } else {
                        $rtn = $rtn;
                    }
                
                    //*********** SAVE PREMIUM IN ARRAY
                    $all_prem_in_array = $this->save_in_array($all_prem_in_array,$rtn,$cnt,$mode,"tr_prem",$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$trprem);
                }
                // CALCULATE TR SA END HERE --------------------------
                
                // CALCULATE CIR SA START HERE --------------------------
                if($cirsa > 0 && !empty($ReturnValues['cirsa_table_name'])) {
                    $crprem = $this->calccritprem($ReturnValues,$mterm,$pterm,$age,$plno,$cirsa,$mode,$option,$year_wise);
                    //$rtn    = $rtn+$crprem;
                    if(!empty($circheck) && $circheck == 1) {
                        $rtn = $rtn + $crprem;
                    } else {
                        $rtn = $rtn;
                    }
                    
                    //*********** SAVE PREMIUM IN ARRAY
                    $all_prem_in_array = $this->save_in_array($all_prem_in_array,$rtn,$cnt,$mode,"cir_prem",$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$crprem);
                }
                // CALCULATE CIR SA END HERE --------------------------
                
                // CALCULATE GST START HERE --------------------------
                $rtn = $this->count_gst($ReturnValues['pltype'],$year_wise,$rtn,$plno);
                // CALCULATE GST END HERE --------------------------
            }
            $cnt++;
        }
        
        return $all_prem_in_array;
    }

    public function save_in_array($all_prem_in_array,$rtn,$cnt,$mode,$PremType,$ReturnValues,$year_wise,$plno,$curr_year,$tax_benifit,$bonus,$sa,$dabsa,$trsa,$cirsa,$option,$mterm,$pterm,$age,$waive,$PropAge,$actualPrem = 0) {
        $all_prem_in_array[$cnt][$mode][$PremType] = $actualPrem;
        $all_prem_in_array[$cnt]['curr_year']      = $curr_year;
        $all_prem_in_array[$cnt]['tax_benifit']    = $tax_benifit;
        $all_prem_in_array[$cnt]['bonus']          = $bonus;
        $all_prem_in_array[$cnt]['plno']           = $plno;
        $all_prem_in_array[$cnt]['sa']             = $sa;
        $all_prem_in_array[$cnt]['dabsa']          = $dabsa;
        $all_prem_in_array[$cnt]['trsa']           = $trsa;
        $all_prem_in_array[$cnt]['cirsa']          = $cirsa;
        $all_prem_in_array[$cnt]['option']         = $option;
        $all_prem_in_array[$cnt]['mterm']          = $mterm;
        $all_prem_in_array[$cnt]['pterm']          = $pterm;
        $all_prem_in_array[$cnt]['age']            = $age;
        $all_prem_in_array[$cnt]['waive']          = $waive;
        $all_prem_in_array[$cnt]['PropAge']        = $PropAge;
        $all_prem_in_array[$cnt][$mode]["total_prem"] = $rtn;
        $all_prem_in_array[$cnt][$mode]["GST"] = $this->count_gst($ReturnValues['pltype'],$year_wise,$rtn,$plno) - $rtn;
        $all_prem_in_array[$cnt][$mode]["prem_With_GST"] = $this->count_gst($ReturnValues['pltype'],$year_wise,$rtn,$plno);
        return $all_prem_in_array;
    }

    public function save_presentation_in_array($all_prem_presentation_array,$cnt,$year,$age,$riskCover,$AriskCover,$premium,$tax,$netPremium,$licReturn,$cashVal,$loan,$commLoan,$NetRtn,$plno,$starting_year,$maturity_year) {
        $all_prem_presentation_array[$cnt]['cnt']           = ($cnt+1);
        $all_prem_presentation_array[$cnt]['plno']          = $plno;
        $all_prem_presentation_array[$cnt]['year']          = $year;
        $all_prem_presentation_array[$cnt]['starting_year'] = $starting_year;
        $all_prem_presentation_array[$cnt]['maturity_year'] = $maturity_year;
        $all_prem_presentation_array[$cnt]['age']           = $age;
        $all_prem_presentation_array[$cnt]['riskCover']     = $riskCover;
        $all_prem_presentation_array[$cnt]['AriskCover']    = $AriskCover;
        $all_prem_presentation_array[$cnt]['premium']       = $premium;
        $all_prem_presentation_array[$cnt]['tax']           = $tax;
        $all_prem_presentation_array[$cnt]['netPremium']    = $netPremium;
        $all_prem_presentation_array[$cnt]['licReturn']     = $licReturn;
        $all_prem_presentation_array[$cnt]['cashVal']       = $cashVal;
        $all_prem_presentation_array[$cnt]['loan']          = $loan;
        $all_prem_presentation_array[$cnt]['commLoan']      = $commLoan;
        $all_prem_presentation_array[$cnt]['NetRtn']        = $NetRtn;
        return $all_prem_presentation_array;
    }

    // get rate
    public function getBasicRate($mterm,$pterm,$age,$plno,$rate_table_name) {
        $basic_rate = $this->getValues("rate",$rate_table_name,"mterm='$mterm' AND age='$age'");
        $basic_rate = (array) $basic_rate[0];
        return $basic_rate[0];
    }

    public function Multiply_Prem_AsPer_Mode($mode,$basic_rate,$plno) {
        $premWithoutST = 0;
        $rtn           = 0;
        if ($mode == 'g' || $mode == 'G') {
            $rtn = $basic_rate;
            if ($rtn != 0 || $rtn != 0.0) {
                $SglPremWoTax = $rtn;
            }
        } else {
            $rtn = $basic_rate * $this->Months2Add()[$mode] / 12;
            $rtn = $this->Round_Off($rtn);
        }
        if ($rtn != 0 || $rtn != 0.0) {
            if ($premWithoutST <= 0) {
                $premWithoutST = $rtn;
            }
        }
        
        $this->check_minimum_premium($mode,$plno,$rtn);
        return $rtn;
    }

    public function count_gst($pltype,$year_wise,$Prem,$plno) {
        $tax = 0;
        
        if($pltype == "E" || $pltype == "M" || $pltype == "C") {
            if($year_wise == 1) {
                $tax = $this->getGST();
            } else {
                $tax = $this->getGST2();
            }
        } else if($pltype == "A") {
            $tax = $this->getGSTPension();
        } else if($pltype == "T") {
            $tax = $this->getGSTTermInsu();
        }
        
        $GSTPremium = $this->Round_Prem(($Prem * $tax),$plno);
        
        $rtn = $GSTPremium + $Prem;
        return $rtn;
    }

    public function Months2Add() {
        $d      = array();
        $d['y'] = 12;
        $d['h'] = 6;
        $d['m'] = 1;
        $d['s'] = 1;
        $d['q'] = 3;
        //$d['s'] = 0;
        $d['0'] = 0;
        $d['g'] = 1;
        return $d;
    }

    public function check_minimum_premium($mode,$plan,$rtn) {
        /*if ($mode.equals("Y") || $mode.equals("y") || $mode.equals("yearly")) {
            if ($rtn >= 1 && rtn < 2400) {
                $rtn = 0;
                $subseqprem = rtn;
                $Y_minPrem = true;
                //@@@Global.Flg_Min_Prem = true;
            }
        } else if ($mode.equals("H") || $mode.equals("h") || $mode.equals("half yearly")) {
            if ($rtn >= 1 && $rtn < 1200) {
                $rtn = 0;
                $subseqprem = rtn;
                $H_minPrem = true;
                //@@@Global.Flg_Min_Prem = true;
            }
        }
        // Plan 905
        if ($Y_minPrem == true && $H_minPrem == true) {
            $Flg_Min_Prem_All = true;
        }*/
    }

    public function Round_Off($value) {
        return $value;
    }

    public function Round_Prem($prem,$plan) {
        return intval(round($prem));
    }

    public function Prem_After_ModeDiscount($mode,$prem,$ReturnValues,$isWavier = 0,$isCir = 0) {
        if($isWavier == 1) {
            $mode_dis_value = $ReturnValues[''."mode_dis_wave_".$mode.''];
        } else {
            $mode_dis_value = $ReturnValues[''."mode_dis_".$mode.''];
        }

        if($isCir == 1) {
            if(in_array($ReturnValues['plno'],[833,845,847,848,860,933,945,947,948]) && $mode == 'm') {
                $mode_dis_value = -5;
            }
        }

        if($ReturnValues['plno'] == 859 || $ReturnValues['plno'] == 861 || $ReturnValues['plno'] == 905) {
            $rtn = $prem * (1 + ($mode_dis_value / 100));
        } else if($ReturnValues['plno'] == 147 || $ReturnValues['plno'] == 148) {
            $rtn = $prem * $mode_dis_value / 100;
        } else {
            $rtn = $prem * (1 - ($mode_dis_value / 100));
        }
        return $rtn;
    }

    public function Prem_After_SADiscount($prem,$plno,$sa,$mterm) {
        $ReturnValues = $this->getValues("sa_disc","plan_sa_discount","plno=$plno AND (term=$mterm OR term=0) AND $sa BETWEEN min_sa AND max_sa");
        $ReturnValues = !empty($ReturnValues[0]) ? (array) $ReturnValues[0] : 0;
        $sa_disc      = !empty($ReturnValues['sa_disc']) ? $ReturnValues['sa_disc'] : 0;
        return $prem - $sa_disc;
    }

    public function PremWaiver($age,$PropAge,$pterm,$plno,$ReturnValues,$sa,$perticular_mode) {
        $planTable = !empty($ReturnValues['prem_waiver_plan']) ? $ReturnValues['prem_waiver_plan'] : 0;
        $ReturnValues1 = $this->getValues("prem",$ReturnValues['prem_waiver_table_name'],"def_yrs = ($pterm) and age1 <= $PropAge and age2 >= $PropAge  and plan = ".$planTable."");
        $ReturnValues1 = !empty($ReturnValues1[0]) ? (array) $ReturnValues1[0] : 0;
        $mfactor = !empty($ReturnValues1['prem']) ? $ReturnValues1['prem'] : 0;
        $mfactor = ($mfactor * $sa / 100);
        
        $mfactor = $this->Prem_After_ModeDiscount($perticular_mode,$mfactor,$ReturnValues,1);
        $mfactor = $this->Multiply_Prem_AsPer_Mode($perticular_mode,$mfactor,$plno);
        return $mfactor;
    }

    public function Multiply_Prem($prem,$sa,$plan) {
        return ($prem * ($sa / 1000));
    }

    public function Prem_After_DAB($ReturnValues,$plan,$DAB_SA,$mterm,$pterm,$age,$plno,$perticular_mode,$year_wise,$daboption = 0,$saoption) {
        $dab_rate = 1;
        if(!empty($ReturnValues['dab_rate_table_name'])) {
            if($plan == 833 || $plan == 836 || $plan == 838 || $plan == 933 || $plan == 936 || $plan == 921) {
                $plan = 0;
            }
            if($plan == 861) {
                if($perticular_mode == 'g') {
                    $dab_rate = $this->getValues("dab_rate",'dab_rate',"mterm='$mterm' AND plno='$plan' AND option_value='$saoption' AND mode='G'");
                } else {
                    $dab_rate = $this->getValues("dab_rate",'dab_rate',"mterm='$mterm' AND plno='$plan' AND option_value='$saoption' AND mode='Y'");
                }
                $dab_rate = !empty($dab_rate[0]) ? (array) $dab_rate[0] : 0;
                $dab_rate = !empty($dab_rate['dab_rate']) ? $dab_rate['dab_rate'] : 0;
            } else {
                $dab_rate = $this->getValues("dab_rate",'dab_rate',"mterm='$mterm' AND pterm='$pterm' AND plno='$plan' AND option_value='$daboption'");
                $dab_rate = !empty($dab_rate[0]) ? (array) $dab_rate[0] : 0;
                $dab_rate = !empty($dab_rate['dab_rate']) ? $dab_rate['dab_rate'] : 1;
            }
        }
        if(($plan == 915 || $plan == 845 || $plan == 945 || $plan == 847 || $plan == 947 || $plan == 848 || $plan == 948 || $plan == 860 || $plan == 855) && $daboption == 1) {
            $dab_rate = 0.5;
        }
        if(($plan == 821 || $plan == 921) && $daboption == 1) {
            $dab_rate = 1.15;
        }
        if($plan == 820 || $plan == 920) {
            $dab_rate = 1.20;
        }
        if($plan == 916 && $mterm == 9) {
            $dab_rate = 7.35;
        } else if($plan == 916 && $mterm == 12) {
            $dab_rate = 9.10;
        } else if($plan == 916 && $mterm == 15) {
            $dab_rate = 10.60;
        }
        //@@@
        if($plan == 812 || $plan == 827 || $plan == 843 || $plan == 943 || $plan == 844 || $plan == 944) {
            $dabprem = ($DAB_SA * $dab_rate) / 2000;
        } else {
            $dabprem = ($DAB_SA * $dab_rate) / 1000;
        }
        
        $dabprem = $this->Multiply_Prem_AsPer_Mode($perticular_mode,$dabprem,$plno);
        return $dabprem;
    }

    //@@@calTrPrem
    public function caltrPrem($ReturnValues,$mterm,$pterm,$age,$plno,$trsa,$perticular_mode,$year_wise,$saoption) {
        $planTable = !empty($ReturnValues['trsa_plan']) ? $ReturnValues['trsa_plan'] : 0;
        if($planTable == 845) {
            $mfactor = $this->getValues("prem",''.$ReturnValues['trsa_table_name'].'',"mterm='$pterm' AND age='$age' AND plno=".$planTable."");
        } elseif($planTable == 861) {
            $mfactor = $this->getValues("prem",''.$ReturnValues['trsa_table_name'].'',"mterm='$mterm' AND age='$age' AND plno=".$planTable." AND mode=".$saoption."");
        } else {
            $mfactor = $this->getValues("prem",''.$ReturnValues['trsa_table_name'].'',"mterm='$mterm' AND age='$age' AND plno=".$planTable."");
        }
        $mfactor = !empty($mfactor[0]) ? (array) $mfactor[0] : 0;
        $mfactor = !empty($mfactor['prem']) ? $mfactor['prem'] : 0;
        $mfactor = ($mfactor * $trsa / 1000);
        
        $mfactor = $this->Prem_After_ModeDiscount($perticular_mode,$mfactor,$ReturnValues,0);
        $mfactor = $this->Multiply_Prem_AsPer_Mode($perticular_mode,$mfactor,$plno);
        return $mfactor;
    }

    public function calBasicPrem($ReturnValues,$mterm,$pterm,$age,$plno,$sa,$perticular_mode,$year_wise,$saoption) {
        $where = "";
        if($saoption != 0 && ($plno == 905 || $plno == 861 || $plno == 853 || $plno == 855 || $plno == 934 || $plno == 834)) {
            if($plno == 905) {
                $where = "mterm='$mterm' AND pterm='$pterm' AND age='$age' AND level='$saoption' AND ";
            }
            if($plno == 861) {
                $where = "mterm='$mterm' AND pterm='$saoption' AND age='$age' AND ";
            }
            if($plno == 853) {
                $where = "mterm='$mterm' AND pterm='$pterm' AND age='$age' AND opt='$saoption' AND ";
            }
            if($plno == 855) {
                $where = "mterm='$mterm' AND pterm='$pterm' AND age='$age' AND opt_122='$saoption' AND ";
            }
            if($plno == 934 || $plno == 834) {
                $where = "mterm='$saoption' AND pterm='$saoption' AND age='$age' AND ";
            }
        } else {
            if(empty($ReturnValues['rate_condition'])) {
                $where = "mterm='$mterm' AND pterm='$pterm' AND age='$age' AND ";
            } else {
                $rate_condition = explode(",",$ReturnValues['rate_condition']);
                foreach($rate_condition as $t) {
                    if($t == "mterm") {
                        $where.=" mterm='$mterm' AND ";
                    }
                    if($t == "pterm") {
                        $where.=" pterm='$pterm' AND ";
                    }
                    if($t == "age") {
                        $where.=" age='$age' AND ";
                    }
                }
            }
        }
        
        $where.=" 1=1 ";
        $mfactor = $this->getValues("rate",''.$ReturnValues['rate_table_name'].'',$where);
        $mfactor = !empty($mfactor[0]) ? (array) $mfactor[0] : 0;
        $mfactorRate = !empty($mfactor['rate']) ? $mfactor['rate'] : 0;
        $modeDis = $this->Prem_After_ModeDiscount($perticular_mode,$mfactorRate,$ReturnValues,0);
        $SADis   = $this->Prem_After_SADiscount($modeDis,$plno,$sa,$mterm);
        $mfactor = ($SADis * $sa / 1000);
        
        $mfactor = $this->Multiply_Prem_AsPer_Mode($perticular_mode,$mfactor,$plno);
        return $mfactor;
    }

    //@@@ calcCritPrem
    public function calccritprem($ReturnValues,$mterm,$pterm,$age,$plno,$critsa,$perticular_mode,$opt,$year_wise) {
        $planTable = !empty($ReturnValues['cirsa_plan']) ? $ReturnValues['cirsa_plan'] : 0;
        if(in_array($planTable,[820,821])) {
            $ratex = $this->getValues("rate",''.$ReturnValues['cirsa_table_name'].''," age='$age' AND plan=".$planTable." AND opt='$opt'");
        } elseif($planTable == 845) {
            $ratex = $this->getValues("rate",''.$ReturnValues['cirsa_table_name'].''," age='$age' AND plan=".$planTable." AND opt='$opt' AND pterm='$pterm'");
        } else {
            $ratex = $this->getValues("rate",''.$ReturnValues['cirsa_table_name'].''," age='$age' AND plan=".$planTable." AND opt='$opt' AND mterm='$mterm' AND pterm='$pterm'");
        }
        $ratex = !empty($ratex[0]) ? (array) $ratex[0] : 0;
        $critprem = $critsa * (!empty($ratex['rate']) ? $ratex['rate'] : 0) / 1000;
        $critprem = $this->Prem_After_ModeDiscount($perticular_mode,$critprem,$ReturnValues,0,1);
        $critprem = $this->Multiply_Prem_AsPer_Mode($perticular_mode,$critprem,$plno);
        return $critprem;
    }

    public function YlyPrem($mode,$Prem) {
        $rtn = 0;
        if ($mode == "y")
            $rtn = $Prem;
        else if ($mode == "h")
            $rtn = $Prem * 2;
        else if ($mode == "m" || $mode == "s")
            $rtn = $Prem * 12;
        else if ($mode == "q")
            $rtn = $Prem * 4;
        else if ($mode == "g")
            $rtn = $Prem;
        
        return $rtn;
    }

    public function CalBonus($data,$bonus,$AssumedPaidupYR,$plan,$pterm,$sa,$age,$SAonDeath,$cnt) {
        $xBonusAmt  = "";
        $xGAddRate  = "";
        $xGAddValue = "";
        $xBRate = $bonus;
        if ($xBRate == "0.00" || $xBRate == "0.0" || $xBRate == "0" || $xBRate == "") {
            $xBonusAmt = "0.00";
            $ag_handi  = 0;
            $AsdPAge   = 0;
            $ag_handi  = $AssumedPaidupYR;
            $AsdPAge   = $plan;
            if ($plan == "847" || $plan == "848") {
                if ($ag_handi > 0) {
                    if (($cnt + $AsdPAge) >= ($ag_handi + 1)) {
                        $xGAddRate=0;
                    }
                }
                $xGAddRate = "50";
                if ($cnt > 5) {
                    $xGAddRate = "55";
                }
                $xGAddValue = (($xGAddRate*$sa)/1000.00);
                return $xGAddValue;
            }
        } else {
            if ($plan == "845") {
                if($cnt <= $pterm) {
                    $xBonusAmt = (($xBRate*$SAonDeath)/1000.00);
                }else{
                    $xBRate1   = $xBRate/2;
                    $xBonusAmt = (($xBRate1*$SAonDeath)/1000.00);
                }
            }else {
                $xBonusAmt = (($xBRate*$sa)/1000.00);
            }
            $int_plno = 0;
            $int_plno = ($plan == "") ? "0" : $plan;
            if ($plan == "845") {
                if ($AssumedPaidupYR > 0){
                    if (($cnt + $age) > $AssumedPaidupYR && $cnt <= $pterm) {
                        $xBonusAmt = "0";
                    }
                }
            }
        }
        return $xBonusAmt;
    }

    /*public function cldcMain($str, $str3, $str2) {
        $cnt  = 0;
        $cnt2 = 0;
        $cnt3 = 0;
        if ($str == "")
            $str = "0";
        if ($str2 == "")
            $str2 = "0";
        
        $str  = $str.trim();
        $str3 = $str3.trim();
        $str2 = $str2.trim();
        if ($str3 == "+" || $str3 == "-") {
            if ($str2 == "0" || $str2 == "0.0" || $str2 == "0.00"
                    || $str2 == "0.000" || $str2 == ".0"
                    || $str2 == ".0000")
                return $str;
        }
        if ($str.indexOf('.') != -1)
            $str = RemoveCharLast($str, '0', '.');

        if ($str2.indexOf('.') != -1)
            $str2 = RemoveCharLast($str2, '0', '.');

        if ($str.indexOf('.') == -1)
            $str = $str + ".0";
        if ($str2.indexOf('.') == -1)
            $str2 = $str2 + ".0";

        $cnt  = $str.length() - $str.indexOf('.');
        $cnt2 = $str2.length() - $str2.indexOf('.');

        $rslt  = "";
        $rslt1 = "";
        if ($cnt > $cnt2) {
            if ($str3 == "*")
                $cnt3 = 0;
            else
                $cnt3 = $cnt - $cnt2;
            $rslt  = RemoveDot($str, '.', 0);
            $rslt1 = RemoveDot($str2, '.', $cnt3);
        } else {
            if ($str3 == "*")
                $cnt3 = 0;
            else
                $cnt3 = $cnt2 - $cnt;
            $rslt  = RemoveDot($str, '.', $cnt3);
            $rslt1 = RemoveDot($str2, '.', 0);
        }

        if ($rslt == ""|| $rslt.toLowerCase() == "null") {
            $rslt = "0";
        }
        if ($rslt1 == ""|| $rslt1.toLowerCase() == "null") {
            $rslt1 = "0";
        }
        //@@@ $r1 = Long.parseLong($rslt), $r2 = Long.parseLong($rslt1);
        $r4 = "";
        if ($str3 == "+") {
            $r3 = $r1 + $r2;
            $r4 = String.valueOf($r3);
            if ($cnt > $cnt2)
                $rslt = AddDot($r4, '.', $r4.length() - $cnt);
            else
                $rslt = AddDot($r4, '.', $r4.length() - $cnt2);
        }
        if ($str3 == "-") {
            $r3 = $r1 - $r2;
            $r4 = String.valueOf($r3);
            if ($cnt > $cnt2)
                $rslt = AddDot($r4, '.', $r4.length() - $cnt);
            else
                $rslt = AddDot($r4, '.', $r4.length() - $cnt2);
        }
        if ($str3 == "*") {
            $r3   = $r1 * $r2;
            $r4   = String.valueOf($r3);
            $rslt = AddDot($r4, '.', $r4.length() - ($cnt + $cnt2 - 1));
        }
        if ($str3 == "/") {
            $r1   = $r1 * 10000;
            $r3   = $r1 / $r2;
            $r4   = String.valueOf($r3);
            $rslt = AddDotDiv($r4, '.', $r4.length() - 5);
        }

        return $rslt;
    }*/

    public function getBonus($ReturnValues,$pterm,$mterm,$age,$plno) {
        $bonus_table = (empty($ReturnValues['bonustable'])) ? "bonus" : $ReturnValues['bonustable'];
        
        if($plno == 845) {
            $where = " field1='$plno' and field4<='$pterm' and field5>='$pterm' and field10<='$mterm' and field13>='$mterm'";
        } else {
            $where = " field1='$plno' and field4<='$pterm' and field5>='$pterm'";
        }

        $basic_rate = $this->getValues("*",$bonus_table,$where);
        if(!empty($basic_rate)) {
            $basic_rate = (array) $basic_rate[0];
            return $basic_rate[6];
        }
        return 0;
    }
    
    // Presentation public functionS 
    public function get_presentation($premium_array) {

        $mterm        = $premium_array[0]["mterm"];
        $pterm        = $premium_array[0]["pterm"];
        $age          = $premium_array[0]["age"];
        $sa           = $premium_array[0]["sa"];
        $dabsa        = $premium_array[0]["dabsa"];
        $trsa         = $premium_array[0]["trsa"];
        $cirsa        = $premium_array[0]["cirsa"];
        $tax_benifit  = $premium_array[0]["tax_benifit"];
        $bonus        = $premium_array[0]["bonus"];
        $option       = $premium_array[0]["option"];
        $plno         = $premium_array[0]["plno"];
        $waive        = $premium_array[0]["waive"];
        $PropAge      = $premium_array[0]["PropAge"];
        $current_year = $premium_array[0]["curr_year"];

        if(isset($premium_array[0]["y"])) {
            $basic_prem         = $premium_array[0]["y"]["basic_prem"];
            $basic_premWith_GST = $premium_array[0]["y"]["prem_With_GST"];
        } else if(isset($premium_array[0]["g"])) {
            $basic_premWith_GST = $premium_array[0]["g"]["prem_With_GST"];
            $basic_prem         = $premium_array[0]["g"]["basic_prem"];
        } else if(isset($premium_array[0]["s"])) {
            $basic_premWith_GST = $premium_array[0]["s"]["prem_With_GST"];
            $basic_prem         = $premium_array[0]["s"]["basic_prem"];
        }
        
        
        $maturity_year = $current_year+$mterm;
        $all_prem_presentation_array = array();
        $current_age = $age;
        $cnt = 0;
        
        for($year=$current_year;$year<($maturity_year+1);$year++){
            
            // Risk Cover Start Here********************************************************
            if($cnt > 0)
                $CurrentRiskCovrage_Amount=$CurrentRiskCovrage_Amount+(($sa/1000)*$bonus);
            else
                $CurrentRiskCovrage_Amount=0;
            
            $riskCover  = $CurrentRiskCovrage_Amount+$sa;
            $AriskCover = $riskCover+$dabsa;
            // Risk Cover END Here********************************************************
            
            // Premium Start Here********************************************************
            $premium = round($basic_premWith_GST);
            
            /*$max_tax = (getConstMaxTabSlab() * $tax_benifit / 100);
            if ($tax_benifit * getConstMaxTabSlab() / 100) > $MaxTax) {
                $tax=$max_tax;
            } else {
                $tax = $basic_prem * 
                calMaxTax = calpremium.Fixedround(((Long.parseLong(presentdata.PTAX)) * ConstMaxTabRate / 100), 2);
                TaxSaveAmount = (long) calMaxTax;
            }*/
            
            $tax = round((($basic_prem*$tax_benifit/100)));
            $netPremium = round($basic_premWith_GST-$tax);
            // Premium End Here********************************************************
            
            // get variables based on plan 
            $ReturnValues = $this->getValues("*","plan","plno=$plno");
            $ReturnValues = (array) $ReturnValues[0];

            //echo "<pre>";print_r($sa * $ReturnValues['per1'] / 100);echo "</pre>";exit();
            $licReturn = 0;
            if($ReturnValues['mb'] == 'Yes' && !empty($ReturnValues['year1']) && !empty($ReturnValues['year2']) && !empty($ReturnValues['per1'])) {
                if($cnt == 0) {
                    $licYearCheck  = $ReturnValues['year1'] + $current_year;
                    $licreturnYear = $ReturnValues['year1'];
                }
                if($year > $licYearCheck) {
                    $licYearCheck  = $licYearCheck + $ReturnValues['year2'];
                    $licreturnYear = $licreturnYear + $ReturnValues['year2'];
                }
                if($licYearCheck == $year && $ReturnValues['a_year'] >= $licreturnYear) {
                    $licReturn = $sa * $ReturnValues['per1'] / 100;
                }
            }

            $cashVal   = 0;
            
            if($cnt < 3) {
                $loan = 0;
            } else {
                //$loan = 100;
                //$loan = $this->calloan($premium_array,$ReturnValues,$cnt,$licReturn);
            }
            
            $commLoan = 0;
            $NetRtn   = 0;
            
            // Maturity Year
            if(($year+1) == ($maturity_year+1)) {
                $premium    = 0;
                $tax        = 0;
                $netPremium = 0;
            }
            $all_prem_presentation_array = $this->save_presentation_in_array($all_prem_presentation_array,$cnt,$year,$current_age,$riskCover,$AriskCover,$premium,$tax,$netPremium,$licReturn,$cashVal,$loan,$commLoan,$NetRtn,$plno,$premium_array[0]["curr_year"],$maturity_year);
            $cnt++;
            $current_age++;
        }
        // $all_plan_data[]=$all_prem_presentation_array;
        // $merge_data=$this->merge_presentation($all_plan_data);
        // echo "<pre>";print_r($merge_data);echo "</pre>";exit();
        return $all_prem_presentation_array;
    }
    public function getSurenderValue($ReturnValues,$mterm,$pterm,$age,$plno,$sa,$perticular_mode,$year_wise){

        if($plno == 845) {
            $where = "";
        } else {
            $where = " term=";
        }
        $basic_rate = $this->getValues("*",$ReturnValues['pl841sv'],$where);
    }
    public function merge_presentation($all_plan_data) {
        $get_year   = array();
        $merge_data = array();
        $cnt        = 0;
        for($i=0;$i<sizeof($all_plan_data);$i++) {
            $single_plan = $all_plan_data[$i];
            for($j=0;$j<sizeof($single_plan);$j++) {
                if(array_search($single_plan[$j]['year'], array_column($merge_data, 'year')) !== false) {
                    $pos=array_search($single_plan[$j]['year'], array_column($merge_data, 'year'));
                    $merge_data[$pos]['riskCover']  = $merge_data[$pos]['riskCover']+$single_plan[$j]['riskCover']; 
                    $merge_data[$pos]['AriskCover'] = $merge_data[$pos]['AriskCover']+$single_plan[$j]['AriskCover']; 
                    $merge_data[$pos]['premium']    = $merge_data[$pos]['premium']+$single_plan[$j]['premium']; 
                    $merge_data[$pos]['tax']        = $merge_data[$pos]['tax']+$single_plan[$j]['tax']; 
                    $merge_data[$pos]['netPremium'] = $merge_data[$pos]['netPremium']+$single_plan[$j]['netPremium']; 
                    $merge_data[$pos]['licReturn']  = $merge_data[$pos]['licReturn']+$single_plan[$j]['licReturn']; 
                    $merge_data[$pos]['cashVal']    = $merge_data[$pos]['cashVal']+$single_plan[$j]['cashVal'];  
                    $merge_data[$pos]['loan']       = $merge_data[$pos]['loan']+$single_plan[$j]['loan']; 
                    $merge_data[$pos]['commLoan']   = $merge_data[$pos]['commLoan']+$single_plan[$j]['commLoan']; 
                    $merge_data[$pos]['NetRtn']     = $merge_data[$pos]['NetRtn']+$single_plan[$j]['NetRtn']; 
                } else {
                    $merge_data[] = $single_plan[$j];
                }
            }
        }
        //usort($merge_data, 'compareByYear');
        $cnt = 0;
        $prev_cum_val = 0;
        foreach($merge_data as $perticular_year_data) {
            $prev_cum_val = $perticular_year_data['loan']+$prev_cum_val;  
            $merge_data[$cnt]['commLoan'] = $prev_cum_val;
            $cnt++;
        }
        return $merge_data;
    }

    public function compareByYear($a, $b) {
        return strcmp($a["year"], $b["year"]);
    }

    // Calculate loan
    public function calloan($premium_array,$ReturnValues,$yearcount,$TotMBReturnIRDA) {
        //echo "<pre>";print_r($premium_array);echo "</pre>";exit();
        //$yearcount      = $yearcount + 1;
        $plno           = $premium_array[0]["plno"];
        $term           = $premium_array[0]["mterm"];
        $pterm          = $premium_array[0]["pterm"];
        $age            = $premium_array[0]["age"];
        $svfact         = 0;
        $svfact1        = 0;
        $TotBasic_Prem  = $premium_array[0]["y"]["basic_prem"] * $yearcount;
        $loanYear       = 3;

        // GSV PROCESS ----------------------------------
        $gsv_rate = $this->getValues($ReturnValues['gsv_rate_field_name'],$ReturnValues['gsv_table_name'],"term='".$term."' And year='".$yearcount."' And PLNO='".$plno."'");
        $gsv_rate = !empty($gsv_rate[0]) ? $gsv_rate[0]->gsv_rate : 0;

        if ($gsv_rate > 0) {
            $svfact = $gsv_rate;
        }

        // if($yearcount == 1 && ($plno == 848 || $plno == 948 || $plno == 860)) {
        //     $svfact = 0;
        // }
        // if($plno == 847 || $plno == 947 || $plno == 848 || $plno == 948 || $plno == 860) {
        //     $svfact = ($TotBasic_Prem * $svfact) - $TotMBReturnIRDA;
        // }

        if($svfact > 0) {
            $GSV_IRDAGtd = $svfact;
        } else {
            $GSV_IRDAGtd = 0;
        }
        $svfact      = $TotBasic_Prem * $svfact;
        $GSV_IRDAGtd = $svfact;

        // SV PROCESS ----------------------------------
        $sv_rate = $this->getValues($ReturnValues['sv_rate_field_name'],$ReturnValues['sv_table_name'],"term='".$term."' And year='".$yearcount."' And PLNO='".$plno."'");
        $Sv_Rate=$sv_rate[0]->sv_rate;
        //echo $Sv_Rate;
        if ($Sv_Rate > 0) {
            $svfact1 = $Sv_Rate;
        }
        echo "<pre>";print_r($svfact1);echo "</pre>";exit();
        //setBonus and calBonus function
        //$bonus = $this->getBonus($ReturnValues,$pterm,$term,$age,$plno);

        if($ConstBonusYear = "Yes") { //ConstBonusYear = "Yes"
            $gsv            = $svfact + ($svfact1 * $TotalBonus);
            $GSV_IRDA4Per   = $svfact1 * $TotalBonusIRDA4Per;
            $GSV_IRDA8Per   = $svfact1 * $TotalBonusIRDA8Per;
        } else {
            $gsv            = $svfact + ($svfact1 * $prevTotalBonus);
            $GSV_IRDA4Per   = $svfact1 * $prevTotalBonusIRDA4Per;
            $GSV_IRDA8Per   = $svfact1 * $prevTotalBonusIRDA8Per; 
        }

        if($yearcount >= $loanYear) {
            if(in_array($plno,[812,818])) {
                $tbonus1 = $bonus_GA - $PrevAddBonusValue;
            } else {
                if ($ConstBonusYear = "Yes") {
                    $tbonus1 = $TotalBonus;
                    $tGadd1  = $GAddTotal;
                } else {
                    $tbonus1 = $prevTotalBonus;
                    $tGadd1  = $GAddTotalPrev;
                }
            }
        } else {
            $tbonus1 = 0;
            if(!in_array($plno,[186,808,809,813,817,917,8,826,831,837,846,847,947,848,948,860])) {
                if($yearcount <= 1) {
                    $PLANsurrvalue = 0;
                }
            }
        }

        if($mode != 'g') {
            if($plno == 186) {
                $paidup=(($yearcount+$Counter)*$totpaidprem/$MTERM) + $tbonus1;
            } else if($plno == 5) {
                $paidup=(($yearcount+$Counter)*$BASICSA/$PTERM) + $tbonus1;
            } else if(in_array($plno,[847,947,848,948,860])) {
                $paidup=(($yearcount+$Counter)*$BASICSA/$PTERM) - $TotMBReturnLoan;
            } else if(in_array($plno,[820,920, 832,932,834,934])) {
                $paidup=(($yearcount+$Counter)*$BASICSA/$PTERM) - $TotMBReturnLoan;
            } else {
                $paidup=(($yearcount+$Counter)*$BASICSA/$MTERM) + $tbonus1;
            }
        } else {
            $paidup = (1 * $BASICSA / $PTERM) + $tbonus1;
        }

        
        /*
        OTHERWISE
        =open('surval1a')
            IF this.mterm > 57
                fld2='t'+iif(this.mterm<10,'0'+allt(str(this.mterm)),str(57,2))
            ELSE
                fld2='t'+iif(this.mterm<10,'0'+allt(str(this.mterm)),str(this.mterm,2))         
            ENDIF
            loca for duration=this.yearcount
            if foun()
                If Vartype(&fld2)="N"
                    svfact=&fld2
                ELSE
                    svfact=0
                Endif
            ENDIF
        */

        /*
            CASE INLIST(this.plno,814,914)
                If gsv>sv
                    sv=gsv
                Endif 
                IF THIS.YEARcount <= (m.nLoanYear-1)    && DUE TO ONLY REGULAR PREMIUM
                    SV = 0
                ENDIF
                DO case
                CASE this.mterm <= 23
                    tloan = sv * 0.90   && for inforce
                CASE BETWEEN(this.mterm, 24, 27)
                    tloan = sv * 0.80   && for inforce
                CASE BETWEEN(this.mterm, 28, 31)        
                    tloan = sv * 0.70   && for inforce
                CASE this.mterm >= 32   && (32 to 35)
                    tloan = sv * 0.60   && for inforce
                    =SaveTime("tloan in case of >= 32 "+TRANSFORM(tloan))                                   
                ENDCASE
                tLoan = mRound(tLoan,250)
            OTHERWISE 
                tloan=sv*.90
                tLoan = mRound(tLoan,250)   && 01/03/2012.rht
            ENDCASE


            this.NewLoanAmt = tloan - this.TotLoanAmt
            IF this.NewLoanAmt < 0
                this.NewLoanAmt = 0
            ENDIF 
            this.TotLoanAmt = tloan
            IF this.calccashvalue = .t.
                this.PlanSurrValue = sv
            ENDIF
            IF INLIST(THIS.PLNO, 807, 812,818)
                this.OldNewLoanAmt = this.NewLoanAmt
                this.OldTotLoanAmt = this.TotLoanAmt
                STORE 0 TO this.NewLoanAmt,this.TotLoanAmt
            ENDIF
        */

        // SV PROCESS ----------------------------------
        $sv_rate = $this->getValues($ReturnValues['sv_rate_field_name'],$ReturnValues['sv_table_name'],"term='".$term."' And year='".$yearcount."' And PLNO='".$plno."'");
        // if(isset($sv_rate->fetch_array()["".$ReturnValues['sv_rate_field_name'].""]))
        //     $Sv_Rate=$sv_rate->fetch_array()["".$ReturnValues['sv_rate_field_name'].""];
        // else
        //     $Sv_Rate=0;
        $Sv_Rate=$sv_rate[0]->sv_rate;
        //echo $Sv_Rate;
        if ($Sv_Rate > 0) {
            $svfact1 = $Sv_Rate;
        }

        
        return $bonus;
        // if (Global.ConstBonusYear.equalsIgnoreCase("Yes")) {
        //     $gsv = $svfact + ($svfact1 * $TotalBonus);
        //     $GSV_IRDA4Per = $svfact1 * $TotalBonusIRDA4Per;
        //     $GSV_IRDA8Per = $svfact1 * $TotalBonusIRDA8Per;
        // } else {
        //     $gsv = $svfact + ($svfact1 * $prevTotalBonus);
        //     $GSV_IRDA4Per = $svfact1 * $prevTotalBonusIRDA4Per;
        //     $GSV_IRDA8Per = $svfact1 * $prevTotalBonusIRDA8Per;
        // }

         // $paidup = ((($yearcount + $Counter) * $basicsa / $mterm) + $tbonus1);

        exit;
    }
    
    ///////////////COMMON public functionS
    public function getValues($fieldsName,$tableName,$Where="1=1",$print=false) {
        if(empty($Where)) {
            $Where = "1=1";
        }
        if($print) {
            $data = DB::connection('lifecell')->select("SELECT $fieldsName FROM $tableName WHERE $Where");
            echo $data;
        }
        $data = DB::connection('lifecell')->select("SELECT $fieldsName FROM $tableName WHERE $Where");
        return $data;
    }

    public function getGSTPension() {
        return $this->GST_pension;
    }

    public function getGSTTermInsu() {
        return $this->GSTTermInsu;
    }

    public function getGST() {
        return $this->GST;
    }

    public function getGST2() {
        return $this->GST2;
    }

    public function getConstMaxTabSlab() {
        return $this->ConstMaxTabSlab;
    }

    public function FABCalculation($ReturnValues,$plan,$mterm,$pterm,$age, $cnt, $DSA) {
        $Fab        = 0;
        $term       = 0; 
        $ppt        = 0;
        $d          = 0;
        $am[]       = null;
        $xMatAmt    = "";
        $xABonusAmt = "0";
        $xMTerm     = "0";
        $xMTerm_old = "0";
        $xPPT       = "0";
        $xBonusAmt  = "";
        $xPremium   = "0";
        $xpaidpr    = "0";
        $xtmpTerm   = ""; 
        $filename   = "";
        $xTmpMTerm  = 0;
        $nPLNo      = $plan;
        $xMTerm_old = $mterm;
        $xMTerm     = $cnt;
        $xPPT       = $pterm;
        if ($nPLNo == 184 || $nPLNo == 185 || $nPLNo == 41 || $nPLNo == 50
                || $nPLNo == 102 || $nPLNo == 845) {
            // d = Integer.parseInt(xMTerm)-Integer.parseInt(xAge);

            if ($nPLNo == 184) {
                if ($pterm == "6") {
                    $d = $xMTerm - 5;
                    $xtmpTerm = $d;
                } else {
                    $d = $pterm;// -Integer.parseInt(xAge);
                    $xtmpTerm = $d;
                }
                //am = Bonus_Factor(nPLNo, Integer.parseInt(xtmpTerm),
                //        Integer.parseInt(data.PLAN_SA), xPremium, "bonus", 11);
                $am = $this->getBonus($ReturnValues,$xtmpTerm,$xtmpTerm,0,$nPLNo);
            }
            if ($nPLNo == 41) {
                $d = $xMTerm - (21 - $data.PLAN_AGE);
                //am = Bonus_Factor(nPLNo, d, Integer.parseInt(data.PLAN_SA),
                //        xPremium, "bonus", 11);
                $am = $this->getBonus($ReturnValues,$d,$d,0,$nPLNo);
            }
            if ($nPLNo == 185 || $nPLNo == 50 || $nPLNo == 102)
                //am = Bonus_Factor(nPLNo, Integer.parseInt(xMTerm),
                //        Integer.parseInt(data.PLAN_SA), xPremium, "bonus", 11);
                $am = $this->getBonus($ReturnValues,$xMTerm,$xMTerm,0,$nPLNo);

            if (nPLNo == 845)
                //am = Bonus_Factor845(nPLNo, Integer.parseInt(xMTerm_old),
                //        Integer.parseInt(data.PLAN_SA), xPremium, "bonus", 11, Integer.parseInt(data.PLAN_PPT));
                $am = $this->getBonus($ReturnValues,$xMTerm_old,$pterm,0,$nPLNo);

        } else
            //am = Bonus_Factor(nPLNo, Integer.parseInt(xMTerm),
            //        Integer.parseInt(data.PLAN_SA), xPremium, "bonus", 11);
            $am = $this->getBonus($ReturnValues,$xMTerm,$xMTerm,0,$nPLNo);

        if ($am == null) {
            $Fab = 0;
            return $Fab;
        }
        $xABYN = $am[10].trim();
        $xMBYN = $am[11].trim();
        if ($xABYN.equals("Y") && $nPLNo != 165) {
            //832 is children money backplan,fab is used for endowment plan
            if ($xMBYN == "Y" && $nPLNo != 832) {
                if ($nPLNo == 845) {
                    $bfld = "";
                    $abonusrate = "";
                    $plno;
                    $term = $xMTerm;
                    $ppt = $pterm;
                    $plno = $nPLNo;

                    $basicSA = 0;
                    $basicSA = $DSA;

                    if ($basicSA <= 25000) {
                        //bfld = "a25000";
                        $bfld = $this->GetABonusRate($term, "a25000");

                    } else if (basicSA >= 25001 && basicSA <= 50000) {
                        //  bfld = "a50000";
                        $bfld = $this->GetABonusRate($term, "a50000");
                    } else if (basicSA >= 50001 && basicSA <= 199999) {
                        //  bfld = "a199999";
                        $bfld = $this->GetABonusRate($term, "a199999");
                    } else if (basicSA >= 200000 && basicSA <= 499999) {
                        //  bfld = "a499999";
                        $bfld = $this->GetABonusRate($term, "a499999");
                    } else if (basicSA >= 500000) {
                        // bfld = "a5000000";
                        $bfld = $this->GetABonusRate($term, "a500000");
                    }
                    if ($bfld != null || (!$bfld=="")) {
                        $abonusrate = $bfld;
                    }
                    $xABonusAmt = $abonusrate*$basicSA;
                    $xABonusAmt = $this->cldcMain($xABonusAmt, "/", "1000.00");
                    $xABonusAmt = $xABonusAmt;

                } else {

                    if ($xMTerm > 25)
                        $xMTerm = "25";
                    switch (nPLNo) {
                        case 106:
                        case 107:
                        case 108:

                            $xABonusAmt = AddBonus_Factor($nPLNo,
                                    $xMTerm,
                                    $data.PLAN_SA, "0", "mabonus1", 5,
                                    $xpaidpr);
                            break;
                        default:

                            $xABonusAmt = AddBonus_Factor($nPLNo,
                                    $xMTerm,
                                    $data.PLAN_SA, "0", "mabonus", 5,
                                    $xpaidpr);
                            break;
                    }
                }

            } else {
                switch (nPLNo) {
                    case 41:
                        $xMTerm = ($xMTerm - (21 - $data.PLAN_AGE));
                        break;

                    case 50:
                        break;

                    default:
                        if ($xMTerm > 40)
                            $xMTerm = "40";
                        break;
                }
                $filename = "abonus";
                switch ($nPLNo) {
                    case 186:
                        $xABonusAmt = AddBonus_Factor($nPLNo,$xMTerm,$xpaidpr,"0",$filename, 5,$xpaidpr);
                    default:
                        $xABonusAmt = AddBonus_Factor(nPLNo,$xMTerm,$data.PLAN_SA, "0", $filename, 5,$xpaidpr);
                }
                $xABonusAmt = Round($xABonusAmt, 0);
            }

            if ($xABonusAmt=="" || $xABonusAmt=="0") {
                $Fab = Round("0", 0);
            } else {
                $Fab = Round($xABonusAmt, 0);
            }

        } else {
            $Fab = 0;
        }
        return $Fab;
    }
   
    public function GetABonusRate($term,$bfield) {
        return $basic_rate = $this->getValues($bfield,$bonus_table,"plno='845' and term ='".$term."'");
    }

    public function sendSmsNew($data) {
        
        $url = "http://2factor.in/API/V1/fb5fd35d-eab0-11eb-8089-0200cd936042/SMS/".$data['MobileNumber']."/".$data['otp']."/OTPVerify";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response,true);
    }
}


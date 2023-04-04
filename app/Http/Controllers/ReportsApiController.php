<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LifeCellUsers\ServicingReports;
use App\Models\LifeCellLic\SetupMarketingReports;
use App\Models\LifeCellLic\SetupServicingReports;
use App\Models\LifeCellLic\SetupPlan;
use App\Models\LifeCellLic\SetupReminder;
use App\Models\LifeCellLic\SetupGSTRate;
use App\Models\LifeCellLic\Party;
use App\Models\LifeCellLic\Agency;
use App\Models\LifeCellLic\Policy;
use App\Models\LifeCell\Plan;
use App\Models\LifeCellLic\Vehicles;
use App\Models\LifeCellLic\Surveryors;
use App\Models\LifeCellLic\Branch;
use App\Models\LifeCellLic\Tpahospital;
use App\Models\LifeCellLic\TPA;

use DB;
use App\Models\LifeCellLic\GiPolicy;

class ReportsApiController extends Controller
{
    public function getServicingReports(Request $request) {
    	
        if(!empty($request['id'])) {
            $data = ServicingReports::where('id',$request['id'])->first();
        } else {
            $data = ServicingReports::orderBy('id')->get();
        }
		return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveServicingReports(Request $request) {
    	
        $postData = $request->All();
        $data     = ServicingReports::saveServicingReportsData($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteServicingReports(Request $request) {
    	
        $postData    = $request->All();
        $reports     = ServicingReports::where('id',$postData['id'])->first();
        
    	if(!empty($reports)) {
    		$reports->delete();
    		return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
    	} else {
    		return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
    	}
    }

    public function getMarketingSetupReports(Request $request) {
        
        if(!empty($request['id'])) {
            $data = SetupMarketingReports::where('id',$request['id'])->where('client_id',$request['client_id'])->first();
        }
        
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveMarketingSetupReports(Request $request) {
        
        $postData = $request->All();
        $data     = SetupMarketingReports::saveMarketingReport($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function getServicingSetupReports(Request $request) {
        
        if(!empty($request['id'])) {
            $data = SetupServicingReports::where('id',$request['id'])->where('client_id',$request['client_id'])->first();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveServicingSetupReports(Request $request) {
        
        $postData = $request->All();
        $data     = SetupServicingReports::saveServicingReport($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function getPlanSetup(Request $request) {
        
        if(!empty($request['id'])) {
            $data = SetupPlan::where('id',$request['id'])->where('client_id',$request['client_id'])->first();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function savePlanSetup(Request $request) {
        
        $postData = $request->All();
        $data     = SetupPlan::savePlanSetup($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function getReminderSetup(Request $request) {
        
        if(!empty($request['id'])) {
            $data = SetupReminder::where('id',$request['id'])->where('client_id',$request['client_id'])->first();
        }

        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveReminderSetup(Request $request) {
        
        $postData = $request->All();
        $data     = SetupReminder::saveReminderSetupData($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function getGSTRateSetup(Request $request) {
        
        if(!empty($request['id'])) {
            $data = SetupGSTRate::where('id',$request['id'])->where('client_id',$request['client_id'])->first();
        } else {
            $data = SetupGSTRate::where('client_id',$request['client_id'])->get();
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function saveGSTRateSetup(Request $request) {
        
        $postData = $request->All();
        $data     = SetupGSTRate::saveGSTRateSetup($postData);

        if(!empty($postData['id'])) {
            return response()->json(["success" => 1, "msg" => "Record Updated Successfully!","data"=>$data]);
        } else {
            return response()->json(["success" => 1, "msg" => "Record inserted Successfully!","data"=>$data]);
        }
    }

    public function deleteGSTRateSetup(Request $request) {
        
        $postData    = $request->All();
        $gst         = SetupGSTRate::where('id',$postData['id'])->first();
        
        if(!empty($gst)) {
            $gst->delete();
            return response()->json(["success" => 1, "msg" => "Record deleted Successfully!","data"=>[]]);
        } else {
            return response()->json(["success" => 0, "msg" => "The id is not valid.","data"=>[]]);
        }
    }
    public function getReportsDatas(Request $request) {
        $data = [];
        $para = $request->all();
        $start  = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('Y-m-d') : NULL;
        $end    = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('Y-m-d') : NULL;
        if(!empty($request['id'])) {
            if($request['id'] == 2) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->whereBetween('FUPDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->where('FUPDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->where('FUPDATE',"<=",$end); 
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->orderBy('PONO','DESC')->get();
            } else if($request['id'] == 5) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE')->whereBetween('FUPDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE')->where('FUPDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE')->where('FUPDATE',"<=",$end); 
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->orderBy('PONO','DESC')->get();
            } else if($request['id'] == 9) {				
				$city    		 = !empty($para['param2']) ? $para['param2'] : NULL;
                $area   		 = !empty($para['param1']) ? $para['param1'] : NULL;
				$ABD    		 = \DB::raw('DATE_FORMAT(ABD,"%m-%d")');
				$where 			 = 'WHERE 1 = 1 ';
				if(!empty($start) && !empty($end))
				{
					$where 		.= " &&  (DATE_FORMAT(ABD, '%c-%d') BETWEEN DATE_FORMAT('$start', '%c-%d') AND DATE_FORMAT('$end', '%c-%d') OR (MONTH('$start') > MONTH('$end') AND (MONTH(ABD) >= MONTH('$start') OR MONTH(ABD) <= MONTH('$end'))))";
					// $where 		.= " &&  (MONTH(ABD) BETWEEN MONTH('$start') AND MONTH('$end'))";
				}
				else if(!empty($start))
				{
					$starta  	 = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('m-d') : NULL;
                    $where   	.= " &&  $ABD = $starta";
                }
				else if(!empty($end))
				{
					$enda    	 = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('m-d') : NULL;
                    $where   	.= " &&  $ABD <= $enda";
                }
				
				if(!empty($city))
				{
					$where   .= " &&  FIND_IN_SET(CITYID,'$city')";
				}
				
				if(!empty($area))
				{
					$where   .= " &&  FIND_IN_SET(ARECD,'$area')";
				}
				
				$qry 		= "SELECT GCODE, NAME, BD, ABD, WDT, MOBILE FROM party $where && client_id = '".$request['client_id']."'";
				$dts 		= \DB::connection('lifecell_lic')->select($qry);
				$data 		= array();
				$i 			= 0;
				foreach($dts as $rw)
				{
					foreach($rw as $k=>$v)
					{
						$data[$i][$k]	= $v;
					}
					$i++;
				}
				
			} else if($request['id'] == 10) {
				$city    		 = !empty($para['param2']) ? $para['param2'] : NULL;
                $area   		 = !empty($para['param1']) ? $para['param1'] : NULL;
				$WDT    		 = \DB::raw('DATE_FORMAT(WDT,"%m-%d")');
				$where 			 = 'WHERE 1 = 1 ';
				if(!empty($start) && !empty($end))
				{
					$where 		.= " &&  (DATE_FORMAT(WDT, '%c-%d') BETWEEN DATE_FORMAT('$start', '%c-%d') AND DATE_FORMAT('$end', '%c-%d') OR (MONTH('$start') > MONTH('$end') AND (MONTH(WDT) >= MONTH('$start') OR MONTH(WDT) <= MONTH('$end'))))";
					// $where 		.= " &&  (MONTH(WDT) BETWEEN MONTH('$start') AND MONTH('$end'))";
				}
				else if(!empty($start))
				{
					$starta  	 = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('m-d') : NULL;
                    $where   	.= " &&  $WDT = $start";
                }
				else if(!empty($end))
				{
					$start  	 = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('m-d') : NULL;
					$end    	 = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('m-d') : NULL;
                    $where   	.= " &&  $WDT <= $end";
                }
				
				if(!empty($city))
				{
					$where   .= " &&  FIND_IN_SET(CITYID,'$city')";
					
				}
				
				if(!empty($area))
				{
					$where   .= " &&  FIND_IN_SET(ARECD,'$area')";
				}
				
				$qry 		= "SELECT GCODE, NAME, BD, ABD, WDT, MOBILE FROM party $where && client_id = '".$request['client_id']."'";
				$dts 		= \DB::connection('lifecell_lic')->select($qry);
				$data 		= array();
				$i 			= 0;
				foreach($dts as $rw)
				{
					foreach($rw as $k=>$v)
					{
						$data[$i][$k]	= $v;
					}
					$i++;
				}
			}
            
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }
    public function getReportsData(Request $request) {
        $data = [];
        info("***************************************");
        info("***************************************");
        info("***************************************");
        info("***************************************");
        info("***************************************");
        $para = $request->all();
        $start  = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('Y-m-d') : NULL;
        $end    = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('Y-m-d') : NULL;
        if(!empty($request['id'])) {
            if($request['id'] == 1) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('RDT',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('RDT',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('RDT',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 2) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->whereBetween('FUPDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->where('FUPDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','ECS_MODE')->where('FUPDATE',"<=",$end); 
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->orderBy('PONO','DESC')->get();
            } else if($request['id'] == 3) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','LASTPREM')->whereBetween('LASTPREM',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','LASTPREM')->where('LASTPREM',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','LASTPREM')->where('LASTPREM',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 4) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 5) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','BRANCH')->whereBetween('FUPDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','BRANCH')->where('FUPDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','FUPDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','MATDATE','BRANCH')->where('FUPDATE',"<=",$end); 
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->orderBy('PONO','DESC')->get();
            } else if($request['id'] == 6) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 7) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 8) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 9) {
                $start  = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('m-d') : NULL;
                $end    = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('m-d') : NULL;
                $ABD    = \DB::raw('DATE_FORMAT(ABD,"%m-%d")');
                if(!empty($start) && !empty($end)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->whereBetween($ABD,[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->where($ABD,$start);
                } else if(!empty($end)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->where($ABD,"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('GCODE',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();

            } else if($request['id'] == 10) {
                $start  = !empty($para['from_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['from_date'])->format('m-d') : NULL;
                $end    = !empty($para['to_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $para['to_date'])->format('m-d') : NULL;
                $WDT    = \DB::raw('DATE_FORMAT(WDT,"%m-%d")');
                if(!empty($start) && !empty($end)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->whereBetween($WDT,[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->where($WDT,$start);
                } else if(!empty($end)) {
                    $data   = Party::select('GCODE','NAME','BD','ABD','WDT','MOBILE')->where($WDT,"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('GCODE',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 12) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 13) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 14) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            } else if($request['id'] == 15) {
                if(!empty($start) && !empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->whereBetween('MATDATE',[$start, $end]);
                } else if(!empty($start)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',$start);
                } else if(!empty($end)) {
                    $data   = Policy::select('PUNIQID','PONO','RDT','PLAN','MODE','PREM','MATDATE','AGCODE','NAME1','AFILE','SA','MTERM','TERM','BCODE','FUPDATE')->where('MATDATE',"<=",$end);
                }
                if(!empty($request['idss'])) {
                    $data = $data->whereIn('PUNIQID',$request['idss']);
                }
                $data = $data->where('client_id',$request['client_id'])->get();
            }
            else if($request['id'] == 16) {
                $query = GiPolicy::select('id','PartyName','PolicyNo','IsurerName','IsurerProductName','RiskDate','RiskExpDate','SumAssured','NetPremium','Premium');
                if(!empty($start) && !empty($end)) {
                    $query->whereBetween('RiskDate',[$start, $end]);
                } else if(!empty($start)) {
                   $query->where('RiskDate',$start);
                } else if(!empty($end)) {
                   $query->where('RiskDate',$end);
                }
                if(!empty($request["agency"])) {
                   $query->whereIn('AgancyId',$request["agency"]);
                }
                if(!empty($request["family_group"])) {

                }
                if(!empty($request["area"])) {

                }
                if(!empty($request["city"])) {

                }
                $data = $query->get();
            }
            else if($request['id'] == 17) {
                $query = GiPolicy::select('id','PartyName','PolicyNo','IsurerName','IsurerProductName','RiskDate','RiskExpDate','SumAssured','NetPremium','Premium');
                if(!empty($start) && !empty($end)) {
                    $query->whereBetween('RiskDate',[$start, $end]);
                } else if(!empty($start)) {
                   $query->where('RiskDate',$start);
                } else if(!empty($end)) {
                   $query->where('RiskDate',$end);
                }
                if(!empty($request["agency"])) {
                   $query->whereIn('AgancyId',$request["agency"]);
                }
                if(!empty($request["family_group"])) {

                }
                if(!empty($request["area"])) {

                }
                if(!empty($request["city"])) {

                }
                $data = $data->get();
            }
            else if($request['id'] == 18) {
                $data = Surveryors::select('surveryors.ID','NAME','AD1','AD2','AD3','city.CITY','PIN','PHONE_O','FAX','EMAIL','surveryors.client_id')->leftjoin("city","city.CITYID","surveryors.CITYID")
                ->where("surveryors.is_delete",0)
                ->where('surveryors.client_id',$request['client_id'])
                ->oldest("NAME")
                ->get();
            }
             else if($request['id'] == 19) {
                $query = Vehicles::select('vehicles.ID','vehicles.NAME','type_of_body.TYPE_BODY','type_vehicle.TYPE_VEHICLE','vehicle_make.VEHICLE_MAKE')
                    ->leftjoin("type_of_body","type_of_body.ID","vehicles.TYPE_BODY")
                    ->leftjoin("type_vehicle","type_vehicle.ID","vehicles.TYPE_VEHICLE")
                    ->leftjoin("vehicle_make","vehicle_make.ID","vehicles.VEHICLE_MAKE")
                    ->where("vehicles.is_delete",0);
                if(!empty($start) && !empty($end)) {
                    $query->whereBetween('vehicles.created_at',[$start, $end]);
                } else if(!empty($start)) {
                   $query->where('vehicles.created_at',$start);
                } else if(!empty($end)) {
                   $query->where('vehicles.created_at',$end);
                }
                if(!empty($request["vehicles"])) {
                   $query->whereIn('vehicles.ID',$request["vehicles"]);
                }
                if(!empty($request["type_vehicle"])) {
                   $query->whereIn('vehicles.TYPE_VEHICLE',$request["type_vehicle"]);
                }
                if(!empty($request["type_of_body"])) {
                   $query->whereIn('vehicles.TYPE_BODY',$request["type_of_body"]);
                }
                 if(!empty($request["vehicle_make"])) {
                   $query->whereIn('vehicles.VEHICLE_MAKE',$request["vehicle_make"]);
                }
                $data = $query->where('vehicles.client_id',$request['client_id'])
                                        ->oldest("vehicles.NAME")
                                        ->get();
            }
            else if($request['id'] == 20) {
                $query = Branch::select('branch.BCODE','BRANCH','city.CITY','AD1','AD2','AD3','ADDRESS','PIN','PHONE_O','BRANCHNM','BR_MGR_NM')->leftjoin("city","city.CITYID","branch.CITYID")
                ->where("branch.is_delete",0)
                ->where('branch.client_id',$request['client_id']);
                if(!empty($request["branch"])) {
                   $query->whereIn('branch.BCODE',$request["branch"]);
                }
                if(!empty($request["city"])) {
                   $query->whereIn('branch.CITYID',$request["city"]);
                }
                if(!empty($request["sorting_option"])) {
                    if($request["sorting_option"]=="Branch Wise"){
                        $query->oldest('BRANCH');      
                    }
                    else if($request["sorting_option"]=="City Wise"){
                        $query->oldest('city.CITY');      
                    }
                    else if($request["sorting_option"]=="Insurer Name Wise"){

                    }
                }
                $data = $query->get();
            }
            else if($request['id'] == 21) {
                $query = Tpahospital::select('tpahospital.ID','NAME','AD1','AD2','AD3','city.CITY','PIN','PHONE_O','FAX','tpahospital.is_delete')
                ->leftjoin("city","city.CITYID","tpahospital.CITYID")
                ->where("tpahospital.is_delete",0)
                ->where('tpahospital.client_id',$request['client_id']);
                if(!empty($request["tpahospital"])) {
                   $query->whereIn('tpahospital.ID',$request["tpahospital"]);
                }
                if(!empty($request["city"])) {
                   $query->whereIn('tpahospital.CITYID',$request["city"]);
                }
                $query->oldest("tpahospital.NAME");
                $data = $query->get();
            }
            else if($request['id'] == 22) {
                $query = TPA::select('tpa.ID','NAME','AD1','AD2','AD3','city.CITY','PIN','PHONE_O','FAX','tpa.is_delete')
                ->leftjoin("city","city.CITYID","tpa.CITYID")
                ->where("tpa.is_delete",0)
                ->where('tpa.client_id',$request['client_id']);
                if(!empty($request["tpa"])) {
                   $query->whereIn('tpa.ID',$request["tpa"]);
                }
                if(!empty($request["city"])) {
                   $query->whereIn('tpa.CITYID',$request["city"]);
                }
                $query->oldest("tpa.NAME");
                $data = $query->get();
                info(\DB::getQueryLog());
            }
            else if($request['id'] == 23) {
                $query = Party::select("city.CITY","party.GCODE","party.NAME","party.AD","party.AD1",
                "party.AD2","party.AD3","party.MOBILE","party.CITYID")
                ->leftjoin("city","city.CITYID","party.CITYID");
                if(!empty($request["city"])) {
                   $query->whereIn('party.CITYID',$request["city"]);
                }
                $query->oldest("party.NAME");
                $data = $query->get();
            }
            else if($request['id'] == 24) {
                DB::enableQueryLog();

                 $query = GiPolicy::select('id','PartyName','PolicyNo','IsurerName','IsurerProductName','RiskDate','RiskExpDate','SumAssured','NetPremium','Premium','partyId','Nominee')
                 ->where("is_active",1);
                //->where('party.client_id',$request['client_id']);

                if(!empty($start) && !empty($end)) {
                    $query->whereBetween('RiskDate',[$start, $end]);
                } else if(!empty($start)) {
                   $query->where('RiskDate',$start);
                } else if(!empty($end)) {
                   $query->where('RiskDate',$end);
                }
                if(!empty($request["party"]) && $request["redio_option"]=="Party") {
                   $query->whereIn('partyId',$request["party"]);
                }
                 if(!empty($request["family_group"]) && $request["redio_option"]=="Family") {
                   //$query->whereIn('partyId',$request["party"]);
                }
                $query_clone = $query;
                $partyIds = $query_clone->pluck("partyId"); 
                $temp = $query->get();
                $policyList = []; 
                $allPartyList = Party::select('GCODE','NAME','ABD','MOBILE','CITYID','ABD')
                                            ->whereIn("GCODE",$partyIds)
                                            ->get();
                $partyList = [];                            
                foreach($allPartyList as $value) { 
                     $partyList[$value["GCODE"]] = $value; 
                }
                foreach($temp as $value) { 
                     $policyList[$value["partyId"]][] = $value; 
                }


                $data["partys"] = $partyList;
                $data["policy_list"] = $policyList;
            }
        }
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }

    public function getAllReminderSetupData(Request $request) {

        $reminderSetup = SetupReminder::where('client_id',$request['client_id'])->first();
        $data          = [];

        if(!empty($reminderSetup)) {
            $todayDt  = date("Y-m-d");

            //birthdayRM
            $birthdayRMbeforeDay = $reminderSetup['birthday_rm_af'];
            $birthdayRMstartDate = \Carbon\Carbon::now()->subDays($birthdayRMbeforeDay)->format('m-d');
            
            $birthdayRMafterDay = $reminderSetup['birthday_rm_bf'];
            $birthdayRMendDate  = date('m-d', strtotime($todayDt. ' + '.$birthdayRMafterDay.' days'));
            
            $ABD    = \DB::raw('DATE_FORMAT(ABD,"%m-%d")');
            $partyBirthReminder  = Party::select('GCODE','NAME','ABD','MOBILE','CITYID')->where($ABD,">=",$birthdayRMstartDate)->where($ABD,"<=",$birthdayRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //agentBirthdayRM
            $agentBirthdayRMbeforeDay = $reminderSetup['agent_birthday_rm_af'];
            $agentBirthdayRMstartDate = \Carbon\Carbon::now()->subDays($agentBirthdayRMbeforeDay)->format('m-d');
            
            $agentBirthdayRMafterDay = $reminderSetup['agent_birthday_rm_bf'];
            $agentBirthdayRMendDate  = date('m-d', strtotime($todayDt. ' + '.$agentBirthdayRMafterDay.' days'));
            
            $BD    = \DB::raw('DATE_FORMAT(BD,"%m-%d")');
            $agentBirthReminder  = Agency::select('AFILE','ANAME','BD','MOBILE','CITYID')->where($BD,">=",$agentBirthdayRMstartDate)->where($BD,"<=",$agentBirthdayRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //marriageAnnRM
            $marriageAnnRMbeforeDay = $reminderSetup['marriage_ann_rm_af'];
            $marriageAnnRMstartDate = \Carbon\Carbon::now()->subDays($marriageAnnRMbeforeDay)->format('m-d');
            
            $marriageAnnRMafterDay = $reminderSetup['marriage_ann_rm_bf'];
            $marriageAnnRMendDate  = date('m-d', strtotime($todayDt. ' + '.$marriageAnnRMafterDay.' days'));
            
            $WDT    = \DB::raw('DATE_FORMAT(WDT,"%m-%d")');
            $marriageAnnReminder  = Party::select('GCODE','NAME','WDT','MOBILE','CITYID')->where($WDT,">=",$marriageAnnRMstartDate)->where($WDT,"<=",$marriageAnnRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //licenceExpiryRM
            $licenceExpiryRMbeforeDay = $reminderSetup['licence_expiry_rm_af'];
            $licenceExpiryRMstartDate = \Carbon\Carbon::now()->subDays($licenceExpiryRMbeforeDay)->format('Y-m-d');
            
            $licenceExpiryRMafterDay = $reminderSetup['licence_expiry_rm_bf'];
            $licenceExpiryRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$licenceExpiryRMafterDay.' days'));
            
            //$LICEXPDT    = \DB::raw('DATE_FORMAT(LICEXPDT,"%m-%d")');
            $licenceExpiryReminder  = Agency::select('AFILE','ANAME','AGCODE','LICEXPDT','MOBILE','CITYID')->where('LICEXPDT',">=",$licenceExpiryRMstartDate)->where('LICEXPDT',"<=",$licenceExpiryRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //agencyExpiryRM
            $agencyExpiryRMbeforeDay = $reminderSetup['agency_expiry_rm_af'];
            $agencyExpiryRMstartDate = \Carbon\Carbon::now()->subDays($agencyExpiryRMbeforeDay)->format('Y-m-d');
            
            $agencyExpiryRMafterDay = $reminderSetup['agency_expiry_rm_bf'];
            $agencyExpiryRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$agencyExpiryRMafterDay.' days'));
            
            //$EXP_DT    = \DB::raw('DATE_FORMAT(EXP_DT,"%m-%d")');
            $agencyExpiryReminder  = Agency::select('AFILE','ANAME','AGCODE','EXP_DT','MOBILE','CITYID')->where('EXP_DT',">=",$agencyExpiryRMstartDate)->where('EXP_DT',"<=",$agencyExpiryRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //lastRenewRM
            $lastRenewRMbeforeDay = $reminderSetup['last_renew_rm_af'];
            $lastRenewRMstartDate = \Carbon\Carbon::now()->subDays($lastRenewRMbeforeDay)->format('Y-m-d');
            
            $lastRenewRMafterDay = $reminderSetup['last_renew_rm_bf'];
            $lastRenewRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$lastRenewRMafterDay.' days'));
            
            //$RENEDT    = \DB::raw('DATE_FORMAT(RENEDT,"%m-%d")');
            $lastRenewReminder  = Agency::select('AFILE','ANAME','AGCODE','RENEDT','MOBILE','CITYID')->where('RENEDT',">=",$lastRenewRMstartDate)->where('RENEDT',"<=",$lastRenewRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //fupRM
            $fupRMbeforeDay = $reminderSetup['fup_rm_af'];
            $fupRMstartDate = \Carbon\Carbon::now()->subDays($fupRMbeforeDay)->format('Y-m-d');
            
            $fupRMafterDay = $reminderSetup['fup_rm_bf'];
            $fupRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$fupRMafterDay.' days'));
            
            //$FUPDATE      = \DB::raw('DATE_FORMAT(FUPDATE,"%m-%d-%Y")');
            $fupReminder  = Policy::select('PUNIQID','PONO','SA','FUPDATE','PREM','AGCODE','NAME1')->where('FUPDATE',">=",$fupRMstartDate)->where('FUPDATE',"<=",$fupRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //maturityRM
            $maturityRMbeforeDay = $reminderSetup['maturity_rm_af'];
            $maturityRMstartDate = \Carbon\Carbon::now()->subDays($maturityRMbeforeDay)->format('Y-m-d');
            
            $maturityRMafterDay = $reminderSetup['maturity_rm_bf'];
            $maturityRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$maturityRMafterDay.' days'));
            
            //$MATDATE      = \DB::raw('DATE_FORMAT(MATDATE,"%m-%d")');
            $maturityReminder  = Policy::select('PUNIQID','PONO','SA','MATDATE','PREM','AGCODE','NAME1')->where('MATDATE',">=",$maturityRMstartDate)->where('MATDATE',"<=",$maturityRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //moneyBackRM
            $moneyBackRMbeforeDay = $reminderSetup['money_back_rm_af'];
            $moneyBackRMstartDate = \Carbon\Carbon::now()->subDays($moneyBackRMbeforeDay)->format('Y-m-d');
            
            $moneyBackRMafterDay = $reminderSetup['money_back_rm_bf'];
            $moneyBackRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$moneyBackRMafterDay.' days'));
            
            //$MATDATE      = \DB::raw('DATE_FORMAT(MATDATE,"%m-%d")');
            $moneyBackReminder  = Policy::select('PUNIQID','PONO','SA','MATDATE','PREM','AGCODE','NAME1')->where('MATDATE',">=",$moneyBackRMstartDate)->where('MATDATE',"<=",$moneyBackRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //healthPlanRM
            $getHealthPlanIDs      = Plan::select('plno')->where('pltype','H')->get()->toArray();
            $healthPlanRMbeforeDay = $reminderSetup['health_plan_rm_af'];
            $healthPlanRMstartDate = \Carbon\Carbon::now()->subDays($healthPlanRMbeforeDay)->format('Y-m-d');
            
            $healthPlanRMafterDay = $reminderSetup['health_plan_rm_bf'];
            $healthPlanRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$healthPlanRMafterDay.' days'));
            
            //$FUPDATE      = \DB::raw('DATE_FORMAT(FUPDATE,"%m-%d")');
            $healthPlanReminder  = Policy::select('PUNIQID','PONO','SA','FUPDATE','PREM','AGCODE','NAME1')->whereIn('PLAN',$getHealthPlanIDs)->where('FUPDATE',">=",$healthPlanRMstartDate)->where('FUPDATE',"<=",$healthPlanRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //termInsuranceRM
            $getTermInsurancePlanIDs  = Plan::select('plno')->where('pltype','T')->get()->toArray();
            $termInsuranceRMbeforeDay = $reminderSetup['term_insurance_rm_af'];
            $termInsuranceRMstartDate = \Carbon\Carbon::now()->subDays($termInsuranceRMbeforeDay)->format('Y-m-d');
            
            $termInsuranceRMafterDay = $reminderSetup['term_insurance_rm_bf'];
            $termInsuranceRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$termInsuranceRMafterDay.' days'));
            
            //$FUPDATE      = \DB::raw('DATE_FORMAT(FUPDATE,"%m-%d")');
            $termInsuranceReminder  = Policy::select('PUNIQID','PONO','SA','FUPDATE','PREM','AGCODE','NAME1')->whereIn('PLAN',$getTermInsurancePlanIDs)->where('FUPDATE',">=",$termInsuranceRMstartDate)->where('FUPDATE',"<=",$termInsuranceRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            //ulipPlanRM
            $getUlipPlanIDs      = Plan::select('plno')->where('pltype','U')->get()->toArray();
            $ulipPlanRMbeforeDay = $reminderSetup['ulip_plan_rm_af'];
            $ulipPlanRMstartDate = \Carbon\Carbon::now()->subDays($ulipPlanRMbeforeDay)->format('Y-m-d');
            
            $ulipPlanRMafterDay = $reminderSetup['ulip_plan_rm_bf'];
            $ulipPlanRMendDate  = date('Y-m-d', strtotime($todayDt. ' + '.$ulipPlanRMafterDay.' days'));
            
            //$FUPDATE      = \DB::raw('DATE_FORMAT(FUPDATE,"%m-%d")');
            $ulipPlanReminder  = Policy::select('PUNIQID','PONO','SA','FUPDATE','PREM','AGCODE','NAME1')->whereIn('PLAN',$getUlipPlanIDs)->where('FUPDATE',">=",$ulipPlanRMstartDate)->where('FUPDATE',"<=",$ulipPlanRMendDate)->where('client_id',$request['client_id'])->get();
            /*=========================================================================================*/

            $data = [
                'partyBirthDayReminder' => $partyBirthReminder,
                'agentBirthDayReminder' => $agentBirthReminder,
                'marriageAnnReminder'   => $marriageAnnReminder,
                'licenceExpiryReminder' => $licenceExpiryReminder,
                'agencyExpiryReminder'  => $agencyExpiryReminder,
                'lastRenewReminder'     => $lastRenewReminder,
                'fupReminder'           => $fupReminder,
                'termInsuranceReminder' => $termInsuranceReminder,
                'ulipPlanReminder'      => $ulipPlanReminder,
                'healthPlanReminder'    => $healthPlanReminder,
                'maturityReminder'      => $maturityReminder,
                'moneyBackReminder'     => $moneyBackReminder,
            ];
        }
        
        return response()->json(["success" => 1, "msg" => "Success.","data"=>$data]);
    }
}
<?php

namespace App\Http\Middleware;

use App\Models\LifeCellLic\AdminApiLog;
use Auth;
use Closure;

class Log
{
    public $start;
    public $end;
    
    public function handle($request, Closure $next, $guard = null)
    {
        return $next($request);
    }
    
    public function terminate($request, $response)
    {
        $this->end = date("Y-m-d H:i:s");    
        $this->log($request, $response);
    }
    
    protected function log($request, $response,$guard = null)
    {
    	// check if log file create than create a log 	
        if(env("IS_LOG_CREATE","no") == "yes") {

    		\Log::info('=>
	        
	        |-------------------------------------------------------------------------------------------------------------------------------
	        | Duration:  ' .($this->end - API_START).' ms
	        | URL: ' . $request->fullUrl().'
	        | Method: ' . $request->getMethod().'
	        | Request: ' . json_encode($request->All()).'
	        | IP Address: ' . $request->getClientIp().'
	        | Status Code: ' . $response->getStatusCode().'
			| response: ' . json_encode($response).'
	        |-------------------------------------------------------------------------------------------------------------------------------|
	        
	        ');
    	}

		$user  = 1;
		// avoiding log which is not needed
    	$filter = new \App\Library\HandleApiLogRequest($request,$response);

		if($user && $filter->can()) {
			$logs = [
				'start_time' => API_START,
				'end_time'   => $this->end,
				'url'        => $request->fullUrl(),
				'method'     => $request->getMethod(),
				'request'    => json_encode($request->All()),
				'response'   => json_encode($response),
				'ip_address' => $request->getClientIp(),
				'status'     => $response->getStatusCode()
			];

			$logs['user_id'] = !empty($request['client_id']) ? $request['client_id'] : 0;
			//AdminApiLog::create($logs);
		}
	}
}

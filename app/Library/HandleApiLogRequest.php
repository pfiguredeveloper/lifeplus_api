<?php

namespace App\Library;

class HandleApiLogRequest
{
    private $request;
    private $response;

    public function __construct($request, $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    private function hasSuccessResponse()
    {
        return (bool) ($this->response->getStatusCode() == 200);
    }

    public function can($ignore = false)
    {
        if ($ignore) {
            return true;
        }

        $url    = $this->request->fullUrl();
        $method = $this->request->getMethod();

        // store response only if has success
        if ($this->hasSuccessResponse()) {
            $requestList = $this->avoidableRequest();
            foreach ($requestList as $list) {
                if ($method == $list["method"] && preg_match($list["url"], $url)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function avoidableRequest()
    {
        return [
            ["method" => "POST", "url" => '/\/lifeplus\/get-masters/'],
        ];
    }
}

